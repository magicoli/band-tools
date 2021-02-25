<?php

get_header();
the_post();

// vars
$location = get_field('location');
$thumbnail = get_field('thumbnail');

?>

<div class="wrap">
  C'est ma template à moa!
	<div id="event-hero">

		<?php if( $location ): ?>
		<div id="event-map" class="acf-map">
			<div class="marker" data-lat="<?php echo $location['lat']; ?>" data-lng="<?php echo $location['lng']; ?>"></div>
		</div>
		<?php endif; ?>


		<?php if( $thumbnail ): ?>
			<img class="thumbnail" src="<?php echo $thumbnail['url']; ?>" alt="<?php echo $thumbnail['alt']; ?>" />
		<?php endif; ?>

		<h2><?php the_title(); ?></h2>
		<h3><?php the_field('date'); ?> from <?php the_field('start_time'); ?> to <?php the_field('end_time'); ?></h3>
		<h4><?php echo $location['address']; ?></h4>

	</div>

	<div id="primary" class="content-area">
		<main id="main" class="site-main" role="main">
			<?php the_content(); ?>
		</main>
	</div>

</div>

<?php get_footer(); ?>
