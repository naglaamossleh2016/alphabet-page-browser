(function () {
  document.addEventListener("DOMContentLoaded", function () {
    document.querySelectorAll(".apb-wrapper").forEach(function (wrapper) {
      const letters = wrapper.querySelectorAll(
        ".apb-letter:not(.apb-disabled)"
      );
      const allLetterButtons = wrapper.querySelectorAll(".apb-letter");
      const groups = wrapper.querySelectorAll(".apb-letter-group");
      const placeholder = wrapper.querySelector(".apb-placeholder");
      const searchInput = wrapper.querySelector(".apb-search-input");
      const clearBtn = wrapper.querySelector(".apb-clear-search");
      const searchResults = wrapper.querySelector(".apb-search-results");
      const viewAllBtn = wrapper.querySelector(".apb-view-all");
      const allLinks = wrapper.querySelectorAll(".apb-page-list a");

      function resetView() {
        groups.forEach(function (g) {
          g.classList.remove("apb-visible");
        });
        allLetterButtons.forEach(function (btn) {
          btn.classList.remove("apb-active");
        });
        searchResults.style.display = "none";
        searchResults.innerHTML = "";
        if (placeholder) {
          placeholder.style.display = "block";
        }
      }

      function showLetter(letter) {
        if (placeholder) {
          placeholder.style.display = "none";
        }
        searchResults.style.display = "none";
        searchResults.innerHTML = "";

        groups.forEach(function (group) {
          if (group.dataset.letter === letter) {
            group.classList.add("apb-visible");
          } else {
            group.classList.remove("apb-visible");
          }
        });

        allLetterButtons.forEach(function (btn) {
          btn.classList.toggle("apb-active", btn.dataset.letter === letter);
        });
      }

      function showAll() {
        if (placeholder) {
          placeholder.style.display = "none";
        }
        searchResults.style.display = "none";
        searchResults.innerHTML = "";

        groups.forEach(function (group) {
          group.classList.add("apb-visible");
        });

        allLetterButtons.forEach(function (btn) {
          btn.classList.remove("apb-active");
        });
      }

      function escapeHtml(str) {
        return str
          .replace(/&/g, "&amp;")
          .replace(/</g, "&lt;")
          .replace(/>/g, "&gt;")
          .replace(/"/g, "&quot;")
          .replace(/'/g, "&#039;");
      }

      function performSearch(query) {
        const q = query.trim().toLowerCase();

        if (!q) {
          resetView();
          return;
        }

        groups.forEach(function (g) {
          g.classList.remove("apb-visible");
        });
        allLetterButtons.forEach(function (btn) {
          btn.classList.remove("apb-active");
        });

        const results = [];
        allLinks.forEach(function (link) {
          const text = link.textContent.trim().toLowerCase();
          if (text.indexOf(q) !== -1) {
            results.push({
              href: link.getAttribute("href"),
              title: link.textContent.trim(),
            });
          }
        });

        if (placeholder) {
          placeholder.style.display = "none";
        }

        let html =
          "<h3>Results for <span>'" +
          escapeHtml(query.trim()) +
          "'</span>:</h3>";

        if (results.length === 0) {
          html += "<p>No results found.</p>";
        } else {
          html += '<ul class="apb-page-list">';
          results.forEach(function (item) {
            html +=
              '<li><a href="' +
              escapeHtml(item.href) +
              '">' +
              escapeHtml(item.title) +
              "</a></li>";
          });
          html += "</ul>";
        }

        searchResults.innerHTML = html;
        searchResults.style.display = "block";
      }

      // click events
      letters.forEach(function (btn) {
        btn.addEventListener("click", function () {
          if (searchInput) {
            searchInput.value = "";
          }
          showLetter(this.dataset.letter);
        });
      });

      // search
      if (searchInput) {
        searchInput.addEventListener("input", function () {
          performSearch(this.value);
        });
      }

      // clear search
      if (clearBtn) {
        clearBtn.addEventListener("click", function () {
          if (searchInput) {
            searchInput.value = "";
            searchInput.focus();
          }
          resetView();
        });
      }

      // view all
      if (viewAllBtn) {
        viewAllBtn.addEventListener("click", function (e) {
          e.preventDefault();
          if (searchInput) {
            searchInput.value = "";
          }
          showAll();
        });
      }

      // initial state
      resetView();
    });
  });
})();
