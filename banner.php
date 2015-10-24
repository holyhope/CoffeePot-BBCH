<?php
/**
 * User: Pierre Péronnet
 * Date: 23/10/2015
 */

$description_page_content = get_theme_mod('desccription_page_content', 'Knowing whose advice to take
and on what topic is the single most
important decision an entrepreneur
can make.');
$description_page_title = get_theme_mod('desccription_page_title', 'Our team');
?>
<div id="banner">
    <?php
    if (($id = get_theme_mod('banner_slider_id')) && ($slider_callback = apply_filters('coffeepot_bbch_banner_slider_callback', false))) {
        call_user_func($slider_callback, $id);
        ?>
        <header class="container-fluid">
            <div class="container">
                <div class="row">
                    <h1 hidden class="col-xs-12 col-md-5 title"><a
                            href="<?php echo home_url(); ?>"><?php bloginfo('name'); ?></a></h1>

                    <div class="col-xs-12 col-md-5 title"><img
                            src="<?php echo esc_url(get_theme_mod('page_logo', get_stylesheet_directory_uri() . '/images/logo_white.png')); ?>"/>
                    </div>
                    <div class="col-md-1 hidden-sm-down">
                        <div class="center-block separator"></div>
                    </div>
                    <div class="col-xs-12 col-md-6">
                        <div
                            class="subtitle text-uppercase m-a-0"><?php echo esc_html($description_page_title); ?></div>

                        <div
                            class="content lead"><?php echo wpautop(esc_html($description_page_content)); ?></div>
                    </div>
                </div>
            </div>
        </header>
        <?php
    } else {
        ?>
        <header class="jumbotron m-a-0" id="banner" style="background-image: url('<?php header_image() ?>');">
            <div class="container">
                <div class="row">
                    <h1 class="col-xs-12 col-md-5 title"><a
                            href="<?php echo home_url(); ?>"><?php bloginfo('name'); ?></a></h1>

                    <div class="col-md-1 hidden-sm-down">
                        <div class="center-block separator"></div>
                    </div>
                    <div class="col-xs-12 col-md-6">
                        <div
                            class="subtitle text-uppercase m-a-0"><?php echo esc_html($description_page_title); ?></div>

                        <div
                            class="content lead"><?php echo wpautop(esc_html($description_page_content)); ?></div>
                    </div>
                </div>
            </div>
        </header>
        <?php
    } ?>
</div>