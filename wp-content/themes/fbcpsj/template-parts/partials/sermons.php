<?php

use Includes\Modules\Sermons\Sermons;

/**
 * @package PSJCG
 * @subpackage fbcpsj
 * @since 1.0
 * @version 1.2
 */

$sermonObject = new Sermons();

$recent = ($sermonObject->getNext([], null, 1))[0];

// echo $recent['date'];
// echo ' = ';
// echo date('Ymd');
?>
<div id="events" class="section-wrapper" >
    <div id="events-section" style="padding: 6rem 0 8rem;">
        <div class="container has-text-centered">
        <h2 class="title is-size-2" style="font-family: 'Playfair Display',serif; font-weight: 700;">
            <?php echo ($recent['date'] > date('Ymd') ? 'Upcoming' : 'Current' ); ?> Message</h2>
        <p class="sermon-name is-size-4"><?php echo $recent['name']; ?></p>
        <p class="sermon-date is-size-4"><?php echo date('F j, Y', strtotime($recent['date'])); ?></p>
        &nbsp;
        <?php if($recent['vimeo'] != ''){ ?>
        <div class="box">
            <div class="video-wrapper horizontal">
            <iframe 
                :src="'https://player.vimeo.com/video/<?php echo $recent['vimeo']; ?>?autoplay=1&title=0&byline=0&portrait=0'" 
                frameborder="0" 
                webkitallowfullscreen mozallowfullscreen allowfullscreen
                style="width:100%;"
            ></iframe>
            </div>
        </div>
        <?php }else{ ?>
            <div class="box" >
                <p>Check back Sunday morning for the video!</p>
            </div>
        <?php } ?>

        <div class="columns" >
            <?php if($recent['notes']!='') {?>
            <div class="column is-4-desktop">
                <a href="<?php echo $recent['notes']['url']; ?>" target="_blank" class="button is-fullwidth is-info" >Download Message Notes</a>
            </div>
            <?php } ?>
            <div class="column is-4-desktop">
                <a href="/connection-card/" class="button is-fullwidth is-info" >Complete Connection Card</a>
            </div>
            <div class="column is-4-desktop">
                <a href="/give/" class="button is-fullwidth is-info" >Tithe & Giving</a>
            </div>
        </div>

        <?php //include(locate_template('template-parts/partials/events-loop.php')); ?>
        </div>
    </div>
</div>
<div class="columns is-gapless is-multiline feat-buttons">
    <div class="column is-4">
        <div class="feat-button ministries">
            <a href="/ministries/" >Children, Youth<br>& Adult Ministries</a>
            <div class="overlay"></div>
        </div>
    </div>
    <div class="column is-4">
        <div class="feat-button prayer">
            <a href="/prayer/" >Ask for Prayer</a>
            <div class="overlay"></div>
        </div>
    </div>
    <div class="column is-4">
        <div class="feat-button goodnews">
            <a href="/the-good-news/" >I am Becoming a<br>Follower of Jesus</a>
            <div class="overlay"></div>
        </div>
    </div>
</div>
<div id="sermons" class="section-wrapper" >
    <div id="sermons-section">
        <div class="container">
            <h2>Current Message Series</h2>
            <span class="separator"></span>
            <?php $series = $sermonObject->getSeries([], 1); ?>
            <div class="current-series has-text-centered">
                <p class="title is-2" style="font-weight: bold; color: #FFF;"><?php echo $series[0]->name; ?></p>
                <p class="sub-title"><?php echo $series[0]->description; ?></p>
                <?php echo apply_filters('the_content', get_term_meta($series[0]->term_id, 'series_series_verse', true)); ?>
            </div>

            <h3>Recent Messages</h3>
            <div class="recently-published-sermons">
                <?php
                $recentlyPublished = $sermonObject->getRecentlyPublished();
                if (!is_array($recentlyPublished)) { ?>
                    <div class="sermon-snippet">
                        <p><?php echo $recentlyPublished; ?></p>
                    </div>
                <?php } else {
                    foreach ($recentlyPublished as $recentSermon) { ?>

                    <div class="columns is-multiline message-snippet" >
                        <div class="column is-8">
                            <p class="title is-3 has-text-white" ><?php echo $recentSermon['name']; ?></p>
                            <p class="subtitle">
                                <span class="sermon-date"><?php echo date('F j, Y', strtotime($recentSermon['date'])); ?></span> |
                                 <?php echo $recentSermon['series']; ?></p>
                        </div>
                        <div class="column is-4 message-buttons">
                            <?php if ($recentSermon['vimeo'] != '') { ?>
                                <button @click="$emit('toggleModal', 'videoViewer', <?php echo $recentSermon['vimeo']; ?>, 'horizontal')"
                                        class="button is-brand watch-button">watch online
                                </button>
                            <?php } ?>
                            <?php if($recentSermon['notes']!='') {?>
                                <a href="<?php echo $recentSermon['notes']['url']; ?>" target="_blank" class="button notes-button" >Message Notes</a>
                            <?php } ?>
                        </div>

                    </div>

                    <?php }
                } ?>
            </div>
  
            <div class="section-close is-centered">
                <div class="watermark">

                </div>
            </div>
        </div>
    </div>
</div>

