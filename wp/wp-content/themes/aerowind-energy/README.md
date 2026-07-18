# AeroWind Energy — Custom WordPress Theme

A premium, fully-responsive WordPress theme for the residential wind-energy brand
**AeroWind Energy** (Home Wind Turbines & Micro-Power Systems). The layout is
inspired by the "Brightworld" structure (bold hero, feature cards, values grid,
client reviews, lead-capture form) but restyled with a unique **Sky Blue / Navy**
corporate identity.

All custom fields are powered by the **free Carbon Fields** library (v3.6+),
bundled directly inside the theme via Composer — **no ACF, no paid plugins.**

## Brand Identity
| Token | Value |
|-------|-------|
| Deep Sky Blue | `#0EA5E9` |
| Steel Slate / Navy | `#0F172A` |
| Soft Mist White | `#F8FAFC` |

Fonts: **Poppins** (headings) + **Inter** (body).

## Features
- **Carbon Fields (bundled via Composer)** — `htmlburger/carbon-fields`.
- **Theme Options page** — logo text/image, announcement bar, header phone & CTA,
  footer about / contact / link columns / copyright.
- **Custom Post Type `aerowind_turbine`** with a dedicated
  `single-aerowind_turbine.php` detail page (Image, Title, Price, Description,
  Rated Power, Rotor Diameter, Cut-in Wind Speed, Health Benefits / Value).
- **Front page (`front-page.php`)** built entirely from Carbon Fields metaboxes:
  Hero, Zig-zag intro (rich text), Why-Wind 4-card grid, Turbines grid (CPT),
  Outstanding-features dark band, Google 5-star testimonial, and a working
  lead-capture contact form (Name, Email, Phone, Average Bill, Message).
- **Fully responsive** with a mobile hamburger nav.
- **ACF auto-deactivation** to guarantee a clean Carbon Fields environment.

## File Structure
```
aerowind-energy/
├── composer.json                 # requires htmlburger/carbon-fields ^3.6
├── style.css                     # theme header + full design system
├── functions.php                 # setup, enqueues, CPT, Carbon Fields boot
├── header.php                    # global header (announcement, logo, nav, phone)
├── footer.php                    # global footer (about, columns, copyright)
├── front-page.php                # landing page (all Carbon Fields sections)
├── single-aerowind_turbine.php   # turbine detail template
├── index.php                     # archive / fallback
├── inc/
│   ├── carbon-fields.php          # all field/container definitions
│   ├── icons.php                  # inline SVG icon library
│   └── seed.php                   # demo-content seeder (WP-CLI)
├── assets/
│   ├── css/  js/ (main.js)  images/
└── vendor/                        # Carbon Fields (installed by Composer)
```

## Installation
```bash
# 1. Install dependencies (bundles Carbon Fields into /vendor)
composer install

# 2. Activate the theme
wp theme activate aerowind-energy

# 3. Seed demo content (Home page, 4 turbines, all fields, theme options)
wp eval-file wp-content/themes/aerowind-energy/inc/seed.php

# 4. Flush permalinks
wp rewrite flush --hard
```

## Sample Turbines
- **AeroWind-1500** — 1.5 kW horizontal-axis flagship
- **V-Turbine Eco** — 0.9 kW vertical-axis for urban winds
- **Micro-Wind Smart** — 0.6 kW smart micro-wind controller kit
- **Cyclone Ridge** — 3.0 kW heavy-duty high-wind ridge-mount

## License
GPL-2.0-or-later. Carbon Fields is © HTML Burger, MIT-licensed.
