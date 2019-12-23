<?php echo $header; ?>
  <section class="category-title">
      <h1 class="ttu h1"><span>Корзина</span></h1>
  </section>
  
  <div class="cart-content container-fluid">

  <div class="col-sm-12">
    <form action="<?php echo $checkout; ?>" method="POST">
        <table class="table table-bordered mincart bigcart">
         <tr> 
            <th colspan="2" class="name"><?php echo count($products); ?> товаров</th>
            <th class="count">
                Кол-во
            </th>
            <th class="summ tc">Цена</th>
            <th class="remove"></th>
          </tr>
          <script type="text/javascript">
          var total_price=[];
          </script>
          <?php foreach ($products as $product) 
          { ?>
          <tr>
            <td class="image"><img src="<?php echo $product['thumb']; ?>"></td>
            <td class="name">
              <a href="<?php echo $product['href']; ?>"><?php echo $product['name']; ?></a>
              <?php if (!$product['stock']) { ?>
              <span class="text-danger">***</span>
              <?php } ?>
              <?php if ($product['option']) { ?>
              <?php foreach ($product['option'] as $option) { ?>
              <br />
              <small><?php echo $option['name']; ?>: <?php echo $option['value']; ?></small>
              <?php }
                } ?>
            </td>
            <td class="count">
                  <input type="hidden" value="<?php echo $product['price_orig']; ?>" id="price_nt<?php echo $product['cart_id']; ?>" class="prod_price">
                <div class="prod-count">
                  <span class="minus"></span>
                  <!-- <input class="form-control" type="text" value="2"> -->
                  <input type="text" id="amount<?php echo $product['cart_id'];?>" name="quantity[<?php echo $product['cart_id']; ?>]" value="<?php echo $product['quantity']; ?>" size="1" class="form-control prod_amount" />
                  <span class="plus"></span>
                  <script type="text/javascript">
                  $('#amount<?php echo $product['cart_id'];?>').on('change', function(e) {
                      var price=String($("#price_nt<?php echo $product['cart_id']; ?>").val()*$("#amount<?php echo $product['cart_id']; ?>").val());
                      // console.log(price+'   '+$("price_nt<?php echo $product['cart_id']; ?>").val()+'  ');
                      price=price.replace(/(\d)(?=(\d\d\d)+([^\d]|$))/g, '$1 ');
                    // $('#price<?php echo $product['cart_id']; ?>').val(price+' '+" руб.");
                    $('#price<?php echo $product['cart_id']; ?>').html(price+' '+" руб.");                    
                    RecountTotal();
                    });
                  window.total_price.push("<?php echo $product['cart_id']; ?>");
                  function RecountTotal()
                  {
                    var total=0;
                    for (var i = window.total_price.length - 1; i >= 0; i--) 
                    {
                      total+=($("#price_nt"+window.total_price[i]).val()*$("#amount"+window.total_price[i]).val());
                    };
                      var price=String(total);
                      $('#total_cart').html(price.replace(/(\d)(?=(\d\d\d)+([^\d]|$))/g, '$1 ')+' '+" руб."); 
                  }
                  $(document).ready(function(){
                      RecountTotal();    
                  });
                  </script>
                </div>
            </td>
            <td class="summ" id="price<?php echo $product['cart_id']; ?>"><?php echo $product['total']; ?></td>
            <td class="remove">
              <button type="button" data-toggle="tooltip" title="<?php echo $button_remove; ?>" class="btn btn-remove" onclick="cart.remove('<?php echo $product['cart_id']; ?>');">
            </td>
          </tr>
          <?php } ?>
        </table>
  </div>
  <div class="clearfix"></div>
   
  <div class="container-fluid">
   <div class="col-sm-12">
    <div class="coupon">
      <div class="form-group ">
            <label class="control-label" for="inputCoupon">Введите код со скидочного купона &nbsp;</label>
            <input type="text" class="form-control" id="inputCoupon" name="buydiscount_coupon" placeholder="12345" style="display: inline-block;width: auto;vertical-align: middle;">
      </div>
      </div>
   <div class="itog-summ">


       <span id="total_cart">Итого: <?php echo $totals[count($totals)-1]['text']; ?></span>
   <div>
    <button type="submit" class="btn btn-lg ttu btn-primary">Оформить заказ</button>
       </div>
    </div>
    </div>
    </div>
</div>
</form>

<?php echo $footer;?>