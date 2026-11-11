# AMEZA assets and licensing

**Photos** — source images referenced in the user-supplied original HTML:
- Hero: Unsplash photo-1558618666-fcd25c85cd64
- Production: Unsplash photo-1581092160562-40aa08e78837
- Product cards (all four used the *same* image): Unsplash photo-1582965348647-321a2c94d2c4

Hero and production photos are fetched with their exact image IDs from the supplied HTML. The original product photo URL returns HTTP 404; for that product photo the workflow uses a replacement free Unsplash photo (_ZK691wQaS0, Kelly Sikkema) rather than pretending to have the original. These are stock photographs, **not** verified photographs of AMEZA products or facilities. Confirm licensing and intended representation prior to publishing.

**Icons** — Font Awesome Free 6.7.2 (official FortAwesome/Font-Awesome repo), covered by CC BY 4.0 for icons: https://fontawesome.com/license/free. Attribution: "Font Awesome Free by Fonticons, Inc. (CC BY 4.0)". Every SVG and transparent PNG is downloaded from the official version, mapping the legacy CSS class to its modern Free icon name. You can use `assets/uploads-ready/icons/*.png` in the WordPress media library.

The repository's previous abstract illustrations are still under `assets/img/*.svg` only as fallback, never considered actual product photos.
