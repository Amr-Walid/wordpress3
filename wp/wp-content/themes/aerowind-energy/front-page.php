<?php
/**
 * Front Page template.
 *
 * Renders every home-page section from Carbon Fields post meta:
 * Hero, Zig-zag Intro, Why-Wind cards, Turbines grid (CPT), Outstanding band,
 * Testimonial, and the Contact / lead capture form container.
 *
 * @package AeroWind
 */

get_header();
$pid = get_the_ID();
?>

<?php /* ============================ HERO ============================ */ ?>
<section class="aw-hero" id="top">
	<div class="aw-hero-bg">
		<?php $hero_bg = aerowind_meta( $pid, 'hero_bg' ); ?>
		<?php if ( $hero_bg ) : ?>
			<img src="<?php echo esc_url( $hero_bg ); ?>" alt="<?php esc_attr_e( 'Wind turbines', 'aerowind' ); ?>">
		<?php endif; ?>
	</div>
	<div class="aw-hero-overlay"></div>
	<div class="aw-container">
		<div class="aw-hero-content">
			<?php if ( $eb = aerowind_meta( $pid, 'hero_eyebrow' ) ) : ?>
				<span class="aw-eyebrow"><?php echo esc_html( $eb ); ?></span>
			<?php endif; ?>
			<h1><?php echo esc_html( aerowind_meta( $pid, 'hero_title', 'Wind energy done right.' ) ); ?></h1>
			<p><?php echo esc_html( aerowind_meta( $pid, 'hero_subtitle' ) ); ?></p>
			<div class="aw-hero-actions">
				<?php if ( $c1 = aerowind_meta( $pid, 'hero_cta_text' ) ) : ?>
					<a class="aw-btn aw-btn-primary" href="<?php echo esc_url( aerowind_meta( $pid, 'hero_cta_link', '#contact' ) ); ?>"><?php echo esc_html( $c1 ); ?></a>
				<?php endif; ?>
				<?php if ( $c2 = aerowind_meta( $pid, 'hero_cta2_text' ) ) : ?>
					<a class="aw-btn aw-btn-ghost" href="<?php echo esc_url( aerowind_meta( $pid, 'hero_cta2_link', '#turbines' ) ); ?>"><?php echo esc_html( $c2 ); ?></a>
				<?php endif; ?>
			</div>
			<?php $badges = aerowind_meta( $pid, 'hero_badges', array() ); ?>
			<?php if ( ! empty( $badges ) && is_array( $badges ) ) : ?>
				<div class="aw-hero-badges">
					<?php foreach ( $badges as $b ) : ?>
						<div class="aw-hero-badge">
							<strong><?php echo esc_html( $b['value'] ?? '' ); ?></strong>
							<span><?php echo esc_html( $b['label'] ?? '' ); ?></span>
						</div>
					<?php endforeach; ?>
				</div>
			<?php endif; ?>
		</div>
	</div>
</section>

