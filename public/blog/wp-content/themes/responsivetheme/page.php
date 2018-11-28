<?php get_header();?>

<div class="col-lg-8 col-md-8 col-sm-8 col-xs-12">
		<div class="row">
			<section>
				<?php while (have_posts()): the_post();?>
								<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>			
									<div class="main-heading">
										<h1><?php the_title(); ?></h1>
									</div>
									<a class="img-post" href="<?php the_permalink() ?>"><?php echo get_the_post_thumbnail() ?></a>
									<?php $category = get_the_category()?>
									<?php the_content();?>
								</article>
				<?php endwhile; ?>
			</section>
	</div>
</div>
<?php get_sidebar(); ?>
<?php get_footer(); ?>