<?php

use Includes\Modules\leads\SimpleContact;

$formSubmitted = (isset($_POST['sec']) ? ($_POST['sec'] == '' ? true : false) : false );
if($formSubmitted){
    $leads = new SimpleContact;
    $leads->handleLead($_POST);
}

/**
 * @package PSJCG
 * @subpackage fbcpsj
 * @since 1.0
 * @version 1.2
 */
$headline = ($post->page_information_headline != '' ? $post->page_information_headline : $post->post_title);
$subhead = ($post->page_information_subhead != '' ? $post->page_information_subhead : '');
$sidebar = ($post->sidebar_content_html != '' ? $post->sidebar_content_html : '');

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

                <div class="entry-content">
                    <?php
                    the_content();
                    ?>
                </div><!-- .entry-content -->

            </div>
        </section>
    </article><!-- #post-## -->
</div>