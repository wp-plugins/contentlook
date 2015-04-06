<div id="cl_settings" >
    <form id="cl_settings_form" name="settings" action="" method="post" enctype="multipart/form-data">
        <div id="cl_settings_title" ><?php _e('ContentLook Settings', _CL_PLUGIN_NAME_); ?><a href="http://wordpress.org/support/view/plugin-reviews/contentlook" target="_blank"><span class="cl_settings_rate" ><span></span><?php _e('Please support us on Wordpress', _CL_PLUGIN_NAME_); ?></span></a></div>
        <div id="cl_settings_body">
            <div id="cl_settings_left" >
                <fieldset id="cl_switch">
                    <div class="cl_option_content" >
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

                <fieldset id="cl_option_connect_frame">
                    <legend><?php
                        if (CL_Classes_Tools::getOption('cl_token') <> '') {
                            _e('Check your audit !');
                        } else {
                            _e('Connect to Contentlook and get the audit', _CL_PLUGIN_NAME_);
                        }
                        ?></legend>
                    <div id="cl_loader" style="display:none">
                        <img src="<?php echo _CL_THEME_URL_ ?>img/loading.gif">
                    </div>
                    <div>
                        <input type="button" value="Take me to the audit page" id="clgotosite" class="claudpage" style="display:none">
                        <div id="clcontentlookquestion" style="display:none">
                            <h3><?php echo __("Your current URL is", _CL_PLUGIN_NAME_); ?>: <span id="sitespan"><?php echo CL_Classes_Tools::getOption('cl_url'); ?></span>
                                <span id="clauditgen">
                                    <span class="cl_sendemail"  style="<?php echo (CL_Classes_Tools::getOption('cl_sendemail') == 1) ? '' : 'display: none' ?>"><?php echo __("You have chosen to receive weekly audit updates!", _CL_PLUGIN_NAME_); ?></span>
                                    <span class="cl_notsendemail" style="<?php echo (CL_Classes_Tools::getOption('cl_sendemail') <> 1) ? '' : 'display: none' ?>"><?php echo __("You have chosen NOT to receive weekly audit updates!", _CL_PLUGIN_NAME_); ?></span>
                                </span>
                                <?php echo sprintf(__("Want to change your settings, manage more websites and refresh your audits ? Log in to %sContentlook%s below!", _CL_PLUGIN_NAME_), '<a href="http://contentlook.co" target="_blank" id="clcontentlooklink">', '</a>'); ?></h3>

                        </div>
                        <input type="button" class="claudpage" value="Login" id="clcontentlooklogin" style="display:none">
                    </div>
                    <div id="clcontentlookrelated" style="display:none">
                        <h3><?php echo __("We've also got a chrome extension. If you're interested in real-time audit generation and updates, check it out!", _CL_PLUGIN_NAME_); ?></h3>
                        <input type="button" id="clgotoextension" value="Chrome extension" class="claudpage">

                    </div>
                    <div id="cl_option_connect"<?php if (CL_Classes_Tools::getOption('cl_token') <> '') echo 'style = "display: none"' ?>>
                        <div id="cl_option_connect_error" style="display: none;"><?php _e('An error occured!', _CL_PLUGIN_NAME_); ?></div>
                        <div>
                            <label for="cl_subscribe_email"><?php _e('Email', _CL_PLUGIN_NAME_); ?></label>
                            <input type="email" value="<?php
                            echo esc_attr($GLOBALS['current_user']->user_email)
                            ?>" size="30" name="cl_email" id="cl_subscribe_email" >
                        </div>
                        <div style="display:none" id='cl_subscribe'>
                            <label for="cl_subscribe_psw" ><?php _e('Password', _CL_PLUGIN_NAME_); ?></label>
                            <input type="password"  size="30" id="cl_subscribe_psw" >
                        </div>
                        <div>
                            <label for="cl_subscribe_url"><?php _e('URL', _CL_PLUGIN_NAME_); ?></label>
                            <input type="text"  id="cl_subscribe_url" name ="siteurl"  value="" size="30" placeholder="http://">
                        </div>
                        <div>
                            <input type="button" value="Generate audit for this URL" id="cl_subscribe_login" style="display:none">
                        </div>

                        <div>
                            <input type="button" value="Subscribe" id="cl_subscribe_subscribe">
                        </div>
                        <div>
                            <a id="clalracc" ><?php echo __("Already have an account? Login", _CL_PLUGIN_NAME_); ?></a>
                        </div>
                        <div>
                            <a id="clbackacc"><?php echo __("Back to the Sign-up page", _CL_PLUGIN_NAME_); ?></a>
                        </div>

                </fieldset>


            </div>

            <div id="cl_settings_submit">
                <input type="hidden" name="action" value="cl_settings_update" />
                <input  type="hidden" id="cl_token" name="cl_token" value="<?php echo CL_Classes_Tools::getOption('cl_token'); ?>" />
                <input   type="hidden" id="cl_url" name="cl_url" value="<?php echo CL_Classes_Tools::getOption('cl_url'); ?>" />
                <input   type="hidden" name="nonce" value="<?php echo wp_create_nonce(_CL_NONCE_ID_); ?>" />
            </div>

        </div>
    </form>


</div>