<?php /* ============================ ZIG-ZAG INTRO ============================ */ ?>
<section class="aw-section aw-zigzag" id="about">
	<div class="aw-container">
		<div class="aw-zigzag-grid">
			<div class="aw-zigzag-media">
				<?php $intro_img = aerowind_meta( $pid, 'intro_image' ); ?>
				<?php if ( $intro_img ) : ?>
					<img src="<?php echo esc_url( $intro_img ); ?>" alt="<?php esc_attr_e( 'Residential wind turbine', 'aerowind' ); ?>">
				<?php endif; ?>
				<div class="aw-float-card">
					<span class="aw-float-icon"><?php aerowind_icon( 'bill' ); ?></span>
					<div>
						<strong><?php echo esc_html( aerowind_meta( $pid, 'intro_float_value', '30%' ) ); ?></strong>
						<span><?php echo esc_html( aerowind_meta( $pid, 'intro_float_label', '' ) ); ?></span>
					</div>
				</div>
			</div>
			<div class="aw-zigzag-text">
				<?php if ( $eb = aerowind_meta( $pid, 'intro_eyebrow' ) ) : ?>
					<span class="aw-eyebrow"><?php echo esc_html( $eb ); ?></span>
				<?php endif; ?>
				<h2><?php echo esc_html( aerowind_meta( $pid, 'intro_title', 'Go wind with the best.' ) ); ?></h2>
				<div class="aw-rich"><?php echo wp_kses_post( aerowind_meta( $pid, 'intro_body' ) ); ?></div>
				<?php $points = aerowind_meta( $pid, 'intro_points', array() ); ?>
				<?php if ( ! empty( $points ) && is_array( $points ) ) : ?>
					<ul class="aw-zigzag-list">
						<?php foreach ( $points as $p ) : ?>
							<li>
								<span class="aw-check"><?php aerowind_icon( 'check' ); ?></span>
								<div>
									<h4><?php echo esc_html( $p['title'] ?? '' ); ?></h4>
									<p><?php echo esc_html( $p['text'] ?? '' ); ?></p>
								</div>
							</li>
						<?php endforeach; ?>
					</ul>
				<?php endif; ?>
				<?php if ( $cta = aerowind_meta( $pid, 'intro_cta_text' ) ) : ?>
					<a class="aw-btn aw-btn-primary" href="<?php echo esc_url( aerowind_meta( $pid, 'intro_cta_link', '#contact' ) ); ?>"><?php echo esc_html( $cta ); ?></a>
				<?php endif; ?>
			</div>
		</div>
	</div>
</section>

<?php /* ============================ WHY WIND CARDS ============================ */ ?>
<section class="aw-section aw-why" id="why">
	<div class="aw-container">
		<div class="aw-section-head">
			<?php if ( $eb = aerowind_meta( $pid, 'why_eyebrow' ) ) : ?>
				<span class="aw-eyebrow"><?php echo esc_html( $eb ); ?></span>
			<?php endif; ?>
			<h2><?php echo esc_html( aerowind_meta( $pid, 'why_title', 'Why go wind now?' ) ); ?></h2>
		</div>
		<?php $cards = aerowind_meta( $pid, 'why_cards', array() ); ?>
		<?php if ( ! empty( $cards ) && is_array( $cards ) ) : ?>
			<div class="aw-cards">
				<?php foreach ( $cards as $card ) : ?>
					<div class="aw-card">
						<div class="aw-card-icon"><?php aerowind_icon( $card['icon'] ?? 'wind' ); ?></div>
						<h3><?php echo esc_html( $card['title'] ?? '' ); ?></h3>
						<p><?php echo esc_html( $card['description'] ?? '' ); ?></p>
					</div>
				<?php endforeach; ?>
			</div>
		<?php endif; ?>
	</div>
</section>

<?php /* ============================ TURBINES (CPT) ============================ */ ?>
<section class="aw-section aw-products" id="turbines">
	<div class="aw-container">
		<div class="aw-section-head">
			<?php if ( $eb = aerowind_meta( $pid, 'products_eyebrow' ) ) : ?>
				<span class="aw-eyebrow"><?php echo esc_html( $eb ); ?></span>
			<?php endif; ?>
			<h2><?php echo esc_html( aerowind_meta( $pid, 'products_title', 'Turbines for every home' ) ); ?></h2>
			<p><?php echo esc_html( aerowind_meta( $pid, 'products_subtitle' ) ); ?></p>
		</div>
		<?php
		$turbines = new WP_Query( array(
			'post_type'      => 'aerowind_turbine',
			'posts_per_page' => 4,
			'orderby'        => 'date',
			'order'          => 'ASC',
		) );
		if ( $turbines->have_posts() ) : ?>
			<div class="aw-turbine-grid">
				<?php while ( $turbines->have_posts() ) : $turbines->the_post();
					$tid   = get_the_ID();
					$power = aerowind_meta( $tid, 'turbine_rated_power' );
					$price = aerowind_meta( $tid, 'turbine_price' );
					?>
					<article class="aw-turbine-card">
						<a class="aw-turbine-thumb" href="<?php the_permalink(); ?>">
							<?php if ( has_post_thumbnail() ) {
								the_post_thumbnail( 'aerowind-card' );
							} ?>
						</a>
						<div class="aw-turbine-body">
							<?php if ( $power ) : ?>
								<span class="aw-turbine-power"><?php aerowind_icon( 'power' ); echo ' ' . esc_html( $power ); ?></span>
							<?php endif; ?>
							<h3><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
							<p><?php echo esc_html( wp_trim_words( get_the_excerpt(), 16 ) ); ?></p>
							<div class="aw-turbine-foot">
								<?php if ( $price ) : ?><span class="aw-turbine-price"><?php echo esc_html( $price ); ?></span><?php endif; ?>
								<a class="aw-btn aw-btn-primary" style="padding:9px 18px;font-size:.85rem" href="<?php the_permalink(); ?>"><?php esc_html_e( 'View', 'aerowind' ); ?></a>
							</div>
						</div>
					</article>
				<?php endwhile; ?>
			</div>
		<?php endif; wp_reset_postdata(); ?>
	</div>
