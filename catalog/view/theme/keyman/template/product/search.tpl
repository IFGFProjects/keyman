<?php echo $header; ?>

<section class="category-title">
    <h2 class="ttu h1"><a href="#"><span><?php echo $heading_title; ?></span></a></h2>
</section>


<section class="filter">
   <div class="container-fluid">
   <div class="col-xs-12">
        <div class="sort">
            <span >Упорядочить </span>
            <a sort-type="p.price" href="#"><span class="sort-by">По цене</span></a>
            <a sort-type="rating"  href="#"><span class="sort-by">По популярности</span></a>
            <script type="text/javascript">
            $(document).ready(set_sorts);



            function set_sorts(){
            
            <?php foreach ($sorts as $sorts) { 
              if ( ($sorts['value'] == $sort . '-' . $order) && ($order=="ASC") )
                {$active_href=str_replace("ASC", "DESC", $sorts['href']);}
              if ( ($sorts['value'] == $sort . '-' . $order) && ($order=="DESC") )
                {$active_href=str_replace("DESC", "ASC", $sorts['href']);}
            ?>
              $('a[sort-type="<?php echo str_replace(array("-ASC","-DESC"),array("",""),$sorts['value'] ) ;?>"]').attr("href","<?php echo $sorts['href']; ?>");

            <?php }

            if (isset($active_href))
              {?>
                $('a[sort-type="<?php echo $sort ;?>"]').attr("href","<?php echo $active_href ?>").addClass("active");  
                <?php if ($order=="ASC") {?> $('a[sort-type="<?php echo $sort ;?>"]').addClass("up"); <?php } ?>
                <?php if ($order=="DESC") {?> $('a[sort-type="<?php echo $sort ;?>"]').addClass("down"); <?php } ?>
        <?php }
            ?>
            }
            </script>
            <div class="pull-right-for-sort">
              <div class="sort-amount">
                  <span>Выводить по</span>
                  <select name="sort-amount" class="form-control" <?php echo $limit; ?>>
                    <?php foreach ($limits as $limits) { ?>
                    <?php if ($limits['value'] == $limit) { ?>
                    <option value="<?php echo $limits['href']; ?>" selected="selected"><?php echo $limits['text']; ?></option>
                    <?php } else { ?>
                    <option value="<?php echo $limits['href']; ?>"><?php echo $limits['text']; ?></option>
                    <?php } ?>
                    <?php } ?>
                  </select>
              </div>
            </div>
            <div class="clearfix"></div>
        </div>
        <div class="clearfix"></div>
        <?php if (count($tags)>1) { ?>
        <div class="filterblock"  id="filter">
        <form id="filter_form" action="<?php echo $url; ?>" method="POST">
            <div class="criterion">
              <a data-toggle="collapse" data-parent="#filter" href="#filter_tag" class="criterion-title"><span>Тэги</span></a>
              <div class="clearfix"></div>
              <div class="filters">
                  <div id="filter_tag" class="collapse">
                      <div class="filterinputs">
                          <div class="size-input">
                            <?php 
                                if (isset($tags))
                                foreach ($tags as $tag_name => $tag_link) 
                                {
                                  ?>
                                 <label class="filtercheck" style="cursor:pointer;" >
                                     <input id="tag_single"  onclick="window.location.href='<?php echo $tag_link; ?>';"  type="checkbox" name="tag[<?php echo $tag_name; ?>]" value="<?php echo $tag_name; ?>" <?php if ($tag_name==$tag_selected) { ?> checked="checked" <?php } ?> >
                                     <span ></span><?php echo $tag_name; ?>
                                 </label>
                            <?php 
                                } ?>
                          </div>
                      </div>
                  </div>
              </div>  
            </div>
        </form>
        </div>
        <?php } ?>

       </div>
    </div>
</section>



