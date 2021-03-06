<?php
/**
 * @package PSJCG
 * @subpackage fbcpsj
 * @since 1.0
 * @version 1.2
 */
$dateposted = human_time_diff(time(),strtotime($result->created_time)) . ' ago';
$content  = isset($result->message) ? $result->message : null;
$photoUrl = isset($result->full_picture) ? $result->full_picture : null;
if($result->type == 'video' && isset($result->attachments)){
	$mediaImage = $result->attachments->data[0]->media->image;
}
$aspectRatio = (isset($mediaImage->height) && isset($mediaImage->width) && $mediaImage->height > $mediaImage->width ? 'vertical' : 'horizontal' );
//echo '<pre>',print_r($result),'</pre>';
?>
<div class="column is-6-tablet is-3-widescreen">

    <div class="blog-article">
        <div class="blog-image <?= !isset($photoUrl) && $result->type != 'video' ? 'no-photo' : '' ?> ">
            <?php if($result->type != 'video' && isset($photoUrl)) { ?>
                <figure class="image">
                    <a target="_blank" href="<?php echo $result->permalink_url; ?>" target="_blank">
                        <img src="<?php echo $photoUrl; ?>" alt="<?php echo $result->caption; ?>" >
                    </a>
                </figure>
            <?php } elseif($result->type == 'video') { ?>
                <div class="video-wrapper <?= $aspectRatio; ?>">
                    <iframe
                            src="<?php echo $result->link ?>"
                            style="border:none;overflow:hidden"
                            scrolling="no"
                            frameborder="0"
                            allowTransparency="true"
                            allowFullScreen="true"
                            class="article-image"
                            width="100%"
                            height="170">

                    </iframe>
                </div>
            <?php } ?>
            <div class="blog-content <?= ! isset($photoUrl) ? 'status-only' : '' ?>">
                <div class="entry-meta <?= ($content == '' ? 'no-text' : ''); ?>" >
                    <?= ($dateposted!='' ? '<p class="time-posted" >'.$dateposted.'</p>' : null); ?>
                </div>
	            <?php if($content != ''){ ?>
                <p><?= wp_trim_words( $content, $num_words = 22, '... <a href="'. $result->permalink_url .'">more</a>' ); ?></p>
                <?php } ?>
            </div>
        </div>

        <div class="blog-link">
            <?php if($result->type != 'video'){ ?>
                <a class="button button-sm is-transparent" target="_blank" href="<?= $result->permalink_url; ?>">Read&nbsp;on&nbsp;facebook</a>
            <?php }else{ ?>
                <a class="button button-sm is-transparent" @click="$emit('toggleModal', 'embedViewer', '<?= $result->link; ?>','<?= $aspectRatio; ?>')" >Watch&nbsp;the&nbsp;video</a>
            <?php } ?>
        </div>
    </div>

</div>
