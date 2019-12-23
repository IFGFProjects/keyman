<?php echo $header; ?>

<section class="category-title">
    <h1 class="ttu h1"><span>Личный кабинет</span></h1>
</section>

<?php 
// $percent_complete=round($user_total_amount/( ($buy_discounts[count($buy_discounts)-1]['to_value']-$buy_discounts[0]['from_value'])/100 ));
$percent_complete=round($user_total_amount/($buy_discounts[count($buy_discounts)-1]['to_value']/100 ));

if ($percent_complete>100)
  {$percent_complete=100;}
if ($percent_complete<25)
  {$percent_complete=25;}
$discount_level=-1;
foreach ($buy_discounts as $dkey => $discount) 
{
  if ( ($user_total_amount>=$discount['from_value']) && ($user_total_amount<$discount['to_value']) )
    {$discount_level=$dkey;}
}

if ( ($discount_level<0) && ($user_total_amount>$buy_discounts[0]['from_value']) )
  if ($user_total_amount>=$buy_discounts[$dkey]['to_value'])
    {$discount_level=$dkey;}


$buy_discounts[-1]=array(
  "discount_id"=>0,
  "from_value"=>0,
  "to_value"=>$buy_discounts[0]['from_value'],
  "discount_percent"=>0
  );

if ($user_total_amount>$buy_discounts[count($buy_discounts)-2]['to_value'])
  {$discount_level=(count($buy_discounts)-2);}
 ?>
<section class="user-cabinet-block">
   <div class="container-fluid">
   <div class="col-sm-12">
    <div class="user-sales">
        <h3 class="user-cabinet-title">Скидки</h3>
        <div class="progress">
            <div class="progress-bar" role="progressbar" aria-valuenow="<?php echo $user_total_amount; ?>" aria-valuemin="0" aria-valuemax="<?php echo $buy_discounts[count($buy_discounts)-2]['to_value']; ?>" style="width: <?php echo $percent_complete; ?>%;">
               <div class="cart-discount">
                    <h3>Ваша скидка <?php echo $buy_discounts[$discount_level]['discount_percent']; ?>%</h3>
                    <?php if ($discount_level<count($buy_discounts)-2) 
                    {?>
                      <span>
                        Вы получите скидку в <?php echo $buy_discounts[$discount_level+1]['discount_percent']; ?>% после того, как сумма Ваших покупок превысит <?php echo number_format($buy_discounts[$discount_level+1]['from_value'],2); ?> рублей
                      </span>
              <?php } ?>
                </div>
            </div>
            <?php 
            foreach ($buy_discounts as $dkey => $discount) 
              { if ($dkey>=0) {?>
            <span class="percent<?php echo $discount['discount_percent']; ?>"></span>
            <span class="pers<?php echo $discount['discount_percent']; ?>"><?php echo $discount['discount_percent']; ?>%</span>
            <?php }} ?>
          </div>
    </div>

    <?php if ($success) { ?>
    <div class="alert alert-success"><i class="fa fa-check-circle"></i> <?php echo $success; ?></div>
    <?php } ?>

    <div class="user-details">
        <h3 class="user-cabinet-title">Мои данные</h3>
        <!-- Edit account -->
        <?php echo $user_details; ?>
        <!-- Edit password -->
        <?php echo $user_password; ?>
        <!-- Edit address -->
        <?php echo $user_address; ?>
    </div>

<?php if (count($user_product_history)>0 ) {?>
    <div class="order-history col-sm-12">
        <h3 class="user-cabinet-title">История покупок</h3> 
        <?php foreach ($user_product_history as $hkey => $hist_product) 
        {?>
        <div class="col-sm-4 col-xs-6 col-md-3 col-lg-1-5">
           <div class="last-order">
            <a href="<?php echo $hist_product['href']; ?>"><img src="<?php echo $hist_product['image']; ?>"></a>
            <div class="last-order-title">
               <a href="<?php echo $hist_product['href']; ?>"><?php echo $hist_product['name']; ?></a>
              </div>
          <div class="last-order-price"><?php echo $hist_product['price']; ?></div>
        </div>  
        </div> 
        <?php } ?>
    </div>
<hr>
<?php } ?>
<div class="clearfix"></div>
    <?php echo $user_wishlist; ?>

    
   </div> 
   </div> 
</section>


<?php echo $footer; ?>
