<?php echo $header; ?>
<style>
  .button_filter,
  .button_sort {
    margin-left: 10px;
    cursor: pointer;
    letter-spacing: 0.1px;
  }
.ajax_products + .paging {
  display: none;
}
  




  .button_filter.active,
  .button_sort.active{
    color: #6A0C13;
    letter-spacing: 0;
    font-weight: bold;
  }
  .button_filter:focus,
  .button_filter:active ,
  .button_sort:active ,
  .button_sort:focus {
    color: #3a383a;
    letter-spacing: 0.1px;
    font-weight: inherit;
  }
  @media (min-width: 768px) {

    .button_filter:hover,
     .button_sort:hover {
      color: #6A0C13;
      letter-spacing: 0;
      font-weight: bold;
     }
     .sort_off, #filter {
        display: block !important;
     }
     .buttons_filters {
      display: none;
     }
  }
  @media (max-width: 767px) {
    .button_filter,
    .button_sort {
      display: inline-block;
      float: left;
      margin-left: 0;
    }
    .button_sort {
      text-align: right;
      float: right;
    }
    .buttons_filters {
      width: 100%;
      border-bottom: 1px solid #f2f2f2;
      padding-bottom: 15px;
      margin-bottom: 15px;
    }
    .sort_off {
      width: 100%;
      padding-bottom: 15px;
      border-bottom: 1px solid #f2f2f2;
    }
    .criterion {
      border-top: none;
      margin-top: 0;
    }
    .sort_off .text {
      display: none;
    }
    .sort_off label.sort-by {
      float: left;
      margin-left: 0;
      width: 100%;
      margin-top: 11px;
    }
  }
</style>

<section class="category-title">
    <h1 class="ttu h1 mb0"><?php echo $heading_title; ?></h1>
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
          <?php if ($bkey<count($breadcrumbs)) {?></a><?php } ?>
        </li>
        <?php } ?>        

      </ol>
</div>
<?php // echo "<h1 style='color:red;'>tags :</h1><pre>";print_r($tags);echo "</pre><hr>"; ?>

<section class="filter">
   <div class="container-fluid">
   <div class="col-xs-12">
        <div class="sort">
     

     <div class="pull-right-for-sort buttons_filters">
       <div class="sort-amount">
         <span class="button_filter">Фильтры</span>
         <span class="button_sort">Упорядочить</span>
       </div>
     </div>



     <div class="pull-left sort_off" style="display:none;">
       <span class="hidden-xs text">Упорядочить</span>
       <a sort-type="ps.price" href="#"><span class="sort-by">По цене</span></a>
       <a sort-type="rating"  href="#"><span class="sort-by">По популярности</span></a>
       </div>
       <script type="text/javascript">
       $(document).ready(function () {
         set_sorts();
         $('.button_filter').click(function () {
           if ($("#filter").css("display")=='none') {
             $('#filter').show(300);
             $('.button_filter').addClass("active");
           }else { 
             $('#filter').hide(300);
             $('.button_filter').removeClass("active");
           };
         });
           
           // $('.button_sort').bind('click', function() {
         $('.button_sort').on('click', function () {
           if ($(".sort_off").css("display")=='none') {
             $('.sort_off').show(300);
             $('.button_sort').addClass("active");
           }else { 
             $('.sort_off').hide(300);
             $('.button_sort').removeClass("active");
           };
         });
       });



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
            <div class="pull-right-for-sort hidden">
              <div class="sort-amount">
                  <span>Выводить по</span>
                  <select name="sort-amount" class="form-control" onchange="window.location.href=this.value;">
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

        
       </div>
<div class="clearfix"></div>
<div class="filterblock col-xs-12" id="filter"  style="display:none;">
  <div class="criterion">
  
      <h2 class="ttu mb0 font_16 none_h">Распродажа по категориям</h2>

  <div class="filterinputs special_cat">
      <?php foreach ($special_categories as $sckey => $category) 
      {?>
        <label class="checkbox-inline filtercheck" onclick="window.location.href='<?php echo $category['category_id']==$selected_category? $no_category_link: $category['href']; ?>'">
         <input type="checkbox" value="<?php echo $category['name']; ?>" <?php if ($category['category_id']==$selected_category) {?> checked="checked" <?php } ?>>
         <span></span> <?php echo $category['name']; ?>
        </label>
      <?php } ?>

    </div>
    </div>
  <div class="clearfix"></div>
  <?php if (isset($category_info)) {?>
    <div class="filter-results">
                             <a class="filter-button" href="<?php echo $no_category_link; ?>" id="button_clear" style="display:inline-block; margin-bottom:5px;">Очистить</a>
                             

                                                      <div class="choosen-input">
                                 <a href="<?php echo $no_category_link; ?>" class="choosen-title tag_type_filter"><?php echo $category_info['name']; ?></a>
                             </div>
                               

                 </div>
    <?php } ?>
  </div>
    </div>
</section>



