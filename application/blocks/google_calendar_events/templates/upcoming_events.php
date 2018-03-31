<?php  defined('C5_EXECUTE') or die(_('Access Denied'));
$page = Page::getCurrentPage();
?>
        <?php if ($title) : ?>
            <h2><?php echo $title ?></h2>
        <?php endif; ?>
        <div class="event-list">
            <?php if(!empty($events)) : ?>
                <?php foreach($events as $index => $event) :
                    $start = \DateTime::createFromFormat(DATE_ISO8601, $event['start']);
                    $end = \DateTime::createFromFormat(DATE_ISO8601, $event['end']);
                    ?>
                    <div class="event-box event-outline">
                        <div class="event-icon">
                            <div class="event-date">
                                <div class="event-day"><?php echo $start->format('j');?></div>
                                <div class="event-month"><?php echo $start->format('M')?></div>
                            </div>
                        </div>
                        <h4 class="event-title"><a target="_blank" href="<?php echo $event['url'] ?>"><?php echo $event['title'] ?></a></h4>
                        <?php if ($includeCalendarNames) : ?>
                            <h5 class="calendarName"><?php echo $event['calendarName']?></h5>
                        <?php endif; ?>
                        <p class="event-time">
                            <i class="fa fa-fw fa-clock-o"></i>
                            <?php if ($event['allDay']) :
                                echo 'All day event';
                            else:
                                if($start->format('M j') == $end->format('M j')) :
                                    echo $start->format('F jS, g:i a') . ' - ' . $end->format('g:i a');
                                else:
                                    echo $start->format('F jS, g:i a') . ' - ' . $end->format('F jS, g:i a');
                                endif;
                            endif;
                            ?>
                        </p>
                        <?php if ($event['location']): ?>
                            <p><i class="fa fa-fw fa-map-marker"></i>  <?php echo $event['location'] ?></p>
                        <?php endif; ?>
                        <?php if ($event['description']): ?>
                            <p><i class="fa fa-fw fa-newspaper-o"></i>  <?php echo $event['description'] ?></p>
                        <?php endif; ?>
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
