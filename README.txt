====================================================
 THUNDERBOLTCARRIERS — STATIC CLONE
====================================================

FOLDER STRUCTURE
----------------
thunderbolt-clone/
├── index.html              ← open this in browser
├── README.txt              ← this file
└── assets/
    ├── css/                (11 empty — download below)
    ├── js/                 (13 empty — download below)
    ├── fonts/
    │   ├── fonts.css       ← READY (@font-face declarations)
    │   ├── rt-fontello.woff2  ← you uploaded
    │   ├── DMSans.woff2       ← you uploaded
    │   ├── Outfit.woff2       ← you uploaded
    │   ├── KumbhSans.woff2    ← you uploaded
    │   └── Poppins.woff2      ← you uploaded
    └── img/                (empty — optional)

NOTE: index.html currently loads CSS & JS from the live
site (thunderboltcarriers.com). Fonts are local. Images
are hotlinked. So the page opens and renders correctly
as-is, with internet.


QUICK START
-----------
1. Double-click index.html — it opens in your browser.
2. If the page looks unstyled or blank white:
   - You need internet (CSS/JS come from live site).
   - Open browser DevTools (F12) → Console to see errors.
3. If icons look missing: check assets/fonts/rt-fontello.woff2
   exists. If not, icons fall back to invisible but layout
   is fine.


CASE STUDIES — 4 CARDS (IMPORTANT)
-----------------------------------
The homepage has FOUR case study cards, not two.
It renders as 2×2 because the live site uses TWO
project-grid widgets, each containing the SAME 2 projects.
That's how the theme demo is built — it's not a bug,
it's what the live site actually displays.

Both widgets are already in index.html:
  - elementor-element-cd3fb59 (top row)
  - elementor-element-db0267a (bottom row)
Do not remove one — you'll break the match with the live site.


LOCALIZE (MAKE IT FULLY OFFLINE)
---------------------------------
The page works online right now. To make it offline:

STEP A — Download the 11 CSS files
----------------------------------
Save each into assets/css/ with the numbered filename:

  01-base.css        ← https://thunderboltcarriers.com/wp-content/uploads/elementor/css/base-desktop.css
                        AND ALSO save https://thunderboltcarriers.com/wp-content/uploads/elementor/css/base-mobile.css
                        (append it to the same 01-base.css file)

  02-theme.css       ← https://thunderboltcarriers.com/wp-content/themes/kariez/assets/css/style.css
  03-kit.css         ← https://thunderboltcarriers.com/wp-content/uploads/elementor/css/post-12374.css
  04-homepage.css    ← https://thunderboltcarriers.com/wp-content/uploads/elementor/css/post-11216.css
  05-footer.css      ← https://thunderboltcarriers.com/wp-content/uploads/elementor/css/post-6589.css
  06-swiper.css      ← https://thunderboltcarriers.com/wp-content/themes/kariez/assets/css/swiper.min.css
  07-animate.css     ← https://thunderboltcarriers.com/wp-content/themes/kariez/assets/css/animate.css
  08-magnific.css    ← https://thunderboltcarriers.com/wp-content/themes/kariez/assets/css/magnific-popup.css
  09-fontello.css    ← https://thunderboltcarriers.com/wp-content/themes/kariez/assets/vendor/fontello.css
  10-fontawesome.css ← https://thunderboltcarriers.com/wp-content/plugins/wpcargo/assets/css/fontawesome.min.css
  11-bootstrap.css   ← https://thunderboltcarriers.com/wp-content/plugins/wpcargo/assets/css/bootstrap.min.css