</section>

<?php /* ============================ OUTSTANDING BAND ============================ */ ?>
<section class="aw-section aw-band">
	<div class="aw-container">
		<div class="aw-section-head">
			<?php if ( $eb = aerowind_meta( $pid, 'band_eyebrow' ) ) : ?>
				<span class="aw-eyebrow"><?php echo esc_html( $eb ); ?></span>
			<?php endif; ?>
			<h2><?php echo esc_html( aerowind_meta( $pid, 'band_title' ) ); ?></h2>
			<p><?php echo esc_html( aerowind_meta( $pid, 'band_subtitle' ) ); ?></p>
		</div>
		<?php $cols = aerowind_meta( $pid, 'band_cols', array() ); ?>
		<?php if ( ! empty( $cols ) && is_array( $cols ) ) : ?>
			<div class="aw-band-grid">
				<?php foreach ( $cols as $col ) : ?>
					<div class="aw-band-col">
						<div class="aw-band-icon"><?php aerowind_icon( $col['icon'] ?? 'shield' ); ?></div>
						<h4><?php echo esc_html( $col['title'] ?? '' ); ?></h4>
						<p><?php echo esc_html( $col['text'] ?? '' ); ?></p>
					</div>
				<?php endforeach; ?>
			</div>
		<?php endif; ?>
	</div>
</section>

<?php /* ============================ TESTIMONIAL ============================ */ ?>
<section class="aw-section aw-testi" id="reviews">
	<div class="aw-container">
		<div class="aw-section-head">
			<?php if ( $eb = aerowind_meta( $pid, 'testi_eyebrow' ) ) : ?>
				<span class="aw-eyebrow"><?php echo esc_html( $eb ); ?></span>
			<?php endif; ?>
			<h2><?php echo esc_html( aerowind_meta( $pid, 'testi_title', 'What homeowners say' ) ); ?></h2>
		</div>
		<div class="aw-testi-grid">
			<div class="aw-testi-media">
				<?php $ti = aerowind_meta( $pid, 'testi_image' ); ?>
				<?php if ( $ti ) : ?><img src="<?php echo esc_url( $ti ); ?>" alt="<?php esc_attr_e( 'Happy customer', 'aerowind' ); ?>"><?php endif; ?>
			</div>
			<div class="aw-review-card">
				<div class="aw-google">
					<?php aerowind_icon( 'google' ); ?>
					<?php
					$rating = (int) aerowind_meta( $pid, 'testi_rating', 5 );
					echo '<span class="aw-stars">' . str_repeat( '★', $rating ) . str_repeat( '☆', 5 - $rating ) . '</span>';
					?>
					<span style="color:var(--aw-slate);font-size:.85rem">Google Reviews</span>
				</div>
				<blockquote class="aw-review-quote">&ldquo;<?php echo esc_html( aerowind_meta( $pid, 'testi_quote' ) ); ?>&rdquo;</blockquote>
				<div class="aw-review-author">
					<?php $name = aerowind_meta( $pid, 'testi_name', 'Customer' ); ?>
					<span class="aw-avatar"><?php echo esc_html( strtoupper( substr( $name, 0, 1 ) ) ); ?></span>
					<div>
						<strong><?php echo esc_html( $name ); ?></strong>
						<span><?php echo esc_html( aerowind_meta( $pid, 'testi_role' ) ); ?></span>
					</div>
				</div>
			</div>
		</div>
	</div>
</section>

