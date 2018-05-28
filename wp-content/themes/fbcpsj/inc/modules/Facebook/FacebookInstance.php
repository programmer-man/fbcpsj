<?php

namespace Includes\Modules\Facebook;

use Facebook\Exceptions\FacebookSDKException;
use Facebook\Exceptions\FacebookResponseException;
use Facebook\Facebook;

class FacebookInstance
{

    protected $pageId;
    protected $accessToken;
    protected $appId;
    protected $appSecret;

    public function __construct($pageId)
    {

        $this->pageId      = $pageId;
        $this->accessToken = (isset($_SESSION['fb_access_token']) ? $_SESSION['fb_access_token'] : null);
        $this->appId       = '960377764104394';
        $this->appSecret   = 'b518db197f7265df6e1d0f9a9c73bc2b';
        $this->checkLogin();

    }

    public function checkLogin()
    {

        $fb = new Facebook([
            'app_id'                  => $this->appId,
            'app_secret'              => $this->appSecret,
            'default_graph_version'   => 'v2.10',
            'persistent_data_handler' => 'session'
        ]);

        $helper      = $fb->getRedirectLoginHelper();
        $accessToken = $this->getAccessToken($helper);
        $oAuth2Client = $fb->getOAuth2Client();

        if (!isset($accessToken)) {
            if ($helper->getError()) {
                echo "Error: " . $helper->getError() . "\n";
                echo "Error Code: " . $helper->getErrorCode() . "\n";
                echo "Error Reason: " . $helper->getErrorReason() . "\n";
                echo "Error Description: " . $helper->getErrorDescription() . "\n";
            } else {
                //not logged in.
                return false;
            }
            exit;
        }

        $tokenMetadata = $oAuth2Client->debugToken($accessToken->getValue());

        echo '<h3>Access Token</h3>';
        echo $accessToken->getValue();
        echo '<input type="hidden" name="facebook_token" value="'.$accessToken->getValue().'" >';

        echo '<h3>Expires</h3>';
        $expires = $tokenMetadata->getExpiresAt();
        echo '<p>' . $expires->format('r') . '</p>';
        echo '<input type="hidden" name="facebook_expires" value="'.$expires->format('r').'" >';

        if (!$accessToken->isLongLived()) {
            $this->getLongLived($accessToken);
            echo 'this token is not long lived.';
        }else{
            echo 'this token is long lived.';
        }

        $_SESSION['fb_access_token'] = (string)$accessToken;
        $this->accessToken           = (string)$accessToken;

        ?>
        <p class="submit">
            <input class="button is-primary" type="submit" name="Submit" value="<?php _e('Update Settings') ?>"/>
        </p>
        <?php

        return true;

    }

    public function getAccessToken($helper)
    {

        try {
            $accessToken = $helper->getAccessToken();
        } catch (FacebookResponseException $e) {
            echo 'Graph returned an error: ' . $e->getMessage();
            exit;
        } catch (FacebookSDKException $e) {
            echo 'Facebook SDK returned an error: ' . $e->getMessage();
            exit;
        }

        return $accessToken;

    }

    public function getLongLived($accessToken)
    {
        $fb = new Facebook([
            'app_id'                  => $this->appId,
            'app_secret'              => $this->appSecret,
            'default_graph_version'   => 'v2.10',
            'persistent_data_handler' => 'session'
        ]);

        $oAuth2Client = $fb->getOAuth2Client();

        try {
            $longLived = $oAuth2Client->getLongLivedAccessToken($accessToken->getValue());
        } catch (FacebookSDKException $e) {
            echo "<p>Error getting long-lived access token: " . $e->getMessage() . "</p>\n\n";
            exit;
        }

        echo '<h3>Long-lived</h3>';
        var_dump($longLived->getValue());

    }

    public function getTokenButton()
    {

        $fb = new Facebook([
            'app_id'                  => $this->appId,
            'app_secret'              => $this->appSecret,
            'default_graph_version'   => 'v2.10',
            'persistent_data_handler' => 'session'
        ]);

        $helper = $fb->getRedirectLoginHelper();

        $permissions = ['manage_pages']; // optional
        $protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off' || $_SERVER['SERVER_PORT'] == 443) ? "https://" : "http://";
        $urlParts = explode('&', $_SERVER['REQUEST_URI']);
        $callback    = $protocol . $_SERVER['HTTP_HOST'] . $urlParts[0];
        $loginUrl    = $helper->getLoginUrl($callback, $permissions);

        echo '<a class="button button-primary button-outlined" href="' . $loginUrl . '">Get Access Token</a>';

    }

    public function refreshTokenButton()
    {

        $fb = new Facebook([
            'app_id'                  => $this->appId,
            'app_secret'              => $this->appSecret,
            'default_graph_version'   => 'v2.10',
            'persistent_data_handler' => 'session'
        ]);

        $helper = $fb->getRedirectLoginHelper();

        $permissions = ['manage_pages']; // optional
        $protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off' || $_SERVER['SERVER_PORT'] == 443) ? "https://" : "http://";
        $urlParts = explode('&', $_SERVER['REQUEST_URI']);
        $callback    = $protocol . $_SERVER['HTTP_HOST'] . $urlParts[0];
        $loginUrl    = $helper->getLoginUrl($callback, $permissions);

        echo '<a class="button button-primary button-outlined" href="' . $loginUrl . '">Refresh Token</a>';
    }

}
