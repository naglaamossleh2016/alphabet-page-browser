# Alphabet Page Browser

Browse WordPress pages alphabetically with an A–Z sidebar, live search box, and a full A–Z listing.

Author: **Naglaa Mossleh**

![Alphabet Page Browser Screenshot](screenshot-1.png)

---

## Features

- A–Z sidebar on the left, grouped into 6 letters per row.
- Letters with no pages are disabled.
- Live search box that filters pages by title.
- “View our full A–Z list” button to show all pages ordered alphabetically.
- Responsive and theme-friendly styling.
- Works with any post type via shortcode attribute.

---

## Installation

1. Download or clone the repository into your `wp-content/plugins` folder:

   ```bash
   wp-content/plugins/alphabet-page-browser
   ```

2. In the WordPress admin, go to Plugins → Installed Plugins and activate
   Alphabet Page Browser.

## Usage

Add the shortcode inside any page or post:

```bash
[alphabet_page_browser]
```

By default it lists pages.
To use it with another post type:

```bash
[alphabet_page_browser post_type="post"]

```
