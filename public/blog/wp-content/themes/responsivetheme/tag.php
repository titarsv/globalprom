<?php get_header(); ?>

<div class="col-lg-8 col-md-8 col-sm-8 col-xs-12">
		<div class="row">
			<section class="post-list">
				<?php if (have_posts()): while (have_posts()): the_post(); ?>
				<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
					<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>			
						<a class="img-post" href="<?php the_permalink() ?>"><?php echo get_the_post_thumbnail($page->ID, 'medium') ?></a>
						<?php $category = get_the_category()?>
						<div class="info">
							<span class="label label-default"><?php echo $category[0]->cat_name?></span>
							<time><?php echo get_the_date('n-F-Y')?></time>
						</div>
						<a class="post-heading" href="<?php the_permalink() ?>"><?php the_title() ?></a>
						<?php if(function_exists('the_ratings')) { the_ratings(); } ?>
						<div class="content">
							<?php the_content()?>
						</div>
						<p><a class="read-more btn btn-primary" href="<?php the_permalink() ?>">Читать далее</a></p>
					</article>
				</div>
				<?php endwhile; endif; ?>
			</section>
		</div>
</div>
<?php get_sidebar(); ?>
<?php get_footer(); ?>