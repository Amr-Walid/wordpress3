<?php
/**
 * AeroWind Energy — Demo content seeder.
 *
 * Run with WP-CLI:
 *   wp eval-file wp-content/themes/aerowind-energy/inc/seed.php
 *
 * Idempotent: re-running updates existing content rather than duplicating.
 *
 * @package AeroWind
 */

if ( ! defined( 'WP_CLI' ) || ! WP_CLI ) {
	// Allow only via WP-CLI.
	if ( ! defined( 'ABSPATH' ) ) {
		exit;
	}
}

if ( ! function_exists( 'carbon_set_post_meta' ) ) {
	WP_CLI::error( 'Carbon Fields is not loaded. Aborting.' );
	return;
}

/**
 * Sideload a theme image into the media library (once) and return attachment ID.
 */
function aw_seed_media( $filename, $title ) {
	// Reuse if already imported.
	$existing = get_posts( array(
		'post_type'   => 'attachment',
		'meta_key'    => '_aw_seed_source',
		'meta_value'  => $filename,
		'numberposts' => 1,
		'fields'      => 'ids',
	) );
	if ( ! empty( $existing ) ) {
		return $existing[0];
	}

	$src = get_template_directory() . '/assets/images/' . $filename;
	if ( ! file_exists( $src ) ) {
		WP_CLI::warning( "Missing image: $filename" );
		return 0;
	}

	require_once ABSPATH . 'wp-admin/includes/file.php';
	require_once ABSPATH . 'wp-admin/includes/media.php';
	require_once ABSPATH . 'wp-admin/includes/image.php';

	$upload = wp_upload_dir();
	$dest   = trailingslashit( $upload['path'] ) . $filename;
	copy( $src, $dest );

	$filetype = wp_check_filetype( $dest, null );
	$attach_id = wp_insert_attachment( array(
		'guid'           => trailingslashit( $upload['url'] ) . $filename,
		'post_mime_type' => $filetype['type'],
		'post_title'     => $title,
		'post_status'    => 'inherit',
	), $dest, 0, true );

	if ( is_wp_error( $attach_id ) || ! $attach_id ) {
		WP_CLI::warning( "Failed to create attachment for $filename" );
		return 0;
	}

	$meta = wp_generate_attachment_metadata( $attach_id, $dest );
	wp_update_attachment_metadata( $attach_id, $meta );
	update_post_meta( $attach_id, '_aw_seed_source', $filename );

	return (int) $attach_id;
}

function aw_att_url( $id ) {
	return $id ? wp_get_attachment_url( $id ) : '';
}

WP_CLI::log( '➤ Importing media...' );
$img_hero    = aw_seed_media( 'hero.jpg', 'AeroWind Hero' );
$img_intro   = aw_seed_media( 'intro.jpg', 'AeroWind Home Turbine' );
$img_testi   = aw_seed_media( 'testimonial.jpg', 'Happy Homeowner' );
$img_t1      = aw_seed_media( 'turbine-1.jpg', 'AeroWind-1500' );
$img_t2      = aw_seed_media( 'turbine-2.jpg', 'V-Turbine Eco' );
$img_t3      = aw_seed_media( 'turbine-3.jpg', 'Micro-Wind Smart' );
$img_t4      = aw_seed_media( 'turbine-4.jpg', 'Cyclone Ridge' );

/* ---------------------------------------------------------------------------
 * 1. Home page (static front page) with front-page.php template
 * ------------------------------------------------------------------------- */
WP_CLI::log( '➤ Creating Home page...' );
$home = get_page_by_path( 'home' );
if ( ! $home ) {
	$home_id = wp_insert_post( array(
		'post_title'   => 'Home',
		'post_name'    => 'home',
		'post_status'  => 'publish',
		'post_type'    => 'page',
		'post_content' => '',
	) );
} else {
	$home_id = $home->ID;
}
update_post_meta( $home_id, '_wp_page_template', 'front-page.php' );
update_option( 'show_on_front', 'page' );
update_option( 'page_on_front', $home_id );

