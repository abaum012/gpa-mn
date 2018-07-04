<?php defined('C5_EXECUTE') or die(_('Access Denied'));
$cp = Core::make('helper/form/color');
?>

<div class="mb-4">
    <?php echo $form->label('calendars', t('Select Calendars to display')) ?>
    <ul class="list-unstyled">
        <?php foreach ($calendarList as $calID => $calendarName) { ?>
            <li><?php echo $form->checkbox('calendars[]', $calID, in_array($calID, $calendars), null) . ' ' . $calendarName; ?></li>
        <?php } ?>
    </ul>
</div>

<div class="mb-4">
    <?php echo $form->label('displayWeekends', t('Weekend Display')) ?>
    <div class="checkbox"><label>
            <?php echo $form->checkbox('displayWeekends', 1, $displayWeekends); ?>
            <?php echo t('Display weekends on calendar.') ?>
        </label></div>
</div>

<div class="mb-4">
    <?php echo $form->label('monthView', t('Calendar Views')) ?>
    <div class="checkbox"><label>
            <?php echo $form->checkbox('monthView', 1, $monthView); ?>
            <?php echo t('Month View') ?>
        </label></div>

    <div class="checkbox"><label>
            <?php echo $form->checkbox('weekView', 1, $weekView); ?>
            <?php echo t('Week View') ?>
        </label></div>

    <div class="checkbox"><label>
            <?php echo $form->checkbox('dayView', 1, $dayView); ?>
            <?php echo t('Day View') ?>
        </label></div>
</div>

