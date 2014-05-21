<?php

/**
 * The main class for controllers
 *
 */
class CL_Classes_FrontController {

    /** @var object of the model class */
    public $model;

    /** @var boolean */
    public $flush = true;

    /** @var object of the view class */
    public $view;

    /** @var name of the  class */
    private $name;

    public function __construct() {

        /* Load error class */
        CL_Classes_ObjController::getController('CL_Classes_Error');

        /* Load Tools */
        CL_Classes_ObjController::getController('CL_Classes_Tools');

        /* get the name of the current class */
        $this->name = get_class($this);

        /* load the model and hooks here for wordpress actions to take efect */
        /* create the model and view instances */
        $this->model = CL_Classes_ObjController::getModel($this->name);
        //IMPORTANT TO LOAD HOOKS HERE
        /* check if there is a hook defined in the controller clients class */
        CL_Classes_ObjController::getController('CL_Classes_HookController')->setAdminHooks($this);
        CL_Classes_ObjController::getController('CL_Classes_HookController')->getShortcodes($this);
    }

    /**
     * load sequence of classes
     * Function called usualy when the controller is loaded in WP
     *
     * @return void
     */
    public function init() {
        $this->view = CL_Classes_ObjController::getController('CL_Classes_DisplayController');

        if ($this->flush)
            $this->output();

        /* load the blocks for this controller */

        CL_Classes_ObjController::getController('CL_Classes_ObjController')->getBlocks($this->name);
    }

    protected function output() {
        $this->hookHead();
        /* view is called from theme directory with the class name by defauls */
        if ($class = CL_Classes_ObjController::getClassPath($this->name))
            $this->view->output($class['name'], $this);
    }

    /**
     * initialize settings
     * Called from index
     *
     * @return void
     */
    public function run() {
        /** check the admin condition */
        if (!is_admin())
            return;

        /* Load the Submit Actions Handler */
        CL_Classes_ObjController::getController('CL_Classes_Action');
        CL_Classes_ObjController::getController('CL_Classes_DisplayController');

        /* show the admin menu and post actions */
        $this->loadMenu();
    }

    /**
     * initialize menu
     *
     * @return void
     */
    private function loadMenu() {
        /* get the menu from controller */
        CL_Classes_ObjController::getController('CL_Controllers_Menu');
    }

    /**
     * first function call for any class
     *
     */
    protected function action() {
        // check to see if the submitted nonce matches with the
        // generated nonce we created
        if (class_exists('wp_verify_nonce'))
            if (!wp_verify_nonce(CL_Classes_Tools::getValue(_CL_NONCE_ID_), _CL_NONCE_ID_))
                die('Invalid request!');
    }

    /**
     * This function will load the media in the header for each class
     *
     * @return void
     */
    public function hookHead() {
        if (!is_admin())
            return;

        if ($class = CL_Classes_ObjController::getClassPath($this->name)) {
            CL_Classes_ObjController::getController('CL_Classes_DisplayController')
                    ->loadMedia($class['name']);
        }
    }

}

?>