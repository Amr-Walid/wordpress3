<?php
/**
 * Fallback template (archives, blog, search).
 *
 * @package AeroWind
 */

get_header();
?>
<section class="aw-single">
	<div class="aw-container">
		<?php if ( have_posts() ) : ?>
			<div class="aw-section-head" style="text-align:left;margin-bottom:32px">
				<h2><?php is_post_type_archive( 'aerowind_turbine' ) ? esc_html_e( 'Our Turbines', 'aerowind' ) : the_archive_title(); ?></h2>
			</div>
			<div class="aw-turbine-grid">
				<?php while ( have_posts() ) : the_post(); ?>
					<article class="aw-turbine-card">
						<a class="aw-turbine-thumb" href="<?php the_permalink(); ?>">
							<?php if ( has_post_thumbnail() ) { the_post_thumbnail( 'aerowind-card' ); } ?>
						</a>
						<div class="aw-turbine-body">
							<h3><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
							<p><?php echo esc_html( wp_trim_words( get_the_excerpt(), 18 ) ); ?></p>
						</div>
					</article>
				<?php endwhile; ?>
			</div>
			<?php the_posts_pagination(); ?>
		<?php else : ?>
			<h2><?php esc_html_e( 'Nothing found.', 'aerowind' ); ?></h2>
		<?php endif; ?>
	</div>
</section>
<?php
get_footer();
