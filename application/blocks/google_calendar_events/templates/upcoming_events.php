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
                <div class="event-box event-outline">
                    <div class="event-icon">
                        <div class="event-date">
                            <div class="event-day"><?php echo $event['day']; ?></div>
                            <div class="event-month"><?php echo $event['month']; ?></div>
                        </div>
                    </div>

                    <h4 class="event-title">
                        <a target="_blank" href="<?php echo $event['url'] ?>"><?php echo $event['title'] ?></a>
                    </h4>

                    <?php if ($includeCalendarNames) : ?>
                        <h5 class="calendarName"><?php echo $event['calendarName'] ?></h5>
                    <?php endif; ?>

                    <p class="event-time">
                        <i class="fa fa-fw fa-clock-o"></i>
                        <?php echo $event['timeText']; ?>
                    </p>

                    <?php if ($event['location']): ?>
                        <p><i class="fa fa-fw fa-map-marker"></i> <?php echo $event['location'] ?></p>
                    <?php endif; ?>

                    <?php if ($event['description']): ?>
                        <p><i class="fa fa-fw fa-newspaper-o"></i> <?php echo $event['description'] ?></p>
                    <?php endif; ?>
                </div>
            <?php endforeach; ?>
        <?php endif; ?>

        <?php if (!empty($events) && $displayType == 'day') : ?>
            <?php foreach ($events as $day => $dayEvents) : ?>
                <div class="event-box event-outline">
                    <div class="event-icon">
                        <div class="event-date">
                            <div class="event-day"><?php echo $dayEvents[0]['day']; ?></div>
                            <div class="event-month"><?php echo $dayEvents[0]['month']; ?></div>
                        </div>
                    </div>

                    <?php foreach ($dayEvents as $event) : ?>
                        <h5 class="event-title">
                            <a target="_blank" href="<?php echo $event['url'] ?>"><?php echo $event['title'] ?></a>
                        </h5>

                        <?php if ($includeCalendarNames) : ?>
                            <h5 class="calendarName"><?php echo $event['calendarName'] ?></h5>
                        <?php endif; ?>

                        <p class="event-time">
                            <i class="fa fa-fw fa-clock-o"></i>
                            <?php echo $event['timeText']; ?>
                        </p>

                        <?php if ($event['location']): ?>
                            <p><i class="fa fa-fw fa-map-marker"></i> <?php echo $event['location'] ?></p>
                        <?php endif; ?>

                        <?php if ($event['description']): ?>
                            <p><i class="fa fa-fw fa-newspaper-o"></i> <?php echo $event['description'] ?></p>
                        <?php endif; ?>

                        <?php if (end($dayEvents) != $event): ?>
                            <hr>
                        <?php endif; ?>

                    <?php endforeach; ?>
                </div>
            <?php endforeach; ?>
        <?php endif; ?>

        <?php if ($linkURL) : ?>
            <a class="btn pull-right" href="<?php echo $linkURL ?>">View All<i
                        class="fa fa-long-arrow-right"></i></a>
        <?php endif; ?>

        <?php if (empty($events)) : ?>
            <p><?php echo $noEventsMessage; ?></p>
        <?php endif; ?>
    </div>
