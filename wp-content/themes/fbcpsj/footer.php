<?php
/**
 * @package PSJCG
 * @subpackage fbcpsj
 * @since 1.0
 * @version 1.2
 */
?>
<?php include(locate_template('template-parts/partials/bot.php')); ?>
<modal><?= (isset($modalContent) && $modalContent != '' ? $modalContent : ''); ?></modal>
</div>
<?php wp_footer(); ?>

</body>
</html>