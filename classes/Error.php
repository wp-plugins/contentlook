<?php

class CL_Classes_Error extends CL_Classes_FrontController {

    /** @var array */
    private static $errors, $switch_off;

    /**
     * The error controller for StarBox
     */
    function __construct() {
        parent::__construct();

        /* Verify dependences */
        if (!function_exists('get_class')) {
            self::setError(__('Function get_class does not exists! Is required for StarBox to work properly.', _CL_PLUGIN_NAME_));
        }
        if (!function_exists('file_exists')) {
            self::setError(__('Function file_exists does not exists! Is required for StarBox to work properly.', _CL_PLUGIN_NAME_));
        }

        if (!defined('ABSPATH'))
            self::setError(__('The home directory is not set!', _CL_PLUGIN_NAME_), 'fatal');

        /* Check the PHP version */
        if (PHP_VERSION_ID < 5100) {
            self::setError(__('The PHP version has to be greater then 5.1', _CL_PLUGIN_NAME_), 'fatal');
        }
    }

    /**
     * Show version error
     */
    public function phpVersionError() {
        echo '<div class="update-nag"><span style="color:red; font-weight:bold;">' . __('For StarBox to work, the PHP version has to be equal or greater then 5.1', _CL_PLUGIN_NAME_) . '</span></div>';
    }

    /**
     * Show the error in wrodpress
     *
     * @param string $error
     * @param boolean $stop
     *
     * @return void;
     */
    public static function setError($error = '', $type = 'notice', $id = '') {
        self::$errors[] = array('id' => $id,
            'type' => $type,
            'text' => $error);
    }

    /**
     * This hook will show the error in WP header
     */
    function hookNotices() {
        if (is_array(self::$errors))
            foreach (self::$errors as $error) {

                switch ($error['type']) {
                    case 'fatal':
                        self::showError(ucfirst(_CL_PLUGIN_NAME_ . " " . $error['type']) . ': ' . $error['text'], $error['id']);
                        die();
                        break;
                    case 'settings':
                        if (CL_Classes_Tools::getOption('ignore_warn') == 1)
                            break;

                        /* switch off option for notifications */
                        self::$switch_off = "<a href=\"javascript:void(0);\" onclick=\"jQuery.post( ajaxurl, {action: 'cl_warnings_off', nonce: '" . wp_create_nonce('cl_none') . "'}, function(data) { if (data) { jQuery('#cl_ignore_warn').attr('checked', true); jQuery('.cl_message').hide(); jQuery('#toplevel_page_cl .awaiting-mod').fadeOut('slow'); } });\" >" . __("Turn off warnings!", _CL_PLUGIN_NAME_) . "</a>";
                        self::showError(ucfirst(_CL_PLUGIN_NAME_) . " " . __('Notice: ', _CL_PLUGIN_NAME_) . $error['text'] . " " . self::$switch_off, $error['id']);
                        break;
                    default:

                        self::showError(ucfirst(_CL_PLUGIN_NAME_) . " " . __('Note: ', _CL_PLUGIN_NAME_) . $error['text'], $error['id']);
                }
            }
        self::$errors = array();
    }

    /**
     * Show the notices to WP
     *
     * @return void
     */
    public static function showError($message, $id = '') {
        $type = 'cl_error';

        if (file_exists(_CL_THEME_DIR_ . 'Notices.php')) {
            include (_CL_THEME_DIR_ . 'Notices.php');
        } else {
            echo $message;
        }
    }

}

?>