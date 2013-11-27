<?php

$currentDir = dirname(__FILE__);

define('_CL_NAMESPACE_', 'CL'); //THIS LINE WILL BE CHANGED WITH THE USER SETTINGS
define('_CL_PLUGIN_NAME_', 'contentlook'); //THIS LINE WILL BE CHANGED WITH THE USER SETTINGS
define('_CL_THEME_NAME_', 'default'); //THIS LINE WILL BE CHANGED WITH THE USER SETTINGS
defined('_CL_API_URL_') || define('_CL_API_URL_', 'http://www.contentlook.co/api/');
defined('_CL_AUDIT_URL_') || define('_CL_AUDIT_URL_', 'http://www.contentlook.co/user/audit/');

/* Directories */
define('_CL_ROOT_DIR_', realpath($currentDir . '/..'));
define('_CL_CLASSES_DIR_', _CL_ROOT_DIR_ . '/classes/');
define('_CL_CONTROLLER_DIR_', _CL_ROOT_DIR_ . '/controllers/');
define('_CL_MODEL_DIR_', _CL_ROOT_DIR_ . '/models/');
define('_CL_TRANSLATIONS_DIR_', _CL_ROOT_DIR_ . '/translations/');
define('_CL_CORE_DIR_', _CL_ROOT_DIR_ . '/core/');
define('_CL_ALL_THEMES_DIR_', _CL_ROOT_DIR_ . '/themes/');
define('_CL_THEME_DIR_', _CL_ROOT_DIR_ . '/themes/' . _CL_THEME_NAME_ . '/');

/* URLS */
define('_CL_URL_', plugins_url() . '/' . _CL_PLUGIN_NAME_);
define('_CL_ALL_THEMES_URL_', _CL_URL_ . '/themes/');
define('_CL_THEME_URL_', _CL_URL_ . '/themes/' . _CL_THEME_NAME_ . '/');
?>