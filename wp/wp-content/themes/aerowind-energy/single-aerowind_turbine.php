<?php
/**
 * Single Turbine template.
 *
 * Displays a dedicated details page for each Turbine CPT entry:
 * Image, Title, Price, Description, Rated Power, Rotor Diameter,
 * Cut-in Wind Speed, and Health Benefits / Value.
 *
 * @package AeroWind
 */

get_header();

while ( have_posts() ) :
	the_post();
	$tid      = get_the_ID();
	$price    = aerowind_meta( $tid, 'turbine_price' );
	$power    = aerowind_meta( $tid, 'turbine_rated_power' );
	$rotor    = aerowind_meta( $tid, 'turbine_rotor_diameter' );
	$cut_in   = aerowind_meta( $tid, 'turbine_cut_in' );
	$type     = aerowind_meta( $tid, 'turbine_type' );
	$benefits = aerowind_meta( $tid, 'turbine_benefits' );
	?>

	<section class="aw-single">
		<div class="aw-container">
			<nav class="aw-breadcrumb">
				<a href="<?php echo esc_url( home_url( '/' ) ); ?>"><?php esc_html_e( 'Home', 'aerowind' ); ?></a>
				&nbsp;/&nbsp;
				<a href="<?php echo esc_url( home_url( '/#turbines' ) ); ?>"><?php esc_html_e( 'Turbines', 'aerowind' ); ?></a>
				&nbsp;/&nbsp;<span><?php the_title(); ?></span>
			</nav>

			<div class="aw-single-grid">
				<div class="aw-single-media">
					<?php if ( has_post_thumbnail() ) {
						the_post_thumbnail( 'large' );
					} ?>
				</div>

				<div class="aw-single-body">
					<?php if ( $power ) : ?>
						<span class="aw-turbine-power"><?php aerowind_icon( 'power' ); echo ' ' . esc_html( $power ); ?></span>
					<?php endif; ?>
					<h1><?php the_title(); ?></h1>
					<?php if ( $type ) : ?>
						<p style="color:var(--aw-sky-600);font-weight:600;margin:-4px 0 10px;font-family:var(--aw-head)"><?php echo esc_html( $type ); ?></p>
					<?php endif; ?>
					<?php if ( $price ) : ?>
						<div class="aw-single-price"><?php echo esc_html( $price ); ?></div>
					<?php endif; ?>

					<div class="aw-single-desc"><?php the_content(); ?></div>

					<div class="aw-specs">
						<?php if ( $power ) : ?>
							<div class="aw-specs-row">
								<span class="aw-spec-label"><?php aerowind_icon( 'power' ); ?><?php esc_html_e( 'Rated Power', 'aerowind' ); ?></span>
								<span class="aw-spec-value"><?php echo esc_html( $power ); ?></span>
							</div>
						<?php endif; ?>
						<?php if ( $rotor ) : ?>
							<div class="aw-specs-row">
								<span class="aw-spec-label"><?php aerowind_icon( 'ruler' ); ?><?php esc_html_e( 'Rotor Diameter', 'aerowind' ); ?></span>
								<span class="aw-spec-value"><?php echo esc_html( $rotor ); ?></span>
							</div>
						<?php endif; ?>
						<?php if ( $cut_in ) : ?>
							<div class="aw-specs-row">
								<span class="aw-spec-label"><?php aerowind_icon( 'gauge' ); ?><?php esc_html_e( 'Cut-in Wind Speed', 'aerowind' ); ?></span>
								<span class="aw-spec-value"><?php echo esc_html( $cut_in ); ?></span>
							</div>
						<?php endif; ?>
						<?php if ( $price ) : ?>
							<div class="aw-specs-row">
								<span class="aw-spec-label"><?php aerowind_icon( 'tag' ); ?><?php esc_html_e( 'Price', 'aerowind' ); ?></span>
								<span class="aw-spec-value"><?php echo esc_html( $price ); ?></span>
							</div>
						<?php endif; ?>
					</div>

					<?php if ( $benefits ) : ?>
						<div class="aw-benefits-box">
							<h3><?php esc_html_e( 'Benefits & Value', 'aerowind' ); ?></h3>
							<p><?php echo esc_html( $benefits ); ?></p>
						</div>
					<?php endif; ?>

					<div style="margin-top:28px;display:flex;gap:14px;flex-wrap:wrap">
						<a class="aw-btn aw-btn-primary" href="<?php echo esc_url( home_url( '/#contact' ) ); ?>"><?php esc_html_e( 'Get a Free Quote', 'aerowind' ); ?></a>
						<a class="aw-btn aw-btn-dark" href="<?php echo esc_url( home_url( '/#turbines' ) ); ?>"><?php esc_html_e( 'Back to Turbines', 'aerowind' ); ?></a>
					</div>
				</div>
			</div>
		</div>
	</section>

	<?php
endwhile;

get_footer();
