<div class="owl-carousel mt-1 mb-1">
    <?php foreach($hounds as $hound): ?>
    <div class="dog">
        <img class="dog-image" src="<?php echo $hound['animalPictures'][0]['urlSecureFullsize']; ?>">
        <h5 class="dog-name"><?php echo $hound['animalName'] ?></h5>
    </div>
    <?php endforeach; ?>
</div>