/* ---------------------------------------------------------------------------
 * 2. Populate Home page Carbon Fields
 * ------------------------------------------------------------------------- */
WP_CLI::log( '➤ Populating Home page fields...' );

// Hero.
carbon_set_post_meta( $home_id, 'hero_eyebrow', 'Home Wind Turbines & Micro-Power' );
carbon_set_post_meta( $home_id, 'hero_title', 'Wind energy done right.' );
carbon_set_post_meta( $home_id, 'hero_subtitle', 'Harness the wind to power your home with zero upfront costs. Premium, whisper-quiet turbines engineered for everyday breezes.' );
carbon_set_post_meta( $home_id, 'hero_cta_text', 'Go Wind Now' );
carbon_set_post_meta( $home_id, 'hero_cta_link', '#contact' );
carbon_set_post_meta( $home_id, 'hero_cta2_text', 'Explore Turbines' );
carbon_set_post_meta( $home_id, 'hero_cta2_link', '#turbines' );
carbon_set_post_meta( $home_id, 'hero_bg', aw_att_url( $img_hero ) );
carbon_set_post_meta( $home_id, 'hero_badges', array(
	array( 'value' => '12k+', 'label' => 'Homes powered' ),
	array( 'value' => '30%', 'label' => 'Avg. bill cut' ),
	array( 'value' => '25yr', 'label' => 'Warranty' ),
) );

// Zig-zag intro.
carbon_set_post_meta( $home_id, 'intro_image', aw_att_url( $img_intro ) );
carbon_set_post_meta( $home_id, 'intro_eyebrow', 'Why AeroWind' );
carbon_set_post_meta( $home_id, 'intro_title', 'Go wind with the best.' );
carbon_set_post_meta( $home_id, 'intro_body', '<p>AeroWind designs high-efficiency domestic turbines that convert even light, gusty winds into clean, dependable electricity. From compact rooftop units to full ridge-mount systems, every install is engineered for your site, your roof, and your budget.</p><p>We handle everything — assessment, permits, installation and lifetime monitoring — so you simply enjoy lower bills and true energy independence.</p>' );
carbon_set_post_meta( $home_id, 'intro_points', array(
	array( 'title' => 'Residential Systems', 'text' => 'Rooftop & pole turbines from 0.6–3 kW, ideal for houses and small holdings.' ),
	array( 'title' => 'Commercial Systems', 'text' => 'Scalable arrays and micro-grids for farms, workshops and off-grid sites.' ),
) );
carbon_set_post_meta( $home_id, 'intro_float_value', '30%' );
carbon_set_post_meta( $home_id, 'intro_float_label', 'Average annual bill saved' );
carbon_set_post_meta( $home_id, 'intro_cta_text', 'Get a Free Quote' );
carbon_set_post_meta( $home_id, 'intro_cta_link', '#contact' );

// Why-Wind cards.
carbon_set_post_meta( $home_id, 'why_eyebrow', 'The Advantages' );
carbon_set_post_meta( $home_id, 'why_title', 'Why go wind now?' );
carbon_set_post_meta( $home_id, 'why_cards', array(
	array( 'icon' => 'bill',  'title' => 'Lower Bills',        'description' => 'Slash your electricity costs by up to a third and lock in your rate against rising energy prices.' ),
	array( 'icon' => 'leaf',  'title' => 'Carbon Free',        'description' => 'Generate 100% clean power on-site and cut several tonnes of CO₂ from your home every year.' ),
	array( 'icon' => 'grid',  'title' => 'Grid Independence',  'description' => 'Pair with a battery to keep the lights on during outages and rely less on the grid.' ),
	array( 'icon' => 'value', 'title' => 'Property Value',     'description' => 'Wind-ready, energy-efficient homes sell faster and command a premium on the market.' ),
) );

