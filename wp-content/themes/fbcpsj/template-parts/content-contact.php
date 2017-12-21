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
                <div class="columns is-multiline">
                    <div class="column is-6">
                        <div class="entry-content">
                            <?php
                            the_content();
                            ?>
                        </div><!-- .entry-content -->
                    </div>
                    <div class="column is-6">
                        <form method="post" >
                            <input type="text" name="sec" value="" class="sec-form-code" style="position: absolute; left:-10000px; top:-10000px; height:0px; width:0px;" >
                            <div class="columns is-multiline">
                                <div class="column is-6">
                                    <input type="text" name="first_name" class="input" placeholder="First Name" required>
                                </div>
                                <div class="column is-6">
                                    <input type="text" name="last_name" class="input" placeholder="Last Name" required>
                                </div>
                                <div class="column is-12">
                                    <input type="email" name="email_address" class="input email" placeholder="Email Address" required>
                                </div>
                                <div class="column is-12">
                                    <textarea class="textarea" name="message" placeholder="Type your message here."></textarea>
                                </div>
                                <div class="column is-12">
                                    <button class="button is-primary" type="submit">submit</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </section>
    </article><!-- #post-## -->
</div>