<section class="filter-products">
  <div class="container-fluid ajax_products_wrap">
    <div class="products ajax_products">
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
                   По запросу
                   <?php } ?>
                </div><br>
                <?php } ?>
                <?php if ($product['price']!=0) {?>

                <div class="product-buttons">
                 <button class="btn btn-default btn-buy" data-toggle="modal" data-target="#quick-order<?php echo $product['product_id']; ?>">Купить</button>
                <!-- <button class="btn btn-default btn-cart" data-toggle="modal" onclick="cart.add('<?php echo $product['product_id']; ?>', '1');" data-target="#quick-cart<?php echo $product['product_id']; ?>">В корзину</button> -->
                </div>
                <?php }else { ?>
                <div class="product-buttons none">
                 <button class="btn btn-default btn-buy" data-toggle="modal" data-target="#quick-order<?php echo $product['product_id']; ?>">Купить</button>
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
                          <?php if ($sizes['quantity']>0) {?>
                           <label class="radio-inline">
                            <?php /* OLD VARIAND WITH DISABLED SIZES ?>
                               <input <?php if ($sizes['quantity']<1) {echo "disabled='disabled'";} ?> type="radio" name="size<?php echo $product['product_id']; ?>" id="size<?php echo $sizes['option_value_id']; ?>" text-value="<?php echo $sizes['name']; ?>" value="<?php echo $sizes['option_value_id']; ?>">
                               <span ><?php echo $sizes['name']; ?></span>   
                            */?>                            
                               <input  type="radio" name="size<?php echo $product['product_id']; ?>" id="size<?php echo $sizes['option_value_id']; ?>" text-value="<?php echo $sizes['name']; ?>" value="<?php echo $sizes['option_value_id']; ?>">
                               <span ><?php echo $sizes['name']; ?></span>
                           </label>
                            <?php } ?>
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
  <img class="ajax-loader hidden" src="catalog/view/theme/keyman/img/ajax-loader.gif" alt="payment">
</section>

<script type="text/javascript">
  window.inProgress=false;
  window.page_number=1;

  $(window).scroll(function() {

      /* Если высота окна + высота прокрутки больше или равны высоте всего документа и ajax-запрос в настоящий момент не выполняется, то запускаем ajax-запрос */
      if($(window).scrollTop() + $(window).height() >= $(document).height() - ($('.category-description').height()+$('footer').height()+200) && !window.inProgress) {

        $(".ajax-loader").removeClass('hidden');
        window.inProgress=true;
        window.page_number=window.page_number+1;
        slide_page();
      }
  });


  function slide_page()
  {
    var form_data = $('#filter_form').serializeArray();

    $.post(
      window.location.href+'&page='+window.page_number,
      form_data,
      function(data) 
      {
        $(".ajax_products_wrap").append($(data).find('.ajax_products'));
        $(".ajax-loader").addClass('hidden');
        if ($(data).find('.ajax_products div').length>0){
          window.inProgress=false;
        } else {
          window.inProgress=true;
        }
        $(".ajax-loader").addClass('hidden');
      }
    ).always(function() {
      $(".ajax-loader").addClass('hidden');
    });
  }
</script>

  <section class="category-description">
            <div class="container-fluid">
              <div class="col-md-10 col-md-offset-1 col-sm-offset-0 col-sm-12">
               <?php echo $content_bottom; ?>
              </div>
            </div>
        </section>


<?php /*

<div class="container" style="display:none;">
  <ul class="breadcrumb">
    <?php foreach ($breadcrumbs as $breadcrumb) { ?>
    <li><a href="<?php echo $breadcrumb['href']; ?>"><?php echo $breadcrumb['text']; ?></a></li>
    <?php } ?>
  </ul>
  <div class="row"><?php echo $column_left; ?>
    <?php if ($column_left && $column_right) { ?>
    <?php $class = 'col-sm-6'; ?>
    <?php } elseif ($column_left || $column_right) { ?>
    <?php $class = 'col-sm-9'; ?>
    <?php } else { ?>
    <?php $class = 'col-sm-12'; ?>
    <?php } ?>
    <div id="content" class="<?php echo $class; ?>"><?php echo $content_top; ?>
      <h2><?php echo $heading_title; ?></h2>
      <?php if ($thumb || $description) { ?>
      <div class="row">
        <?php if ($thumb) { ?>
        <div class="col-sm-2"><img src="<?php echo $thumb; ?>" alt="<?php echo $heading_title; ?>" title="<?php echo $heading_title; ?>" class="img-thumbnail" /></div>
        <?php } ?>
        <?php if ($description) { ?>
        <div class="col-sm-10"><?php echo $description; ?></div>
        <?php } ?>
      </div>
      <hr>
      <?php } ?>
      <?php if ($categories) { ?>
      <h3><?php echo $text_refine; ?></h3>
      <?php if (count($categories) <= 5) { ?>
      <div class="row">
        <div class="col-sm-3">
          <ul>
            <?php foreach ($categories as $category) { ?>
            <li><a href="<?php echo $category['href']; ?>"><?php echo $category['name']; ?></a></li>
            <?php } ?>
          </ul>
        </div>
      </div>
      <?php } else { ?>
      <div class="row">
        <?php foreach (array_chunk($categories, ceil(count($categories) / 4)) as $categories) { ?>
        <div class="col-sm-3">
          <ul>
            <?php foreach ($categories as $category) { ?>
            <li><a href="<?php echo $category['href']; ?>"><?php echo $category['name']; ?></a></li>
            <?php } ?>
          </ul>
        </div>
        <?php } ?>
      </div>
      <?php } ?>
      <?php } ?>
      <?php if ($products) { ?>
      <p><a href="<?php echo $compare; ?>" id="compare-total"><?php echo $text_compare; ?></a></p>
      <div class="row">
        <div class="col-md-4">
          <div class="btn-group hidden-xs">
            <button type="button" id="list-view" class="btn btn-default" data-toggle="tooltip" title="<?php echo $button_list; ?>"><i class="fa fa-th-list"></i></button>
            <button type="button" id="grid-view" class="btn btn-default" data-toggle="tooltip" title="<?php echo $button_grid; ?>"><i class="fa fa-th"></i></button>
          </div>
        </div>
        <div class="col-md-2 text-right">
          <label class="control-label" for="input-sort"><?php echo $text_sort; ?></label>
        </div>
        <div class="col-md-3 text-right">
          <select id="input-sort" class="form-control" onchange="location = this.value;">
            <?php foreach ($sorts as $sorts) { ?>
            <?php if ($sorts['value'] == $sort . '-' . $order) { ?>
            <option value="<?php echo $sorts['href']; ?>" selected="selected"><?php echo $sorts['text']; ?></option>
            <?php } else { ?>
            <option value="<?php echo $sorts['href']; ?>"><?php echo $sorts['text']; ?></option>
            <?php } ?>
            <?php } ?>
          </select>
        </div>
        <div class="col-md-1 text-right">
          <label class="control-label" for="input-limit"><?php echo $text_limit; ?></label>
        </div>
        <div class="col-md-2 text-right">
          <select id="input-limit" class="form-control" onchange="location = this.value;">
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
      <br />
      <div class="row">
        <?php foreach ($products as $product) { ?>
        <div class="product-layout product-list col-xs-12">
          <div class="product-thumb">
            <div class="image"><a href="<?php echo $product['href']; ?>"><img src="<?php echo $product['thumb']; ?>" alt="<?php echo $product['name']; ?>" title="<?php echo $product['name']; ?>" class="img-responsive" /></a></div>
            <div>
              <div class="caption">
                <h4><a href="<?php echo $product['href']; ?>"><?php echo $product['name']; ?></a></h4>
                <p><?php echo $product['description']; ?></p>
                <?php if ($product['rating']) { ?>
                <div class="rating">
                  <?php for ($i = 1; $i <= 5; $i++) { ?>
                  <?php if ($product['rating'] < $i) { ?>
                  <span class="fa fa-stack"><i class="fa fa-star-o fa-stack-2x"></i></span>
                  <?php } else { ?>
                  <span class="fa fa-stack"><i class="fa fa-star fa-stack-2x"></i><i class="fa fa-star-o fa-stack-2x"></i></span>
                  <?php } ?>
                  <?php } ?>
                </div>
                <?php } ?>
                <?php if ($product['price']) { ?>
                <p class="price">
                  <?php if (!$product['special']) { ?>
                  <?php echo $product['price']; ?>
                  <?php } else { ?>
                  <span class="price-new"><?php echo $product['special']; ?></span> <span class="price-old"><?php echo $product['price']; ?></span>
                  <?php } ?>
                  <?php if ($product['tax']) { ?>
                  <span class="price-tax"><?php echo $text_tax; ?> <?php echo $product['tax']; ?></span>
                  <?php } ?>
                </p>
                <?php } ?>
              </div>
              <div class="button-group">
                <button type="button" onclick="cart.add('<?php echo $product['product_id']; ?>', '<?php echo $product['minimum']; ?>');"><i class="fa fa-shopping-cart"></i> <span class="hidden-xs hidden-sm hidden-md"><?php echo $button_cart; ?></span></button>
                <button type="button" data-toggle="tooltip" title="<?php echo $button_wishlist; ?>" onclick="wishlist.add('<?php echo $product['product_id']; ?>');"><i class="fa fa-heart"></i></button>
                <button type="button" data-toggle="tooltip" title="<?php echo $button_compare; ?>" onclick="compare.add('<?php echo $product['product_id']; ?>');"><i class="fa fa-exchange"></i></button>
              </div>
            </div>
          </div>
        </div>
        <?php } ?>
      </div>
      <div class="row">
        <div class="col-sm-6 text-left"><?php echo $pagination; ?></div>
        <div class="col-sm-6 text-right"><?php echo $results; ?></div>
      </div>
      <?php } ?>
      <?php if (!$categories && !$products) { ?>
      <p><?php echo $text_empty; ?></p>
      <div class="buttons">
        <div class="pull-right"><a href="<?php echo $continue; ?>" class="btn btn-primary"><?php echo $button_continue; ?></a></div>
      </div>
      <?php } ?>
      <?php echo $content_bottom; ?></div>
    <?php echo $column_right; ?></div>
</div>
*/ ?>
<?php echo $footer; ?>














