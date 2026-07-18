<?php
/**
 * Carbon Fields definitions for AeroWind Energy.
 *
 * - Theme Options page (global settings)
 * - Front Page metaboxes (Hero, Zig-zag, Why-Wind cards, Outstanding band,
 *   Testimonials, Contact form container)
 * - Turbine CPT product detail fields
 *
 * @package AeroWind
 */

use Carbon_Fields\Container;
use Carbon_Fields\Field;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/* =====================================================================
 * THEME OPTIONS PAGE
 * ===================================================================== */
Container::make( 'theme_options', __( 'AeroWind Options', 'aerowind' ) )
	->set_page_menu_title( __( 'AeroWind Options', 'aerowind' ) )
	->set_icon( 'dashicons-admin-generic' )
	->add_tab( __( 'Branding', 'aerowind' ), array(
		Field::make( 'text', 'aw_logo_text', __( 'Logo Text', 'aerowind' ) )
			->set_default_value( 'AeroWind' )
			->set_help_text( 'Displayed when no logo image is set. The word after the first is highlighted in sky blue.' ),
		Field::make( 'image', 'aw_logo_image', __( 'Logo Image (optional)', 'aerowind' ) )
			->set_value_type( 'url' ),
	) )
	->add_tab( __( 'Announcement Bar', 'aerowind' ), array(
		Field::make( 'checkbox', 'aw_announce_enable', __( 'Show announcement bar', 'aerowind' ) )
			->set_default_value( true ),
		Field::make( 'text', 'aw_announce_text', __( 'Announcement Text', 'aerowind' ) )
			->set_default_value( 'Limited offer — Zero upfront installation on all home turbines this quarter.' ),
	) )
	->add_tab( __( 'Header', 'aerowind' ), array(
		Field::make( 'text', 'aw_header_phone', __( 'Header Phone Number', 'aerowind' ) )
			->set_default_value( '1-800-WIND-NRG' ),
		Field::make( 'text', 'aw_header_cta_text', __( 'Header Button Text', 'aerowind' ) )
			->set_default_value( 'Get Started' ),
		Field::make( 'text', 'aw_header_cta_link', __( 'Header Button Link', 'aerowind' ) )
			->set_default_value( '#contact' ),
	) )
	->add_tab( __( 'Footer', 'aerowind' ), array(
		Field::make( 'textarea', 'aw_footer_about', __( 'Footer About Text', 'aerowind' ) )
			->set_default_value( 'AeroWind Energy engineers premium residential wind turbines and smart micro-power systems that turn everyday breezes into clean, reliable electricity.' ),
		Field::make( 'text', 'aw_footer_phone', __( 'Footer Phone', 'aerowind' ) )
			->set_default_value( '1-800-946-3674' ),
		Field::make( 'text', 'aw_footer_email', __( 'Footer Email', 'aerowind' ) )
			->set_default_value( 'hello@aerowind.energy' ),
		Field::make( 'text', 'aw_footer_address', __( 'Footer Address', 'aerowind' ) )
			->set_default_value( '221 Turbine Way, Boulder, CO 80301' ),
		Field::make( 'complex', 'aw_footer_columns', __( 'Footer Link Columns', 'aerowind' ) )
			->set_layout( 'tabbed-vertical' )
			->add_fields( array(
				Field::make( 'text', 'title', __( 'Column Title', 'aerowind' ) ),
				Field::make( 'complex', 'links', __( 'Links', 'aerowind' ) )
					->add_fields( array(
						Field::make( 'text', 'label', __( 'Label', 'aerowind' ) ),
						Field::make( 'text', 'url', __( 'URL', 'aerowind' ) ),
					) ),
			) ),
		Field::make( 'text', 'aw_footer_copyright', __( 'Copyright Text', 'aerowind' ) )
			->set_default_value( '© 2026 AeroWind Energy. All rights reserved.' ),
	) );

/* =====================================================================
 * FRONT PAGE METABOXES
 * ===================================================================== */
$front_page = Container::make( 'post_meta', __( 'AeroWind — Home Page Sections', 'aerowind' ) )
	->where( 'post_type', '=', 'page' )
	->where( 'post_template', '=', 'front-page.php' )
	->set_context( 'normal' )
	->set_priority( 'high' );

