<?php
/**
 * Created by PhpStorm.
 * User: bbair
 * Date: 9/25/2017
 * Time: 8:51 PM
 */

namespace Includes\Modules\services;

use Includes\Modules\CPT\CustomPostType;

// Exit if accessed directly.
if (!defined('ABSPATH')) {
    exit;
}

class Ministries
{

    public function __construct()
    {
    }

    public function createPostType()
    {

        $ministries = new CustomPostType('Ministry',
            [
                'supports'           => ['title', 'editor', 'author'],
                'menu_icon'          => 'dashicons-networking',
                'has_archive'        => false,
                'menu_position'      => null,
                'public'             => true,
                'publicly_queryable' => true,
                'hierarchical'       => true,
                'show_ui'            => true,
                'show_in_nav_menus'  => true,
                '_builtin'           => false,
                'rewrite'            => [
                    'slug'       => 'ministries',
                    'with_front' => true,
                    'feeds'      => true,
                    'pages'      => false
                ]
            ]
        );

        $ministries->addMetaBox(
            'Ministry Info',
            [
                'Photo'             => 'image',
                'Contact Person'    => 'text',
                'Contact Email'     => 'text',
                'Show Detail Page'  => 'boolean',
                'Show Contact Form' => 'boolean'
            ]
        );


    }

    /**
     * @return null
     */
    public function createAdminColumns()
    {

        add_filter('manage_ministry_posts_columns',
            function ($defaults) {
                $defaults = [
                    'title'       => 'Name',
                    'contact'     => 'Contact Person',
                    'showdetails' => 'Show Detail Page',
                    'photo'       => 'Photo'
                ];

                return $defaults;
            }, 0);

        add_action('manage_ministry_posts_custom_column', function ($column_name, $post_ID) {
            switch ($column_name) {
                case 'photo':
                    $photo = get_post_meta($post_ID, 'ministry_info_photo', true);
                    echo(isset($photo) ? '<img src ="' . $photo . '" class="img-fluid" style="width:400px; max-width:100%;" >' : null);
                    break;

                case 'contact':
                    $object = get_post_meta($post_ID, 'ministry_info_contact_person', true);
                    echo(isset($object) ? $object : null);
                    break;

                case 'showdetails':
                    $featured = get_post_meta($post_ID, 'ministry_info_show_detail_page', true);
                    echo($featured == 'on' ? 'TRUE' : 'FALSE');
                    break;

            }
        }, 0, 2);

    }

    public function getMinistries($args = [])
    {

        $request = [
            'post_type'      => 'ministry',
            'posts_per_page' => -1,
            'orderby'        => 'menu_order',
            'order'          => 'ASC',
            'offset'         => 0,
            'post_status'    => 'publish',
        ];

        $request = get_posts(array_merge($request, $args));

        $output = [];
        foreach ($request as $item) {

            array_push($output, [
                'id'             => (isset($itemID) ? $item->ID : null),
                'name'           => $item->post_title,
                'contact_person' => (isset($item->ministry_info_contact_person) ? $item->ministry_info_contact_person : null),
                'show_details'    => (isset($item->ministry_info_show_detail_page) ? $item->ministry_info_show_detail_page : null),
                'slug'           => (isset($item->post_name) ? $item->post_name : null),
                'photo'          => (isset($item->ministry_info_photo) ? $item->ministry_info_photo : null),
                'link'           => get_permalink($item->ID),
            ]);

        }

        return $output;
    }

    public function getSingle($name)
    {

        $output = $this->getMinistries([
            'title'          => $name,
            'posts_per_page' => 1,
        ]);

        return $output[0];
    }

    public function getMinistryNames()
    {

        $request = $this->getMinistries([]);

        $output = [];
        foreach ($request as $item) {
            array_push($output, (isset($item->post_title) ? $item->post_title : null));
        }

        return $output;
    }

}