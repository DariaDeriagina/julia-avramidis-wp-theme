# Julia Avramidis — Custom WordPress Theme

Custom WordPress theme built from Figma layouts.

## Features
- Custom front page template (Figma-driven layout)
- ACF-powered content sections (Hero, About, Divider, etc.)
- Responsive layout (mobile + desktop)

## Requirements
- WordPress 6.x
- PHP 8.x recommended
- (Optional) Advanced Custom Fields (ACF) plugin

## Install
1. Copy the theme folder into:
   `wp-content/themes/julia-avramidis/`
2. Activate the theme in WordPress Admin → Appearance → Themes.

## Development Notes
- Main template: `front-page.php`
- Styles: `style.css`
- Assets: `assets/`

## ACF (if enabled)
This theme expects ACF fields/groups such as:
- Hero: `hero_headline`, `hero_subtitle`, `hero_button_label`, `hero_button_link`, `hero_image`
- About group: `about[...]`
- Divider group: `divider[...]`

## License
Private / client project (update if you plan to open-source).
EOF