/* ---- Hero Section ---- */
$front_page->add_tab( __( 'Hero', 'aerowind' ), array(
	Field::make( 'text', 'hero_eyebrow', __( 'Eyebrow', 'aerowind' ) )
		->set_default_value( 'Home Wind Turbines' ),
	Field::make( 'text', 'hero_title', __( 'Title', 'aerowind' ) )
		->set_default_value( 'Wind energy done right.' ),
	Field::make( 'textarea', 'hero_subtitle', __( 'Subtitle', 'aerowind' ) )
		->set_default_value( 'Harness the wind to power your home with zero upfront costs.' ),
	Field::make( 'text', 'hero_cta_text', __( 'Primary CTA Text', 'aerowind' ) )
		->set_default_value( 'Go Wind Now' ),
	Field::make( 'text', 'hero_cta_link', __( 'Primary CTA Link', 'aerowind' ) )
		->set_default_value( '#contact' ),
	Field::make( 'text', 'hero_cta2_text', __( 'Secondary CTA Text', 'aerowind' ) )
		->set_default_value( 'Explore Turbines' ),
	Field::make( 'text', 'hero_cta2_link', __( 'Secondary CTA Link', 'aerowind' ) )
		->set_default_value( '#turbines' ),
	Field::make( 'image', 'hero_bg', __( 'Background Image', 'aerowind' ) )
		->set_value_type( 'url' ),
	Field::make( 'complex', 'hero_badges', __( 'Hero Stat Badges', 'aerowind' ) )
		->set_layout( 'grid' )
		->add_fields( array(
			Field::make( 'text', 'value', __( 'Value', 'aerowind' ) ),
			Field::make( 'text', 'label', __( 'Label', 'aerowind' ) ),
		) ),
) );

/* ---- Zig-Zag Intro ---- */
$front_page->add_tab( __( 'Intro (Zig-Zag)', 'aerowind' ), array(
	Field::make( 'image', 'intro_image', __( 'Left Image', 'aerowind' ) )
		->set_value_type( 'url' ),
	Field::make( 'text', 'intro_eyebrow', __( 'Eyebrow', 'aerowind' ) )
		->set_default_value( 'Why AeroWind' ),
	Field::make( 'text', 'intro_title', __( 'Title', 'aerowind' ) )
		->set_default_value( 'Go wind with the best.' ),
	Field::make( 'rich_text', 'intro_body', __( 'Body (rich text)', 'aerowind' ) ),
	Field::make( 'complex', 'intro_points', __( 'Quick Details', 'aerowind' ) )
		->add_fields( array(
			Field::make( 'text', 'title', __( 'Title', 'aerowind' ) ),
			Field::make( 'text', 'text', __( 'Description', 'aerowind' ) ),
		) ),
	Field::make( 'text', 'intro_float_value', __( 'Floating Card Value', 'aerowind' ) )
		->set_default_value( '30%' ),
	Field::make( 'text', 'intro_float_label', __( 'Floating Card Label', 'aerowind' ) )
		->set_default_value( 'Average annual bill saved' ),
	Field::make( 'text', 'intro_cta_text', __( 'CTA Text', 'aerowind' ) )
		->set_default_value( 'Get a Free Quote' ),
	Field::make( 'text', 'intro_cta_link', __( 'CTA Link', 'aerowind' ) )
		->set_default_value( '#contact' ),
) );

/* ---- Why Wind Grid (4 cards) ---- */
$front_page->add_tab( __( 'Why Wind (Cards)', 'aerowind' ), array(
	Field::make( 'text', 'why_eyebrow', __( 'Eyebrow', 'aerowind' ) )
		->set_default_value( 'The Advantages' ),
	Field::make( 'text', 'why_title', __( 'Section Title', 'aerowind' ) )
		->set_default_value( 'Why go wind now?' ),
	Field::make( 'complex', 'why_cards', __( 'Benefit Cards', 'aerowind' ) )
		->set_max( 4 )
		->add_fields( array(
			Field::make( 'select', 'icon', __( 'Icon', 'aerowind' ) )
				->set_options( array(
					'bill'   => 'Lower Bills',
					'leaf'   => 'Carbon Free',
					'grid'   => 'Grid Independence',
					'value'  => 'Property Value',
					'wind'   => 'Wind',
					'shield' => 'Shield',
				) ),
			Field::make( 'text', 'title', __( 'Title', 'aerowind' ) ),
			Field::make( 'textarea', 'description', __( 'Description', 'aerowind' ) ),
		) ),
) );

/* ---- Outstanding Features Band ---- */
$front_page->add_tab( __( 'Outstanding Band', 'aerowind' ), array(
	Field::make( 'text', 'band_eyebrow', __( 'Eyebrow', 'aerowind' ) )
		->set_default_value( 'Built To Last' ),
	Field::make( 'text', 'band_title', __( 'Title', 'aerowind' ) )
		->set_default_value( 'Outstanding turbines, unparalleled service.' ),
	Field::make( 'textarea', 'band_subtitle', __( 'Subtitle', 'aerowind' ) )
		->set_default_value( 'From aerospace-grade blades to lifetime monitoring, every AeroWind system is engineered for decades of quiet, dependable power.' ),
	Field::make( 'complex', 'band_cols', __( 'Benefit Columns', 'aerowind' ) )
		->set_max( 4 )
		->add_fields( array(
			Field::make( 'select', 'icon', __( 'Icon', 'aerowind' ) )
				->set_options( array(
					'blade'   => 'Premium Blades',
					'smart'   => 'Smart Systems',
					'rate'    => 'Fixed Rates',
					'care'    => 'Product Care',
					'wind'    => 'Wind',
					'shield'  => 'Shield',
				) ),
			Field::make( 'text', 'title', __( 'Title', 'aerowind' ) ),
			Field::make( 'textarea', 'text', __( 'Description', 'aerowind' ) ),
		) ),
) );

