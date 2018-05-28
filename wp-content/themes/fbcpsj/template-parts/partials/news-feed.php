<?php

use KeriganSolutions\FacebookFeed\FacebookFeed;

?>
<div class="facebook-news">
    <div class="container-fluid">
    <h2>News</h2>
    <span class="separator"></span>

    <div class="columns">
        <?php
        $feed    = new FacebookFeed();

        try{
            $results = $feed->fetch(4);
            foreach ($results->posts as $result) {
                include(locate_template('template-parts/partials/mini-article.php'));
            }

        } catch (Exception $e){
            echo '<div class="column"><p class="has-text-centered">Our news feed is temporarily down for maintenance.</p></div>';
            //echo $e->getMessage();
        }
        ?>
    </div>
    <div class="facebook-likes">
        <script>
            window.fbAsyncInit = function() {
                FB.init({
                    appId      : '960377764104394',
                    xfbml      : true,
                    version    : 'v2.10'
                });
                FB.AppEvents.logPageView();
            };

            (function(d, s, id){
                var js, fjs = d.getElementsByTagName(s)[0];
                if (d.getElementById(id)) {return;}
                js = d.createElement(s); js.id = id;
                js.src = "//connect.facebook.net/en_US/sdk.js";
                fjs.parentNode.insertBefore(js, fjs);
            }(document, 'script', 'facebook-jssdk'));
        </script>

        <iframe src="https://www.facebook.com/plugins/like.php?href=https%3A%2F%2Fwww.facebook.com%2Flighthousechurchpsj%2F&width=300&layout=standard&action=like&size=large&show_faces=true&share=true&height=80&appId=960377764104394" width="300" height="98" style="border:none;overflow:hidden" scrolling="no" frameborder="0" allowTransparency="true"></iframe>
    </div>
        <div class="section-close is-centered">
            <a class="button is-info is-pill" href="/news/">More news</a> <a class="button is-info is-pill" href="https://www.facebook.com/lighthousechurchpsj/" target="_blank" >Follow us on Facebook!</a>
        </div>
    </div>
</div>
