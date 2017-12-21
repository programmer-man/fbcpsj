<?php

use KeriganSolutions\FacebookFeed\FacebookFeed;

/**
 * @package PSJCG
 * @subpackage fbcpsj
 * @since 1.0
 * @version 1.2
 */
$headline = ($post->page_information_headline != '' ? $post->page_information_headline : get_the_archive_title());
$subhead  = ($post->page_information_subhead != '' ? $post->page_information_subhead : get_the_archive_description());
?>
<div class="mid-pad"></div>
<div id="mid">
    <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
        <section class="hero">
            <div class="hero-body">
                <div class="container">
                    <h1 class="title"><?php echo $headline; ?></h1>
                    <?php echo($subhead != '' ? '<p class="subtitle">' . $subhead . '</p>' : null); ?>
                </div>
            </div>
        </section>
        <section id="content" class="content section">
            <div class="columns is-multiline">
                <?php
                $feed    = new FacebookFeed();
                $results = $feed->fetch(36);

                foreach ($results->posts as $result) {
                    include(locate_template('template-parts/partials/mini-article.php'));
                } ?>
            </div>
        </section>
    </article><!-- #post-## -->
</div>