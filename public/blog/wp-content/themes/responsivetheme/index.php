<?php get_header(); ?>
    <section class="siteSection">
        <div class="container">
            <div class="row">
                <div class="col-xs-12">
                    <h1><?php bloginfo('name'); ?></h1>

                    <div class="subHeader"><?php bloginfo('description'); ?></div>
                    <nav class="newsTabs js-tabs">
                        <ul>
                            <?php echo str_replace('<a','<a class="btn"',wp_list_categories(['title_li' => '', 'style' => 'list', 'echo' => 0])); ?>
                        </ul>
                    </nav>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-8">
                    <div class="row">
                        <?php if (have_posts()): while (have_posts()): the_post(); ?>
                            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                <div class="article-item blog-item_big clearfix">
                                    <div class="blog-item-img">
                                        <a href="<?php the_permalink() ?>"><?php echo get_the_post_thumbnail($page->ID, 'medium') ?></a>
                                    </div>
                                    <div class="article-item-content">
                                        <div class="article-item-title">
                                            <a href="<?php the_permalink() ?>"><?php the_title() ?></a>
                                            <?php if(function_exists('the_ratings')) { the_ratings(); } ?>
                                        </div>
                                        <div class="article-item-text">
                                            <?php the_content()?>
                                        </div>
                                    </div>
                                    <div class="article-item-meta clearfix">
                                        <div class="article-item-date">
                                            <?php echo get_the_date('j F Y')?>
                                        </div>
                                        <div class="article-item-action">
                                            <a href="<?php the_permalink() ?>">Читать далее</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php endwhile; endif; ?>
                    </div>
                </div>
                <?php get_sidebar(); ?>
            </div>
            <div class="row">
                <div class="col-xs-12">
                    <div id="paginator">
                        <?php the_posts_pagination(); ?>
                    </div>
                </div>
            </div>
        </div>
    </section>

<?php get_footer(); ?>