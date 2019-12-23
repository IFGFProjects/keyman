<?php echo $header; ?>
<section class="category-title">
    <h1 class="ttu h1 mb0"><span><?php echo $heading_title; ?></span></h1>
</section>

<div class="container-fluid">
       <ol class="breadcrumb crumbstyle">
                <?php $counter = 0; $array_lenth = count($breadcrumbs); ?>
           <?php foreach ($breadcrumbs as $bkey=>$breadcrumb) { ?>
                 <?php $counter++;?>
                <?php if($counter == $array_lenth){continue;} ?>
        <li>
          <?php if ($bkey<count($breadcrumbs)-1) {?><a href="<?php echo $breadcrumb['href']; ?>"><?php } ?>
            <?php echo $breadcrumb['text']; ?>
          <?php if ($bkey<count($breadcrumbs)-1) {?></a><?php } ?>
        </li>
        <?php } ?>       

      </ol>
</div>

<section class="kit-content">
    <div class="container-fluid">
        <div class="col-sm-4 col-xs-6">
        	<?php
          $tr=false;
           foreach ($products as $pkey => $product) 
        	{?>

        	
               <div class="kit-jacket">
               <div class="kitpart">
                <div class="part-img">
                    <a href="<?php echo $product['image_orig']; ?>" class="fancybox"><img src="<?php echo $product['kit_image']; ?>"></a>
                </div>
                <div class="kit-title">
                    <a href="<?php echo $product['href']; ?>" class="h3 ttu fs14"><?php echo $product['name']; ?></a>
                </div>
                <div class="kitpart-description">
                    <?php if ($product['sku']!="") { ?><span>Артикул: <?php echo $product['sku']; ?></span><?php } ?>
        

<!--         <div class="product-color mt5">
            <span>Цвет:</span>
            <div class="inline-block-part">
               <label class="radio-inline">
                <input type="radio" name="colors1" id="color1" value="option1"><span style="background:#333;"></span>
            </label>
            <label class="radio-inline">
                <input type="radio" name="colors1" id="color2" value="option2" checked><span style="background:#555;"></span>
            </label>
            </div>
        </div> -->
        <div id="kit_sizes">
        <?php 
            if (isset($product['options']))
        {foreach ($product['options'] as $optkey => $option) 
              {
                if ($option['option_id']==13)
                {?>
              <div class="product-size mt10">
                  <span>Размер:</span>

              <?php  foreach ($option['product_option_value'] as $szkey => $option_value) 
                {
                
                  if ($option_value['quantity']>0) {
              ?>
            <label class="radio-inline">
                <!-- <input type="radio" name="filter_options[13][<?php echo $option['product_option_id']; ?>]" id="size<?php echo $option['product_option_id']; ?>" value="<?php echo $option['product_option_id']; ?>"><span><?php echo $sizes['name']; ?></span> -->
                <input type="radio" name="option[<?php echo $product['product_id']; ?>][<?php echo $option['product_option_id']; ?>]" value="<?php echo $option_value['product_option_value_id']; ?>"><span><?php echo $option_value['name']; ?></span>
            </label>
        <?php }}?>
        </div>
        
        <?php } ?>
        <?php } ?>
      <?php } ?>
      </div>

                    <!-- <span class="a-block mt5">Бренд:  <?php echo $product['manufacturer']; ?></span>
                    <?php foreach ($product['attribute_groups'] as $attribute_group) { ?>
                      <?php foreach ($attribute_group['attribute'] as $atr_id => $attribute) { if ($atr_id!=41) { ?>
                      <span class="a-block mt5"><?php echo $attribute['name']; ?>: <?php echo $attribute['text']; ?></span>
                      <?php } } ?>
                    <?php } ?>
                     <span class="a-block mt5">Состав: хлопок 100%</span> -->

                    <!-- <a href="#" class="a-block mt5" data-toggle="popover" data-html="true" data-placement="bottom" data-trigger="focus" data-content="<?php echo $product['attribute_groups'][61]['attribute'][41]['text']; ?>"> -->
                    <a href="<?php echo $image_orig; ?>" class="fancybox">
                    <!-- <span class="underline-pointer">Рекомендации по уходу</span></a> -->
                    <?php if ($product['cat_add_data']!="" && false) {?>
                    <a href="#jacket-size<?php echo $product['product_id']; ?>" class="a-block mt5" data-toggle="modal" data-target="#jacket-size<?php echo $product['product_id']; ?>"><span class="underline-pointer">Таблица размеров</span></a>

                                     <div class="modal fade" id="jacket-size<?php echo $product['product_id']; ?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                                  <div class="modal-dialog modal-lg">
                                    <div class="modal-content">
                                      <div class="modal-header">
                                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                          <section class="category-title">
                                          <h4 class="modal-title fs20"><strong>Таблица размеров</strong></h4>
                                      </section>
                                      </div>
                                      <div class="modal-body text-center">
                                          <div class="table-responsive">
                    							<?php echo $product['cat_add_data']; ?>
                                          </div>
                                      </div>
                                      
                                    </div><!-- /.modal-content -->
                                  </div><!-- /.modal-dialog -->
                                </div><!-- /.modal --> 
                    <?php } ?>
                </div>
            </div>
            </div>
                <?php if ( ($pkey+1>=count($products)/2) && (!$tr)  ) {?>
                    </div>
                    <div class="col-sm-4 col-xs-6 pull-right">
                    <?php $tr=true; } ?>
            <?php } ?>


        </div>
        <div class="col-sm-4 col-xs-12">
            <div class="kit-bigman">
               <div class="kit-bigimg">
                <img src="<?php echo $image_orig; ?>">
              </div>
            </a>
              </div>
            <div class="kitbigimg-title text-center ttu">
                <h2><?php echo $heading_title; ?></h2>
            </div>
            <?php if ($price_orig<1) {?>
            <div class="new-product-price ttu">
                <span>Нет в наличии</span>
            </div>
            <?php } elseif ((int)$special>0) { ?>
            <div class="kit-price text-center">
                <div class="kit-new-price ttu">
                    <span><?php echo $special; ?></span>
                </div>
                <div class="kit-old-price">
                    <span><?php echo $price; ?></span>
                </div>
            </div>
            <?php } else { ?>
            <div class="kit-price text-center">
                <div class="kit-new-price ttu">
                    <span><?php echo $price; ?></span>
                </div>
            	<?php if (isset( $strike_price) ) {?>
                <div class="kit-old-price">
                    <span><?php echo $strike_price; ?></span>
                </div>
                <?php } ?>
            </div>
            <?php } ?>


            <?php if ($price_orig<1) {?>
            <div class="product-buttons">
                   <button class="btn btn-default btn-buy" data-toggle="modal" data-target="#quick-order<?php echo $product_id;?>">Купить</button>
                  <button class="btn btn-default btn-cart" data-toggle="modal" id="button-cart" data-target="#quick-cart">В корзину</button>
            </div>
            <?php } ?>

            </div>

			<div id="product">
				
				<input class="form-control input-lg" type="hidden" name="quantity" value="1">
				<input type="hidden" name="product_id" value="<?php echo $product_id; ?>">
			</div>

        </div>
        
        <div class="clearfix"></div>
    </div>
