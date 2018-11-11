<?php defined('C5_EXECUTE') or die("Access Denied.");

$this->inc('elements/header_top.php');

?>

<div id="top-bar">
    <div class="container clearfix">
        <div class="col_half nobottommargin">
            <div id="top-title">
                <span>Greyhound Pets of America Minnesota</span>
            </div>
        </div>

        <div class="col_half fright col_last nobottommargin">
            <div id="top-social">
                <?php
                $a = new GlobalArea('Social Links');
                $a->setCustomTemplate('social_links', 'top_links.php');
                $a->display($c);
                ?>
            </div>
        </div>
    </div>
</div>

<header id="header" class="">
    <div id="header-wrap">
        <div class="container clearfix">
            <div id="primary-menu-trigger"><i class="fa fa-bars fa-2x"></i></div>
            <div id="logo">
                <a href="/" class="standard-logo">
                    <img src="<?php echo $view->getThemePath()?>/img/logo.png">
                </a>
                <a href="/" class="retina-logo">
                    <img src="<?php echo $view->getThemePath()?>/img/logo.png">
                </a>
            </div>
            <nav id="primary-menu" class="on-click">
                <?php
                    $nav = BlockType::getByHandle('autonav');
                    $nav->controller->orderBy = 'display_asc';
                    $nav->controller->displayPages = 'top';
                    $nav->controller->displaySubPages = 'all';
                    $nav->controller->displaySubPageLevels = 'custom';
                    $nav->controller->displaySubPageLevelsNum = 2;
                    $nav->render('templates/top_nav');
                ?>
            </nav>
        </div>
    </div>
</header>