<section class="filter-products">
  <div class="container-fluid">
    <div class="products">
      <?php //echo "<h1 style='color:red;'>products :</h1><pre>";print_r($products);echo "</pre><hr>"; ?>
        <?php foreach ($products as $product) { ?>
        <div class="col-sm-6 col-md-4 col-xs-6">
            <div class="product-cart" >
                <!-- <a href="<?php echo $product['image']; ?>" class="fancybox" title="<?php echo $product['meta_description']; ?>"> -->
                <a href="<?php echo $product['href']; ?>" title="<?php echo $product['meta_description']; ?>">
                  <img src="<?php echo $product['thumb']; ?>">
                </a>
                <div class="product-title">
                  <a href="<?php echo $product['href']; ?>"><?php echo $product['name']; ?></a>
                </div>
                <?php if ((int)$product['special']>0)
                  {?>
                  <div class="produst-price">
                  <span style="color:#751c1c;text-decoration:line-through">
                    <span style="color: #3a383a;"><?php echo $product['price']; ?></span>
                  </span><br>
                  <?php echo $product['special']; ?>
                </div>
                <?php } else { ?>
                <div class="produst-price">
                  <?php if ($product['price']!=0) { echo $product['price']; } else { ?>
                   Нет в наличии
                   <?php } ?>
                </div><br>
                <?php } ?>
                <?php if ($product['price']>1) {?>
                <div class="product-buttons">
                 <button class="btn btn-default btn-buy" data-toggle="modal" data-target="#quick-order<?php echo $product['product_id']; ?>">Купить</button>
                <!-- <button class="btn btn-default btn-cart" data-toggle="modal" onclick="cart.add('<?php echo $product['product_id']; ?>', '1');" data-target="#quick-cart<?php echo $product['product_id']; ?>">В корзину</button> -->
                </div>
                <?php } ?>
            </div>
        </div>

                <div class="modal fade" id="quick-order<?php echo $product['product_id']; ?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                  <div class="modal-dialog">
                    <div class="modal-content">
                      <form  id="fast_order_<?php echo $product['product_id']; ?>">
                      <button type="button" class="close redclose" id="close<?php echo $product['product_id']; ?>" data-dismiss="modal" aria-hidden="true"></button>
                      <div class="col-sm-5">
                          <div class="product-preview">
                              <img src="<?php echo $product['thumb']; ?>">
                          </div>
                      </div>
                      <div class="col-sm-7">
                          <div class="modal-product-description">
                            <input type="hidden" name="heading_title<?php echo $product['product_id']; ?>" id="heading_title<?php echo $product['product_id']; ?>"  value="<?php echo $product['name']; ?>">
                            <input type="hidden" name="product_id<?php echo $product['product_id']; ?>"    id="product_id<?php echo $product['product_id']; ?>"     value="<?php echo $product['product_id']; ?>">
                            <input type="hidden" name="price<?php echo $product['product_id']; ?>"         id="price<?php echo $product['product_id']; ?>"          value="<?php echo $product['price']; ?>">
                            <input type="hidden" name="model<?php echo $product['product_id']; ?>"         id="model<?php echo $product['product_id']; ?>"          value="<?php echo $product['model']; ?>">
                              <h2 class="modal-product-title"><?php echo $product['name']; ?></h2>
                              <h2 class="modal-product-price"><?php echo $product['special']? $product['special'] : $product['price']; ?></h2>
        <!--                       <div class="product-color">
                                  <h4>Цвет:</h4>
                                  <label class="radio-inline">
                                      <input type="radio" name="colors" id="color1" value="option1"><span style="background:#333;"></span>
                                  </label>
                                  <label class="radio-inline">
                                      <input type="radio" name="colors" id="color2" value="option2" checked><span style="background:#555;"></span>
                                  </label>
                                  <label class="radio-inline">
                                      <input type="radio" name="colors" id="color3" value="option3"><span style="background:#666;"></span>
                                  </label>
                                  <label class="radio-inline">
                                      <input type="radio" name="colors" id="color4" value="option4"><span style="background:#999;"></span>
                                  </label>
                                  <label class="radio-inline">
                                      <input type="radio" name="colors" id="color5" value="option5"><span style="background:#a2925a;"></span>
                                  </label>
                              </div> -->
                              <div class="product-size">
                                  <h4>Размер:</h4>
                              <?php foreach ($product['options'] as $opt_ind => $option) {
                                if ($option['option_id']==13) {
                                  foreach ($option['product_option_value'] as $skey => $sizes) {
                                    ?>
                                   <label class="radio-inline">
                                       <input <?php if ($sizes['quantity']<1) {echo "disabled='disabled'";} ?> type="radio" name="size<?php echo $product['product_id']; ?>" id="size<?php echo $sizes['option_value_id']; ?>" text-value="<?php echo $sizes['name']; ?>" value="<?php echo $sizes['option_value_id']; ?>">
                                       <span ><?php echo $sizes['name']; ?></span>
                                   </label>
                              <?php }
                                }
                              } ?>
                              </div>
                              <div class="product-count">
                                <div class="pull-left col-xs-3 p0">
                                    <h4>Кол-во:</h4>
                                    <input type="hidden" value="<?php echo $product['price_orig']; ?>" id="price_orig<?php echo $product['product_id']; ?>">
                                    <div class="prod-count"><span class="minus" id="minus<?php echo $product['product_id']; ?>"></span><input class="form-control" name="amount<?php echo $product['product_id']; ?>" id="amount<?php echo $product['product_id']; ?>" type="text" value="1"><span class="plus" id="plus<?php echo $product['product_id']; ?>"></span></div>
                                </div>
                                <div class="pull-left col-xs-9 pl10 p0">
                                   <h4>Итоговая стоимость:</h4>
                                   <div class="total-price h2" id="price_tr<?php echo $product['product_id']; ?>">
                                      <?php echo $product['special']? $product['special'] : $product['price']; ?>
                                   </div>
                                </div>
                                <div class="clearfix"></div>
                              </div>
                              
                          </div>
                      </div>
                      <div class="clearfix"></div>
                      <div class="modal-footer">
                        <div class="form-group">
                          <input type="text" class="form-control input-lg" name="name<?php echo $product['product_id']; ?>"  id="name<?php echo $product['product_id']; ?>" placeholder="Имя:">
                        </div>
                        <div class="form-group">
                          <input type="text" class="form-control input-lg" name="lname<?php echo $product['product_id']; ?>" id="lname<?php echo $product['product_id']; ?>" placeholder="Фамилия:">
                        </div>
                        <div class="form-group">
                          <input type="text" class="form-control input-lg" name="phone<?php echo $product['product_id']; ?>" id="phone<?php echo $product['product_id']; ?>" placeholder="Номер телефона  :">
                        </div>
                        <div class="form-group">
                          <input type="text" class="form-control input-lg" name="mail<?php echo $product['product_id']; ?>" id="mail<?php echo $product['product_id']; ?>" placeholder="E-mail  :">
                        </div>
                        <div class="form-group">
                          <input type="text" class="form-control input-lg" name="address<?php echo $product['product_id']; ?>" id="address<?php echo $product['product_id']; ?>" placeholder="Адрес доставки:">
                        </div>
                        <div class="form-group">
                          <textarea class="form-control input-lg" name="comment<?php echo $product['product_id']; ?>" id="comment<?php echo $product['product_id']; ?>" placeholder="Комментарий к заказу:" rows="3"></textarea>
                        </div>
                        
                        <button class="btn btn-primary btn-block btn-lg" id="fast_order_button<?php echo $product['product_id']; ?>">Заказать</button>
                      </div>
                      </form>
                    </div>
                  </div>
                </div>

                <script>
                    $('#fast_order_button<?php echo $product['product_id'];?>').on('click', function(e) {
                      e.preventDefault();
                        // Form fill variables
                        var data = [];

                        data['name']          = $('#name<?php echo $product['product_id'];?>').val()+' '+$('#lname<?php echo $product['product_id'];?>').val();
                        data['phone']         = $('#phone<?php echo $product['product_id'];?>').val();
                        data['mail']          = $('#mail<?php echo $product['product_id'];?>').val();
                        data['address']          = $('#address<?php echo $product['product_id'];?>').val();
                        data['comment']       = $('#comment<?php echo $product['product_id'];?>').val();
                        data['heading_title'] = $('#heading_title<?php echo $product['product_id'];?>').val();
                        data['price']         = $('#price<?php echo $product['product_id'];?>').val();
                        data['product_id']    = $('#product_id<?php echo $product['product_id'];?>').val();
                        data['amount']    = $('#amount<?php echo $product['product_id'];?>').val();
                        data['model']         = $('#model<?php echo $product['product_id'];?>').val();
                        data['size']    = 0;
                        if ($('[name=size<?php echo $product['product_id'];?>]').length>0)
                          {data['size']=$('[name=\'size<?php echo $product['product_id'];?>\']:checked').attr("text-value");}


                        $.ajax({
                            url: 'index.php?route=product/fastorder/sender',
                            type: 'post',
                            data: {name: data['name'], phone: data['phone'], model: data['model'], mail: data['mail'], address: data['address'], comment: data['comment'], heading_title: data['heading_title'], amount: data['amount'], size: data['size'], price: data['price'] ,product_id: data['product_id']},
                            dataType: 'json',
                            beforeSend: function() {
                                // Do form valdation
                                if (!$('#name<?php echo $product['product_id'];?>').val()) {console.error("Имя не заполнено!");return false;}
                                if (!$('#phone<?php echo $product['product_id'];?>').val()) {console.error("Телефон не заполнен!");return false;}
                                if (!$('#mail<?php echo $product['product_id'];?>').val()) {console.error("E-mail не заполнен!");return false;}
                                if ( (!$('[name=size<?php echo $product['product_id'];?>]').val()) && ($('[name=size<?php echo $product['product_id'];?>]').length>0) ) {console.error("Размер не выбран!");return false;}
                            },
                            complete: function() {
                                $('#error-msg').hide();
                                $('#bs-fastorder<?php echo $product['product_id'];?>').modal('hide');
                                $('#close<?php echo $product['product_id']; ?>').click();
                            },
                            success: function(json) {
                                $('#fastorder-success<?php echo $product['product_id'];?>').modal('show');
                                $('#close<?php echo $product['product_id']; ?>').click();
                                console.debug(json);
                            },
                            error: function(xhr, ajaxOptions, thrownError) {
                                alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
                            }
                        });
                    });
                    $('#amount<?php echo $product['product_id'];?>').on('change', function(e) {
                        var price=String($("#price_orig<?php echo $product['product_id']; ?>").val()*$("#amount<?php echo $product['product_id']; ?>").val());
                        console.log(price+'   '+$("price_orig<?php echo $product['product_id']; ?>").val()+'  ');
                        price=price.replace(/(\d)(?=(\d\d\d)+([^\d]|$))/g, '$1 ');
                      $('#price<?php echo $product['product_id']; ?>').val(price+' '+" руб.");
                      $('#price_tr<?php echo $product['product_id']; ?>').html(price+' '+" руб.");
                      });
                  </script>
                
                <?php } ?>
    </div>
    <div class="paging text-center">
    <?php echo $pagination; ?>
    </div>

  </div>