</section>


 <div class="modal fade" id="quick-cart" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close redclose" data-dismiss="modal" aria-hidden="true"></button>
          <h4 class="modal-title h2 ttu"><span>Товар добавлен в корзину</span></h4>
      </div>
      <div class="col-sm-12">
          <div class="modal-mincart">
            <table class="table table-bordered mincart">
              <tr>
                <td class="image"><?php /*/ ?><img src="assets/img/suit-preview.png"><?php /*/ ?></td>
                <td class="name"><a href="#">Смокинг Giorgio Napoli</a></td>
                <td class="count">2 шт.</td>
                <td class="summ">1 500 000 руб.</td>
              </tr>
            </table>
          </div>
      </div>
      <div class="clearfix"></div>
      <div class="modal-footer">
        <button type="button" class="btn btn-lg ttu btn-default pull-left" data-dismiss="modal">Продолжить</button>
        <button type="button" class="btn btn-lg ttu btn-primary" onclick="window.location.href='<?php echo $cart_href; ?>';">Оформить заказ</button>
      </div>
    </div>
  </div>
</div>

<script type="text/javascript"><!--
$('select[name=\'recurring_id\'], input[name="quantity"]').change(function(){
	$.ajax({
		url: 'index.php?route=product/product/getRecurringDescription',
		type: 'post',
		data: $('input[name=\'product_id\'], input[name=\'quantity\'], select[name=\'recurring_id\']'),
		dataType: 'json',
		beforeSend: function() {
			$('#recurring-description').html('');
		},
		success: function(json) {
			$('.alert, .text-danger').remove();

			if (json['success']) {
				$('#recurring-description').html(json['success']);
			}
		}
	});
});
//--></script>
<script type="text/javascript"><!--
$('#button-cart').on('click', function() {
	$.ajax({
		url: 'index.php?route=checkout/cart/add',
		type: 'post',
		data: $('#product input[type=\'text\'], #product input[type=\'hidden\'], #kit_sizes input[type=\'radio\']:checked, #product input[type=\'checkbox\']:checked, #product select, #product textarea'),
		dataType: 'json',
		beforeSend: function() {
			$('#button-cart').button('loading');
		},
		complete: function() {
			$('#button-cart').button('reset');
		},
		success: function(json) {
			$('.alert, .text-danger').remove();
			$('.product-size').removeClass('has-error');
console.debug(json);
			if (json['error']) {
				if (json['error']['option']) {
					for (i in json['error']['option']) {
						var element = $('#input-option' + i.replace('_', '-'));

						if (element.parent().hasClass('input-group')) {
							element.parent().after('<div class="text-danger">' + json['error']['option'][i] + '</div>');
						} else {
							element.after('<div class="text-danger">' + json['error']['option'][i] + '</div>');
						}
					}
				}

				if (json['error']['recurring']) {
					$('select[name=\'recurring_id\']').after('<div class="text-danger">' + json['error']['recurring'] + '</div>');
				}

				// Highlight any found errors
				$('.text-danger').parent().addClass('has-error');
			}

			if (json['success']) 
      {
        var data=json['products'];
        console.debug(data);
        var cart_html="";
        for (var key in data) 
        {
          cart_html+='<tr>'
            +'<td class="image"><img src="'+data[key].image+'"></td>'
            +'<td class="name"><a href="'+data[key].href+'">'+data[key].name+'</a></td>'
            +'<td class="count">'+data[key].quantity+' шт.</td>'
            +'<td class="summ">'+data[key].price+'</td>'
          +'</tr>';
        };

        $("table.mincart").html(cart_html);

    //     $('.breadcrumb').after('<div class="alert alert-success">' + json['success'] + '<button type="button" class="close" data-dismiss="alert">&times;</button></div>');

				// $('#cart > button').html('<i class="fa fa-shopping-cart"></i> ' + json['total']);

				// $('html, body').animate({ scrollTop: 0 }, 'slow');

				// $('#cart > ul').load('index.php?route=common/cart/info ul li');
			}
		},
        error: function(xhr, ajaxOptions, thrownError) {
            alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
        }
	});
});
//--></script>


        <div class="modal fade" id="quick-order<?php echo $product_id; ?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
          <div class="modal-dialog">
            <div class="modal-content">
              <form  id="fast_order_<?php echo $product_id; ?>">
              <button type="button" class="close redclose" id="close<?php echo $product_id; ?>" data-dismiss="modal" aria-hidden="true"></button>
              <div class="col-sm-5">
                  <div class="product-preview">
                      <img src="<?php echo $thumb; ?>">
                  </div>
              </div>
              <div class="col-sm-7">
                  <div class="modal-product-description">
                    <input type="hidden" name="heading_title<?php echo $product_id; ?>" id="heading_title<?php echo $product_id; ?>"  value="<?php echo $heading_title; ?>">
                    <input type="hidden" name="product_id<?php echo $product_id; ?>"    id="product_id<?php echo $product_id; ?>"     value="<?php echo $product_id; ?>">
                    <input type="hidden" name="price<?php echo $product_id; ?>"         id="price<?php echo $product_id; ?>"          value="<?php echo $price_orig; ?>">
                    <input type="hidden" name="model<?php echo $product_id; ?>"         id="model<?php echo $product_id; ?>"          value="<?php echo $model; ?>">
                      <h2 class="modal-product-title"><?php echo $heading_title; ?></h2>
                      <h2 class="modal-product-price">
                        <?php if ((int)$special>0) { ?>
                        <div class="kit-price text-center">
                            <div class="kit-new-price ttu">
                                <span><?php echo $special; ?></span>
                            </div>
                            <div class="kit-old-price">
                                <span><?php echo $price; ?></span>
                            </div>
                        </div>
                        <?php } else { ?>
                        <div class="kit-price text-center">
                            <div class="kit-new-price ttu">
                                <span><?php echo $price; ?></span>
                            </div>
                         <?php if (isset( $strike_price) ) {?>
                            <div class="kit-old-price">
                                <span><?php echo $strike_price; ?></span>
                            </div>
                            <?php } ?>
                        </div>
                        <?php } ?>
                      </h2>

                      <div class="product-size">
                          <h4>Размер:</h4>
                      <?php foreach ($options as $opt_ind => $option) {
                        if ($option['option_id']==13) {
                          foreach ($option['product_option_value'] as $skey => $sizes) {
                            ?>
                           <label class="radio-inline">
                               <input type="radio" name="size<?php echo $product_id; ?>" id="size<?php echo $sizes['option_value_id']; ?>" text-value="<?php echo $sizes['name']; ?>" value="<?php echo $sizes['option_value_id']; ?>">
                               <span ><?php echo $sizes['name']; ?></span>
                           </label>
                      <?php }
                        }
                      } ?>
                      </div>
                      <div class="product-count">
                        <div class="pull-left col-xs-3 p0">
                            <h4>Кол-во:</h4>
                            <input type="hidden" value="<?php echo $price_orig; ?>" id="price_orig<?php echo $product_id; ?>">
                            <div class="prod-count"><span class="minus" id="minus<?php echo $product_id; ?>"></span><input class="form-control" name="amount<?php echo $product_id; ?>" id="amount<?php echo $product_id; ?>" type="text" value="1"><span class="plus" id="plus<?php echo $product_id; ?>"></span></div>
                        </div>
                        <div class="pull-left col-xs-9 pl10 p0">
                           <h4>Итоговая стоимость:</h4>
                           <div class="total-price h2" id="price_tr<?php echo $product_id; ?>">
                              <?php echo $special? $special : $price; ?>
                           </div>
                        </div>
                        <div class="clearfix"></div>
                      </div>
                      
                  </div>
              </div>
              <div class="clearfix"></div>
              <div class="modal-footer">
                <div class="form-group">
                  <input type="text" class="form-control input-lg" name="name<?php echo $product_id; ?>"  id="name<?php echo $product_id; ?>" placeholder="Имя:">
                </div>
                <div class="form-group">
                  <input type="text" class="form-control input-lg" name="lname<?php echo $product_id; ?>" id="lname<?php echo $product_id; ?>" placeholder="Фамилия:">
                </div>
                <div class="form-group">
                  <input type="text" class="form-control input-lg" name="phone<?php echo $product_id; ?>" id="phone<?php echo $product_id; ?>" placeholder="Номер телефона  :">
                </div>
                <div class="form-group">
                  <input type="text" class="form-control input-lg" name="mail<?php echo $product_id; ?>" id="mail<?php echo $product_id; ?>" placeholder="E-mail  :">
                </div>
                <div class="form-group">
                  <input type="text" class="form-control input-lg" name="address<?php echo $product_id; ?>" id="address<?php echo $product_id; ?>" placeholder="Адрес доставки:">
                </div>
                <div class="form-group">
                  <textarea class="form-control input-lg" name="comment<?php echo $product_id; ?>" id="comment<?php echo $product_id; ?>" placeholder="Комментарий к заказу:" rows="3"></textarea>
                </div>
                
                <button class="btn btn-primary btn-block btn-lg" id="fast_order_button<?php echo $product_id; ?>">Заказать</button>

              </div>
              </form>
            </div>
          </div>
        </div>

        <?php echo $content_bottom; ?>

