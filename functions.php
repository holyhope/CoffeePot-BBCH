<?php
/**
 * User: Pierre Péronnet
 * Date: 19/10/2015
 */

include_once 'bootstrap.php';
include_once 'gmap.php';

function coffeepot_bbch_enqueue()
{
    wp_enqueue_style('core', get_stylesheet_uri(), false);
    wp_enqueue_style('override', get_template_directory_uri() . '/override.css', false);
    wp_enqueue_style('dashicons');

    wp_add_inline_style('core', '#banner .container-fluid{height:' . get_theme_mod('banner_height', 400) . 'px}');
}

add_action('wp_enqueue_scripts', 'coffeepot_bbch_enqueue');

function coffeepot_bbch_enqueue_libraries()
{
    wp_enqueue_script('jquery-smoothscroll', get_template_directory_uri() . '/scripts/jquery.smooth-scroll.js', array('jquery'), false, true);
}

add_action('wp_enqueue_scripts', 'coffeepot_bbch_enqueue_libraries');

function coffeepot_bbch_setup()
{
    add_theme_support('custom-header', array(
        'width' => 1200,
        'height' => 400,
        'default-image' => get_stylesheet_directory_uri() . '/images/meeting_people.jpg',
    ));
    remove_theme_support('menus');
}

add_action('after_setup_theme', 'coffeepot_bbch_setup');

function coffeepot_bbch_setup_simplify()
{
    remove_theme_support('custom-background');
}

add_action('after_setup_theme', 'coffeepot_bbch_setup_simplify');

function coffeepot_bbch_footer_copyrights()
{
    ?>
    <div
        class="container copyrights"><?php
        echo esc_html(get_theme_mod('footer_copyrights', __('Made by CoffeePot', 'coffeepot_bbch')));
        ?></div>
    <?php
}

add_action('wp_footer', 'coffeepot_bbch_footer_copyrights', 30);

function coffeepot_bbch_adminbar_simplify($wp_admin_bar)
{
    $slider_callback_exists = (bool)apply_filters('coffeepot_bbch_slider_callback', false);

    $wp_admin_bar->add_node(array(
        'id' => 'front-page',
        'href' => admin_url('customize.php?' . http_build_query(array(
                'return' => $_SERVER['REQUEST_URI'],
                'autofocus[section]' => 'title_tagline',
            ), '', '&')),
        'title' => __('Landing page', 'coffeepot_bbch'),
        'parent' => 'customize',
    ));
    if ($slider_callback_exists) {
        if ($id = get_theme_mod('front_slider_id')) {
            $wp_admin_bar->add_node(array(
                'id' => 'banner-slider',
                'href' => admin_url('admin.php?' . http_build_query(array(
                        'page' => 'easingslider_edit_sliders',
                        'edit' => $id,
                    ), '', '&')),
                'title' => __('Landing images', 'coffeepot_bbch'),
                'parent' => 'customize',
            ));
        }
    }
    $wp_admin_bar->add_node(array(
        'id' => 'banner',
        'href' => admin_url('customize.php?' . http_build_query(array(
                'return' => $_SERVER['REQUEST_URI'],
                'autofocus[section]' => 'banner',
            ), '', '&')),
        'title' => __('Banner', 'coffeepot_bbch'),
        'parent' => 'customize',
    ));
    if ($slider_callback_exists) {
        if ($id = get_theme_mod('banner_slider_id')) {
            $wp_admin_bar->add_node(array(
                'id' => 'banner-slider',
                'href' => admin_url('admin.php?' . http_build_query(array(
                        'page' => 'easingslider_edit_sliders',
                        'edit' => $id,
                    ), '', '&')),
                'title' => __('Banner images', 'coffeepot_bbch'),
                'parent' => 'customize',
            ));
        }
    }
    $wp_admin_bar->add_node(array(
        'id' => 'map-footer',
        'href' => admin_url('customize.php?' . http_build_query(array(
                'return' => $_SERVER['REQUEST_URI'],
                'autofocus[section]' => 'footer',
            ), '', '&')),
        'title' => __('Footer', 'coffeepot_bbch'),
        'parent' => 'customize',
    ));
}

