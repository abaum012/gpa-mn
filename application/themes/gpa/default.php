<?php
defined('C5_EXECUTE') or die("Access Denied.");

$this->inc('elements/header.php');
$this->inc('elements/page-title.php');
?>
    <section id="content">
        <div class="content-wrap">
            <div class="container clearfix">
                <?php
                $a = new Area('Main');
                $a->enableGridContainer();
                $a->display($c);
                ?>
            </div>
    </section>

<?php
$this->inc('elements/footer.php');
