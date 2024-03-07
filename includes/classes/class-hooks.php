<?php

namespace Cf7CboxAlt;

require_once ABSPATH . 'wp-admin/includes/plugin.php';

use Cf7CboxAlt\Constants;
use Cf7CboxAlt\CheckboxSVG;

/**
 * Class Hooks
 *
 * Contains methods for adding hooks and enqueueing scripts and styles.
 */
class Hooks {

    /**
     * Add hooks for enqueueing scripts and styles, and adding custom content before the checkbox wrapper.
     */
    public function actions() {
        add_action( 'init', array( $this, 'load_plugin_textdomain_init') );
        add_action( 'wp_enqueue_scripts', array( $this, 'enqueue_scripts_and_styles' ) );
    }

    /**
     * Enqueue scripts and styles for the plugin.
     */
    public function enqueue_scripts_and_styles() {
        // Enqueue scripts
        wp_enqueue_script( 'cf7-cbox-alt-mix', CF7_CBOX_ALT_PLUGIN_URL . 'assets/js/mix.js', array(), '20151215', true );

        // Enqueue styles
        wp_enqueue_style( 'cf7-cbox-alt-style', CF7_CBOX_ALT_PLUGIN_URL . 'assets/css/mix.css' );
    }


    /**
     * Load the plugin text domain for localization.
     */
    public function load_plugin_textdomain_init() {
        load_plugin_textdomain( 'cf7-cbox-alt', false, dirname( plugin_basename( __FILE__ ) ) . '/languages/' );
    }

}