// Turbines section intro.
carbon_set_post_meta( $home_id, 'products_eyebrow', 'Our Range' );
carbon_set_post_meta( $home_id, 'products_title', 'Turbines for every home' );
carbon_set_post_meta( $home_id, 'products_subtitle', 'Choose from horizontal, vertical-axis and smart micro-wind systems — each tuned for a different rooftop, plot and power need.' );

// Outstanding band.
carbon_set_post_meta( $home_id, 'band_eyebrow', 'Built To Last' );
carbon_set_post_meta( $home_id, 'band_title', 'Outstanding turbines, unparalleled service.' );
carbon_set_post_meta( $home_id, 'band_subtitle', 'From aerospace-grade blades to lifetime monitoring, every AeroWind system is engineered for decades of quiet, dependable power.' );
carbon_set_post_meta( $home_id, 'band_cols', array(
	array( 'icon' => 'blade', 'title' => 'Premium Blades', 'text' => 'Aerospace-grade composite blades that stay quiet and efficient in any breeze.' ),
	array( 'icon' => 'smart', 'title' => 'Smart Systems',  'text' => 'App monitoring, auto-furling and MPPT controllers optimise every watt.' ),
	array( 'icon' => 'rate',  'title' => 'Fixed Rates',    'text' => 'Transparent pricing and zero-money-down financing with no surprises.' ),
	array( 'icon' => 'care',  'title' => 'Product Care',    'text' => 'A 25-year warranty and lifetime remote support keep you covered.' ),
) );

// Testimonial.
carbon_set_post_meta( $home_id, 'testi_eyebrow', '5-Star Rated Company' );
carbon_set_post_meta( $home_id, 'testi_title', 'What homeowners say' );
carbon_set_post_meta( $home_id, 'testi_image', aw_att_url( $img_testi ) );
carbon_set_post_meta( $home_id, 'testi_quote', 'Our AeroWind turbine paid for itself faster than we imagined. It is whisper-quiet and our power bill dropped by a third in the first year. The install team was flawless.' );
carbon_set_post_meta( $home_id, 'testi_name', 'Marcus Reyes' );
carbon_set_post_meta( $home_id, 'testi_role', 'Homeowner, Boulder CO' );
carbon_set_post_meta( $home_id, 'testi_rating', '5' );

// Contact form container.
carbon_set_post_meta( $home_id, 'contact_eyebrow', 'Get In Touch' );
carbon_set_post_meta( $home_id, 'contact_title', "Let's upgrade your energy standards." );
carbon_set_post_meta( $home_id, 'contact_side_title', 'Zero money down.' );
carbon_set_post_meta( $home_id, 'contact_side_text', 'Tell us about your home and our wind advisors will design a system, estimate savings, and handle installation — all with no upfront cost.' );
carbon_set_post_meta( $home_id, 'contact_side_points', array(
	array( 'text' => 'Free on-site wind & roof assessment' ),
	array( 'text' => 'Custom savings estimate in 48 hours' ),
	array( 'text' => 'Turn-key install & permits handled' ),
	array( 'text' => '25-year warranty on every system' ),
) );
carbon_set_post_meta( $home_id, 'contact_submit', 'Request My Free Assessment' );

/* ---------------------------------------------------------------------------
 * 3. Insert 4 sample Turbines (idempotent by slug)
 * ------------------------------------------------------------------------- */
WP_CLI::log( '➤ Creating Turbines...' );

