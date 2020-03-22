<?php

use Includes\Modules\Sermons\Sermons;

/**
 * @package PSJCG
 * @subpackage fbcpsj
 * @since 1.0
 * @version 1.2
 */

$sermonObject = new Sermons();

?>
<div id="events" class="section-wrapper" >
    <div id="events-section" style="padding: 6rem 0 8rem;">
        <div class="container has-text-centered">
        <h2 class="title is-size-2" style="font-family: 'Playfair Display',serif; font-weight: 700;">Upcoming Online Sermon</h2>
        <?php
            $recent = ($sermonObject->getNext([], null, 1))[0];
        ?>
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

        <?php //include(locate_template('template-parts/partials/events-loop.php')); ?>
        </div>
    </div>
</div>
<div id="sermons" class="section-wrapper" >
    <div id="sermons-section">
        <div class="container">
            <h2>Sermons</h2>
            <span class="separator"></span>
            <div class="columns">
                <div class="column is-6-desktop">
                    <h3>Current Series</h3>
                    <?php
                    $series = $sermonObject->getSeries([], 1);
                    ?>
                    <div class="current-series">
                        <p class="title is-2" style="font-weight: bold;"><?php echo $series[0]->name; ?></p>
                        <p class="sub-title"><?php echo $series[0]->description; ?></p>
                        <?php echo apply_filters('the_content', get_term_meta($series[0]->term_id, 'series_series_verse', true)); ?>
                    </div>

                    <h3>Upcoming Sermons</h3>
                    <div class="upcoming-sermons">
                        <?php
                        $upcoming = $sermonObject->getUpcoming();
                        if (!is_array($upcoming)) { ?>
                            <div class="sermon-snippet">
                                <p><?php echo $upcoming; ?></p>
                            </div>
                        <?php } else {
                            foreach ($upcoming as $upcomingSermon) { ?>
                                <div class="sermon-snippet centered">
                                    <div class="sermon-title">
                                        <p class="sermon-name"><?php echo $upcomingSermon['name']; ?></p>
                                        <p class="sermon-series"><?php echo $upcomingSermon['series']; ?></p>
                                        <p class="sermon-date"><?php echo date('F j, Y',
                                                strtotime($upcomingSermon['date'])); ?></p>
                                    </div>
                                </div>
                            <?php }
                        } ?>
                    </div>
                </div>
                <div class="column is-6-desktop">
                    <h3>Recent Sermons</h3>
                    <div class="recently-published-sermons">
                        <?php
                        $recentlyPublished = $sermonObject->getRecentlyPublished();
                        if (!is_array($recentlyPublished)) { ?>
                            <div class="sermon-snippet">
                                <p><?php echo $recentlyPublished; ?></p>
                            </div>
                        <?php } else {
                            foreach ($recentlyPublished as $recentSermon) { ?>
                                <div class="sermon-snippet <?php echo($recentSermon['vimeo'] != '' ? 'has-button' : ''); ?>">
                                    <div class="sermon-title">
                                        <p class="sermon-name"><?php echo $recentSermon['name']; ?></p>
                                    </div>
                                    <div class="sermon-info">
                                        <div class="sermon-stuff">
                                            <p class="sermon-series"><?php echo $recentSermon['series']; ?></p>
                                            <p class="sermon-date"><?php echo date('F j, Y', strtotime($recentSermon['date'])); ?></p>
                                        </div>
                                        <?php if ($recentSermon['vimeo'] != '') { ?>
                                            <div class="sermon-button">
                                                <button @click="$emit('toggleModal', 'videoViewer', <?php echo $recentSermon['vimeo']; ?>, 'horizontal')"
                                                        class="button button-sm is-transparent">watch online
                                                </button>
                                            </div>
                                        <?php } ?>
                                    </div>
                                </div>
                            <?php }
                        } ?>
                    </div>
                </div>
            </div>
            <div class="section-close is-centered">
                <div class="watermark">

                </div>
            </div>
        </div>
    </div>
</div>

