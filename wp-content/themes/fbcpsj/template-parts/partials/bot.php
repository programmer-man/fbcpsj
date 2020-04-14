<?php

use Includes\Modules\Navwalker\BulmaNavwalker;

/**
 * @package PSJCG
 * @subpackage fbcpsj
 * @since 1.0
 * @version 1.2
 */
?>
<div id="bot" class="centered">

    <div class="footer-contact">
        <div class="columns is-multiline is-centered">
            <div class="column contact">
                <p><strong>Contact the Church Office:</strong></p>
                <p><a href="tel:850-227-1552" >850-227-1552</a><br>
                <a href="mailto:fbcpsj@gtcom.net" >fbcpsj@gtcom.net</a></p>
            </div>
            <div class="column physical">
                <p><strong>Office Hours: 8:00 AM - 5:00 PM</strong></p>
                <p>528 6th St.<br>
                    Port St. Joe, FL 32456</p>
            </div>
            <div class="column mailing">
                <p><strong>Mailing Address:</strong></p>
                <p>P.O. Box 568.<br>
                    Port St. Joe, FL 32457</p>
            </div>
        </div>
    </div>

    <div class="bottom-nav">
        <?php wp_nav_menu( array(
            'theme_location' => 'footer-menu',
            'container'      => false,
            'menu_class'     => 'navbar is-transparent',
            'fallback_cb'    => '',
            'menu_id'        => 'footer-menu',
            'link_before'    => '',
            'link_after'     => '',
            'items_wrap'     => '<div id="%1$s" class="%2$s">%3$s</div>',
            'walker'         => new BulmaNavwalker()
        ) ); ?>
    </div>

</div>
<footer id="bot-bot" >
    <div class="container">
        <div class="content has-text-centered">
            <p id="copyright">&copy; <?php echo date('Y'); ?> <?php echo get_bloginfo(); ?>. All rights reserved.</p>
        </div>
    </div>
</footer>