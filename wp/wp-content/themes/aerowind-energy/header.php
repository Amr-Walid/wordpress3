<?php
/**
 * Header template — loads global theme options.
 *
 * @package AeroWind
 */
?><!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<?php wp_body_open(); ?>

<?php
$announce_on   = aerowind_opt( 'aw_announce_enable', true );
$announce_text = aerowind_opt( 'aw_announce_text', '' );
if ( $announce_on && $announce_text ) : ?>
	<div class="aw-announce"><?php echo wp_kses_post( $announce_text ); ?></div>
<?php endif; ?>

<header class="aw-header" id="aw-header">
	<div class="aw-container aw-header-inner">
		<a class="aw-logo" href="<?php echo esc_url( home_url( '/' ) ); ?>">
			<?php
			$logo_img  = aerowind_opt( 'aw_logo_image', '' );
			$logo_text = aerowind_opt( 'aw_logo_text', 'AeroWind' );
			if ( $logo_img ) : ?>
				<img src="<?php echo esc_url( $logo_img ); ?>" alt="<?php echo esc_attr( $logo_text ); ?>">
			<?php else :
				$parts = explode( ' ', $logo_text, 2 ); ?>
				<span class="aw-logo-mark"><?php aerowind_icon( 'wind' ); ?></span>
				<span><?php echo esc_html( $parts[0] ); ?><span class="aw-accent"><?php echo isset( $parts[1] ) ? esc_html( $parts[1] ) : 'Wind'; ?></span></span>
			<?php endif; ?>
		</a>

		<nav class="aw-nav" aria-label="<?php esc_attr_e( 'Primary', 'aerowind' ); ?>">
			<?php
			if ( has_nav_menu( 'primary' ) ) {
				wp_nav_menu( array(
					'theme_location' => 'primary',
					'container'      => false,
					'menu_class'     => '',
					'fallback_cb'    => 'aerowind_default_menu',
				) );
			} else {
				aerowind_default_menu();
			}
			?>
		</nav>

		<div class="aw-header-actions">
			<?php $phone = aerowind_opt( 'aw_header_phone', '' ); ?>
			<?php if ( $phone ) : ?>
				<a class="aw-header-phone" href="tel:<?php echo esc_attr( preg_replace( '/[^0-9+]/', '', $phone ) ); ?>">
					<?php aerowind_icon( 'phone' ); ?><span><?php echo esc_html( $phone ); ?></span>
				</a>
			<?php endif; ?>
			<a class="aw-btn aw-btn-primary" href="<?php echo esc_url( aerowind_opt( 'aw_header_cta_link', '#contact' ) ); ?>">
				<?php echo esc_html( aerowind_opt( 'aw_header_cta_text', 'Get Started' ) ); ?>
			</a>
			<button class="aw-burger" id="aw-burger" aria-label="<?php esc_attr_e( 'Toggle menu', 'aerowind' ); ?>">
				<span></span><span></span><span></span>
			</button>
		</div>
	</div>
</header>

<main id="aw-main">