STEP B — Download the 13 JS files
---------------------------------
Save each into assets/js/:

  01-jquery.min.js         ← https://thunderboltcarriers.com/wp-includes/js/jquery/jquery.min.js
  02-swiper.min.js         ← https://thunderboltcarriers.com/wp-content/themes/kariez/assets/js/swiper.min.js
  03-wow.min.js            ← https://thunderboltcarriers.com/wp-content/themes/kariez/assets/js/wow.min.js
  04-waypoints.js          ← https://thunderboltcarriers.com/wp-content/themes/kariez/assets/js/waypoints.js
  05-counterup.js          ← https://thunderboltcarriers.com/wp-content/themes/kariez/assets/js/counterup.js
  06-appear.js             ← https://thunderboltcarriers.com/wp-content/themes/kariez/assets/js/appear.js
  07-isotope.min.js        ← https://thunderboltcarriers.com/wp-content/themes/kariez/assets/js/isotope.min.js
  08-magnific-popup.js     ← https://thunderboltcarriers.com/wp-content/themes/kariez/assets/js/magnific-popup.js
  09-headroom.js           ← https://thunderboltcarriers.com/wp-content/themes/kariez/assets/js/headroom.js
  10-parallax-scroll.js    ← https://thunderboltcarriers.com/wp-content/themes/kariez/assets/js/parallax-scroll.js
  11-ele-parallax.js       ← https://thunderboltcarriers.com/wp-content/themes/kariez/assets/js/ele-parallax.js
  12-imagesloaded.min.js   ← https://thunderboltcarriers.com/wp-includes/js/imagesloaded.min.js
  13-scripts.js            ← https://thunderboltcarriers.com/wp-content/themes/kariez/assets/js/scripts.js

STEP C — Replace URLs in index.html
-----------------------------------
Open index.html in a text editor and do these
Find & Replace operations.

CSS — theme folder:
  FIND:    https://thunderboltcarriers.com/wp-content/themes/kariez/assets/css/
  REPLACE: ./assets/css/

  (Then rename each downloaded file to the numbered version,
   OR just rename to match — e.g. style.css → 02-theme.css,
   swiper.min.css → 06-swiper.css, animate.css → 07-animate.css,
   magnific-popup.css → 08-magnific.css)

CSS — fontello (special path):
  FIND:    https://thunderboltcarriers.com/wp-content/themes/kariez/assets/vendor/fontello.css
  REPLACE: ./assets/css/09-fontello.css

CSS — Elementor:
  FIND:    https://thunderboltcarriers.com/wp-content/uploads/elementor/css/base-desktop.css
  REPLACE: ./assets/css/01-base.css
  FIND:    https://thunderboltcarriers.com/wp-content/uploads/elementor/css/base-mobile.css
  REPLACE: ./assets/css/01-base.css
  FIND:    https://thunderboltcarriers.com/wp-content/uploads/elementor/css/post-12374.css
  REPLACE: ./assets/css/03-kit.css
  FIND:    https://thunderboltcarriers.com/wp-content/uploads/elementor/css/post-11216.css
  REPLACE: ./assets/css/04-homepage.css
  FIND:    https://thunderboltcarriers.com/wp-content/uploads/elementor/css/post-6589.css
  REPLACE: ./assets/css/05-footer.css

CSS — plugins:
  FIND:    https://thunderboltcarriers.com/wp-content/plugins/wpcargo/assets/css/fontawesome.min.css
  REPLACE: ./assets/css/10-fontawesome.css
  FIND:    https://thunderboltcarriers.com/wp-content/plugins/wpcargo/assets/css/bootstrap.min.css
  REPLACE: ./assets/css/11-bootstrap.css

JS — theme folder:
  FIND:    https://thunderboltcarriers.com/wp-content/themes/kariez/assets/js/
  REPLACE: ./assets/js/

  (Rename: swiper.min.js → 02-swiper.min.js, wow.min.js →
   03-wow.min.js, etc. Or skip the rename and leave original
   names — the numbering is only a suggestion.)

JS — WordPress core:
  FIND:    https://thunderboltcarriers.com/wp-includes/js/jquery/jquery.min.js
  REPLACE: ./assets/js/01-jquery.min.js
  FIND:    https://thunderboltcarriers.com/wp-includes/js/imagesloaded.min.js
  REPLACE: ./assets/js/12-imagesloaded.min.js

After the replace, save index.html. Reload it — now offline.

