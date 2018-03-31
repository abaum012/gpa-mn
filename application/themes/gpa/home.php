<?php defined('C5_EXECUTE') or die("Access Denied");

$this->inc('elements/header.php');

?>

    <section class="home-slider clearfix d-flex align-items-center">
        <div class="container">
            <div class="row">
                <div class="col-xl-6">
                    <div class="home-slide-content">
                        <h3 class="display-3">Find Your Match!</h3>
                        <p class="lead">Our experience shows that successful, life-long adoptions are achieved by carefully and thoughtfully considering each match.</p>
                        <div class="row">
                            <div class="col-lg-6 text-center"><a href="#" class="button button-border button-circle">Available Dogs</a></div>
                            <div class="col-lg-6 text-center"><a href="#" class="button button-border button-circle">Adoption Process</a></div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-6">
                    <div class="owl-carousel">
                        <div class="card">
                            <img class="card-image-top" src="<?php echo $view->getThemePath(); ?>/img/demo/clint1.jpg">
                            <div class="card-body">
                                <p class="card-title">Minnie</p>
                            </div>
                        </div>
                        <div class="dog">
                            <img class="dog-image" src="<?php echo $view->getThemePath(); ?>/img/demo/clint1.jpg">
                        </div>
                        <div class="dog">
                            <img class="dog-image" src="<?php echo $view->getThemePath(); ?>/img/demo/keeper.jpg">
                        </div>
                        <div class="dog">
                            <img class="dog-image" src="<?php echo $view->getThemePath(); ?>/img/demo/lash.jpg">
                        </div>
                        <div class="dog">
                            <img class="dog-image" src="<?php echo $view->getThemePath(); ?>/img/demo/lobstah.jpg">
                        </div>
                    </div>
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
            <section class="bottommargin-lg" id="about">
                <div class="container clearfix">
                    <div class="row">
                        <div class="row clearfix">
                            <div class="col-lg-6">
                                <div class="heading-block topmargin">
                                    <h1>GPA - MN</h1>
                                </div>
                                <p class="lead">A Twin Cities based volunteer run organization, dedicated to rescuing and placing retired racing greyhounds.</p>
                                <p><a href="#" class="button button-border button-circle">About Our Organization</a></p>
                            </div>
                            <div class="col-lg-6">
                                <img src="http://www.gpa-mn.org/uploads/7/2/1/4/7214501/6398490_orig.jpg" class="img-fluid">
                            </div>
                        </div>
                    </div>
                </div>
            </section>

        </div>
    </section>

<?php
$this->inc('elements/footer.php');
