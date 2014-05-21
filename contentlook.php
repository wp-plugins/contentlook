<?php

/*
  Copyright (c) 2012, Squirrly Limited.
  The copyrights to the software code in this file are licensed under the (revised) BSD open source license.

  Plugin Name: ContentLook
  Plugin URI:
  Author: Squirrly UK
  Description: ContentLook helps you take a look at your whole Content Marketing strategy, including your 6 main areas: Blogging, Traffic, Social Media, SEO, Links and Authority.
  Version: 1.1.1
  Author URI: http://www.squirrly.co
 */
/* SET THE CURRENT VERSION ABOVE AND BELOW */
define('CL_VERSION', '1.1.1');
/* Call config files */
require(dirname(__FILE__) . '/config/config.php');

/* important to check the PHP version */
if (PHP_VERSION_ID >= 5100) {
    /* inport main classes */
    require_once(_CL_CLASSES_DIR_ . 'ObjController.php');
    require_once(_CL_CLASSES_DIR_ . 'BlockController.php');

    /* Main class call */
    CL_Classes_ObjController::getController('CL_Classes_FrontController')->run();
} else {
    /* Main class call */
    add_action('admin_notices', array(CL_Classes_ObjController::getController('CL_Classes_FrontController'), 'phpVersionError'));
}

// --
// Upgrade StarBox call.
register_activation_hook(__FILE__, 'cl_upgrade');

function cl_upgrade() {
    set_transient('cl_upgrade', true, 30);
}
