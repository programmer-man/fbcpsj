<?php
namespace Includes\Modules\Facebook;

use GuzzleHttp\Client;

class FacebookFeed
{
    private $accessToken;
    private $pageId;
    private $defaultPhoto;
    private $scope;

    function __construct ($scope = 'facebook')
    {
        $this->scope        = $scope;
        $this->accessToken  = get_option('facebook_token');
        $this->pageId       = get_option('facebook_page_id');
        $this->defaultPhoto = '/wp-content/uploads/2017/09/DETRKX3XkAAJ3e3.jpg';
    }

    /**
     * @param int $limit
     * @return array
     */
    private function saveToSession( $dataName, $dataValue, $expires )
    {
        $_SESSION[$this->scope . '_' . $dataName] = serialize($dataValue);
        $_SESSION[$this->scope . '_' . $dataName . '_expires'] = time() + $expires;
    }
    private function getFromSession( $dataName )
    {
        return unserialize($_SESSION[$this->scope . '_' . $dataName]);
    }
    private function checkSession( $dataName )
    {
        $useSession = (isset($_SESSION[$this->scope . '_' . $dataName]) && ($_SESSION[$this->scope . '_' . $dataName . '_expires'] > time()) ? true : false);
        if(!$useSession){ unset($_SESSION[$this->scope . '_' . $dataName]); }
        return $useSession;
    }
    public function fetch($limit = 5)
    {
        $client = new Client([ 'base_uri' => 'https://graph.facebook.com/v2.9' ]);

        $fields = 'id,message,link,name,caption,description,created_time,updated_time,picture,object_id,type';

        if ($this->checkSession('facebook_news_feed')) {
            $feed = $this->getFromSession('facebook_news_feed');
        } else {
            $response = $client->request('GET', '/' . $this->pageId . '/posts/?fields=' . $fields . '&limit=' . $limit . '&access_token=' . $this->accessToken);
            $feed     = json_decode($response->getBody());
            $this->saveToSession('facebook_news_feed', $feed, 5);
        }

        //echo '<pre>',print_r($feed),'</pre>';

        return $feed;
    }
    public function photo($fbpost)
    {
        $client = new Client([ 'base_uri' => 'https://graph.facebook.com/v2.9' ]);

        switch ($fbpost->type){
            case 'link':
                if($this->checkSession('facebook_link_' . $fbpost->id)){
                    $returned = $this->getFromSession('facebook_link_' . $fbpost->id);
                }else{
                    $response = $client->request('GET', '/?id=' . $fbpost->link . '&access_token=' . $this->accessToken);
                    $returned = json_decode($response->getBody());
                    $this->saveToSession('facebook_link_' . $fbpost->id, $returned, 604800);
                }
                if(! isset($returned->og_object->id)){
                    //$fbpost->type = 'foo'; //no og_object, so change type to skip this conditional
                    return (isset($fbpost->picture) ? $fbpost->picture : $this->defaultPhoto);
                }

                $og_id = $returned->og_object->id;

                if($this->checkSession('facebook_link_' .$og_id)) {
                    $returned = $this->getFromSession('facebook_link_' . $og_id);
                }else{
                    $response = $client->request('GET', '/' . $og_id . '/?fields=image&access_token=' . $this->accessToken);
                    $returned  = json_decode($response->getBody());
                    $this->saveToSession('facebook_link_' . $og_id, $returned, 604800);
                }

                return $returned->image[0]->url;

            case 'video':

                return $fbpost->link;

            case 'status':

                return $this->defaultPhoto;

            default:

                if($this->checkSession('facebook_object_' .$fbpost->id)) {
                    $returned = $this->getFromSession('facebook_object_' . $fbpost->id);
                } else {
                    $response = $client->request('GET', '/' . $fbpost->id . '/?fields=object_id&access_token=' . $this->accessToken);
                    $returned = json_decode($response->getBody());
                    $this->saveToSession('facebook_object_' . $fbpost->id, $returned, 604800);
                }

                $object_id = $returned->object_id;
                $photo_url = 'https://graph.facebook.com/v2.9/' . $object_id . '/picture?access_token=' . $this->accessToken;

                return $photo_url;

        }

    }
}
