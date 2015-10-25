<?php
/**
 * User: Pierre Péronnet
 * Date: 24/10/2015
 */

function coffeepot_bbch_customize_gmap($wp_customize)
{
    $wp_customize->add_section('map_footer', array(
        'title' => __('Maps customization', 'coffeepot_bbch'),
        'priority' => 100,
        'description' => __('Customize Google Map displayed on the bottom of the page', 'coffeepot_bbch'),
    ));
    /*
    $wp_customize->add_setting('gmap_api_key', array(
        'default' => '',
        'transport' => 'refresh',
    ));
    $wp_customize->add_control(new WP_Customize_Control($wp_customize, 'gmap_api_key', array(
        'label' => __('Google Map API key', 'coffeepot_bbch'),
        'section' => 'map_footer',
        'settings' => 'gmap_api_key',
    )));
    $wp_customize->add_setting('gmap_position', array(
        'default' => '',
        'transport' => 'refresh',
    ));
    $wp_customize->add_control(new WP_Customize_Control($wp_customize, 'gmap_position', array(
        'label' => __('Position', 'coffeepot_bbch'),
        'section' => 'map_footer',
        'settings' => 'gmap_position',
    )));
    */
    $wp_customize->add_setting('gmap_panel_title', array(
        'default' => 'Contact us',
        'transport' => 'refresh',
    ));
    $wp_customize->add_control(new WP_Customize_Control($wp_customize, 'gmap_panel_title', array(
        'label' => __('Panel title', 'coffeepot_bbch'),
        'section' => 'map_footer',
        'settings' => 'gmap_panel_title',
    )));
    $wp_customize->add_setting('gmap_panel_content', array(
        'default' => 'BBCH
Two Temple Place
London WC2R 3BD',
        'transport' => 'refresh',
    ));
    $wp_customize->add_control(new WP_Customize_Control($wp_customize, 'gmap_panel_content', array(
        'type' => 'textarea',
        'label' => __('Panel content', 'coffeepot_bbch'),
        'section' => 'map_footer',
        'settings' => 'gmap_panel_content',
    )));
    $wp_customize->add_setting('gmap_latitude', array(
        'default' => '51.5114218',
        'transport' => 'refresh',
        'sanitize_callback' => 'floatval',
    ));
    $wp_customize->add_control(new WP_Customize_Control($wp_customize, 'gmap_latitude', array(
        'type' => 'number',
        'label' => __('Latitude', 'coffeepot_bbch'),
        'section' => 'map_footer',
        'settings' => 'gmap_latitude',
    )));
    $wp_customize->add_setting('gmap_longitude', array(
        'default' => '-0.1151832',
        'transport' => 'refresh',
        'sanitize_callback' => 'floatval',
    ));
    $wp_customize->add_control(new WP_Customize_Control($wp_customize, 'gmap_longitude', array(
        'type' => 'number',
        'label' => __('Longitude', 'coffeepot_bbch'),
        'section' => 'map_footer',
        'settings' => 'gmap_longitude',
    )));
    $wp_customize->add_setting('gmap_height', array(
        'default' => '350',
        'transport' => 'refresh',
        'sanitize_callback' => 'intval',
    ));
    $wp_customize->add_control(new WP_Customize_Control($wp_customize, 'gmap_height', array(
        'type' => 'number',
        'label' => __('Height (pixel)', 'coffeepot_bbch'),
        'section' => 'map_footer',
        'settings' => 'gmap_height',
    )));
    $wp_customize->add_setting('gmap_marker', array(
        'default' => $template_directory . '/images/marker_gmap.png',
        'transport' => 'refresh',
        'sanitize_callback' => 'esc_url_raw',
    ));
    $wp_customize->add_control(new WP_Customize_Image_Control($wp_customize, 'gmap_marker', array(
        'label' => __('Marker', 'theme_name'),
        'section' => 'map_footer',
        'settings' => 'gmap_marker',
    )));
}

add_action('customize_register', 'coffeepot_bbch_customize_gmap');


function coffeepot_bbch_enqueue_gmap()
{
    wp_register_script('gmap', 'https://maps.googleapis.com/maps/api/js?key=' . urlencode(get_theme_mod('gmap_api_key')), false);
    // wp_register_script('gmap', 'https://maps.googleapis.com/maps/api/js?v=3.exp&amp;libraries=places', false);
    wp_enqueue_script('custom_gmap', get_template_directory_uri() . '/scripts/custom_gmap.js', array('jquery', 'gmap'), false, true);
    $gmap_values = array(
        'marker' => esc_url(get_theme_mod('gmap_marker', get_stylesheet_directory_uri() . '/images/marker_gmap.png')),
    );
    $location = array(
        'lat' => floatval(get_theme_mod('gmap_latitude', '51.5114218')),
        'lng' => floatval(get_theme_mod('gmap_longitude', '-0.1151832')),
    );
    if (empty($location['lat']) || empty($location['lng'])) {
        $gmap_values['position'] = get_theme_mod('gmap_position');
    } else {
        $gmap_values['location'] = $location;
    }
    wp_localize_script('custom_gmap', 'gmap_values', $gmap_values);
}

add_action('wp_enqueue_scripts', 'coffeepot_bbch_enqueue_gmap');

function coffeepot_bbch_footer_gmap()
{
    if (is_singular()) {
        ?>
        <aside id="gmap" class="container p-a-0">
        <div class="panel card">
            <div class="card-block"><h4
                    class="title card-title"><?php echo esc_html(get_theme_mod('gmap_panel_title', 'Contact us')); ?></h4>
                <?php echo wpautop(esc_html(get_theme_mod('gmap_panel_content', 'BBCH
Two Temple Place
London WC2R 3BD'))); ?></div>
        </div>
        <div class="canvas" style="height: <?php echo esc_attr(get_theme_mod('gmap_height', '350')); ?>px;"></div>
        </aside><?php
    }
}

add_action('wp_footer', 'coffeepot_bbch_footer_gmap');


function coffeepot_bbch_adminbar_simplify_gmap($wp_admin_bar)
{
    $wp_admin_bar->add_node(array(
        'id' => 'map-footer',
        'href' => admin_url('customize.php?' . http_build_query(array(
                'return' => $_SERVER['REQUEST_URI'],
                'autofocus[section]' => 'map_footer',
            ), '', '&')),
        'title' => __('Footer map', 'coffeepot_bbch'),
        'parent' => 'customize',
    ));
}

add_action('admin_bar_menu', 'coffeepot_bbch_adminbar_simplify_gmap', 20);