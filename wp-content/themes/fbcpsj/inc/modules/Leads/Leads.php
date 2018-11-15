<?php

namespace Includes\Modules\leads;

use Includes\Modules\CPT\CustomPostType;

class Leads
{
	protected $postType;
	public    $adminEmail;
	public    $domain;
	public    $ccEmail;
	public    $bccEmail;
	public    $additionalFields;
	public    $siteName;

    /**
     * Leads constructor.
     * configure any options here
     */
    public function __construct ()
    {
        date_default_timezone_set('America/New_York');

        $this->postType   = 'Lead';
        $this->domain     = 'fbcpsj.org';

        //separate multiple email addresses with a ';'
        $this->adminEmail = 'bbaird85@gmail.com';
        $this->ccEmail    = ''; //Admin email only
        $this->bccEmail   = 'bbaird85@gmail.com';

        //use this to merge in additional fields
        $this->assembleLeadData([
            //'name' => 'label'
        ]);
    }

	protected function set($var, $value)
	{
		$this->$var = $value;
	}

	protected function get($var)
	{
		return $this->$var;
	}

	protected function uglify($var){
		return str_replace(' ', '_', strtolower($var));
	}

	/**
     * Creates custom post type and backend view
     * @instructions run once from functions.php
     */
    public function setupAdmin ()
    {
        $this->createPostType();
        $this->createAdminColumns();
    }

    /**
     * Handle data submitted by lead form
     * @param array $dataSubmitted
     * @instructions pass $_POST to $dataSubmitted from template file
     * @return boolean
     */
    public function handleLead ($dataSubmitted = [])
    {
	    $fullName = (isset($dataSubmitted['full_name']) ? $dataSubmitted['full_name'] : null);
	    $dataSubmitted['full_name'] = (isset($dataSubmitted['first_name']) && isset($dataSubmitted['last_name']) ? $dataSubmitted['first_name'] . ' ' . $dataSubmitted['last_name'] : $fullName);

	    $this->addToDashboard($dataSubmitted);
	    if(!$this->validateSubmission($dataSubmitted)){ return false; }
	    $this->sendNotifications($dataSubmitted);
	    return true;
    }

	/*
	 * Validate certain data types on the backend
	 * @param array $dataSubmitted
	 * @return boolean $passCheck
	 */
	protected function validateSubmission($dataSubmitted)
	{

		$passCheck = true;
		if ($dataSubmitted['email_address'] == '') {
			$passCheck = false;
		} elseif (!filter_var($dataSubmitted['email_address'], FILTER_VALIDATE_EMAIL) && !preg_match('/@.+\./',
			$dataSubmitted['email_address'])) {
			$passCheck = false;
		}
		if ($dataSubmitted['full_name'] == '') {
			$passCheck = false;
        }
        // if (function_exists('akismet_verify_key') && !empty(akismet_get_key())){
        //     $comment = [
        //         'blog' => site_url(),
        //         'user_ip' => $dataSubmitted['ip_address'],
        //         'user_agent' => $dataSubmitted['user_agent'],
        //         'referrer' => $dataSubmitted['referrer'],
        //         'comment_content' => $dataSubmitted['message']
        //     ];
        //     $fuspam = $this->fuspam($comment, 'check-spam', akismet_get_key());
        //     if ($fuspam) {
        //         $passCheck = false;
        //     }
        // }

		return $passCheck;

    }

    public function getIP() {
        $client  = @$_SERVER['HTTP_CLIENT_IP'];
        $forwarded = @$_SERVER['HTTP_X_FORWARDED_FOR'];
        $remote  = $_SERVER['REMOTE_ADDR'];

        if (filter_var($client, FILTER_VALIDATE_IP)) {
            return $client;}
        elseif (filter_var($forward, FILTER_VALIDATE_IP)) {
            return $forward;}
        else {
            return $remote;}
    } 
    
    // Fuspam 1.3
    // F-U-Spam!
    // This script is light on documentation on purpose. Go to it's home for more info on how to use it:
    // http://www.whatsmyip.org/lib/fuspam-akismet-php/

    // Set these values of array $comment, then call fuspam().
    // Set all array values unless you are only verifying your key, then just set 'blog'

    //	$comment['blog'] = "";
    //	$comment['user_ip'] = "";
    //	$comment['user_agent'] = "";
    //	$comment['referrer'] = "";
    //	$comment['permalink'] = "";
    //	$comment['comment_type'] = "";
    //	$comment['comment_author'] = "";
    //	$comment['comment_author_email'] = "";
    //	$comment['comment_author_url'] = "";
    //	$comment['comment_content'] = "";

