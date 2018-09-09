<?php defined('C5_EXECUTE') or die("Access Denied."); ?>

<ul>
    <?php foreach($links as $link) {
        $service = $link->getServiceObject();
        $serviceName = $service->getDisplayName();
        ?>
        <li><a target="_blank" href="<?php echo h($link->getURL()); ?>" class="si-<?php echo strtolower($serviceName); ?>" title="<?php echo $serviceName; ?> Link"><span class="ts-icon"><i class="fa fa-<?php echo strtolower($serviceName); ?>"></i></span><span class="ts-text"><?php echo $serviceName; ?></span></a></li>
    <?php } ?>
    <li><a href="tel:763-785-4000" class="si-secondary" title="763-785-4000"><span class="ts-icon"><i class="fa fa-phone"></i></span><span class="ts-text">763-785-4000</span></a></li>
    <li><a href="mailto:info@gpa-mn.org" class="si-primary"><span class="ts-icon"><i class="fa fa-envelope"></i></span><span class="ts-text">info@gpa-mn.org</span></a></li>
</ul>
