<?php defined('C5_EXECUTE') or die("Access Denied."); ?>
<section id="page-title" class="page-title-dark"
    <?php if ($ptImage): ?>
        style="background-image: url('<?php echo $ptImage; ?>');"
    <?php endif; ?>>

    <div class="container clearfix">
        <h1><?php echo $c->getCollectionName(); ?></h1>
    </div>

</section>
