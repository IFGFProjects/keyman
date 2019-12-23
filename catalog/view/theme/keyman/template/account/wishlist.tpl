<div class="order-history">
    <h3 class="user-cabinet-title">Закладки</h3> 
    <?php foreach ($products as $hist_product) 
    {?>
    <div class="col-sm-4 col-xs-6 col-md-3 col-lg-1-5">
       <div class="last-order">
        <a href="<?php echo $hist_product['href']; ?>"><img src="<?php echo $hist_product['image']; ?>"></a>
        <div class="last-order-title">
           <a href="<?php echo $hist_product['href']; ?>"><?php echo $hist_product['name']; ?></a>
          </div>
      <div class="last-order-price"><?php echo $hist_product['price']; ?></div>
      <a href="<?php echo $hist_product['remove']; ?>">Убрать из закладок</a>
    </div>  
    </div> 
    <?php } ?>
</div>