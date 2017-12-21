<?php

 use Includes\Modules\Slider\BulmaSlider;
 use Includes\Modules\Events\Events;
 use Includes\Modules\Layouts\Layouts;
 use Includes\Modules\Navwalker\BulmaNavwalker;
 use Includes\Modules\Social\SocialSettingsPage;
use Includes\Modules\Facebook\FacebookSettings;
 use Includes\Modules\Sermons\Sermons;
 use Includes\Modules\Team\Team;
 use Includes\Modules\Services\Ministries;
 use Includes\Modules\Leads\Leads;
 use Includes\Modules\Leads\SimpleContact;

require('vendor/autoload.php');

add_action('init', function (){
    if (!session_id()) {
        session_start();
    }
}, 1);

/**
 * @package PSJCG
 * @subpackage fbcpsj
 * @since 1.0
 * @version 1.2
 */

function fbcpsj_setup() {

    $facebookSettingsPage = new FacebookSettings();
    $facebookSettingsPage->setupPage();

    $leads = new SimpleContact;
    $leads->setupAdmin();

    $slider = new BulmaSlider();
    $slider->createPostType();
    $slider->createAdminColumns();

    $events = new Events();
    $events->createPostType();
    $events->createAdminColumns();

    $sermons = new Sermons();
    $sermons->createPostType();
    $sermons->createAdminColumns();

    $team = new Team();
    $team->createPostType();
    $team->createAdminColumns();

    $team = new Ministries();
    $team->createPostType();
    $team->createAdminColumns();

    $layouts = new Layouts();
    $layouts->createPostType();
    $layouts->createDefaultFormats();
    $layouts->createLayout( 'two-column', 'two column page layout', 'twocol' );
    $layouts->addContentBox('two-column', 'Page', 'Sidebar Content');
    $layouts->addToType('Ministry');
    $layouts->addContentBox('two-column', 'Ministry', 'Sidebar Content');

	load_theme_textdomain( 'fbcpsj', get_template_directory() . '/languages' );
	add_theme_support( 'automatic-feed-links' );
	add_theme_support( 'title-tag' );
	add_theme_support( 'post-thumbnails' );

	register_nav_menus( array(
		'mobile-menu'    => esc_html__( 'Mobile Menu', 'fbcpsj' ),
		'main-menu'      => esc_html__( 'Main Navigation', 'fbcpsj' ),
        'footer-menu'    => esc_html__( 'Footer Navigation', 'fbcpsj' )
	) );

	add_theme_support( 'html5', array(
		'search-form',
		'comment-form',
		'comment-list',
		'gallery',
		'caption'
	) );

	function fbcpsj_inline()
  {
    ?>
		<style type="text/css">
  			<?php echo file_get_contents(get_template_directory() . '/style.css'); ?>
		</style>
	<?php
}

	add_action( 'wp_head', 'fbcpsj_inline' );
}

add_action( 'after_setup_theme', 'fbcpsj_setup' );

function fbcpsj_scripts()
{
    wp_register_script('scripts', get_template_directory_uri() . '/app.js', array(), '0.0.1', true);
    wp_enqueue_script('scripts');
//    wp_enqueue_style('style', get_stylesheet_uri());
}
add_action( 'wp_enqueue_scripts', 'fbcpsj_scripts' );

//Remove WordPress's content filtering so we can make our own tags AND use them.
// remove_filter( 'the_content', 'wpautop' );
