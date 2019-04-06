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
    <div id="events" class="section-wrapper" >
        <?php include(locate_template('template-parts/partials/events-loop.php')); ?>
    </div>
    <div id="sermons" class="section-wrapper" >
        <?php include(locate_template('template-parts/partials/sermons.php')); ?>
    </div>
    <div id="storm" class="section-wrapper" style="padding:4rem 2rem;">

        <div class="columns is-multiline" >
        <div class="column is-half"> 
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
                <img src="/wp-content/themes/fbcpsj/img/storm/9.jpg">
            </div>
 
        </div>

        </div>
        <div class="column is-half" style="padding:1rem 2rem">
            <h2 class="title is-2" >Welcome!</h2>
            <p class="is-white">On October 10, 2018 Hurricane Michael, the strongest hurricane to ever hit the panhandle of Florida, slammed into Port St. Joe and our surrounding communities, leaving a path of destruction in its wake. We are unable to meet in our building at 102 Third St. and are blessed to be able to meet at the Port St. Joe Elemenary School Auditorium on Sundays. </p>
            &nbsp;
            <p>If you'd like to help by serving, providing relief items, message us on Facebook or give us a call and we'll connect you to the right emergency personnel. 
            If you'd like to help our church financially, please use our online giving portal. Thank You!</p>
           &nbsp;
           <div class="py-4">
            <a href="https://www.churchteams.com/m/Give.asp?oID=15641&amp;aID=RmFXL29WckVoL1ZXeG9IN051bmJnYWwxb2U5OFZ6WlQ%3D" target="_blank" class="button is-secondary my-1" style="margin: 0.25rem;">Give Online</a> 
            <form action="https://www.paypal.com/cgi-bin/webscr" method="post" target="_top" style="display: inline;">
                <input type="hidden" name="cmd" value="_s-xclick"> 
                <input type="hidden" name="hosted_button_id" value="8M67CR77BHLML"> 
                <button type="submit" class="button is-secondary my-1" style="margin: 0.25rem;">Give with PayPal</button> 
                <img alt="" src="https://www.paypalobjects.com/en_US/i/scr/pixel.gif" width="1" height="1" border="0">
            </form>
            </div>
            </div>
            </div>
    </div>
    <div id="news" class="section-wrapper" >
        <?php include(locate_template('template-parts/partials/news-feed.php')); ?>
    </div>
</div>
