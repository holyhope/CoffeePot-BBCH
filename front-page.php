<?php
/**
 * User: Pierre Péronnet
 * Date: 23/10/2015
 */

get_header();
$template_directory = get_stylesheet_directory_uri();
?>
    <header id="home-page">
        <?php
        if (($id = get_theme_mod('front_slider_id')) && ($slider_callback = apply_filters('coffeepot_bbch_slider_callback', false))) {
            add_filter('easingslider_get_container_styles', 'coffeepot_bbch_easingslider_styles');
            add_filter('easingslider_get_viewport_styles', 'coffeepot_bbch_easingslider_styles');
            call_user_func($slider_callback, $id);
            remove_filter('easingslider_get_viewport_styles', 'coffeepot_bbch_easingslider_styles');
            remove_filter('easingslider_get_container_styles', 'coffeepot_bbch_easingslider_styles');
            /*
            ?>
            <h1 class="title center-block img-circle text-center"><?php
                preg_match_all("/\\p{Lu}/", get_bloginfo('name'), $uppercase);
                $uppercase = implode('', $uppercase[0]);
                $length = strlen($uppercase);
                $head = substr($uppercase, 0, $length / 2);
                $queue = substr($uppercase, $length - strlen($head));
                echo '<span class="head">', esc_html($head), '</span>';
                echo '<span class="queue">' . esc_html($queue) . '</span>';
                ?></h1>
            <?php
            */
            ?>
            <div class="center-block img-circle title text-center">
                <img
                    src="<?php echo esc_url(get_theme_mod('front_logo', $template_directory . '/images/logo_color.png')); ?>"/>
            </div>

            <?php if (display_header_text()): ?>
                <div class="content-container"><p
                        class="content lead center-block text-center"><?php bloginfo('description'); ?></p></div>
            <?php endif; ?>

            <div class="text-center arrow-container"><a
                    class="arrow down dashicons dashicons-arrow-down" href="#banner"
                    onclick="javascript: jQuery.smoothScroll({scrollTarget: '#banner'}); return false;"></a></div>
            <?php
        } else { ?>
            <div class="container-fluid jumbotron m-a-0"
                 style="background-image: url('<?php echo get_theme_mod('front_image', $template_directory . '/images/skyline_nyc.jpg'); ?>');">
                <h1 hidden class="title center-block img-circle text-center"><?php
                    preg_match_all("/\\p{Lu}/", get_bloginfo('name'), $uppercase);
                    $uppercase = implode('', $uppercase[0]);
                    $length = strlen($uppercase);
                    $head = substr($uppercase, 0, $length / 2);
                    $queue = substr($uppercase, $length - strlen($head));
                    echo '<span class="head">', esc_html($head), '</span>';
                    echo '<span class="queue">' . esc_html($queue) . '</span>';
                    ?></h1>

                <div class="center-block img-circle title text-center">
                    <img
                        src="<?php echo esc_url(get_theme_mod('front_logo', $template_directory . '/images/logo_color.png')); ?>"/>
                </div>

                <?php if (display_header_text()): ?>
                    <div class="content-container"><p
                            class="content lead center-block text-center"><?php bloginfo('description'); ?></p></div>
                <?php endif; ?>

                <div class="text-center arrow-container"><a
                        class="arrow down dashicons dashicons-arrow-down" href="#banner"
                        onclick="javascript: jQuery.smoothScroll({scrollTarget: '#banner'}); return false;"></a></div>
            </div>
            <?php
        } ?>
    </header>
<?php
get_template_part('banner', 'front'); ?>
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