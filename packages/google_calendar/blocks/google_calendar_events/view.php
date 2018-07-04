<?php defined('C5_EXECUTE') or die(_('Access Denied'));
$page = Page::getCurrentPage();
?>

    <div class="event-list-container">
        <?php if ($title) : ?>
            <div class="event-list-title">
                <h2><?php echo $title ?></h2>
            </div>
        <?php endif; ?>
        <div class="event-list">
            <?php if (!empty($events) && $displayType == 'event') : ?>
                <?php foreach ($events as $index => $event) : ?>
                    <div class="event">
                        <div class="event-date pull-left">
                            <span class="day">
                                <?php echo $event['day'] ?>
                            </span>
                            <span class="month" style="background-color: <?php echo $event['bgColor'] ?>; color: <?php echo $event['textColor'] ?>">
                                <?php echo $event['month'] ?>
                            </span>
                        </div>
                        <div class="event-details">
                            <h4 class="event-title">
                                <a target="_blank" href="<?php echo $event['url'] ?>"><?php echo $event['title'] ?></a>
                            </h4>
                            <?php if ($includeCalendarNames) : ?>
                                <h5 class="calendarName"><?php echo $event['calendarName'] ?></h5>
                            <?php endif; ?>
                            <p class="event-time">
                                <i class="fa fa-fw fa-clock-o"></i>
                                <?php echo $event['timeText'] ?>
                            </p>
                            <?php if ($event['location']) { ?><p><i
                                    class="fa fa-fw fa-map-marker"></i>  <?php echo $event['location'] ?></p><?php } ?>
                            <?php if ($event['description']) { ?><p><i
                                    class="fa fa-fw fa-newspaper-o"></i>  <?php echo $event['description'] ?>
                                </p><?php } ?>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>

            <?php if (!empty($events) && $displayType == 'day') : ?>
                <?php foreach ($events as $day => $dayEvents) : ?>
                        <div class="event event-by-day">
                            <div class="event-date pull-left">
                                <span class="day">
                                    <?php echo $dayEvents[0]['day'] ?>
                                </span>
                                <span class="month" style="background-color: <?php echo $dayEvents[0]['bgColor'] ?>; color: <?php echo $dayEvents[0]['textColor'] ?>">
                                    <?php echo $dayEvents[0]['month'] ?>
                                </span>
                            </div>
                            <?php foreach ($dayEvents as $event) : ?>
                            <div class="event-details">
                                <h4 class="event-title">
                                    <a target="_blank" href="<?php echo $event['url'] ?>"><?php echo $event['title'] ?></a>
                                </h4>
                                <?php if ($includeCalendarNames) : ?>
                                    <h5 class="calendarName"><?php echo $event['calendarName'] ?></h5>
                                <?php endif; ?>
                                <p class="event-time">
                                    <i class="fa fa-fw fa-clock-o"></i>
                                    <?php echo $event['timeText'] ?>
                                </p>
                            </div>
                            <?php endforeach; ?>
                        </div>
                <?php endforeach; ?>
            <?php endif; ?>

            <?php if (empty($events)) { ?>
                <p><?php echo $noEventsMessage; ?></p>

                <?php if ($page->isEditMode())
                {
                    echo '<h4>No events were found. Make sure you have the correct API Key and Calendar ID in the Dashboard.</h4>';
                } ?>

            <?php } ?>

            <?php if ($linkURL) { ?>
                <a class="btn pull-right" href="<?php echo $linkURL ?>">View All<i class="fa fa-long-arrow-right"></i></a>
            <?php } ?>
        </div>
    </div>
</div>