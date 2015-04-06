jQuery(document).ready(function () {

    if (jQuery('#cl_token').val() !== '') {
        jQuery(".claudpage,#clcontentlookquestion,#clcontentlooklogin,#clcontentlookrelated").show();
    }

    jQuery('.cl_switch-input').on("change", function (event) {
        clcheckoption();
    });

    jQuery('#clalracc').bind('click', function (event) {
        jQuery('#cl_subscribe,#cl_subscribe_login,#clbackacc').show();
        jQuery('#clalracc,#cl_subscribe_subscribe').hide();
    });

    jQuery('#clbackacc').bind('click', function (event) {
        jQuery('#cl_subscribe,#cl_subscribe_login,#clbackacc').hide();
        jQuery('#clalracc,#cl_subscribe_subscribe').show();
    });

    //Subscribe form
    jQuery('#cl_subscribe_subscribe').bind('click', function (event) {
        if (event) {
            event.preventDefault();
        }

        if ((!jQuery('#cl_subscribe_url').val()) || (!jQuery('#cl_subscribe_email').val())) {
            jQuery('#cl_option_connect_error').html('Please fill in all the forms ! ').show();
        }

        if (cl_validateEmail(jQuery('#cl_subscribe_email').val()) && cl_validateUrl(jQuery('#cl_subscribe_url').val())) {
            jQuery('#cl_option_connect_error').html('').show();

            jQuery.getJSON('http://api.contentlook.co/signup/?callback=?',
                    {
                        email: jQuery('#cl_subscribe_email').val(),
                        url: jQuery('#cl_subscribe_url').val()
                    },
            function (data) {
                if (typeof data.token !== 'undefined') {
                    jQuery('#cl_option_connect_error').html('Account created! Please check your email for your password').show();
                    jQuery('#cl_token').val(data.token);
                    jQuery('#cl_url').val(jQuery('#cl_subscribe_url').val());

                    //save the token in database
                    clsetToken();

                    jQuery('#cl_subscribe,#cl_subscribe_login,#clbackacc').show();
                    jQuery('#clalracc,#cl_subscribe_subscribe').hide();

                }
                else {
                    jQuery('#cl_subscribe_subscribe,#clalracc').hide();
                    jQuery('#cl_subscribe,#cl_subscribe_login,#clbackacc').show();
                    jQuery('#cl_option_connect_error').html('Email allready registered ! ').show();
                    return;
                }
            });
        }
    });

    jQuery('#cl_subscribe_login').bind('click', function (e) {
        clLogin(e);
    });

    jQuery('#cl_subscribe_psw').bind('keypress', function (e) {
        if (e.which == 13) {
            clLogin(e);
        }

    });

    //Login form
    clLogin = function (e) {
        e.preventDefault();

        if ((!jQuery('#cl_subscribe_url').val()) || (!jQuery('#cl_subscribe_email').val()) || (!jQuery('#cl_subscribe_psw').val())) {
            jQuery('#cl_option_connect_error').html('Please fill in all the forms! ').show();
            return;
        }

        //check login
        if (cl_validateUrl(jQuery('#cl_subscribe_url').val()) && cl_validateEmail(jQuery('#cl_subscribe_email').val())) {
            jQuery('#cl_option_connect_error').html('').show();

            jQuery.getJSON('http://api.contentlook.co/login/?callback=?',
                    {
                        email: jQuery('#cl_subscribe_email').val(),
                        password: jQuery('#cl_subscribe_psw').val()
                    }
            ).success(
                    function (data) {
                        if (typeof data.error !== 'undefined') {
                            jQuery('#cl_option_connect_error').html('Inccorect password!');
                            return;
                        }

                        if (typeof data.token !== 'undefined') {
                            jQuery("#cl_loader").show();

                            jQuery("fieldset legend").html("Generating the audit, please wait!");
                            jQuery("#sitespan").html(jQuery('#cl_subscribe_url').val());
                            jQuery('#cl_token').val(data.token);
                            //save the token in database
                            clsetToken();
                            //hide the login form
                            jQuery("#cl_option_connect").hide();

                            jQuery.getJSON(
                                    'http://api.contentlook.co/score/' + encodeURIComponent(jQuery('#cl_subscribe_url').val()) + "?token=" + (jQuery('#cl_token').val()) + "&update=1"
                                    ).success(
                                    function () {
                                        jQuery("#cl_loader").hide();
                                        jQuery("fieldset legend").html("Audit ready!");
                                        jQuery("#clcontentlookquestion,#clcontentlooklogin,.claudpage,#clcontentlookrelated").show();
                                    }
                            ).error(function () {
                                jQuery('#cl_option_connect_error').html('Audit error occured!');
                            });
                        }
                    })
                    .error(function () {
                        jQuery('#cl_option_connect_error').html('Login error occured!');
                    });
        }
    };

    clcheckoption = function () {
        if (jQuery('#cl_sendemail_on').is(":checked")) {
            jQuery.getJSON(
                    'http://api.contentlook.co/unsubscribe?token=' + (jQuery('#cl_token').val()) + "&unsubscribe=0"
                    ).success(
                    function () {
                        jQuery('.cl_sendemail').show();
                        jQuery('.cl_notsendemail').hide();
                    }
            )
        }

        else if (jQuery('#cl_sendemail_off').is(":checked")) {
            jQuery.getJSON(
                    'http://api.contentlook.co/unsubscribe?token=' + (jQuery('#cl_token').val()) + "&unsubscribe=1"
                    ).success(
                    function () {
                        jQuery('.cl_sendemail').hide();
                        jQuery('.cl_notsendemail').show();
                    }
            )
        }

        jQuery.getJSON(
                cl_Query.ajaxurl,
                {
                    action: 'cl_settings_update',
                    data: jQuery('#cl_settings').find('form').serialize(),
                    nonce: cl_Query.nonce
                });

    };

    jQuery('#clgotosite').bind('click', function () {
        window.open("http://contentlook.co/audit/" + encodeURIComponent(jQuery('#cl_url').val()) + "/" + md5('score' + jQuery('#cl_url').val()), '_blank');
    });

    jQuery('#clcontentlooklogin').bind('click', function () {
        window.open("http://contentlook.co/login/");
    });

    jQuery('#clgotoextension').bind('click', function () {
        window.open("https://chrome.google.com/webstore/detail/seo-content-audit-by-cont/fdjeiiocdnnpmghkkgpkmkcbkkkiekal");
    });
});

