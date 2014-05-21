<?php

/**
 * The class handles the theme part in WP
 */
class CL_Classes_DisplayController {

    private static $name;
    private static $cache;

    /**
     * echo the css link from theme css directory
     *
     * @param string $uri The name of the css file or the entire uri path of the css file
     * @param string $media
     *
     * @return string
     */
    public static function loadMedia($uri = '', $media = 'all', $params = null) {
        $css_uri = '';
        $js_uri = '';

        if ((!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') || strpos($_SERVER['PHP_SELF'], '/admin-ajax.php') !== false)
            return;

        if (isset(self::$cache[$uri]))
            return;

        self::$cache[$uri] = true;

        /* if is a custom css file */
        if (strpos($uri, '/') === false) {
            $name = strtolower($uri);

            if (file_exists(_CL_THEME_DIR_ . 'css/' . $name . '.css')) {
                $css_uri = _CL_THEME_URL_ . 'css/' . $name . '.css?ver=' . CL_VERSION_ID;
            }
            if (file_exists(_CL_THEME_DIR_ . 'js/' . $name . '.js')) {
                $js_uri = _CL_THEME_URL_ . 'js/' . $name . '.js?ver=' . CL_VERSION_ID;
            }
        } else {
            $name = strtolower(basename($uri));
            if (strpos($uri, '.css') !== FALSE)
                $css_uri = $uri;
            elseif (strpos($uri, '.js') !== FALSE) {
                $js_uri = $uri;
            }
        }


        if ($css_uri <> '') {
            if (function_exists('wp_style_is'))
                if (wp_style_is(_CL_PLUGIN_NAME_ . $name))
                    wp_deregister_style(_CL_PLUGIN_NAME_ . $name);
//            //echo _CL_PLUGIN_NAME_ . $name . ', ' . $css_uri . ', ' . CL_VERSION . '<br />';

            wp_register_style(_CL_PLUGIN_NAME_ . $name, $css_uri, null, CL_VERSION, 'all');
            wp_enqueue_style(_CL_PLUGIN_NAME_ . $name);
            // echo "<link rel='stylesheet' id='sq_menu.css-css'  href='" . $css_uri . "' type='text/css' media='all' />" . "\n";
        }

        if ($js_uri <> '') {
            wp_register_script('jquery', "http://ajax.googleapis.com/ajax/libs/jquery/1/jquery.min.js", false, 'latest', false);
            wp_enqueue_script('jquery');

            if (function_exists('wp_script_is'))
                if (wp_script_is(_CL_PLUGIN_NAME_ . $name))
                    wp_deregister_script(_CL_PLUGIN_NAME_ . $name);

            wp_register_script(_CL_PLUGIN_NAME_ . $name, $js_uri, null, CL_VERSION);
            wp_enqueue_script(_CL_PLUGIN_NAME_ . $name);
        }
    }

    /**
     * Called for any class to show the block content
     *
     * @param string $block the name of the block file in theme directory (class name by default)
     *
     * @return string of the current class view
     */
    public function output($block, $obj) {
        self::$name = $block;
        echo $this->echoBlock($obj);
    }

    /**
     * echo the block content from theme directory
     *
     * @return string
     */
    public static function echoBlock($view) {
        global $post_ID;
        if (file_exists(_CL_THEME_DIR_ . self::$name . '.php')) {
            ob_start();
            /* includes the block from theme directory */
            include(_CL_THEME_DIR_ . self::$name . '.php');
            $block_content = ob_get_contents();
            ob_end_clean();

            return $block_content;
        }
    }

}

?>