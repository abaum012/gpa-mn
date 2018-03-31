<?php defined('C5_EXECUTE') or die("Access Denied.");

$title = h($title);
?>

<?php if($linkURL) : ?>
    <a href="<?php echo $linkURL; ?>">
<?php endif; ?>
    <div class="feature-box fbox-outline">
        <div class="fbox-icon">
            <i class="fa fa-<?php echo $icon; ?> i-alt"></i>
        </div>
        <h3><?php echo $title; ?></h3>
        <?php if ($paragraph) echo $paragraph; ?>
    </div>
</a>
