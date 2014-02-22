<div id="cl_settings" >
    <form id="cl_settings_form" name="settings" action="" method="post" enctype="multipart/form-data">
        <div id="cl_settings_title" ><?php _e('ContentLook Settings', _CL_PLUGIN_NAME_); ?><a href="http://wordpress.org/support/view/plugin-reviews/contentlook" target="_blank"><span class="cl_settings_rate" ><span></span><?php _e('Please support us on Wordpress', _CL_PLUGIN_NAME_); ?></span></a></div>
        <div id="cl_settings_body">
            <div id="cl_settings_left" >
                <fieldset>
                    <div class="cl_option_content">
                        <div class="cl_switch">
                            <input id="cl_sendemail_on" type="radio" class="cl_switch-input" name="cl_sendemail"  value="1" <?php echo ((CL_Classes_Tools::getOption('cl_sendemail') == 1) ? "checked" : '') ?> />
                            <label for="cl_sendemail_on" class="cl_switch-label cl_switch-label-off"><?php _e('Yes', _CL_PLUGIN_NAME_); ?></label>
                            <input id="cl_sendemail_off" type="radio" class="cl_switch-input" name="cl_sendemail" value="0" <?php echo ((!CL_Classes_Tools::getOption('cl_sendemail')) ? "checked" : '') ?> />
                            <label for="cl_sendemail_off" class="cl_switch-label cl_switch-label-on"><?php _e('No', _CL_PLUGIN_NAME_); ?></label>
                            <span class="cl_switch-selection"></span>
                        </div>
                        <span><?php _e('Create the audit once a week', _CL_PLUGIN_NAME_); ?></span>

                    </div>

                </fieldset>

                <fieldset id="cl_option_connect_frame" <?php if (CL_Classes_Tools::getOption('cl_token') <> '') echo 'style="display: none"' ?>>
                    <legend><?php _e('Connect to Contentlook and get the audit:', _CL_PLUGIN_NAME_); ?></legend>

                    <div id="cl_option_connect">
                        <div id="cl_option_connect_error" style="display: none;"><?php _e('An error occured!', _CL_PLUGIN_NAME_); ?></div>
                        <div>
                            <label for="cl_subscribe_email"><?php _e('Email:', _CL_PLUGIN_NAME_); ?></label>
                            <input type="email" value="<?php
                            echo esc_attr($GLOBALS['current_user']->user_email)
                            ?>" size="30" name="cl_email" id="cl_subscribe_email" >
                        </div>
                        <div>
                            <label for="cl_subscribe_url"><?php _e('URL:', _CL_PLUGIN_NAME_); ?></label>
                            <input type="text"  value="<?php echo get_bloginfo('url') ?>" size="30" id="cl_subscribe_url" >
                        </div>
                        <div>
                            <input type="button" value="Subscribe" id="cl_subscribe_subscribe">
                        </div>

                    </div>

                </fieldset>
                <div id="cl_option_audit" <?php if (CL_Classes_Tools::getOption('cl_token') == '') echo 'style="display: none"' ?>>
                    <span id="cl_option_audit_link" style="display: none">
                        <?php echo '<a class="cl_button"  target="_blank">' . __('Check your site audit', _CL_PLUGIN_NAME_) . '</a>' ?>
                    </span>
                    <span id="cl_option_audit_notready" style="display: none">
                        <?php _e('The audit will be ready soon ...', _CL_PLUGIN_NAME_) ?>
                    </span>
                    <span id="cl_option_audit_error" style="display: none">
                        <?php _e('Contentlook receives a page error while checking your site ...', _CL_PLUGIN_NAME_) ?>
                    </span>
                </div>

                <div id="cl_option_audit_demo"><iframe width="853" height="480" src="//www.youtube.com/embed/l3QSCNhHzqM" frameborder="0" allowfullscreen></iframe></div>

            </div>

            <div id="cl_settings_submit">
                <input type="hidden" name="action" value="cl_settings_update" />
                <input type="hidden" id="cl_token" name="cl_token" value="<?php echo CL_Classes_Tools::getOption('cl_token'); ?>" />

                <input type="hidden" name="nonce" value="<?php echo wp_create_nonce(_CL_NONCE_ID_); ?>" />
            </div>

        </div>
    </form>


</div>