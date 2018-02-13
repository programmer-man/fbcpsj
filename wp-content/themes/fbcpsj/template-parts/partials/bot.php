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
        <p><a href="tel:850-227-1552" >850-227-1552</a></p>
        <p>102 Third St.<br>
            Port St. Joe, FL 32456</p>
        <p><a target="_blank" href="https://www.google.com/maps/dir//102+Third+Street+Port+Saint+Joe,+FL+32456/@29.813375,-85.3395991,13z/data=!3m1!4b1!4m9!4m8!1m0!1m5!1m1!1s0x88949665a2c8f611:0x14d60cdf286d5335!2m2!1d-85.3045797!2d29.8133796!3e0" >Get Directions</p>
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