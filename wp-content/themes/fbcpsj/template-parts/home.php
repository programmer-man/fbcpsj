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
    <div id="news" class="section-wrapper" >
        <?php include(locate_template('template-parts/partials/news-feed.php')); ?>
    </div>
</div>
