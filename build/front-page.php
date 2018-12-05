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


<?php if (have_rows('meny')) : ?>

<div class="matsedel">
	<h3><?php the_field( 'meny_rubrik' ); ?></h3>
	<ul>
	<?php while (have_rows('meny')) : the_row(); ?>
		<li class="dag"><h4>MÅNDAG</h4><?php the_sub_field('mandag'); ?></li>
		<li class="dag"><h4>TISDAG</h4><?php the_sub_field('tisdag'); ?></li>
		<li class="dag"><h4>ONSDAG</h4><?php the_sub_field('onsdag'); ?></li>
		<li class="dag"><h4>TORSDAG</h4><?php the_sub_field('torsdag'); ?></li>
		<li class="dag"><h4>FREDAG</h4><?php the_sub_field('fredag'); ?></li>
	<?php endwhile; ?>
	</ul>
</div>

<?php endif; ?>


<?php
// ----------------------------------------
// Close ACF loop
}
// ----------------------------------------

// Run the Genesis loop

genesis();