<?php /* ============================ CONTACT / LEAD FORM ============================ */ ?>
<section class="aw-section aw-contact" id="contact">
	<div class="aw-container">
		<div class="aw-section-head">
			<?php if ( $eb = aerowind_meta( $pid, 'contact_eyebrow' ) ) : ?>
				<span class="aw-eyebrow"><?php echo esc_html( $eb ); ?></span>
			<?php endif; ?>
			<h2><?php echo esc_html( aerowind_meta( $pid, 'contact_title' ) ); ?></h2>
		</div>

		<?php if ( isset( $_GET['lead'] ) && 'success' === $_GET['lead'] ) : ?>
			<div style="max-width:760px;margin:0 auto 26px;padding:16px 22px;border-radius:14px;background:var(--aw-sky-light);color:var(--aw-sky-700);font-weight:600;text-align:center">
				<?php esc_html_e( 'Thank you! Our wind advisors will be in touch within one business day.', 'aerowind' ); ?>
			</div>
		<?php endif; ?>

		<div class="aw-contact-grid">
			<div class="aw-contact-side">
				<span class="aw-eyebrow"><?php echo esc_html( aerowind_meta( $pid, 'contact_eyebrow', 'Free Assessment' ) ); ?></span>
				<h2><?php echo esc_html( aerowind_meta( $pid, 'contact_side_title', 'Zero money down.' ) ); ?></h2>
				<p><?php echo esc_html( aerowind_meta( $pid, 'contact_side_text' ) ); ?></p>
				<?php $sp = aerowind_meta( $pid, 'contact_side_points', array() ); ?>
				<?php if ( ! empty( $sp ) && is_array( $sp ) ) : ?>
					<ul>
						<?php foreach ( $sp as $point ) : ?>
							<li><?php aerowind_icon( 'check' ); ?><span><?php echo esc_html( $point['text'] ?? '' ); ?></span></li>
						<?php endforeach; ?>
					</ul>
				<?php endif; ?>
			</div>

			<form class="aw-contact-form" method="post" action="<?php echo esc_url( admin_url( 'admin-post.php' ) ); ?>">
				<input type="hidden" name="action" value="aerowind_lead">
				<?php wp_nonce_field( 'aerowind_lead', 'aerowind_lead_nonce' ); ?>
				<div class="aw-form-row">
					<div class="aw-field">
						<label for="aw_name"><?php esc_html_e( 'Full Name', 'aerowind' ); ?></label>
						<input type="text" id="aw_name" name="aw_name" placeholder="Jane Doe" required>
					</div>
					<div class="aw-field">
						<label for="aw_email"><?php esc_html_e( 'Email', 'aerowind' ); ?></label>
						<input type="email" id="aw_email" name="aw_email" placeholder="jane@email.com" required>
					</div>
				</div>
				<div class="aw-form-row">
					<div class="aw-field">
						<label for="aw_phone"><?php esc_html_e( 'Phone', 'aerowind' ); ?></label>
						<input type="tel" id="aw_phone" name="aw_phone" placeholder="(555) 123-4567">
					</div>
					<div class="aw-field">
						<label for="aw_bill"><?php esc_html_e( 'Average Monthly Bill', 'aerowind' ); ?></label>
						<select id="aw_bill" name="aw_bill">
							<option value="">Select range</option>
							<option>Under $80</option>
							<option>$80 – $150</option>
							<option>$150 – $250</option>
							<option>Over $250</option>
						</select>
					</div>
				</div>
				<div class="aw-field">
					<label for="aw_message"><?php esc_html_e( 'Message', 'aerowind' ); ?></label>
					<textarea id="aw_message" name="aw_message" placeholder="Tell us about your home and roof..."></textarea>
				</div>
				<button type="submit" class="aw-btn aw-btn-primary" style="width:100%;justify-content:center">
					<?php echo esc_html( aerowind_meta( $pid, 'contact_submit', 'Request My Free Assessment' ) ); ?>
				</button>
				<p class="aw-form-note"><?php esc_html_e( 'By submitting you agree to be contacted by AeroWind Energy. No spam, ever.', 'aerowind' ); ?></p>
			</form>
		</div>
	</div>
</section>

<?php get_footer(); ?>
