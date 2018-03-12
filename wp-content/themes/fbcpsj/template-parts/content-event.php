<?php
/**
 * @package PSJCG
 * @subpackage fbcpsj
 * @since 1.0
 * @version 1.2
 */

use Includes\Modules\Events\Events;

$events = new Events();
$event = $events->getSingleEvent($post->ID);

$headline = ($post->page_information_headline != '' ? $post->page_information_headline : $post->post_title);
$subhead = ($event['recurr_readable'] != '' ? $event['recurr_readable'] : $event['formatted_date'] . ', ' . $event['time'] );
$sidebar = ($post->sidebar_content_html != '' ? $post->sidebar_content_html : '');

//echo '<pre>',print_r($event),'</pre>';


?>
<div class="mid-pad"></div>
<div id="mid" >
    <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
        <section class="hero">
            <div class="hero-body">
                <div class="container">
                    <h1 class="title"><?php echo $headline; ?></h1>
                    <?php echo ($subhead!='' ? '<p class="subtitle">'.$subhead.'</p>' : null); ?>
                </div>
            </div>
        </section>
        <section id="content" class="content section">
            <div class="container">
                <?php if($sidebar != ''){ ?>
                    <div class="columns is-multiline">
                        <div class="column is-6">
                <?php } ?>
                    <div class="entry-content">
                        <?= apply_filters('the_content', $event['content']); ?>
                    </div><!-- .entry-content -->
                <?php if($sidebar != ''){ ?>
                        </div>
                        <div class="column is-6">
                            <?php echo $sidebar;?>
                        </div>
                    </div>
                <?php } ?>
            </div>
        </section>
    </article><!-- #post-## -->
</div>