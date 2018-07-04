<?php defined('C5_EXECUTE') or die(_('Access Denied'));
?>

<div class="mb-3">
    <?php echo $form->label('calendars', t('Select Calendars to display')) ?>
    <ul class="list-unstyled">
        <?php foreach ($calendarList as $calID => $calendarName) { ?>
            <li><?php echo $form->checkbox('calendars[]', $calID, in_array($calID, $calendars), null) . ' ' . $calendarName; ?></li>
        <?php } ?>
    </ul>
</div>

<div class="mb-3">
    <?php echo $form->label('includeCalendarNames', t('Calendar Names')) ?>
    <div class="checkbox"><label>
            <?php echo $form->checkbox('includeCalendarNames', 1, $includeCalendarNames); ?>
            <?php echo t('Include calendar names with events') ?>
        </label></div>
</div>

<div class="mb-3 mt-5">
    <?php echo $form->label('displayType', t('How should Events be Displayed')) ?>
    <select name="displayType" data-select="display-type" class="form-control">
        <option value="event" <?php echo($displayType == 'event' ? 'selected="selected"' : '') ?>><?php echo t('Single Events') ?></option>
        <option value="day" <?php echo($displayType == 'day' ? 'selected="selected"' : '') ?>><?php echo t('Grouped by Day') ?></option>
    </select>
</div>

<div class="mb-3">
    <?php echo $form->label('eventNum', t('Number of events to display'), ['id' => 'eventNumText']) ?>
    <?php echo $form->number('eventNum', intval($eventNum), array('min' => 1, 'max' => 50)); ?>
</div>


<div class="mb-3" id="dayNumber">
    <?php echo $form->label('dayNum', t('Number of days to display')) ?>
    <?php echo $form->number('dayNum', intval($dayNum), array('max' => 10)); ?>
</div>

<div class="mb-3 mt-5">
    <?php echo $form->label('title', t('Display Title (optional)')) ?>
    <?php echo $form->text('title', $title, 'Upcoming Events'); ?>
</div>

<div class="mb-3">
    <label class="control-label" for="noEventsMessage"><?php echo t('empty calendar message (optional)'); ?></label>
    <?php echo $form->text('noEventsMessage', $noEventsMessage, array('maxlength' => '255')); ?>
</div>

<div class="mb-3">
    <?php echo $form->label('linktype', t('link to full calendar page (optional)')) ?>
    <select name="linktype" data-select="feature-link-type" class="form-control">
        <option value="0" <?php echo(empty($externallink) && empty($internallinkcid) ? 'selected="selected"' : '') ?>><?php echo t('none') ?></option>
        <option value="1" <?php echo(empty($externallink) && !empty($internallinkcid) ? 'selected="selected"' : '') ?>><?php echo t('another page') ?></option>
        <option value="2" <?php echo(!empty($externallink) ? 'selected="selected"' : '') ?>><?php echo t('external url') ?></option>
    </select>
</div>

<div data-select-contents="feature-link-type-internal" style="display: none;" class="form-group">
    <?php echo $form->label('internalLinkCID', t('Choose Page:')) ?>
    <?php echo Loader::helper('form/page_selector')->selectPage('internalLinkCID', $internalLinkCID); ?>
</div>

<div data-select-contents="feature-link-type-external" style="display: none;" class="form-group">
    <?php echo $form->label('externalLink', t('URL')) ?>
    <?php echo $form->text('externalLink', $externalLink); ?>
</div>

</fieldset>

<script type="text/javascript">
    $(function () {
        $('select[data-select=feature-link-type]').on('change', function () {
            if ($(this).val() == '0') {
                $('div[data-select-contents=feature-link-type-internal]').hide();
                $('div[data-select-contents=feature-link-type-external]').hide();
            }
            if ($(this).val() == '1') {
                $('div[data-select-contents=feature-link-type-internal]').show();
                $('div[data-select-contents=feature-link-type-external]').hide();
            }
            if ($(this).val() == '2') {
                $('div[data-select-contents=feature-link-type-internal]').hide();
                $('div[data-select-contents=feature-link-type-external]').show();
            }
        }).trigger('change');

        $('select[data-select=display-type]').on('change', function () {
            if ($(this).val() == 'event') {
                $('#eventNumText').html('Number of events to display');
                $('#dayNumber').hide();
            }
            if ($(this).val() == 'day') {
                $('#eventNumText').html('Maximum number of events to retrieve');
                $('#dayNumber').show();
            }
        }).trigger('change');
    });
</script>