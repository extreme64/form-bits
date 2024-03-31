<?php

namespace Cf7CboxAlt;

/*
Plugin Name: Form Bits
Plugin URI: 
Description: Form bits and additions.
Text Domain: cf7-cbox-alt
Version: 2.0
Author: MastG
Author URI: https://forwardcreating.com/
*/

defined( 'ABSPATH' ) || exit;

/**
 * Class ContactForm7CheckboxSVG
 *
 * This class serves as the entry point for the Contact Form 7 Checkbox SVG plugin.
 * It initializes the plugin by defining constants for plugin paths and URLs, loading required files,
 * and initializing hooks for Contact Form 7 and Mailchimp for WP integration.
 */
class ContactForm7CheckboxSVG {
    
    /**
     * Defines constants for plugin paths and URLs, loads required files,
     * and initializes hooks for Contact Form 7 and Mailchimp for WP integration.
     */
    public function __construct() {
        define( 'CF7_CBOX_ALT_PLUGIN_PATH', plugin_dir_path( __FILE__ ) );
        define( 'CF7_CBOX_ALT_PLUGIN_URL', plugin_dir_url( __FILE__ ) );

        require_once CF7_CBOX_ALT_PLUGIN_PATH . 'includes/classes/class-constants.php';
        require_once CF7_CBOX_ALT_PLUGIN_PATH . 'includes/classes/class-checkbox-svg.php';
        require_once CF7_CBOX_ALT_PLUGIN_PATH . 'includes/classes/class-hooks.php';
        require_once CF7_CBOX_ALT_PLUGIN_PATH . 'includes/classes/class-cf7-handler.php';
        require_once CF7_CBOX_ALT_PLUGIN_PATH . 'includes/classes/class-mc4wp-handler.php';
        require_once CF7_CBOX_ALT_PLUGIN_PATH . 'includes/classes/class-mc4wp-error-handler.php';

        // Initialize hooks
        $this->init_hooks();
    }

    /**
     * Initializes hooks for Contact Form 7 and Mailchimp for WP integration.
     */
    private function init_hooks() {
        // Initialize CF7 Handler
        $cf7_handler = new CF7Handler();
        $cf7_handler->actions();

        // Initialize MC4WP Handler
        $mc4wp_handler = new MC4WPHandler();
        $mc4wp_handler->filters();
        $mc4wp_handler->actions();

        // Initialize Hooks
        $hooks = new Hooks();
        $hooks->actions();

        // Initialize the MC4WP error handler
        MC4WPErrorHandler::init();
    }
}

// Initialize the ContactForm7CheckboxSVG plugin
new ContactForm7CheckboxSVG();