IMPORTANT: Also download the elementor bundle files and the
elementor frontend files if you want fully offline:

  https://thunderboltcarriers.com/wp-content/plugins/elementor/assets/css/frontend.min.css
  https://thunderboltcarriers.com/wp-content/plugins/elementor/assets/lib/eicons/css/elementor-icons.min.css
  https://thunderboltcarriers.com/wp-content/plugins/elementor/assets/css/widget-icon-box.min.css
  https://thunderboltcarriers.com/wp-content/plugins/elementor/assets/js/webpack.runtime.min.js
  https://thunderboltcarriers.com/wp-content/plugins/elementor/assets/js/frontend-modules.min.js
  https://thunderboltcarriers.com/wp-content/plugins/elementor/assets/js/frontend.min.js
  https://thunderboltcarriers.com/wp-content/plugins/elementor/assets/js/shared-frontend-handlers.03caa53373b56d3bab67.bundle.min.js
  https://thunderboltcarriers.com/wp-content/plugins/elementor/assets/js/text-editor.45609661e409413f1cef.bundle.min.js

Save them in assets/css/ and assets/js/ with these names:
  12-elementor-frontend.css
  13-elementor-icons.css
  14-widget-icon-box.css
  15-elementor-webpack-runtime.js
  16-elementor-frontend-modules.js
  17-elementor-frontend.js
  18-elementor-shared-handlers.js
  19-elementor-text-editor.js

Then add <link> and <script> tags for them in index.html
next to their siblings, using local paths.


LOCALIZE IMAGES (OPTIONAL)
--------------------------
All images are currently hotlinked from the live site.
To make them local:

1. Create the mirror path structure:
   assets/img/wp-content/uploads/2025/01/
   assets/img/wp-content/uploads/2025/02/
   assets/img/wp-content/uploads/2025/03/
   assets/img/wp-content/uploads/2024/12/
   assets/img/wp-content/uploads/2026/08/

2. For every img src and background-image URL in
   index.html, do:

   FIND:    https://thunderboltcarriers.com/wp-content/uploads/
   REPLACE: ./assets/img/wp-content/uploads/

3. Download each referenced image from the live site
   into the matching folder.

That's it — no other edits needed.


FONTS STILL NEEDING NAMES
-------------------------
Five font files are mapped in assets/fonts/fonts.css:
  - rt-fontello.woff2   (icons)
  - DMSans.woff2        (body)
  - Outfit.woff2        (headings)
  - KumbhSans.woff2     (counters)
  - Poppins.woff2

If you also sent Roboto and Roboto Slab binaries in
your earlier uploads (the two unlabeled .woff2 files),
save them as:
  - Roboto.woff2
  - RobotoSlab.woff2
in this folder and uncomment/add the @font-face blocks
in assets/fonts/fonts.css.

The page ALSO loads Roboto and Roboto Slab from Google
Fonts <link> in index.html, so they render correctly
even without a local copy.


WHAT'S NOT INCLUDED
-------------------
- Chatway live-chat widget (third-party, not needed)
- WordPress comments, emoji boilerplate, admin bar
- cookieadmin consent scripts (banner not included)
- WooCommerce tracking form scripts (not used on home)


TESTING CHECKLIST
-----------------
Open index.html → verify:

  [ ] Header: logo left, nav center, phone right
  [ ] Hero slider: 3 slides, autoplay, "Moving Your Products..."
  [ ] About section: photo left, title + 6 bullets right
  [ ] Counters: 32K+ / 154+ / 8845 (animate on scroll)
  [ ] Hover services: 4 panels (Boxes / Furniture / Inland / Cargo)
  [ ] Yellow marquee scrolls right-to-left
  [ ] Progress bars: 3 bars fill on scroll (89/94/97%)
  [ ] Work process: 3 circular steps (01, 02, 03)
  [ ] Testimonials: 2 slides (Michael T. / Sarah M.)
  [ ] World map: 5 blinking pins
  [ ] Case studies: 4 cards in 2×2 (2 unique × 2 rows)
  [ ] Partners: 8 SVG logos
  [ ] Footer: 4 columns + copyright bar
  [ ] Back-to-top button appears after scroll
  [ ] Mobile: hamburger menu triggers off-canvas drawer

If any of these fail:
  1. Open DevTools (F12) → Console
  2. Check for 404 errors — those mean the CSS/JS URL
     is unreachable (temporary network issue, or the
     live site changed paths)
  3. Check for JS errors — those usually mean jQuery
     loaded AFTER a dependent script


THAT'S IT
---------
Questions? Just ask. Happy cloning.