<?php

namespace Includes\Modules\Layouts;

use Includes\Modules\CPT\CustomPostType;

/**
 * Layouts class
 */

 // Exit if accessed directly.
if (! defined('ABSPATH')) {
    exit;
}

class Layouts
{

    private $postType;
    private $contentTerm;
    private $contentTitle;
    private $metaBoxId;

    /**
     * Layouts constructor.
     */
    function __construct()
    {

    }

    /**
     * @return null
     */
    public function createPostType()
    {
        $page = new CustomPostType('Page');
        $page->addMetaBox(
            'Page Information',
            array(
                'Headline' => 'text',
                'Subhead'  => 'text'
            )
        );

        $page->addTaxonomy('layout', array(
            'hierarchical'      => true,
            'show_ui'           => true,
            'show_admin_column' => true,
            'query_var'         => true,
            'rewrite'           => array('slug' => 'format'),
            'capabilities'      => array(
                'manage_terms' => '',
                'edit_terms'   => '',
                'delete_terms' => '',
                'assign_terms' => 'edit_posts'
            ),
            'public'            => true,
            'show_in_nav_menus' => false,
            'show_tagcloud'     => false,
        ));

        $page->convertCheckToRadio('layout');

    }

    public function addToType( $postType = 'Post' ){

        $this->postType = $postType;
        add_action('init', function (){
            register_taxonomy_for_object_type('layout', $this->postType);
        });

    }

    /**
     * @return null
     */
    public function createDefaultFormats()
    {

        add_action('init', function () {
            wp_insert_term(
                'Default',
                'layout',
                array(
                    'description' => '',
                    'slug'        => 'default'
                )
            );
        });

    }

    /**
     * @param term
     * @param slug
     * @param description
     */
    public function createLayout($term = '', $description = '', $slug = '')
    {
        wp_insert_term(
            $term,
            'layout',
            [
                'description' => $description,
                'slug'        => $slug
            ]
        );

    }

    private function uglify($text){
        return strtolower( str_replace( ' ', '_', $text ) );
    }

    public function addContentBox($term = 'default', $postType = 'Page', $title = 'Content'){

        $this->contentTerm = $term;
        $this->contentTitle = $title;
        $this->metaBoxId = $this->uglify($title);

        $page = new CustomPostType($postType);
        $page->addMetaBox(
            $this->contentTitle,
            array(
                'HTML' => 'wysiwyg'
            )
        );

        add_action( 'admin_notices', function(){
            global $post;
            if(isset($post)) {
                $postID = $post->ID;
                $terms  = wp_get_post_terms($postID, 'layout');
                if (!isset($terms[0]) || $terms[0]->name != $this->contentTerm) {
                    remove_meta_box($this->metaBoxId, 'page', 'normal');
                }
            }

        },10,1);

    }
}
