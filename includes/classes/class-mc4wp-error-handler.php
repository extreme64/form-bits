<?php

namespace Cf7CboxAlt;

require_once ABSPATH . 'wp-admin/includes/plugin.php';

/**
 * Class MC4WPErrorHandler
 *
 * This class provides error handling functionality for the 'Mailchimp for WP' plugin form API errors.
 */
class MC4WPErrorHandler {

    /**
     * Initializes the cluster functionality for handling MC4WP form API errors.
     */
    public static function init() {
        if (is_plugin_active('mailchimp-for-wp/mailchimp-for-wp.php')) {
            add_action('mc4wp_form_api_error', array(__CLASS__, 'handle_error'), 10, 2);
        } else {
            error_log("Notice: Needed plugin not present/active!");
        }
    }

    /**
     * Custom error handler for MC4WP form API errors.
     *
     * @param array $form The form data.
     * @param array $error_message The error message.
     */
    public static function handle_error($form, $error_message) {
        $plugin_origin_name = 'CF7 CBOX ALT';
        $status = null;
        $message = null;

        try {
            list($status, $message) = self::extractErrorInfo($error_message);
        } catch (Exception $e) {
            error_log("Error occurred @$plugin_origin_name: " . $e->getMessage());
        }

        if ((int)$status === 400) {
            self::logBadRequestError($plugin_origin_name, $message);
        }
    }

    /**
     * Extracts error information from the MC4WP form API response.
     *
     * @param array $error_message The error message.
     * @return array An array containing the status code and error message.
     */
    private static function extractErrorInfo($error_message) {
        foreach ($error_message as $item) {
            foreach ($item as $responseObj) {
                if ($responseObj instanceof \WP_HTTP_Requests_Response) {
                    $responseArray = json_decode($responseObj->body, true);
                    return [isset($responseArray['status']) ? $responseArray['status'] : null, isset($responseArray['detail']) ? $responseArray['detail'] : null];
                }
            }
        }
        return [null, null];
    }

    /**
     * Logs a bad request error.
     *
     * @param string $plugin_origin_name The name of the originating plugin.
     * @param string $message The error message.
     */
    private static function logBadRequestError($plugin_origin_name, $message) {
        $hook = 'mc4wp_form_api_error';
        $plugin = 'Mailchimp for WP';
        $error_message = "Error: Bad Request (400) occurred while processing the form";
        $error_message .= " in hook '$hook'. ";
        $error_message .= " Plugin: $plugin.";
        $error_message .= " Details: $message.";
        $error_message .= " Originated: @$plugin_origin_name.";

        error_log($error_message);
    }
}