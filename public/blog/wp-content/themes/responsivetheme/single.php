<?php get_header();?>
<div class="container siteSection">
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
            <?php while (have_posts()): the_post();?>
                <div class="inner-page__wrapper">
                    <span class="inner-page__title"><?php the_title(); ?></span>
                </div>
                <section class="news-unit__wrapper">
                    <div class="news-unit__content col-xs-12">
                        <?php
                        $content_part = get_extended(get_the_content());
                        echo apply_filters('the_content', $content_part['main']);
                        //the_content();
                        ?>
                    </div>
                </section>
                <?php
                if ( comments_open() || get_comments_number() ) {
                    comments_template();
                }
                ?>
            <?php endwhile; ?>
        </div>
        <?php get_sidebar(); ?>
    </div>
</div>
<?php get_footer(); ?>