</section>

<section class="category-description">
          <div class="container-fluid">
            <div class="col-md-10 col-md-offset-1 col-sm-offset-0 col-sm-12">
              <?php echo $description; ?>
            </div>
          </div>
      </section>












































<script type="text/javascript"><!--
$('#button-search').bind('click', function() {
	url = 'index.php?route=product/search';

	var search = $('#content input[name=\'search\']').prop('value');

	if (search) {
		url += '&search=' + encodeURIComponent(search);
	}

	var category_id = $('#content select[name=\'category_id\']').prop('value');

	if (category_id > 0) {
		url += '&category_id=' + encodeURIComponent(category_id);
	}

	var sub_category = $('#content input[name=\'sub_category\']:checked').prop('value');

	if (sub_category) {
		url += '&sub_category=true';
	}

	var filter_description = $('#content input[name=\'description\']:checked').prop('value');

	if (filter_description) {
		url += '&description=true';
	}

	location = url;
});

$('#content input[name=\'search\']').bind('keydown', function(e) {
	if (e.keyCode == 13) {
		$('#button-search').trigger('click');
	}
});

$('select[name=\'category_id\']').on('change', function() {
	if (this.value == '0') {
		$('input[name=\'sub_category\']').prop('disabled', true);
	} else {
		$('input[name=\'sub_category\']').prop('disabled', false);
	}
});

$('select[name=\'category_id\']').trigger('change');
--></script>
<?php echo $footer; ?>