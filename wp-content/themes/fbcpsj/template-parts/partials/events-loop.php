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
        <div class="columns is-multiline">
            <?php

            $eventsLoop = new Events();
            $events     = $eventsLoop->getHomePageEvents(4);

            foreach ($events as $num => $event) { ?>
                <div class="column is-6-tablet is-3-desktop event-<?php echo $num; ?> has-text-centered">
                    <div class="card event-container">
                        <div class=" card-image event-image" style="background-image:url('<?php echo $event['photo']; ?>');">
                            <?php if ($event['details'] == 'on') { ?>
                                <a href="<?php echo $event['link']; ?>" ></a>
                            <?php } ?>
                        </div>
                        <div class="event-info">
                            <div class="title-location">
                                <span class="event-title"><?php echo $event['name']; ?></span>
                                <span class="event-date"><?php echo $event['recurr_readable']; ?></span>
                                <span class="time"><?php echo $event['time']; ?></span>
                                <span class="location"><?php echo $event['location']; ?></span>
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
        <!-- <div class="section-close is-centered">
            <a class="button is-info is-pill" href="/events/">All events</a>
        </div> -->
    </div>
</div>