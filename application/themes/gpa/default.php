<?php
defined('C5_EXECUTE') or die("Access Denied.");

$this->inc('elements/header.php');
$this->inc('elements/page-title.php');
?>
    <section id="content">
        <div class="content-wrap">
            <?php
            $a = new Area('Main');
            $a->enableGridContainer();
            $a->display($c);
            ?>
    </section>

<?php
$this->inc('elements/footer.php');
