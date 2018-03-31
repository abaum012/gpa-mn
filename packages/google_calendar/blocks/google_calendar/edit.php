<?php defined('C5_EXECUTE') or die(_('Access Denied'));
$cp = Core::make('helper/form/color');
?>

<fieldset>
  <legend><?php echo t('Calendar Settings') ?></legend>
  <div class="form-group">
    <?php echo $form->label('calendars', t('Select Calendars to display'))?>
    <ul class="list-unstyled">
      <?php foreach($calendarList as $calID => $calendarName) { ?>
        <li><?php echo $form->checkbox('calendars[]', $calID, in_array($calID, $calendars), null) . ' ' . $calendarName; ?></li>
      <?php } ?>
    </ul>
  </div>

  <div class="form-group">
    <label for="displayWeekends"><?php echo t('Weekend Display') ?></label>
    <div class="checkbox">
      <label>
        <?php echo $form->checkbox('displayWeekends', 1, $displayWeekends); ?>
        <?php echo t('Display weekends on calendar.'); ?>
      </label>
    </div>
  </div>

  <div class="form-group">
    <label for="monthView"><?php echo t('Calendar Views') ?></label>
    <div class="checkbox">
      <label>
        <?php echo $form->checkbox('monthView', 1, $monthView); ?>
        <?php echo t('Month view'); ?>
      </label>
    </div>

    <div class="checkbox">
      <label>
        <?php echo $form->checkbox('weekView', 1, $weekView); ?>
        <?php echo t('Week view'); ?>
      </label>
    </div>

    <div class="checkbox">
      <label>
        <?php echo $form->checkbox('dayView', 1, $dayView); ?>
        <?php echo t('Day view'); ?>
      </label>
    </div>

  </div>


</fieldset>