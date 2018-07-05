<?php defined('C5_EXECUTE') or die("Access Denied.");

$this->inc('elements/header_top.php');

?>

<div id="top-bar">
    <div class="container clearfix">
        <div class="col_half nobottommargin">
            <div id="top-title">
                <span>Greyhound Pets of America - Minnesota</span>
            </div>
        </div>

        <div class="col_half fright col_last nobottommargin">
            <div id="top-social">
                <ul>
                    <li><a href="https://twitter.com/gpamn" target="_blank" class="si-twitter"><span class="ts-icon"><i class="fa fa-twitter"></i></span><span class="ts-text">Twitter</span></a></li>
                    <li><a href="https://www.instagram.com/gpamn/" target="_blank" class="si-instagram"><span class="ts-icon"><i class="fa fa-instagram"></i></span><span class="ts-text">Instagram</span></a></li>
                    <li><a href="https://www.facebook.com/gpamn/" target="_blank" class="si-facebook"><span class="ts-icon"><i class="fa fa-facebook"></i></span><span class="ts-text">Facebook</span></a></li>
                    <li><a href="tel:763-785-4000" class="si-secondary" title="763-785-4000"><span class="ts-icon"><i class="fa fa-phone"></i></span><span class="ts-text">763-785-4000</span></a></li>
                    <li><a href="mailto:info@gpa-mn.org" class="si-primary"><span class="ts-icon"><i class="fa fa-envelope"></i></span><span class="ts-text">info@gpa-mn.org</span></a></li>
                </ul>
            </div>
        </div>
    </div>
</div>

<header id="header" class="">
    <div id="header-wrap">
        <div class="container clearfix">
            <div id="primary-menu-trigger"><i class="icon-reorder"></i></div>
            <div id="logo">
                <a href="/" class="standard-logo">
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
                <div id="top-search">
                    <a href="#" id="top-search-trigger"><i class="icon-search3"></i><i class="icon-line-cross"></i></a>
                    <form action="search.html" method="get">
                        <input type="text" name="q" class="form-control" value="" placeholder="Type &amp; Hit Enter..">
                    </form>
                </div>
            </nav>
        </div>
    </div>
</header>

