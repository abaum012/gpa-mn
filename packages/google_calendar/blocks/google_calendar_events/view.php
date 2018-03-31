<?php  defined('C5_EXECUTE') or die(_('Access Denied'));
$page = Page::getCurrentPage();
?>

<div class="widget-area">
  <aside class="widget widget-posts">
    <?php if ($title) : ?>
    <div class="widget-title">
      <h2><?php echo $title ?></h2>
    </div>
    <?php endif; ?>
      <div class="widget-list">
        <?php if(!empty($events)) : ?>
          <?php foreach($events as $index => $event) :
            $start = \DateTime::createFromFormat(DATE_ISO8601, $event['start']);
            $end = \DateTime::createFromFormat(DATE_ISO8601, $event['end']);
            ?>
          <div class="event">
            <div class="event-date pull-left">
              <span class="day">
                <?php echo $start->format('d');?>
              </span>
              <span class="month" style="background-color: <?php echo $event['bgColor'] ?>; color: <?php echo $event['textColor'] ?>">
                <?php echo $start->format('M')?>
              </span>
            </div>
            <div class="event-details">
              <h4 class="event-title"><a target="_blank" href="<?php echo $event['url'] ?>"><?php echo $event['title'] ?></a></h4>
              <?php if ($includeCalendarNames) : ?>
                  <h5 class="calendarName"><?php echo $event['calendarName']?></h5>
                <?php endif; ?>
              <p class="event-time">
                <i class="fa fa-fw fa-clock-o"></i>
                <?php if ($event['allDay']) :
                  echo 'All day event';
                else:
                  echo $start->format('M jS, g:i a') . ' - ' . $end->format('M jS, g:i a');
                endif;
                ?>
              </p>
              <?php if ($event['location']) { ?><p><i class="fa fa-fw fa-map-marker"></i>  <?php echo $event['location'] ?></p><?php } ?>
              <?php if ($event['description']) { ?><p><i class="fa fa-fw fa-newspaper-o"></i>  <?php echo $event['description'] ?></p><?php } ?>
            </div>
          </div>
          <?php endforeach; ?>

          <?php if ($linkURL) {?>
            <a class="btn pull-right" href="<?php echo $linkURL ?>">View All<i class="fa fa-long-arrow-right"></i></a>
          <?php } ?>
        <?php endif; ?>

        <?php if (empty($events)) { ?>
          <p><?php    echo $noEventsMessage; ?></p>

          <?php if ($page->isEditMode()) {
            echo '<h4>No events were found. Make sure you have the correct API Key and Calendar ID in the Dashboard.</h4>';
          } ?>

        <?php    } ?>
      </div>
  </aside>
</div>