add_action('admin_bar_menu', 'coffeepot_bbch_adminbar_simplify');

function coffeepot_bbch_customize_simplify($wp_customize)
{
    $wp_customize->remove_section('themes');
    $wp_customize->remove_section('colors');
    $wp_customize->remove_section('nav_menus');
}

add_action('customize_register', 'coffeepot_bbch_customize_simplify', 1000);

function coffeepot_bbch_customize_tagline($wp_customize)
{
    $template_directory = get_stylesheet_directory_uri();

    $section = $wp_customize->get_section('title_tagline');
    $section->title = __('Front page', 'coffeepot_bbch');
    $section->description = __('Customize the home page', 'coffeepot_bbch');

    $wp_customize->add_setting('front_logo', array(
        'default' => $template_directory . '/images/logo_color.png',
        'transport' => 'refresh',
        'sanitize_callback' => 'esc_url_raw',
    ));
    $wp_customize->add_control(new WP_Customize_Image_Control($wp_customize, 'front_logo', array(
        'label' => __('Front logo', 'coffeepot_bbch'),
        'section' => 'title_tagline',
        'settings' => 'front_logo',
        'priority' => 1,
    )));
    $wp_customize->add_setting('front_image', array(
        'default' => $template_directory . '/images/skyline_nyc.jpg',
        'transport' => 'refresh',
        'sanitize_callback' => 'esc_url_raw',
    ));
    $wp_customize->add_control(new WP_Customize_Image_Control($wp_customize, 'front_image', array(
        'label' => __('Cover image', 'coffeepot_bbch'),
        'section' => 'title_tagline',
        'settings' => 'front_image',
    )));
    if (apply_filters('coffeepot_bbch_slider_callback', false)) {
        $wp_customize->add_setting('front_slider_id', array(
            'default' => '',
            'transport' => 'refresh',
            'sanitize_callback' => 'absint',
        ));
        $wp_customize->add_control(new WP_Customize_Control($wp_customize, 'front_slider_id', array(
            'type' => 'number',
            'label' => __('Slider', 'coffeepot_bbch'),
            'section' => 'title_tagline',
            'settings' => 'front_slider_id',
            'priority' => 1,
        )));
        $wp_customize->remove_section('header_image');
    }
}

add_action('customize_register', 'coffeepot_bbch_customize_tagline');

