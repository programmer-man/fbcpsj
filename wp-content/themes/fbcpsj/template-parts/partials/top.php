<?php

use Includes\Modules\Navwalker\BulmaNavwalker;

/**
 * @package PSJCG
 * @subpackage fbcpsj
 * @since 1.0
 * @version 1.2
 */
?>
<header id="top" :class="{ 'smaller': scrolled }">
    <nav class="navbar is-transparent">
        <div class="navbar-brand">
            <a href="/">
                <img src="<?php echo get_template_directory_uri() . '/img/logo.svg'; ?>" alt="First Baptist Church Port St. Joe" width="200" height="60">
            </a>

            <div class="navbar-burger burger" id="TopNavBurger" data-target="TopNavMenu" @click="toggleMenu">
                <span></span>
                <span></span>
                <span></span>
            </div>
        </div>

        <div id="TopNavMenu" class="navbar-menu" :class="{ 'is-active': isOpen }" >
            <?php wp_nav_menu( array(
                    'theme_location' => 'main-menu',
                    'container'      => false,
                    'menu_class'     => 'navbar-end',
                    'fallback_cb'    => '',
                    'menu_id'        => 'main-menu',
                    'link_before'    => '',
                    'link_after'     => '',
                    'items_wrap'     => '<div id="%1$s" class="%2$s">%3$s</div>',
                    'walker'         => new BulmaNavwalker()
            ) ); ?>
        </div>

        <!-- <div class="service-times">
            <p>Classic/Choir Service: <strong>8:30 am</strong><br>
             Sunday School: <strong>9:45 am</strong><br>
             All-Contemporary Service: <strong>10:45 am</strong></p>
        </div> -->
    </nav>
</header>
