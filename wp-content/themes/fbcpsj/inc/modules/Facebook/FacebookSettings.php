<?php

namespace Includes\Modules\Facebook;

use Includes\Modules\Facebook\FacebookInstance;
use KeriganSolutions\FacebookFeed\FacebookFeed;

class FacebookSettings
{
    protected $status;
    protected $facebookPageID;
    protected $facebookToken;
    protected $facebookExpires;

    public function __construct()
    {
        $this->save();
        $this->facebookPageID = get_option('facebook_page_id');
        $this->facebookToken = get_option('facebook_token');
        $this->facebookExpires = get_option('facebook_expires');
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

    protected function createSettingsPage(){ 
        $fbSession = new FacebookInstance();
        $hasSavedToken = $this->facebookToken != ''; //TODO: check if saved in DB and display
        $hasSavedPageId = $this->facebookPageID != ''; //TODO: check if saved in DB and display
        $fb = new FacebookInstance;
        if (isset($_POST['facebook_submit_settings']) && $_POST['facebook_submit_settings'] == 'yes') {
            update_option('facebook_page_id',
                isset($_POST['facebook_page_id']) ? sanitize_text_field($_POST['facebook_page_id']) : $this->facebookPageID);
            update_option('facebook_token',
                isset($_POST['facebook_token']) ? sanitize_text_field($_POST['facebook_token']) : $this->facebookToken);
            update_option('facebook_expires',
                isset($_POST['facebook_expires']) ? sanitize_text_field($_POST['facebook_expires']) : $this->facebookExpires);
        }
        ?>
        <div class="wrap">
            <h1 class="wp-heading-inline" style="margin-bottom: .5rem;">Facebook Settings</h1>
            <div>
                <h3>Page ID</h3>
                <form enctype="multipart/form-data" name="facebook_settings" id="facebook_settings" method="post"
                      action="<?php echo str_replace('%7E', '~', $_SERVER['REQUEST_URI']); ?>">
                    <input type="hidden" name="facebook_submit_settings" value="yes">
                    <input type="text" name="facebook_page_id" value="<?php echo $this->facebookPageID; ?>" > <input class="button is-primary" type="submit" name="Submit" value="<?php _e('Update Page ID') ?>"/>
                </form>
                
                <hr>
                <h3>Authorization Token</h3>
                <p><strong>Current Token:</strong> <?php echo $this->facebookToken; ?></p>
                <p><strong>Expires:</strong> <?php echo $this->facebookExpires; ?></p>
                <form enctype="multipart/form-data" name="facebook_settings" id="facebook_settings" method="post"
                      action="/wp-admin/admin.php?page=facebook-settings">
                    <input type="hidden" name="facebook_submit_settings" value="yes">
                    
                    <?php
                    $fbSession->checkLogin();
                    if($hasSavedToken) {
                        $fbSession->refreshTokenButton();
                        
                    }else{
                        $fbSession->getTokenButton();
                    }
                    ?>
                </form>
                
            </div>
        </div>
        <?php
    }

    protected function save(){



    }

}