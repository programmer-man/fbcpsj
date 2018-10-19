<?php

use Includes\Modules\Slider\BulmaSlider;

/**
 * @package PSJCG
 * @subpackage fbcpsj
 * @since 1.0
 * @version 1.2
 */
$headline = ($post->page_information_headline != '' ? $post->page_information_headline : $post->post_title);
$subhead = ($post->page_information_subhead != '' ? $post->page_information_subhead : '');
?>
<div id="mid" >
    <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
        <div class="section-wrapper" style="background-color: #555;" >

            <slider>
                <?php
                    $slider = new BulmaSlider();
                    echo $slider->getSlider('home-page-slideshow');
                ?>
            </slider>

        </div>
    </article>
    <!-- <div id="events" class="section-wrapper" >
        <?php include(locate_template('template-parts/partials/events-loop.php')); ?>
    </div>
    <div id="sermons" class="section-wrapper" >
        <?php include(locate_template('template-parts/partials/sermons.php')); ?>
    </div> -->
    <div id="storm" class="section-wrapper">

        <div class="columns is-multiline" >
            <div class="column is-3-desktop">
                <img src="/wp-content/themes/fbcpsj/img/storm/1.jpg">
            </div>
            <div class="column is-3-desktop">
                <img src="/wp-content/themes/fbcpsj/img/storm/2.jpg">
            </div>
            <div class="column is-3-desktop">
                <img src="/wp-content/themes/fbcpsj/img/storm/3.jpg">
            </div>
            <div class="column is-3-desktop">
                <img src="/wp-content/themes/fbcpsj/img/storm/4.jpg">
            </div>
            <div class="column is-3-desktop">
                <img src="/wp-content/themes/fbcpsj/img/storm/5.jpg">
            </div>
            <div class="column is-3-desktop">
                <img src="/wp-content/themes/fbcpsj/img/storm/6.jpg">
            </div>
            <div class="column is-3-desktop">
                <img src="/wp-content/themes/fbcpsj/img/storm/7.jpg">
            </div>
            <div class="column is-3-desktop">
                <img src="/wp-content/themes/fbcpsj/img/storm/8.jpg">
            </div>
            <div class="column is-3-desktop">
                <img src="/wp-content/themes/fbcpsj/img/storm/9.jpg">
            </div>
            <div class="column is-3-desktop">
                <img src="/wp-content/themes/fbcpsj/img/storm/10.jpg">
            </div>
            <div class="column is-3-desktop">
                <img src="/wp-content/themes/fbcpsj/img/storm/11.jpg">
            </div>
            <div class="column is-3-desktop">
                <img src="/wp-content/themes/fbcpsj/img/storm/12.jpg">
            </div>
        </div>

    </div>
    <div id="news" class="section-wrapper" >
        <?php include(locate_template('template-parts/partials/news-feed.php')); ?>
    </div>
</div>