<script>
$(document).ready(function(){
        

    $('#fast_order_button<?php echo $product_id;?>').on('click', function(e) {
      e.preventDefault();
        // Form fill variables
        var data = [];

        data['name']          = $('#name<?php echo $product_id;?>').val()+' '+$('#lname<?php echo $product_id;?>').val();
        data['phone']         = $('#phone<?php echo $product_id;?>').val();
        data['mail']          = $('#mail<?php echo $product_id;?>').val();
        data['address']          = $('#address<?php echo $product_id;?>').val();
        data['comment']       = $('#comment<?php echo $product_id;?>').val();
        data['heading_title'] = $('#heading_title<?php echo $product_id;?>').val();
        data['price']         = $('#price<?php echo $product_id;?>').val();
        data['product_id']    = $('#product_id<?php echo $product_id;?>').val();
        data['amount']    = $('#amount<?php echo $product_id;?>').val();
        data['model']         = $('#model<?php echo $product_id;?>').val();
        data['size']    = 0;
         if ($('[name=\'size<?php echo $product_id;?>\']').length>0)
           {$('[name=\'size<?php echo $product_id;?>\']:checked').attr("text-value");}

        $.ajax({
            url: 'index.php?route=product/fastorder/sender',
            type: 'post',
            data: {name: data['name'], phone: data['phone'],model: data['model'], mail: data['mail'], address: data['address'], comment: data['comment'], heading_title: data['heading_title'], amount: data['amount'], size: data['size'], price: data['price'] ,product_id: data['product_id']},
            dataType: 'json',
            beforeSend: function() {
                // Do form valdation
                if (!$('#name<?php echo $product_id;?>').val()) {console.error("Имя не заполнено!");return false;}
                if (!$('#phone<?php echo $product_id;?>').val()) {console.error("Телефон не заполнен!");return false;}
                if (!$('#mail<?php echo $product_id;?>').val()) {console.error("E-mail не заполнен!");return false;}
                if ( (!$('[name=size<?php echo $product_id;?>]').val()) && ($('[name=size<?php echo $product_id;?>]').length>0)  ) {console.error("Размер не выбран!");return false;}
            },
            complete: function() {
                $('#error-msg').hide();
                $('#bs-fastorder<?php echo $product_id;?>').modal('hide');
                $('#close<?php echo $product_id; ?>').click();
            },
            success: function(json) {
                $('#fastorder-success<?php echo $product_id;?>').modal('show');
                $('#close<?php echo $product_id; ?>').click();
                console.debug(json);
            },
            error: function(xhr, ajaxOptions, thrownError) {
                alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
            }
        });
    });
    $('#amount<?php echo $product_id;?>').on('change', function(e) {
        var price=String($("#price_orig<?php echo $product_id; ?>").val()*$("#amount<?php echo $product_id; ?>").val());
        console.log(price+'   '+$("price_orig<?php echo $product_id; ?>").val()+'  ');
        price=price.replace(/(\d)(?=(\d\d\d)+([^\d]|$))/g, '$1 ');
      $('#price<?php echo $product_id; ?>').val(price+' '+" руб.");
      $('#price_tr<?php echo $product_id; ?>').html(price+' '+" руб.");
      });
 });
  </script>

<?php echo $footer; ?>