/* ---- Products / Turbines section intro ---- */
$front_page->add_tab( __( 'Turbines Section', 'aerowind' ), array(
	Field::make( 'text', 'products_eyebrow', __( 'Eyebrow', 'aerowind' ) )
		->set_default_value( 'Our Range' ),
	Field::make( 'text', 'products_title', __( 'Title', 'aerowind' ) )
		->set_default_value( 'Turbines for every home' ),
	Field::make( 'textarea', 'products_subtitle', __( 'Subtitle', 'aerowind' ) )
		->set_default_value( 'Choose from horizontal, vertical-axis and smart micro-wind systems — each tuned for a different rooftop, plot and power need.' ),
) );

/* ---- Testimonials ---- */
$front_page->add_tab( __( 'Testimonials', 'aerowind' ), array(
	Field::make( 'text', 'testi_eyebrow', __( 'Eyebrow', 'aerowind' ) )
		->set_default_value( '5-Star Rated Company' ),
	Field::make( 'text', 'testi_title', __( 'Section Title', 'aerowind' ) )
		->set_default_value( 'What homeowners say' ),
	Field::make( 'image', 'testi_image', __( 'Left Image', 'aerowind' ) )
		->set_value_type( 'url' ),
	Field::make( 'textarea', 'testi_quote', __( 'Quote', 'aerowind' ) )
		->set_default_value( 'Our AeroWind turbine paid for itself faster than we imagined. It is whisper-quiet and our power bill dropped by a third in the first year.' ),
	Field::make( 'text', 'testi_name', __( 'Client Name', 'aerowind' ) )
		->set_default_value( 'Marcus Reyes' ),
	Field::make( 'text', 'testi_role', __( 'Client Location / Role', 'aerowind' ) )
		->set_default_value( 'Homeowner, Boulder CO' ),
	Field::make( 'select', 'testi_rating', __( 'Rating', 'aerowind' ) )
		->set_options( array( '5' => '5 Stars', '4' => '4 Stars', '3' => '3 Stars' ) )
		->set_default_value( '5' ),
) );

/* ---- Contact Form Container ---- */
$front_page->add_tab( __( 'Contact Form', 'aerowind' ), array(
	Field::make( 'text', 'contact_eyebrow', __( 'Eyebrow', 'aerowind' ) )
		->set_default_value( 'Get In Touch' ),
	Field::make( 'text', 'contact_title', __( 'Title', 'aerowind' ) )
		->set_default_value( "Let's upgrade your energy standards." ),
	Field::make( 'text', 'contact_side_title', __( 'Side Panel Title', 'aerowind' ) )
		->set_default_value( 'Zero money down.' ),
	Field::make( 'textarea', 'contact_side_text', __( 'Side Panel Text', 'aerowind' ) )
		->set_default_value( 'Tell us about your home and our wind advisors will design a system, estimate savings, and handle installation — all with no upfront cost.' ),
	Field::make( 'complex', 'contact_side_points', __( 'Side Panel Bullets', 'aerowind' ) )
		->add_fields( array(
			Field::make( 'text', 'text', __( 'Bullet', 'aerowind' ) ),
		) ),
	Field::make( 'text', 'contact_submit', __( 'Submit Button Text', 'aerowind' ) )
		->set_default_value( 'Request My Free Assessment' ),
) );

/* =====================================================================
 * TURBINE (CPT) PRODUCT DETAILS
 * ===================================================================== */
Container::make( 'post_meta', __( 'Turbine Specifications', 'aerowind' ) )
	->where( 'post_type', '=', 'aerowind_turbine' )
	->set_context( 'normal' )
	->set_priority( 'high' )
	->add_fields( array(
		Field::make( 'text', 'turbine_price', __( 'Price', 'aerowind' ) )
			->set_attribute( 'placeholder', '$4,900' ),
		Field::make( 'text', 'turbine_rated_power', __( 'Rated Power', 'aerowind' ) )
			->set_attribute( 'placeholder', '1.5 kW' ),
		Field::make( 'text', 'turbine_rotor_diameter', __( 'Rotor Diameter', 'aerowind' ) )
			->set_attribute( 'placeholder', '3.2 m' ),
		Field::make( 'text', 'turbine_cut_in', __( 'Cut-in Wind Speed', 'aerowind' ) )
			->set_attribute( 'placeholder', '2.5 m/s' ),
		Field::make( 'text', 'turbine_type', __( 'Turbine Type', 'aerowind' ) )
			->set_attribute( 'placeholder', 'Horizontal-axis / Vertical-axis' ),
		Field::make( 'textarea', 'turbine_benefits', __( 'Health Benefits / Value', 'aerowind' ) )
			->set_help_text( 'Displayed in the highlighted "Benefits & Value" box on the detail page.' ),
	) );