clsetToken = function () {
    jQuery.getJSON(
            cl_Query.ajaxurl,
            {
                action: 'cl_settings_connected',
                token: (jQuery('#cl_token').val()),
                nonce: cl_Query.nonce,
                url: (jQuery('#cl_subscribe_url').val())
            });
};

cl_validateEmail = function ($email) {
    if ($email === '')
        return false;
    var emailReg = /^([\w-\.]+@([\w-]+\.)+[\w-]{2,4})?$/;
    if (!emailReg.test($email)) {
        jQuery('#cl_option_connect_error').html('Inccorect email format ! ').show();
        return false;
    } else {
        return true;
    }
};

cl_validateUrl = function (url) {
    if (url === '')
        return false;
    var urlReg = /^(https?|ftp):\/\/(((([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(%[\da-f]{2})|[!\$&'\(\)\*\+,;=]|:)*@)?(((\d|[1-9]\d|1\d\d|2[0-4]\d|25[0-5])\.(\d|[1-9]\d|1\d\d|2[0-4]\d|25[0-5])\.(\d|[1-9]\d|1\d\d|2[0-4]\d|25[0-5])\.(\d|[1-9]\d|1\d\d|2[0-4]\d|25[0-5]))|((([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])*([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])))\.)+(([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])*([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])))\.?)(:\d*)?)(\/((([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(%[\da-f]{2})|[!\$&'\(\)\*\+,;=]|:|@)+(\/(([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(%[\da-f]{2})|[!\$&'\(\)\*\+,;=]|:|@)*)*)?)?(\?((([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(%[\da-f]{2})|[!\$&'\(\)\*\+,;=]|:|@)|[\uE000-\uF8FF]|\/|\?)*)?(\#((([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(%[\da-f]{2})|[!\$&'\(\)\*\+,;=]|:|@)|\/|\?)*)?$/;
    if (!urlReg.test(url)) {
        jQuery('#cl_option_connect_error').html('Inccorect URL format ! ').show();
        return false;
    } else {
        return true;
    }
}
