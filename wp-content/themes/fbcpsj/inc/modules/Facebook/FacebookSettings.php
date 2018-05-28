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

        //$page_id = FACEBOOK_PAGE_ID;
        if($this->facebookToken){
            define('FACEBOOK_ACCESS_TOKEN',$this->facebookToken);
        }
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
        $fbSession = new FacebookInstance( '139165192785547' );
        $hasSavedToken = $this->facebookToken != ''; //TODO: check if saved in DB and display
        $fb = new FacebookInstance;
        ?>
        <div class="wrap">
        <h1 class="wp-heading-inline" style="margin-bottom: .5rem;">Facebook Settings</h1>
            <?php if($hasSavedToken){ ?>
            <div>
                <h3>Current Token</h3>
                <p><?php echo $this->facebookToken; ?></p>
            </div>
            <?php } ?>
            <div>
                <?php
                if (isset($_POST['facebook_submit_settings']) && $_POST['facebook_submit_settings'] == 'yes') {
                    update_option('facebook_page_id',
                        isset($_POST['facebook_page_id']) ? sanitize_text_field($_POST['facebook_page_id']) : $this->facebookPageID);
                    update_option('facebook_token',
                        isset($_POST['facebook_token']) ? sanitize_text_field($_POST['facebook_token']) : $this->facebookToken);
                    update_option('facebook_expires',
                        isset($_POST['facebook_expires']) ? sanitize_text_field($_POST['facebook_expires']) : $this->facebookExpires);
                }
                ?>

                <form enctype="multipart/form-data" name="facebook_settings" id="facebook_settings" method="post"
                      action="<?php echo str_replace('%7E', '~', $_SERVER['REQUEST_URI']); ?>">
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
                <hr>
                <div class="columns">
                    <?php
                    $feed = new FacebookFeed();

                    try{
                        $results = $feed->fetch(4);
                        foreach ($results->posts as $result) {
                            include(locate_template('template-parts/partials/mini-article.php'));
                        }

                    } catch (Exception $e){
                        echo $e->getMessage();
                    }
                    ?>
                </div>
            </div>
        </div>
        <?php
    }

    protected function save(){



    }

}