function coffeepot_bbch_customize_banner($wp_customize)
{
    $wp_customize->add_section('banner', array(
        'title' => __('Banner', 'coffeepot_bbch'),
        'priority' => 100,
    ));

    $wp_customize->add_setting('page_logo', array(
        'default' => get_stylesheet_directory_uri() . '/images/logo_white.png',
        'transport' => 'refresh',
        'sanitize_callback' => 'esc_url_raw',
    ));
    $wp_customize->add_control(new WP_Customize_Image_Control($wp_customize, 'page_logo', array(
        'label' => __('Logo', 'coffeepot_bbch'),
        'section' => 'banner',
        'settings' => 'page_logo',
        'priority' => 1,
    )));
    $wp_customize->add_setting('desccription_page_title', array(
        'default' => 'Our team',
        'transport' => 'refresh',
    ));
    $wp_customize->add_control(new WP_Customize_Control($wp_customize, 'desccription_page_title', array(
        'label' => __('Description title for pages', 'coffeepot_bbch'),
        'section' => 'banner',
        'settings' => 'desccription_page_title',
        'priority' => 2,
    )));
    $wp_customize->add_setting('desccription_page_content', array(
        'default' => 'Knowing whose advice to take
and on what topic is the single most
important decision an entrepreneur
can make.',
        'transport' => 'refresh',
    ));
    $wp_customize->add_control(new WP_Customize_Control($wp_customize, 'desccription_page_content', array(
        'type' => 'textarea',
        'label' => __('Description content for pages', 'coffeepot_bbch'),
        'section' => 'banner',
        'settings' => 'desccription_page_content',
        'priority' => 3,
    )));
    $wp_customize->add_setting('banner_height', array(
        'default' => 400,
        'transport' => 'refresh',
        'sanitize_callback' => 'intval',
    ));
    $wp_customize->add_control(new WP_Customize_Control($wp_customize, 'banner_height', array(
        'label' => __('Height (pixel)', 'coffeepot_bbch'),
        'section' => 'banner',
        'settings' => 'banner_height',
    )));
    $wp_customize->get_control('header_image')->section = 'banner';
    if (apply_filters('coffeepot_bbch_slider_callback', false)) {
        $wp_customize->add_setting('banner_slider_id', array(
            'default' => '',
            'transport' => 'refresh',
            'sanitize_callback' => 'absint',
        ));
        $wp_customize->add_control(new WP_Customize_Control($wp_customize, 'banner_slider_id', array(
            'type' => 'number',
            'label' => __('Slider', 'coffeepot_bbch'),
            'section' => 'banner',
            'settings' => 'banner_slider_id',
            'priority' => 1,
        )));
        $wp_customize->remove_section('header_image');
    }
}

add_action('customize_register', 'coffeepot_bbch_customize_banner');

function coffeepot_bbch_slider_easyslider($exists)
{
    return $exists ? $exists : (function_exists('easingslider') ? 'easingslider' : false);
}

add_filter('coffeepot_bbch_slider_callback', 'coffeepot_bbch_slider_easyslider', 10);

function coffeepot_bbch_easingslider_styles($styles)
{
    return 'height:100%;' . preg_replace(array(
        '/max-height:[^;]*;/',
        '/height:[^;]*;/'
    ), '', $styles);
}

function coffeepot_bbch_slider_wowslider($exists)
{
    return $exists ? $exists : (function_exists('wowslider') ? 'wowslider' : false);
}

add_filter('coffeepot_bbch_slider_callback', 'coffeepot_bbch_slider_wowslider', 30);


function coffeepot_bbch_customize_footer($wp_customize)
{
    $wp_customize->add_section('footer', array(
        'title' => __('Footer', 'coffeepot_bbch'),
        'priority' => 100,
        'description' => __('Customize Google Map displayed on the bottom of the page', 'coffeepot_bbch'),
    ));
    $wp_customize->add_setting('footer_copyrights', array(
        'default' => __('Made by CoffeePot', 'coffeepot_bbch'),
        'transport' => 'refresh',
    ));
    $wp_customize->add_control(new WP_Customize_Control($wp_customize, 'footer_copyrights', array(
        'label' => __('Copyrights', 'coffeepot_bbch'),
        'section' => 'footer',
        'settings' => 'footer_copyrights',
        'priority' => 1,
    )));
}

add_action('customize_register', 'coffeepot_bbch_customize_footer', 7);

function coffeepot_bbch_customize_theme_variants($wp_customize)
{
    $wp_customize->add_setting('theme_variant', array(
        'default' => 'white',
        'transport' => 'refresh',
    ));
    $wp_customize->add_control(
        new WP_Customize_Control(
            $wp_customize,
            'theme_variant',
            array(
                'label' => __('Theme variants', 'coffeepot_bbch'),
                'section' => 'colors',
                'settings' => 'theme_variant',
                'type' => 'radio',
                'choices' => array(
                    'white' => __('White', 'coffeepot_bbch'),
                    'red_transparent' => __('Red (transparent)', 'coffeepot_bbch'),
                    'white_transparent' => __('White (transparent)', 'coffeepot_bbch'),
                )
            )
        )
    );
}

//add_action('customize_register', 'coffeepot_bbch_customize_theme_variants');