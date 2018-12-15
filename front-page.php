<?php
/*
Template Name: Hem
*/

// Force full width content
add_filter('genesis_site_layout', '__genesis_return_full_width_content');

// Remove regular content
remove_action('genesis_entry_content', 'genesis_do_post_content');

// Remove title
remove_action('genesis_entry_header', 'genesis_do_post_title');

// Add and start the Advanced Custom Fields loop
add_action('genesis_entry_content', 'acf_loop');

function acf_loop()
{

// ----------------------------------------
// Add Advanced Custom Fields content below
// ----------------------------------------
?>


<div id="hero-message-wrapper">
		<div id="hero-1">
			<?php the_field('text_del_1'); ?>
		</div>
	</div>

		<div id="hero-message-cont">
			<div id="hero-ill"></div>
			<div id="hero-2">
				<?php the_field('text_del_2'); ?>
			</div>
			<div id="hero-3">
				<?php the_field('text_del_3'); ?>
			</div>
			<div class="cta-wrapper">
				<a class="cta" href="http://montessori:8888/forskola/"><?php the_field('cta'); ?></a>
			</div>
		</div>

	<div class="wave wave-1"></div>
	<div class="wave-shadow wave-shadow-1"></div>
	<div class="wave wave-2"></div>
	<div class="wave-shadow wave-shadow-2"></div>
	<div class="wave wave-0"></div>
	<div class="wave-shadow wave-shadow-0"></div>


	<?php
	// Matsedel

		// Query the latest entry from this custom post type.
		$args = array( 'post_type' => 'matsedel', 'posts_per_page' => 1 );
		$loop = new WP_Query( $args );
		?>

		<?php while ( $loop->have_posts() ) : $loop->the_post(); ?>

		<div class="matsedel">

		<h3><?php the_title(); ?></h3>

		<ul>
			<?php

			// Get måndag - torsdag

			if ( have_rows( 'm-t' ) ) : ?>
				<?php while ( have_rows( 'm-t' ) ) : the_row(); ?>

					<li class="dag">
						<h4><?php the_sub_field( 'veckodag' ); ?></h4>
						<p>
							<strong>Lunch</strong><br />
							<?php the_sub_field( 'lunch' ); ?><br />
							<strong>Mellanmål</strong><br />
							<?php the_sub_field( 'mellanmal' ); ?>
							<?php the_sub_field( 'mellanmal-annat' ); ?>
						</p>
					</li>

				<?php endwhile; ?>
			<?php else : ?>
				<?php // no rows found ?>
			<?php endif; ?>


			<?php

			// Get fredag

			if ( have_rows( 'fredag' ) ) : ?>
				<?php while ( have_rows( 'fredag' ) ) : the_row(); ?>
					<li class="dag">
						<h4>Fredag</h4>
						<p>
							<strong>Lunch</strong><br />
							<?php the_sub_field( 'lunch' ); ?><br />
							<strong>Mellanmål</strong><br />
							<?php the_sub_field( 'mellanmal' ); ?>
						</p>
					</li>
				<?php endwhile; ?>
			<?php endif; ?>
		</ul>
		</div>

		<?php wp_reset_postdata(); ?>
		<?php endwhile; ?>


<?php
// ----------------------------------------
// Close ACF loop
}
// ----------------------------------------

// Run the Genesis loop

genesis();
