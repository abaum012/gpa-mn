<?php defined('C5_EXECUTE') or die('Access Denied.');
?>

<form id="keys-form" action="<?php echo $view->action(''); ?>" method="post">
    <?php echo Core::make('helper/validation/token')->output('update_keys'); ?>

    <div class="form-group">
        <?php echo $form->label('rescue_groups_api_key', t('Rescue Groups API Key')); ?>
        <?php echo $form->text('rescue_groups_api_key', $rescue_groups_api_key); ?>
    </div>

    <div class="form-group">
        <?php echo $form->label('rescue_groups_id', t('Rescue Groups Group ID')); ?>
        <?php echo $form->text('rescue_groups_id', $rescue_groups_id); ?>
    </div>

    <div class="ccm-dashboard-form-actions-wrapper">
        <div class="ccm-dashboard-form-actions">
            <button type="submit" class="btn btn-primary pull-right" name="tracking-code-form"><?php echo t('Save'); ?></button>
        </div>
    </div>
</form>
