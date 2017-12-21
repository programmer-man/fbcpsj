<?php

use Includes\Modules\Events\Events;

/**
 * @package PSJCG
 * @subpackage fbcpsj
 * @since 1.0
 * @version 1.2
 */
?>
<div id="events-section">
    <div class="container">
        <div class="columns">
            <?php

            $eventsLoop = new Events();
            $events     = $eventsLoop->getHomePageEvents(4);

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
        <div class="section-close is-centered">
            <a class="button is-info is-pill" href="/events/">All events</a>
        </div>
    </div>
</div>