<?php

use Includes\Modules\services\Ministries;

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
                </div>
            </div>
        </section>
        <section id="content" class="content section ministries-section">
            <div class="container">
                <div class="entry-content">
                    <?php
                    the_content();
                    ?>

                    <div class="columns is-multiline is-centered">
                        <?php

                        $ministryLoop = new Ministries();
                        $ministries     = $ministryLoop->getMinistries([]);

//                        print_r($ministries);

                        foreach ($ministries as $num => $ministry) { ?>
                            <div class="column is-6-tablet is-3-desktop ministry-<?php echo $num; ?>">
                                <div class="ministry-container">
                                    <div class="ministry-image" style="background-image:url('<?php echo $ministry['photo']; ?>');">
                                        <?php if ($ministry['show_details'] == 'on') { ?>
                                            <a href="<?php echo $ministry['link']; ?>" ></a>
                                        <?php } ?>
                                    </div>
                                    <div class="ministry-text">
                                        <h3><?php echo $ministry['name']; ?></h3>
                                    </div>
                                    <div class="ministry-link">
                                        <?php if ($ministry['show_details'] == 'on') { ?>
                                            <a href="<?php echo $ministry['link']; ?>" class="button button-sm is-transparent">more info</a>
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