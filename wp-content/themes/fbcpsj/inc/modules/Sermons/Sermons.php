<?php

namespace Includes\Modules\Sermons;

use Includes\Modules\CPT\CustomPostType;

/**
 * Events Class
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

class Sermons {

    public $timezone;

    /**
     * Sermons constructor.
     */
    function __construct() {

        $this->timezone = new \DateTimeZone( 'America/New_York' );

    }

    /**
     * @return null
     */
    public function createPostType() {

        $sermons = new CustomPostType( 'Sermon', array(
            'supports'           => array( 'title', 'revisions' ),
            'menu_icon'          => 'dashicons-format-video',
            'rewrite'            => array( 'with_front' => true ),
            'has_archive'        => true,
            'menu_position'      => null,
            'public'             => true,
            'publicly_queryable' => true,
        ) );

        $sermons->addTaxonomy( 'Series', [
            'hierarchical'      => true,
            'show_ui'           => true,
            'show_admin_column' => true,
            'query_var'         => true,
            'rewrite'           => array( 'slug' => 'format' ),
            'public'            => true,
            'show_in_nav_menus' => false,
            'show_tagcloud'     => false,
        ] );

        $sermons->convertCheckToRadio( 'series' );

        $sermons->addMetaBox( 'Sermon Details', array(
            'Vimeo Code'  => 'text',
            'Sermon Date' => 'date',
            'Show'        => 'boolean'
        ) );

        $sermons->createTaxonomyMeta( 'series', [ 'label' => 'Series Verse', 'type' => 'wysiwyg' ] );
        $sermons->createTaxonomyMeta( 'series', [ 'label' => 'Active', 'type' => 'boolean' ] );

    }

    /**
     * @return null
     */
    public function createAdminColumns() {

        add_filter( 'manage_sermon_posts_columns',
            function ( $defaults ) {
                $defaults = [
                    'title'       => 'title',
                    'sermon-date' => 'Sermon Date',
                    'vimeo'       => 'Vimeo Code',
                    'series'      => 'Series',
                    'show'        => 'Shown on Website'
                ];

                return $defaults;
            }, 0 );

        add_action( 'manage_sermon_posts_custom_column', function ( $column_name, $post_ID ) {
            switch ( $column_name ) {

                case 'sermon-date':
                    $object = get_post_meta( $post_ID, 'sermon_details_sermon_date', true );
                    echo( isset( $object ) ? date( 'M j, Y', strtotime( $object ) ) : null );
                    break;

                case 'vimeo':
                    $object = get_post_meta( $post_ID, 'sermon_details_vimeo_code', true );
                    echo( isset( $object ) ? '<a target="_blank" href="https://vimeo.com/' . $object . '">' . $object . '</a>' : null );
                    break;

                case 'show':
                    $object = get_post_meta( $post_ID, 'sermon_details_show', true );
                    echo( $object == 'on' ? 'TRUE' : 'FALSE' );
                    break;

                case 'series':
                    $term = wp_get_object_terms( $post_ID, 'series' );
                    echo( isset( $term[0]->name ) ? $term[0]->name : null );
                    break;
            }
        }, 0, 2 );

        add_action( 'restrict_manage_posts', function () {
            $type = 'post';
            if ( isset( $_GET['post_type'] ) ) {
                $type = $_GET['post_type'];
            }

            if ( 'sermon' == $type ) {

                $values = get_terms( [
                    'taxonomy'   => 'series',
                    'hide_empty' => false,
                ] );

                echo '<select name="series">
                    <option value="">All Series\'</option>';

                $current_v = isset( $_GET['series'] ) ? $_GET['series'] : '';
                foreach ( $values as $label => $value ) {
                    printf
                    (
                        '<option value="%s"%s>%s</option>',
                        $value->slug,
                        $value->slug == $current_v ? ' selected="selected"' : '',
                        $value->name
                    );
                }

                echo '</select>';

            }
        } );

    }

    public function getSermons( $args = [], $category = '', $limit = - 1 ) {

        $request = [
            'posts_per_page' => $limit,
            'offset'         => 0,
            'order'          => 'DESC',
            'orderby'        => 'meta_value_num',
            'meta_key'       => 'sermon_details_sermon_date',
            'post_type'      => 'sermon',
            'post_status'    => 'publish',
        ];

        $request = array_merge( $request, $args );

        if ( $category != '' ) {
            $categoryArray        = [
                [
                    'taxonomy'         => 'series',
                    'field'            => 'slug',
                    'terms'            => $category,
                    'include_children' => false,
                ],
            ];
            $request['tax_query'] = $categoryArray;
        }

        $postList = get_posts( $request );

        $outputArray = [];

        foreach ( $postList as $post ) {

            $term = wp_get_object_terms( $post->ID, 'series' );
            $outputArray[] = [
                'id'    => ( isset( $post->ID ) ? $post->ID : null ),
                'name'  => ( isset( $post->post_title ) ? $post->post_title : null ),
                'slug'  => ( isset( $post->post_name ) ? $post->post_name : null ),
                'date'  => ( isset( $post->sermon_details_sermon_date ) ? $post->sermon_details_sermon_date : null ),
                'vimeo' => ( isset( $post->sermon_details_vimeo_code ) ? $post->sermon_details_vimeo_code : null ),
                'show'  => ( isset( $post->sermon_details_show ) ? $post->sermon_details_show : null ),
                'series' => ( isset($term[0]) ? $term[0]->name : ''),
                'link'  => get_permalink( $post->ID ),
            ];

        }

        return $outputArray;

    }

    public function getSeries( $args = [], $limit = 0 ){

        $request = get_terms([
            'taxonomy'   => 'series',
            'hide_empty' => false,
        ]);

        $request = array_merge( $request, $args );

        //chop to limit manually since SCP Order is ganked.
        if ($limit != 0) {
            $outputArray = array_slice($request, 0, $limit);
        }

        return $outputArray;

    }

    public function getRecentlyPublished(){

        $request = $this->getSermons([
            'meta_query'     => [
                'relation' => 'AND',
                [
                    'key'     => 'sermon_details_show',
                    'value'   => 'on',
                    'compare' => '='
                ],
                [
                    'key'     => 'sermon_details_sermon_date',
                    'value'   => date('Ymd'),
                    'compare' => '<'
                ]
            ]
        ],null,4);

        if(!empty($request)){
        	$output = $request;
        }else{
        	$output = 'There are currently no available sermons.';
        }

        return $output;

    }

    public function getUpcoming(){

	    $request = $this->getSermons([
            'order'          => 'ASC',
            'meta_query'     => [
                [
                    'key'     => 'sermon_details_sermon_date',
                    'value'   => date('Ymd'),
                    'compare' => '>'
                ]
            ]
        ],null,2);

	    if(!empty($request)){
		    $output = $request;
	    }else{
		    $output = 'Check back soon!';
	    }

        return $output;

    }




}