$turbines = array(
	array(
		'slug'    => 'aerowind-1500',
		'title'   => 'AeroWind-1500',
		'thumb'   => $img_t1,
		'content' => 'The AeroWind-1500 is our flagship horizontal-axis home turbine. Its aerospace-grade three-blade rotor and auto-yaw system capture the maximum energy from prevailing winds while staying remarkably quiet. Ideal for detached homes and small holdings with open exposure.',
		'price'   => '$4,900',
		'power'   => '1.5 kW',
		'rotor'   => '3.2 m',
		'cut_in'  => '2.5 m/s',
		'type'    => 'Horizontal-axis',
		'benefit' => 'Cuts a typical household bill by up to 35% and offsets ~1.8 tonnes of CO₂ each year — cleaner air for your family and a healthier planet.',
	),
	array(
		'slug'    => 'v-turbine-eco',
		'title'   => 'V-Turbine Eco',
		'thumb'   => $img_t2,
		'content' => 'The V-Turbine Eco is a sleek vertical-axis turbine that works beautifully in turbulent, multi-directional urban winds. Its low profile and near-silent operation make it perfect for rooftops and tighter suburban plots where a traditional turbine won\'t fit.',
		'price'   => '$3,200',
		'power'   => '0.9 kW',
		'rotor'   => '1.8 m',
		'cut_in'  => '1.8 m/s',
		'type'    => 'Vertical-axis',
		'benefit' => 'Whisper-quiet and bird-friendly, the Eco delivers clean power in gusty city conditions while keeping neighbours happy and rooftops uncluttered.',
	),
	array(
		'slug'    => 'micro-wind-smart',
		'title'   => 'Micro-Wind Smart',
		'thumb'   => $img_t3,
		'content' => 'The Micro-Wind Smart is an intelligent micro-wind controller and micro-turbine kit. With built-in MPPT charging, app monitoring and battery-ready output, it is the brains that squeezes every last watt from your wind system — perfect for cabins, sheds and off-grid setups.',
		'price'   => '$1,450',
		'power'   => '0.6 kW',
		'rotor'   => '1.2 m',
		'cut_in'  => '1.5 m/s',
		'type'    => 'Smart micro-wind controller',
		'benefit' => 'Keeps essential devices and batteries topped up off-grid, reducing generator use and giving you resilient, low-maintenance backup power.',
	),
	array(
		'slug'    => 'cyclone-ridge',
		'title'   => 'Cyclone Ridge',
		'thumb'   => $img_t4,
		'content' => 'The Cyclone Ridge is our heavy-duty ridge-mount turbine built for high-wind rural sites. Reinforced blades and a storm-protection auto-furl mechanism let it harvest serious power on exposed hilltops and coastal properties without compromising durability.',
		'price'   => '$6,700',
		'power'   => '3.0 kW',
		'rotor'   => '4.0 m',
		'cut_in'  => '3.0 m/s',
		'type'    => 'Horizontal-axis (high-wind)',
		'benefit' => 'Generates enough clean energy to power most of a large rural home, dramatically cutting bills and offsetting up to 3.5 tonnes of CO₂ annually.',
	),
);

foreach ( $turbines as $t ) {
	$existing = get_page_by_path( $t['slug'], OBJECT, 'aerowind_turbine' );
	$post_arr = array(
		'post_title'   => $t['title'],
		'post_name'    => $t['slug'],
		'post_content' => $t['content'],
		'post_excerpt' => wp_trim_words( $t['content'], 22 ),
		'post_status'  => 'publish',
		'post_type'    => 'aerowind_turbine',
	);
	if ( $existing ) {
		$post_arr['ID'] = $existing->ID;
		$tid = wp_update_post( $post_arr );
	} else {
		$tid = wp_insert_post( $post_arr );
	}

	if ( $t['thumb'] ) {
		set_post_thumbnail( $tid, $t['thumb'] );
	}
	carbon_set_post_meta( $tid, 'turbine_price', $t['price'] );
	carbon_set_post_meta( $tid, 'turbine_rated_power', $t['power'] );
	carbon_set_post_meta( $tid, 'turbine_rotor_diameter', $t['rotor'] );
	carbon_set_post_meta( $tid, 'turbine_cut_in', $t['cut_in'] );
	carbon_set_post_meta( $tid, 'turbine_type', $t['type'] );
	carbon_set_post_meta( $tid, 'turbine_benefits', $t['benefit'] );

	WP_CLI::log( "   • {$t['title']} (ID $tid)" );
}

/* ---------------------------------------------------------------------------
 * 4. Theme Options
 * ------------------------------------------------------------------------- */
