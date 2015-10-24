<?php
/**
 * User: Pierre Péronnet
 * Date: 19/10/2015
 */
get_header();
get_template_part('banner', 'front');
?>
    <div class="container" id="page">
        <?php the_post(); ?>
        <article <?php post_class('container-fluid'); ?> id="post-<?php the_ID(); ?>">
            <div class="entry"><?php the_content(); ?></div>
        </article>
        <div class="button-collapse">
            <?php if (get_theme_mod('collapsible', false)): ?>
                <span class="arrows collapsed" data-toggle="collapse" data-target="#content">
                    <span class="down dashicons dashicons-arrow-down"></span>
                    <span class="up dashicons dashicons-arrow-up"></span>
                </span>
            <?php endif; ?>
        </div>
    </div>
<?php get_footer();