<?php  defined('C5_EXECUTE') or die(_('Access Denied'));
$page = Page::getCurrentPage();
?>

<?php if ($page->isEditMode()) { ?>
  <div class="ccm-edit-mode-disabled-item"><?php echo t('Event Calendars are disabled in edit mode.')?></div>
<?php } else {?>

<div id="calendar">
  <div id="loader">
    <i class="fa fa-spinner fa-spin fa-3x fa-fw"></i>
  </div>
</div>
<script>

  $(document).ready(function() {

    $('#calendar').fullCalendar({
      header: {
        left: 'title',
        center: '',
        right: '<?php echo $calendarViews; ?> today prev,next'
      },

      weekends: <?php echo $displayWeekends? 'true': 'false'; ?>,

      defaultView: '<?php echo $defaultView ?>',

      events: function(start, end, timezone, callback) {
        $.ajax({
          beforeSend: function() {
            $('#loader').show();
            $('.fc-view').addClass('overlay');
          },
          complete: function(){
            $('#loader').hide();
            $('.fc-view').removeClass('overlay');
          },
          url: '<?php echo URL::to('/events/get-events'); ?>/',
          type: 'GET',
          dataType: 'json',
          data: {
            calendars: '<?php echo $calendars; ?>',
            timeMin: start.format(),
            timeMax: end.format()
          },
          success: function(doc) {
            var events = [];
            $(doc).each(function() {
              events.push({
                title: $(this).attr('title'),
                start: $(this).attr('start'),
                end: $(this).attr('end'),
                allDay: $(this).attr('allDay'),
                url: $(this).attr('url'),
                color: $(this).attr('bgColor'),
                textColor: $(this).attr('textColor')
              });
            });
            console.debug(events);
            callback(events);
          },
          error: function() {
            alert('there was an error while fetching events!');
          }
        });
      },

      eventMouseover: function(event, jsEvent, view) {
        $(this).css('color', '#000000');
        $(this).css('background-color', '#ffffff');
      },

      eventMouseout: function(event, jsEvent, view) {
        $(this).css('color', event.textColor);
        $(this).css('background-color', event.color);
      }
    });

  });

</script>
<?php } ?>