WP_CLI::log( '➤ Setting Theme Options...' );
carbon_set_theme_option( 'aw_logo_text', 'Aero Wind' );
carbon_set_theme_option( 'aw_announce_enable', true );
carbon_set_theme_option( 'aw_announce_text', 'Limited offer — <strong>Zero upfront installation</strong> on all home turbines this quarter.' );
carbon_set_theme_option( 'aw_header_phone', '1-800-946-3674' );
carbon_set_theme_option( 'aw_header_cta_text', 'Get Started' );
carbon_set_theme_option( 'aw_header_cta_link', '#contact' );
carbon_set_theme_option( 'aw_footer_about', 'AeroWind Energy engineers premium residential wind turbines and smart micro-power systems that turn everyday breezes into clean, reliable electricity.' );
carbon_set_theme_option( 'aw_footer_phone', '1-800-946-3674' );
carbon_set_theme_option( 'aw_footer_email', 'hello@aerowind.energy' );
carbon_set_theme_option( 'aw_footer_address', '221 Turbine Way, Boulder, CO 80301' );
carbon_set_theme_option( 'aw_footer_copyright', '© 2026 AeroWind Energy. All rights reserved.' );
carbon_set_theme_option( 'aw_footer_columns', array(
	array(
		'title' => 'Products',
		'links' => array(
			array( 'label' => 'AeroWind-1500', 'url' => '/turbines/aerowind-1500/' ),
			array( 'label' => 'V-Turbine Eco', 'url' => '/turbines/v-turbine-eco/' ),
			array( 'label' => 'Micro-Wind Smart', 'url' => '/turbines/micro-wind-smart/' ),
			array( 'label' => 'Cyclone Ridge', 'url' => '/turbines/cyclone-ridge/' ),
		),
	),
	array(
		'title' => 'Company',
		'links' => array(
			array( 'label' => 'Why Wind', 'url' => '/#why' ),
			array( 'label' => 'Reviews', 'url' => '/#reviews' ),
			array( 'label' => 'About Us', 'url' => '/#about' ),
			array( 'label' => 'Contact', 'url' => '/#contact' ),
		),
	),
	array(
		'title' => 'Support',
		'links' => array(
			array( 'label' => 'Free Assessment', 'url' => '/#contact' ),
			array( 'label' => 'Warranty', 'url' => '/#' ),
			array( 'label' => 'Financing', 'url' => '/#' ),
			array( 'label' => 'FAQ', 'url' => '/#' ),
		),
	),
) );

/* ---------------------------------------------------------------------------
 * 5. Build a primary nav menu
 * ------------------------------------------------------------------------- */
WP_CLI::log( '➤ Building primary menu...' );
$menu_name = 'AeroWind Primary';
$menu = wp_get_nav_menu_object( $menu_name );
if ( ! $menu ) {
	$menu_id = wp_create_nav_menu( $menu_name );
} else {
	$menu_id = $menu->term_id;
	// clear existing items
	foreach ( wp_get_nav_menu_items( $menu_id ) as $it ) {
		wp_delete_post( $it->ID, true );
	}
}
$items = array(
	array( 'title' => 'Home', 'url' => home_url( '/' ) ),
	array( 'title' => 'Why Wind', 'url' => home_url( '/#why' ) ),
	array( 'title' => 'Turbines', 'url' => home_url( '/#turbines' ) ),
	array( 'title' => 'Reviews', 'url' => home_url( '/#reviews' ) ),
	array( 'title' => 'Contact', 'url' => home_url( '/#contact' ) ),
);
foreach ( $items as $i ) {
	wp_update_nav_menu_item( $menu_id, 0, array(
		'menu-item-title'  => $i['title'],
		'menu-item-url'    => $i['url'],
		'menu-item-status' => 'publish',
		'menu-item-type'   => 'custom',
	) );
}
$locations = get_theme_mod( 'nav_menu_locations' );
$locations['primary'] = $menu_id;
set_theme_mod( 'nav_menu_locations', $locations );

WP_CLI::success( 'AeroWind Energy demo content seeded successfully!' );
