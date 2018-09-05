<?php defined('C5_EXECUTE') or die("Access Denied."); ?>
<style>
</style>
<div class="grid grid-container">
    <div class="col-lg-12 col-xl-6 grid-sizer"></div>
    <?php foreach ($hounds as $hound) : ?>
        <div class="col-lg-12 col-xl-6 grid-item">
            <div class="grid-content">
                <div class="card">
                    <?php if($hound['animalAdoptionPending'] == 'Yes'): ?>
                    <div class="ribbon ribbon-top-right"><span>Adoption Pending</span></div>
                    <?php endif; ?>
                    <div class="card-body">
                        <div class="team team-list clearfix">
                            <div class="team-image">
                                <div data-lightbox="gallery">
                                    <?php foreach ($hound['animalPictures'] as $key => $image) : ?>
                                        <a href="<?php echo $image['urlSecureFullsize']; ?>"
                                            <?php echo ($key > 0) ? 'hidden' : ''; ?>
                                           data-lightbox="gallery-item">
                                            <img src="<?php echo $image['urlSecureFullsize']; ?>"
                                                 alt="<?php echo $hound['animalName'] ?>Image<?php echo $key; ?>">
                                            <div class="overlay">
                                                <div class="overlay-wrap"><i class="fa fa-search-plus"></i></div>
                                            </div>
                                        </a>
                                    <?php endforeach; ?>
                                </div>
                            </div>
                            <div class="team-desc">
                                <div class="team-title">
                                    <h2 class="mb-1">
                                        <?php echo $hound['animalName'] ?></h2>
                                    <span><?php echo $hound['animalSummary'] ?></span>
                                </div>
                                <div class="team-content">
                                    <ul class="icon-list ">
                                        <li>
                                            <span class="fa-stack fa-lg">
                                                <i class="fa fa-words fa-border-circle fa-stack-1x ">AGE</i>
                                            </span>
                                            <?php
                                            $now = date_create();
                                            $bd = date_create_from_format('n/j/Y', $hound['animalBirthdate']);
                                            $interval = $now->diff($bd);
                                            $years = $interval->format('%y');
                                            $months = $interval->format('%m');

                                            echo $years . ' Years';
                                            echo ($months) ? ' ' . $months . ' Months' : '';
                                            ?>

                                        </li>
                                        <li>
                                            <?php if ($hound['animalOKWithDogs'] == 'Yes') : ?>
                                                <span class="fa-stack fa-lg">
                                                    <i class="fa fa-check fa-border-circle fa-stack-1x text-success"></i>
                                                </span>
                                                Dog Friendly
                                            <?php elseif ($hound['animalOKWithDogs'] == 'No') : ?>
                                                <span class="fa-stack fa-lg">
                                                    <i class="fa fa-times fa-border-circle fa-stack-1x text-danger"></i>
                                                </span>
                                                Not Dog Friendly
                                            <?php else : ?>
                                                <span class="fa-stack fa-lg">
                                                    <i class="fa fa-question fa-border-circle fa-stack-1x text-theme"></i>
                                                </span>
                                                Dog Friendliness
                                            <?php endif; ?>
                                        </li>
                                        <li>
                                            <?php if ($hound['animalOKWithCats'] == 'Yes') : ?>
                                                <span class="fa-stack fa-lg">
                                                    <i class="fa fa-check fa-border-circle fa-stack-1x text-success"></i>
                                                </span>
                                                Cat Friendly
                                            <?php elseif ($hound['animalOKWithCats'] == 'No') : ?>
                                                <span class="fa-stack fa-lg">
                                                    <i class="fa fa-times fa-border-circle fa-stack-1x text-danger"></i>
                                                </span>
                                                Not Cat Friendly
                                            <?php else : ?>
                                                <span class="fa-stack fa-lg">
                                                    <i class="fa fa-question fa-border-circle fa-stack-1x text-theme"></i>
                                                </span>
                                                Cat Friendliness
                                            <?php endif; ?>
                                        </li>
                                        <li>
                                            <button
                                                    data-toggle="modal"
                                                    data-target="#modal-<?php echo $hound['animalID'] ?>"
                                                    class="button button-large button-border button-circle">Learn
                                                More!
                                            </button>
                                        </li>

                                        <div class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog"
                                             id="modal-<?php echo $hound['animalID'] ?>"
                                             aria-labelledby="<?php echo $hound['animalName'] ?>-detail-modal"
                                             aria-hidden="true">
                                            <div class="modal-dialog modal-dialog-centered modal-lg">
                                                <div class="card border-primary modal-content">
                                                    <div class="modal-body">
                                                        <button type="button" class="close" data-dismiss="modal"
                                                                aria-label="Close">
                                                            <span aria-hidden="true">&times;</span>
                                                        </button>
                                                        <p>
                                                            <?php echo $hound['animalDescriptionPlain']; ?>
                                                        </p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    <?php endforeach; ?>
</div>
