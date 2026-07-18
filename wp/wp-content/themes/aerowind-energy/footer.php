<?php
/**
 * Footer template — loads global footer options (info, columns, copyright).
 *
 * @package AeroWind
 */
?>
</main><!-- #aw-main -->

<footer class="aw-footer">
	<div class="aw-container">
		<div class="aw-footer-top">
			<div class="aw-footer-brand">
				<a class="aw-logo" href="<?php echo esc_url( home_url( '/' ) ); ?>">
					<span class="aw-logo-mark"><?php aerowind_icon( 'wind' ); ?></span>
					<?php
					$logo_text = aerowind_opt( 'aw_logo_text', 'AeroWind' );
					$parts     = explode( ' ', $logo_text, 2 );
					?>
					<span style="color:#fff"><?php echo esc_html( $parts[0] ); ?><span class="aw-accent"><?php echo isset( $parts[1] ) ? esc_html( $parts[1] ) : 'Wind'; ?></span></span>
				</a>
				<p class="aw-footer-about"><?php echo esc_html( aerowind_opt( 'aw_footer_about', '' ) ); ?></p>
				<ul class="aw-footer-contact" style="margin-top:20px">
					<?php if ( $ph = aerowind_opt( 'aw_footer_phone', '' ) ) : ?>
						<li><?php aerowind_icon( 'phone' ); ?><span><?php echo esc_html( $ph ); ?></span></li>
					<?php endif; ?>
					<?php if ( $em = aerowind_opt( 'aw_footer_email', '' ) ) : ?>
						<li><?php aerowind_icon( 'mail' ); ?><span><?php echo esc_html( $em ); ?></span></li>
					<?php endif; ?>
					<?php if ( $ad = aerowind_opt( 'aw_footer_address', '' ) ) : ?>
						<li><?php aerowind_icon( 'map' ); ?><span><?php echo esc_html( $ad ); ?></span></li>
					<?php endif; ?>
				</ul>
			</div>

			<?php
			$columns = aerowind_opt( 'aw_footer_columns', array() );
			if ( ! empty( $columns ) && is_array( $columns ) ) :
				foreach ( $columns as $col ) : ?>
					<div class="aw-footer-col">
						<h4><?php echo esc_html( $col['title'] ?? '' ); ?></h4>
						<ul>
							<?php
							if ( ! empty( $col['links'] ) && is_array( $col['links'] ) ) {
								foreach ( $col['links'] as $link ) {
									printf(
										'<li><a href="%s">%s</a></li>',
										esc_url( $link['url'] ?? '#' ),
										esc_html( $link['label'] ?? '' )
									);
								}
							}
							?>
						</ul>
					</div>
				<?php endforeach;
			endif; ?>
		</div>

		<div class="aw-footer-bottom">
			<span><?php echo esc_html( aerowind_opt( 'aw_footer_copyright', '© AeroWind Energy' ) ); ?></span>
			<div class="aw-social">
				<a href="#" aria-label="Facebook"><?php aerowind_icon( 'facebook' ); ?></a>
				<a href="#" aria-label="Twitter"><?php aerowind_icon( 'twitter' ); ?></a>
				<a href="#" aria-label="LinkedIn"><?php aerowind_icon( 'linkedin' ); ?></a>
				<a href="#" aria-label="Instagram"><?php aerowind_icon( 'instagram' ); ?></a>
			</div>
		</div>
	</div>
</footer>

<?php wp_footer(); ?>
</body>
</html>
