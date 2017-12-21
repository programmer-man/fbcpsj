<?php

use Includes\Modules\Events\Events;

/**
 * @package PSJCG
 * @subpackage fbcpsj
 * @since 1.0
 * @version 1.2
 */
$headline = ($post->page_information_headline != '' ? $post->page_information_headline : $post->post_title);
$subhead = ($post->page_information_subhead != '' ? $post->page_information_subhead : '');
?>
<div class="mid-pad"></div>
<div id="mid" >
    <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
        <section class="hero">
            <div class="hero-body">
                <div class="container">
                    <h1 class="title"><?php echo $headline; ?></h1>
                    <?php echo ($subhead!='' ? '<p class="subtitle">'.$subhead.'</p>' : null); ?>
                    <?php if ( 'post' === get_post_type() ) : ?>
                        <div class="entry-meta">
                            <?php //fbcpsj_posted_on(); ?>
                        </div><!-- .entry-meta -->
                    <?php endif; ?>
                </div>
            </div>
        </section>
        <section id="content" class="content section">
            <div class="container">
                <div class="entry-content">
                    <?php
                    the_content();
                    ?>

                    <div class="columns is-multiline">
                        <?php

                        $eventsLoop = new Events();
                        $events     = $eventsLoop->getUpcomingEvents([]);

                        foreach ($events as $num => $event) { ?>
                            <div class="column is-6-tablet is-3-desktop event-<?php echo $num; ?>">
                                <div class="event-container">
                                    <div class="event-image" style="background-image:url('<?php echo $event['photo']; ?>');">
                                        <?php if ($event['details'] == 'on') { ?>
                                            <a href="<?php echo $event['link']; ?>" ></a>
                                        <?php } ?>
                                    </div>
                                    <div class="event-info">
                                        <div class="date">
                                            <span class="day"><?php echo date('d', strtotime($event['start'])); ?></span>
                                            <span class="mon"><?php echo date('M', strtotime($event['start'])); ?></span>
                                        </div>
                                        <div class="title-location">
                                            <span class="event-title"><?php echo $event['name']; ?></span>
                                            <?php if($event['time'] != ''){ ?>
                                                <span class="location"><?php echo $event['location']; ?></span>
                                            <?php } ?>
                                            <?php if($event['time'] != ''){ ?>
                                                <span class="time"><?php echo $event['time']; ?></span>
                                            <?php } ?>
                                        </div>
                                    </div>
                                    <div class="event-link">
                                        <?php if ($event['details'] == 'on') { ?>
                                            <a href="<?php echo $event['link']; ?>" class="button button-sm is-transparent">more info</a>
                                        <?php } ?>
                                    </div>
                                </div>
                            </div>
                        <?php } ?>
                    </div>

                </div><!-- .entry-content -->
            </div>
        </section>
    </article><!-- #post-## -->
</div>