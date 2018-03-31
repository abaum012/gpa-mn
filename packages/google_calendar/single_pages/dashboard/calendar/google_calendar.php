<?php defined('C5_EXECUTE') or die("Access Denied.");
$cp = Core::make('helper/form/color');
?>

<?php if ($controller->getAction() == 'add' ||
    $controller->getAction() == 'edit' ||
    $controller->getAction() == 'submit'): ?>

    <form method="post" action="<?= $view->action('submit') ?>">
        <?php echo $token->output('submit') ?>
        <?php echo $form->hidden('id', $id) ?>
        <fieldset>
            <legend><?php echo t('Calendar Information') ?></legend>
            <div class="form-group">
                <?php echo $form->label('name', t('Name')) ?>
                <?php echo $form->text('name', $name) ?>
            </div>
        </fieldset>
        <fieldset>
            <legend><?php echo t('Calendar Event Colors') ?></legend>
            <div class="form-group">
                <?php echo $form->label('bgColor', t('Background Color: ')) ?>
                <?php $cp->output('bgColor', $bgColor ? $bgColor : '#FFFFFF', array('preferredFormat' => 'hex')); ?>
            </div>
            <div class="form-group">
                <?php echo $form->label('textColor', t('Text Color: ')) ?>
                <?php $cp->output('textColor', $textColor ? $textColor : '#000000', array('preferredFormat' => 'hex')); ?>
            </div>
        </fieldset>
        <fieldset>
            <legend><?php echo t('Google Settings') ?></legend>
            <div class="form-group">
                <?php echo $form->label('apiKey', t('API Key')) ?>
                <?php echo $form->text('apiKey', $apiKey) ?>
            </div>
            <div class="form-group">
                <?php echo $form->label('googleID', t('Google Calendar ID')) ?>
                <?php echo $form->text('googleID', $googleID) ?>
            </div>
        </fieldset>
        <div class="ccm-dashboard-form-actions-wrapper">
            <div class="ccm-dashboard-form-actions">
                <a href="<?php echo URL::to('/dashboard/calendar/google_calendar') ?>"
                   class="btn btn-default pull-left"><?= t('Cancel') ?></a>
                <?php if (isset($id)) : ?>
                    <?php echo $form->submit('save', t('Save'), array('class' => 'btn btn-primary pull-right')) ?>
                <?php else: ?>
                    <?php echo $form->submit('add', t('Add'), array('class' => 'btn btn-primary pull-right')) ?>
                <?php endif; ?>
            </div>
        </div>
    </form>

    <?php if (isset($id)) : ?>
        <div class="ccm-dashboard-header-buttons">
            <button data-dialog="delete-entity" class="btn btn-danger"><?php echo t("Delete") ?></button>
        </div>

        <div style="display: none">
            <div id="ccm-dialog-delete-entity" class="ccm-ui">
                <form method="post" class="form-stacked" action="<?= $view->action('delete') ?>">
                    <?php echo $token->output('delete') ?>
                    <?php echo $form->hidden('id', $id) ?>
                    <p><?= t('Are you sure? This action cannot be undone.') ?></p>
                </form>
                <div class="dialog-buttons">
                    <button class="btn btn-default pull-left"
                            onclick="jQuery.fn.dialog.closeTop()"><?= t('Cancel') ?></button>
                    <button class="btn btn-danger pull-right"
                            onclick="$('#ccm-dialog-delete-entity form').submit()"><?= t('Delete') ?></button>
                </div>
            </div>
        </div>

        <script type="text/javascript">
            $('button[data-dialog=delete-entity]').on('click', function () {
                jQuery.fn.dialog.open({
                    element: '#ccm-dialog-delete-entity',
                    modal: true,
                    width: 320,
                    title: '<?=t("Delete Calendar")?>',
                    height: 'auto'
                });
            });
        </script>
    <?php endif; ?>

<?php else : ?>

    <?php if (count($calendars)) : ?>

        <div class="ccm-dashboard-content-full">
            <div data-search-element="results">
                <div class="table-responsive">
                    <table class="ccm-search-results-table">
                        <thead>
                        <tr>
                            <th><span><?php echo t('ID') ?></span></th>
                            <th><span><?php echo t('Name') ?></span></th>
                            <th><span><?php echo t('API Key') ?></span></th>
                            <th><span><?php echo t('Calendar ID') ?></span></th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php foreach ($calendars as $gc) : ?>
                            <tr>
                                <td><?php echo h($gc->getID()) ?></td>
                                <td>
                                    <a href="<?php echo URL::to('/dashboard/calendar/google_calendar/edit', $gc->getID()) ?>">
                                        <?php echo h($gc->getName()) ?>
                                    </a>
                                </td>
                                <td><?php echo h($gc->getApiKey()) ?></td>
                                <td><?php echo h($gc->getGoogleID()) ?></td>
                            </tr>
                        <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

    <?php else: ?>

        <p><?php echo t("No results found.") ?></p>

    <?php endif; ?>

    <div class="ccm-dashboard-header-buttons">
        <a href="<?php echo URL::to('/dashboard/calendar/google_calendar/add') ?>"
           class="btn btn-primary"><?php echo t("Add") ?></a>
    </div>

<?php endif;