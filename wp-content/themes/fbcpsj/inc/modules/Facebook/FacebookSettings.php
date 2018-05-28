<?php

namespace Includes\Modules\Facebook;

use Includes\Modules\Facebook\FacebookInstance;

class FacebookSettings
{
    protected $status;
    protected $facebookPageID;
    protected $facebookToken;

    public function __construct()
    {
        $this->save();
        $this->facebookPageID = get_option('facebook_page_id');
        $this->facebookToken = get_option('facebook_token');
    }

    public function setupPage()
    {
        $this->createNavLabel();
    }

    protected function createNavLabel()
    {

        add_action('admin_menu', function () {
            add_menu_page('Facebook Settings', 'Facebook Settings', 'manage_options', 'facebook-settings', function () {
                $this->createSettingsPage();
            }, 'dashicons-admin-generic', 999);
        });

    }

    protected function createSettingsPage(){ ?>
        <div class="wrap">
        <h1 class="wp-heading-inline" style="margin-bottom: .5rem;">Facebook Settings</h1>
            <?php if($this->facebookToken != ''){ ?>
            <div>
                <h3>Current Token</h3>
                <p><?php echo $this->facebookToken; ?></p>
            </div>
            <?php } ?>
            <div>
                <?php
                $fbSession = new FacebookInstance( '139165192785547' );
                $hasSavedToken = false; //TODO: check if saved in DB and display

                if (isset($_POST['facebook_submit_settings']) && $_POST['facebook_submit_settings'] == 'yes') {
                    update_option('facebook_page_id',
                        isset($_POST['facebook_page_id']) ? sanitize_text_field($_POST['facebook_page_id']) : $this->facebookPageID);
                    update_option('facebook_token',
                        isset($_POST['facebook_token']) ? sanitize_text_field($_POST['facebook_token']) : $this->facebookToken);
                }

                ?>

                <form enctype="multipart/form-data" name="facebook_settings" id="facebook_settings" method="post"
                      action="<?php echo str_replace('%7E', '~', $_SERVER['REQUEST_URI']); ?>">
                    <input type="hidden" name="facebook_submit_settings" value="yes">

                    <?php
                    if($fbSession->checkLogin() || $hasSavedToken) {
                        $fbSession->refreshTokenButton();
                    }else{
                        $fbSession->getTokenButton();
                    }
                    ?>

                    <p class="submit">
                        <input class="button is-primary" type="submit" name="Submit" value="<?php _e('Update Settings') ?>"/>
                    </p>
                </form>
                <hr>

            </div>
        </div>
        <?php
    }

    protected function save(){



    }

}