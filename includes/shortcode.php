<?php
/**
 * Shortcode + query logic for Alphabet Page Browser
 */

if (!defined('ABSPATH')) {
    exit;
}

/**
 * Register CSS & JS (هنستدعيهم جوه الشورت كود)
 */
function apb_register_assets()
{
    wp_register_style(
        'apb-style',
        APB_PLUGIN_URL . 'assets/css/alphabet-page-browser.css',
        array(),
        APB_PLUGIN_VERSION
    );

    wp_register_script(
        'apb-script',
        APB_PLUGIN_URL . 'assets/js/alphabet-page-browser.js',
        array(),
        APB_PLUGIN_VERSION,
        true
    );
}
add_action('init', 'apb_register_assets');

/**
 * Render shortcode [alphabet_page_browser]
 */
function apb_alphabet_page_browser_shortcode($atts)
{

    // تأكد إن الـ CSS والـ JS موجودين في الصفحة
    wp_enqueue_style('apb-style');
    wp_enqueue_script('apb-script');

    $atts = shortcode_atts(
        array(
            'post_type' => 'page',
        ),
        $atts,
        'alphabet_page_browser'
    );

    $args = array(
        'post_type' => $atts['post_type'],
        'posts_per_page' => -1,
        'post_status' => 'publish',
        'orderby' => 'title',
        'order' => 'ASC',
    );
    $query = new WP_Query($args);

    if (!$query->have_posts()) {
        return '<p>No pages found.</p>';
    }

    // A-Z groups
    $letters = range('A', 'Z');
    $groups = array();

    foreach ($letters as $letter) {
        $groups[$letter] = array();
    }

    while ($query->have_posts()) {
        $query->the_post();

        $title = trim(get_the_title());
        if ('' === $title) {
            continue;
        }

        if (function_exists('mb_substr')) {
            $first_letter = mb_substr($title, 0, 1, 'UTF-8');
        } else {
            $first_letter = substr($title, 0, 1);
        }

        $first_letter = strtoupper($first_letter);

        if (isset($groups[$first_letter])) {
            $groups[$first_letter][] = array(
                'title' => $title,
                'link' => get_permalink(),
            );
        }
    }

    wp_reset_postdata();

    // أول حرف فيه صفحات (لو حبيت تستخدميه لاحقاً)
    $first_active_letter = '';
    foreach ($letters as $letter) {
        if (!empty($groups[$letter])) {
            $first_active_letter = $letter;
            break;
        }
    }

    ob_start();
    ?>

    <div class="apb-wrapper" data-first-letter="<?php echo esc_attr($first_active_letter); ?>">
        <div class="apb-left">
            <div class="apb-search">
                <span class="apb-search-icon">🔍</span>
                <input type="text" class="apb-search-input" placeholder="Search..." />
                <button type="button" class="apb-clear-search" aria-label="Clear search">&times;</button>
            </div>

            <div class="apb-letters">
                <?php foreach ($letters as $letter): ?>
                    <?php
                    $has_pages = !empty($groups[$letter]);
                    $classes = 'apb-letter';
                    if (!$has_pages) {
                        $classes .= ' apb-disabled';
                    }
                    ?>
                    <button type="button" class="<?php echo esc_attr($classes); ?>"
                        data-letter="<?php echo esc_attr($letter); ?>">
                        <?php echo esc_html($letter); ?>
                    </button>
                <?php endforeach; ?>
            </div>

            <button type="button" class="apb-view-all">
                View our full A-Z list
            </button>
        </div>

        <div class="apb-results">
            <div class="apb-placeholder">
                Type your search query in the box to the left. Or, select the first letter of the word you're looking for.
            </div>

            <div class="apb-search-results"></div>

            <?php foreach ($letters as $letter): ?>
                <?php
                if (empty($groups[$letter])) {
                    continue;
                }
                ?>
                <div class="apb-letter-group" data-letter="<?php echo esc_attr($letter); ?>">
                    <h3><?php echo esc_html($letter); ?></h3>
                    <ul class="apb-page-list">
                        <?php foreach ($groups[$letter] as $page): ?>
                            <li>
                                <a href="<?php echo esc_url($page['link']); ?>">
                                    <?php echo esc_html($page['title']); ?>
                                </a>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            <?php endforeach; ?>
        </div>
    </div>

    <?php
    return ob_get_clean();
}
add_shortcode('alphabet_page_browser', 'apb_alphabet_page_browser_shortcode');
