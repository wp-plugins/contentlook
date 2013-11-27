<?php

class CL_Controllers_Menu extends CL_Classes_FrontController {
    /** @var array themes */

    /** @var array snippet */
    var $options = array();

    //
    function init() {

    }

    function upgradeRedirect() {
        // Bail if no activation redirect
        if (!get_transient('cl_upgrade'))
            return;

        // Delete the redirect transient
        delete_transient('cl_upgrade');
        CL_Classes_Tools::emptyCache();

        wp_safe_redirect(admin_url('admin.php?page=cl_settings'));
        exit();
    }

    /*
     * Creates the Setting menu in Wordpress
     */

    public function hookMenu() {

        $this->upgradeRedirect();
        CL_Classes_Tools::checkErrorSettings(true);

        /* add the plugin menu in admin */
        if (current_user_can('administrator')) {
            $this->model->addSubmenu(array('options-general.php',
                __('ContentLook Settings', _CL_PLUGIN_NAME_),
                __('ContentLook', _CL_PLUGIN_NAME_) . CL_Classes_Tools::showNotices(CL_Classes_Tools::$errors_count, 'errors_count'),
                'edit_posts',
                'cl_settings',
                array($this, 'showMenu')
            ));
        }
    }

    public function showMenu() {
        CL_Classes_Tools::checkErrorSettings();
        /* Force call of error display */
        CL_Classes_ObjController::getController('CL_Classes_Error')->hookNotices();

        parent::init();
    }

    /**
     * Called when Post action is triggered
     *
     * @return void
     */
    public function action() {
        parent::action();
        switch (CL_Classes_Tools::getValue('action')) {

            case 'cl_settings_update':

                if (CL_Classes_Tools::getValue('data') <> '') {
                    parse_str(CL_Classes_Tools::getValue('data'), $params);
                    $this->saveValues($params);
                    $args['action'] = 'update';
                    $args['sendemail'] = (int) $params['cl_sendemail'];
                    $responce = CL_Classes_Action::apiCall('', $args);
                    exit();
                } else {
                    $this->saveValues($_POST);
                    $args['action'] = 'update';
                    $args['sendemail'] = (int) CL_Classes_Tools::getValue('cl_sendemail');
                    $responce = CL_Classes_Action::apiCall('', $args);
                }
//

                CL_Classes_Tools::emptyCache();
                break;
            case 'cl_settings_connected':
                CL_Classes_Tools::saveOptions('cl_connected', 1);
                CL_Classes_Tools::saveOptions('cl_token', CL_Classes_Tools::getValue('token'));
                break;
        }
    }

    private function saveValues($params) {
        if (!empty($params))
            foreach ($params as $key => $value)
                if ($key <> 'action' && $key <> 'nonce')
                    CL_Classes_Tools::saveOptions($key, $value);
    }

}

?>