<div class="slider">
  <?php foreach ($banners as $banner) { ?>

    <div class="slide">
       <a href="<?php echo $banner['link']; ?>">
        <img src="<?php echo $banner['image']; ?>" alt="<?php echo $banner['title']; ?>">
        <div class="stext">
           <div class="h1-title">
<!--             <b>Весенние скидки</b>
            <br>на всех разделах
            <br><span class="big-percent">20%</span> -->
            <!-- <?php echo $banner['title']; ?> -->
         </div>
         </div>
      </a> 
    </div>
  <?php } ?>
</div>