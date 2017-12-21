<?php

use Includes\Modules\Team\Team;

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
        <section id="content" class="content section team-section">
            <div class="container">
                <div class="entry-content">
                    <?php
                    the_content();
                    ?>

                    <div class="columns is-multiline is-centered">
                        <?php

                        $team        = new Team();
                        $teamMembers = $team->getteam( [] );

                        foreach ($teamMembers as $num => $teamMember) { ?>
                            <div class="column is-6-tablet is-3-desktop team-member-<?php echo $num; ?>">
                                <div class="team-member-container">

                                    <div class="team-member-info">
                                        <div class="team-member-image" style="background-image:url('<?php echo $teamMember['thumbnail']; ?>');">
                                            <a href="<?php echo $teamMember['link']; ?>" >
                                                <figure class="image is-4by3"></figure>
                                            </a>
                                        </div>
                                        <div class="team-member-text">
                                            <h3><?php echo $teamMember['name']; ?></h3>
                                            <p><?php echo $teamMember['title']; ?></p>
                                            <p><a href="mailto:<?php echo $teamMember['email']; ?>" ><?php echo $teamMember['email']; ?></a></p>
                                        </div>
                                    </div>
                                    <div class="team-member-link">
                                        <a href="<?php echo $teamMember['link']; ?>" class="button button-sm is-rounded">more info</a>
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