    public function fuspam( $comment , $type , $key )
    {
        $payload = http_build_query($comment);
        
        switch ($type){
            case "verify-key":
                $call = "1.1/verify-key";
                $payload = "key={$key}&blog={$comment['blog']}";
                break;
                
            case "check-spam":
                $call = "1.1/comment-check";
                break;
                
            case "submit-spam":
                $call = "1.1/submit-spam";
                break;
                
            case "submit-ham":
                $call = "1.1/submit-ham";
                break;
                
            default:
                return "Error: 'type' not recognized";
                break;
        }
        
        $curl = curl_init("http://$key.rest.akismet.com/$call");
        
        curl_setopt($curl,CURLOPT_USERAGENT,"Fuspam/1.3 | Akismet/1.11");
        curl_setopt($curl,CURLOPT_TIMEOUT,5);
        curl_setopt($curl,CURLOPT_POSTFIELDS,$payload);
        curl_setopt($curl,CURLOPT_RETURNTRANSFER,true);
        
        $i = 0;
        do {
            $result = curl_exec($curl);
            
            if ($result === false)
                { sleep(1); }
            
            $i++;
        } while ( ($i < 5) and ($result === false) );
        
        if ($result === false){ 
            // not spam on error
            $result = false; 
        }
            
        return $result;
	}


    /**
     * adds a lead (post) to WP admin dashboard (database)
     * @param array $leadInfo
     */
    protected function addToDashboard ($leadInfo)
    {

        $fieldArray = [];
        foreach($this->additionalFields as $name => $label){
            $fieldArray['lead_info_' . $name] = $leadInfo[$name];
        }

        wp_insert_post(
            [
                'post_content'   => '',
                'post_status'    => 'publish',
                'post_type'      => $this->uglify($this->postType),
                'post_title'     => $leadInfo['first_name'] . ' ' . $leadInfo['last_name'],
                'comment_status' => 'closed',
                'ping_status'    => 'closed',
                'meta_input'     => $fieldArray
            ],
            true
        );
    }

    /**
     * Returns a properly formatted address
     * @param  $street
     * @param  $street2
     * @param  $city
     * @param  $state
     * @param  $zip
     *
     * @return string
     */
    protected function fullAddress ($street, $street2, $city, $state, $zip)
    {
        return $street . ' ' . $street2 . ' ' . $city . ', ' . $state . '  ' . $zip;
    }

    /*
     * Used to manage data retrieved by lead. Used by pretty much everything.
     * Can pass in additional inputs. Arrays are merged to keep from duplicating fields.
     * @param $input
     */
    protected function assembleLeadData ($input = [])
    {
        $this->additionalFields = array_merge([
            'first_name'    => 'First Name',
            'last_name'     => 'Last Name',
            'email_address' => 'Email Address',
            'phone_number'  => 'Phone Number'
        ], $input);
    }

	public function getLeads($args = []){
		$request = [
			'posts_per_page' => - 1,
			'offset'         => 0,
			'post_type'      => $this->uglify($this->postType),
			'post_status'    => 'publish',
		];

		$args = array_merge( $request, $args );
		$results = get_posts( $args );

		$resultArray = [];
		foreach ( $results as $item ){
			$meta = get_post_meta($item->ID);
			$resultArray[] = [
				'object' => $item,
				'meta'   => $meta
			];
		}

		return $resultArray;
	}

    /*
     * Sends notification email(s)
     * @param array $leadInfo
     */
    protected function sendNotifications ($leadInfo)
    {
        $emailAddress = $leadInfo['email_address'];
        $fullName     = $leadInfo['first_name'] . ' ' . $leadInfo['last_name'];

	    $tableData = '';
	    foreach ($this->additionalFields as $key => $var) {
		    if(isset($leadInfo[$key])) {
			    $tableData .= '<tr><td class="label"><strong>' . $var . '</strong></td><td>' . $leadInfo[$key] . '</td>';
		    }
	    }

        $this->sendEmail(
            [
                'to'        => $this->adminEmail,
                'from'      => get_bloginfo() . ' <noreply@' . $this->domain . '>',
                'subject'   => $this->postType . ' submitted on website',
                'cc'        => $this->ccEmail,
                'bcc'       => $this->bccEmail,
                'replyto'   => $fullName . '<' . $emailAddress . '>',
                'headline'  => 'You have a new ' . strtolower($this->postType),
                'introcopy' => 'A ' . strtolower($this->postType) . ' was received from the website. Details are below:',
                'leadData'  => $tableData
            ]
        );

        $this->sendEmail(
            [
                'to'        => $fullName . ' <' . $emailAddress . '>',
                'from'      => get_bloginfo() . ' <noreply@' . $this->domain . '>',
                'subject'   => 'Your website submission has been received',
                'bcc'       => $this->bccEmail,
                'headline'  => 'Thank you',
                'introcopy' => 'We\'ll review the information you\'ve provided and get back with you as soon as we can.',
                'leadData'  => $tableData
            ]
        );

    }

