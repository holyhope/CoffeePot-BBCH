<?php
/**
 * User: Pierre Péronnet
 * Date: 24/10/2015
 */

function coffeepot_bbch_compatibility_metatag()
{
    ?>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no"/>
    <style>
        @media print {
            .container {
                width: auto;
            }
        }
    </style><?php
}

add_action('wp_footer', 'coffeepot_bbch_compatibility_metatag');

function coffeepot_bbch_adobe_typo()
{
    ?>
    <script type="application/javascript" src="https://use.typekit.net/vtk2knz.js"></script>
    <script type="application/javascript">
        <!--
        try {
            Typekit.load({async: true});
        } catch (e) {
        }
        -->
    </script><?php
}

add_action('wp_footer', 'coffeepot_bbch_adobe_typo');

function coffeepot_bbch_compatibility_scripts()
{
    ?>
    <script type="application/javascript">
        <!--
        // Copyright 2014-2015 Twitter, Inc.
        // Licensed under MIT (https://github.com/twbs/bootstrap/blob/master/LICENSE)
        if (navigator.userAgent.match(/IEMobile\/10\.0/)) {
            var msViewportStyle = document.createElement('style')
            msViewportStyle.appendChild(
                document.createTextNode(
                    '@-ms-viewport{width:auto!important}'
                )
            )
            document.querySelector('head').appendChild(msViewportStyle)
        }
        -->
    </script>
    <script type="application/javascript">
        jQuery(function () {
            var nua = navigator.userAgent
            var isAndroid = (nua.indexOf('Mozilla/5.0') > -1 && nua.indexOf('Android ') > -1 && nua.indexOf('AppleWebKit') > -1 && nua.indexOf('Chrome') === -1)
            if (isAndroid) {
                jQuery('select.form-control').removeClass('form-control').css('width', '100%')
            }
        })
    </script><?php
}

add_action('wp_footer', 'coffeepot_bbch_compatibility_scripts');

function coffeepot_bbch_enqueue_bootstrap_scripts()
{
    wp_register_script('bootstrap', get_template_directory_uri() . '/scripts/bootstrap/bootstrap.min.js', array('jquery'));
    wp_register_script('bootstrap-carousel', get_template_directory_uri() . '/scripts/bootstrap/umd/carousel.js', array('bootstrap'));
    wp_enqueue_script('bootstrap-collapse', get_template_directory_uri() . '/scripts/bootstrap/umd/collapse.js', array('bootstrap'));
}

add_action('wp_enqueue_scripts', 'coffeepot_bbch_enqueue_bootstrap_scripts');