<?php defined('C5_EXECUTE') or die("Access Denied");

$this->inc('elements/header.php');

?>

    <section class="home-slider clearfix d-flex align-items-center">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-6 mt-3 mb-3">
                    <div class="home-slide-content">
                        <?php
                        $a = new Area('Banner Content');
                        $a->display($c);
                        ?>
                    </div>
                </div>
                <div class="col-lg-6 mt-3 mb-3">
                    <?php
                    $a = new Area('Dog Carousel');
                    $a->display($c);
                    ?>
                </div>
            </div>
        </div>
    </section>

    <section id="content">
        <div class="content-wrap">
            <div class="promo promo-full bottommargin-lg bg-light header-stick notopborder">
                <div class="container clearfix">
                    <div class="row">
                        <div class="col-12 col-lg-4">
                            <?php
                            $a = new Area('Feature 1');
                            $a->setCustomTemplate('feature', 'home_feature.php');
                            $a->display($c);
                            ?>
                        </div>
                        <div class="col-12 col-lg-4">
                            <?php
                            $a = new Area('Feature 2');
                            $a->setCustomTemplate('feature', 'home_feature.php');
                            $a->display($c);
                            ?>
                        </div>
                        <div class="col-12 col-lg-4">
                            <?php
                            $a = new Area('Feature 3');
                            $a->setCustomTemplate('feature', 'home_feature.php');
                            $a->display($c);
                            ?>
                        </div>
                    </div>
                </div>
            </div>

            <section>
                <div class="container clearfix">
                    <div class="row">
                        <div class="col-12 col-lg-7">
                            <div class="fancy-title title-border-color">
                                <h3>Featured Event</h3>
                            </div>
                            <?php
                            $a = new Area('Featured Events');
                            $a->display($c);
                            ?>
                        </div>
                        <div class="col-12 col-lg-5">
                            <div class="fancy-title title-border-color">
                                <h3>Upcoming Events</h3>
                            </div>
                            <?php
                            $a = new Area('Upcoming Events');
                            $a->display($c);
                            ?>
                        </div>
                    </div>
                </div>
            </section>
            <section class="topmargin-lg" id="about">
                <div class="container clearfix">
                    <div class="row">
                        <div class="row clearfix">
                            <div class="col-lg-6">
                                <?php
                                $a = new Area('Home Bottom 1');
                                $a->display($c);
                                ?>
                            </div>
                            <div class="col-lg-6">
                                <?php
                                $a = new Area('Home Bottom 2');
                                $a->display($c);
                                ?>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

        </div>
    </section>

<?php
$this->inc('elements/footer.php');