    /**
     * Creates a custom post type and meta boxes (now dynamic)
     */
    protected function createPostType ()
    {

        $leads = new CustomPostType(
            $this->postType,
            [
                'supports'           => ['title'],
                'menu_icon'          => 'dashicons-star-empty',
                'has_archive'        => false,
                'menu_position'      => null,
                'public'             => false,
                'publicly_queryable' => false,
            ]
        );

        $fieldArray = [];
        foreach($this->additionalFields as $name => $label){
            $fieldArray[$label] = 'locked';
        }

        $leads->addMetaBox(
            'Lead Info', $fieldArray
        );
    }

    /*
     * Creates columns and data in admin panel
     */
    protected function createAdminColumns ()
    {

        //Adds Column labels. Can be enabled/disabled using screen options.
        add_filter('manage_' . strtolower($this->postType) . '_posts_columns', function () {

            $additionalLabels = [];
            foreach($this->additionalFields as $name => $label) {
                if($name != 'first_name' && $name != 'last_name') {
                    $additionalLabels[$name] = $label;
                }
            }

            $defaults = array_merge(
                [
                    'title'         => 'Name',
                    'email_address' => 'Email',
                    'phone_number'  => 'Phone Number',
                ], $additionalLabels
            );

            $defaults['date'] = 'Date Posted'; //always last

            return $defaults;
        }, 0);

        //Assigns values to columns
        add_action('manage_' . strtolower($this->postType) . '_posts_custom_column', function ($column_name, $post_ID) {
            if($column_name != 'title' && $column_name != 'date'){
                switch ($column_name) {
                    case 'email_address':
                        $email_address = get_post_meta($post_ID, 'lead_info_email_address', true);
                        echo(isset($email_address) ? '<a href="mailto:' . $email_address . '" >' . $email_address . '</a>' : null);
                        break;
                    case 'phone_number':
                        $phone_number = get_post_meta($post_ID, 'lead_info_phone_number', true);
                        echo(isset($phone_number) ? '<a href="tel:' . $phone_number . '" >' . $phone_number . '</a>' : null);
                        break;
                    default:
                        echo get_post_meta($post_ID, 'lead_info_' . $column_name, true);
                }
            }
        }, 0, 2);
    }

    /*
     * grabs blank template file and fills with content
     * @return string
     */
    protected function createEmailTemplate ($emailData)
    {
        $eol           = "\r\n";
        $emailTemplate = file_get_contents(wp_normalize_path(get_template_directory() . '/inc/modules/Leads/emailtemplate.php'));
        $emailTemplate = str_replace('{headline}', $eol . $emailData['headline'] . $eol, $emailTemplate);
        $emailTemplate = str_replace('{introcopy}', $eol . $emailData['introcopy'] . $eol, $emailTemplate);
        $emailTemplate = str_replace('{data}', $eol . $emailData['leadData'] . $eol, $emailTemplate);
        $emailTemplate = str_replace('{datetime}', date('M j, Y') . ' @ ' . date('g:i a'), $emailTemplate);
        $emailTemplate = str_replace('{website}', 'www.fbcpsj.org', $emailTemplate);
        $emailTemplate = str_replace('{url}', 'https://fbcpsj.org', $emailTemplate);
        $emailTemplate = str_replace('{copyright}', date('Y') . ' ' . get_bloginfo(), $emailTemplate);
        return $emailTemplate;
    }

    /*
     * actually send an email
     * TODO: Add handling for attachments
     */
	public function sendEmail ( $emailData = [] ) {
		$eol           = "\r\n";
		$emailTemplate = $this->createEmailTemplate($emailData);
		$headers       = 'From: ' . $emailData['from'] . $eol;
		$headers       .= (isset($emailData['cc']) ? 'Cc: ' . $emailData['cc'] . $eol : '');
		$headers       .= (isset($emailData['bcc']) ? 'Bcc: ' . $emailData['bcc'] . $eol : '');
		$headers       .= (isset($emailData['replyto']) ? 'Reply-To: ' . $emailData['replyto'] . $eol : '');
		$headers       .= 'MIME-Version: 1.0' . $eol;
		$headers       .= 'Content-type: text/html; charset=utf-8' . $eol;

		wp_mail($emailData['to'], $emailData['subject'], $emailTemplate, $headers);
	}
}
