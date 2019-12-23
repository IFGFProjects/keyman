<?php echo $header; ?>

<link href="catalog/view/javascript/jquery/owl-carousel/owl.carousel.css" type="text/css" rel="stylesheet" media="screen">

<link href="catalog/view/javascript/lightgallery/lightgallery.css" type="text/css" rel="stylesheet" media="screen">
<script src="catalog/view/javascript/lightgallery/lightgallery.min.js" type="text/javascript"></script>
<script src="catalog/view/javascript/lightgallery/lg-thumbnail.min.js" type="text/javascript"></script>
<script src="catalog/view/javascript/lightgallery/lg-zoom.js" type="text/javascript"></script>
<script src="catalog/view/javascript/lightgallery/lg-video.js" type="text/javascript"></script>

<script src="catalog/view/theme/keyman/js/swipe_hammer.js" type="text/javascript"></script>


<style>



@media (max-width: 479px) {
  .mini-img2.hidden {
    display: block !important;
  }
  .mini-img2 #ytplayer2{
    width: 100% !important;
  }
  .thumbs {
    display: initial;
  }

  .owl-dots {
    position: absolute;
    top: auto;
    left: 0;
    bottom: 10px;
    width: 100%;
    text-align: center;
  }
  .mini-img2 .owl-controls .owl-dot {
    display: inline-block;
    margin: 0px 6px;
  }
  .mini-img2.owl-carousel .owl-dot span{
    display: block;
    width: 6px;
    height: 6px;
    background: rgb(151, 151, 151);
    border-radius: 20px;
    box-shadow: inset 0 0 3px rgba(0,0,0,0.3);
    border: 1px solid white;
    margin-bottom: 2px;
    transition: all 0.3s;
    -webkit-transition: all 0.3s;
    -moz-transition: all 0.3s;
    -o-transition: all 0.3s;
  }
  .mini-img2.owl-carousel .owl-dot.active span {
    width: 11px;
    height: 11px;
    margin-bottom: 0px;
  }
  .owl-carousel .owl-nav div {
    font-size: 30px;
    color: rgb(151, 151, 151);
    opacity: 1 !important;
  }
  .owl-carousel .owl-nav div {
    opacity: 1;
    height: 90%;
    vertical-align: middle;
    display: flex;
    top: 0 !important;
    align-items: center;
    position: absolute;
  }
  .owl-carousel .owl-nav .owl-next {
      right: 0px;
  }
  .owl-carousel .owl-nav .owl-prev {
      left: 0px;
  }
  .lg-sub-html {
    display: none;
  }
  .lg-outer .lg-video-cont, .lg-outer .lg-video {
    height: 80%;
  }
  .thumbs.active, .mini-img2 a {
      border: none;
  }
  .owl-carousel .video .overlay_video{
    position: absolute;
    width: 100%;
    height: 100%;
  }
}

</style>

<section class="category-title">
    <h1 class="ttu h1 mb0"><?php echo $heading_title; ?></h1>
</section>

<div class="container-fluid">
       <ol class="breadcrumb crumbstyle ">
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



<section class="product-block" id="product">
    <div class="container-fluid">
        <div class="col-md-8 col-sm-7">
           <div id="product-gallery">
           <div class="row">
               <div class="col-sm-9 col-md-10 pos_rel hidden-xs">
                    <div class="product-img text-center img_block">
                      <a href="<?php echo $image_orig; ?>" rel="product" class="fancy"> 
                      <img src="<?php echo $image_orig; ?>" data-large="<?php echo $image_orig; ?>" class="zoom-photo" id="main-image" title="<?php echo $heading_title; ?>"> 
                      </a>
                    </div>
                    <?php if ($video_code) { ?>
                    <div class="video_block product-img text-center off">

                    </div>
                     <?php } ?>
                </div>
               
                <div class="col-sm-3 col-md-2">
                  <div class="mini-img hidden-xs">
                   <a href="<?php echo $image_orig; ?>" rel="product" class="thumbs active" data-image="<?php echo $image_orig; ?>"><img src="<?php echo $thumb; ?>" onclick="$('.video_block').removeClass( 'active' );$('#product-gallery .product-img.img_block').removeClass( 'off' );$('.video_block').html( '' );  "></a>
                   <?php if ($images) { ?>
                   <?php foreach ($images as $image) { ?>

                   <a href="<?php echo $image['orig']; ?>" rel="product" title="<?php echo $heading_title; ?>" alt="<?php echo $heading_title; ?>" class="thumbs" data-image="<?php echo $image['orig']; ?>" onclick="$('.video_block').removeClass( 'active' );$('#product-gallery .product-img.img_block').removeClass( 'off' );$('.video_block').html( '' );  ">
                     <img src="<?php echo $image['thumb']; ?>" title="<?php echo $heading_title; ?>" alt="<?php echo $heading_title; ?>"></a>
                   <?php } ?>
                   <?php } ?>
                   <?php if ($video_code) { ?>
                   <div class="thumbs video" >
                   <i class="glyphicon glyphicon-play"><span>Видео</span>
                   </i>
                   </div>
                   <?php } ?>
                   
                   <div class="clearfix"></div>
                   </div>


                   <div class="mini-img2 hidden">
                    <a href="<?php echo $image_orig; ?>" data-src="<?php echo $image_orig; ?>" rel="product" class="thumbs active" data-image="<?php echo $image_orig; ?>">
                      <img src="<?php echo $mobile; ?>" onclick="$('.video_block').removeClass( 'active' );$('#product-gallery .product-img.img_block').removeClass( 'off' );$('.video_block').html( '' );  ">
                    </a>
                    <?php if ($images) { ?>
                    <?php foreach ($images as $image) { ?>

                    <a href="<?php echo $image['orig']; ?>" data-src="<?php echo $image['orig']; ?>" rel="product" title="<?php echo $heading_title; ?>" alt="<?php echo $heading_title; ?>" class="thumbs" data-image="<?php echo $image['orig']; ?>" onclick="$('.video_block').removeClass( 'active' );$('#product-gallery .product-img.img_block').removeClass( 'off' );$('.video_block').html( '' );  ">
                      <img src="<?php echo $image['mobile']; ?>" title="<?php echo $heading_title; ?>" alt="<?php echo $heading_title; ?>"></a>
                    <?php } ?>
                    <?php } ?>
                    <?php if ($video_code) { ?>

                    <div class="thumbs video" data-src="https://www.youtube.com/watch?v=<?php echo $video_code; ?>?loop=1" >
                       <div class="overlay_video"></div>
                       <iframe id="ytplayer2" type="text/html" src="https://www.youtube.com/embed/<?php echo $video_code; ?>?loop=1&playlist=<?php echo $video_code; ?>" loop="1" playlist="<?php echo $video_code; ?>" frameborder="0" allowfullscreen></iframe>
                    </div>
                    <?php } ?>
                    
                  </div>




                    <script>
                    $(document).ready(function(){
                          $('.video').bind('click', function() {
                              if ( $('.video').hasClass( "active" )) {
                                 // $('.video').removeClass( 'active' ); 
                                 // $('.video_block').removeClass( 'active' ); 
                                 // $('#product-gallery .product-img').removeClass( "off" );
                              } else {
                                $('.video_block').html( '<iframe id="ytplayer" type="text/html" src="https://www.youtube.com/embed/<?php echo $video_code; ?>?loop=1&playlist=<?php echo $video_code; ?>&autoplay=1" autoplay="1" loop="1" playlist="<?php echo $video_code; ?>" frameborder="0" allowfullscreen></iframe>' ); 
                                
                                $('.video').addClass( "active" ); 
                                $('.img_block').addClass( "active" ); 
                                $('#product-gallery .product-img.img_block').addClass( "off" );
                                $('.video_block').addClass( "active" );
                                $('.video_block').removeClass( "off" );
                              }
                            });



$('.mini-img2').owlCarousel({
  items: 1,
  autoPlay: false,
  video:true,
  touchDrag: false,
  singleItem: false,
  <?php if ($video_code) { ?>
  // nav: true,
  <?php }else { ?>
  // nav: false,
  <?php } ?>
  navText: ['<span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>', '<span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>'],
  dots: true
});

$('.thumbnails').magnificPopup({
  type:'image',
  delegate: 'a',
  gallery: {
    enabled:true
  }
});




                      });
                   </script>
                </div>
           </div>
        </div>
        </div>
        <div class="col-md-4 col-sm-5">
            <div class="modal-product-desc">
          <?php if ($price_orig<1) {?>
          <div class="new-product-price ttu">
              <span>По запросу</span>
          </div>
          <?php } elseif (!empty($strike_price) ) {?>
          <!-- discount -->
          <div class="old-product-price ttu">
                <span style='color:#751c1c;text-decoration:line-through'>
                <span style="color: #3a383a;">Цена: <?php echo $strike_price; ?></span>
                </span>
            </div>
          <div class="new-product-price ttu">
              <span>Цена: <?php echo $price; ?></span>
          </div>
          <?php } elseif (!empty($special)) 
          {?>
          <!-- special -->
          <div class="old-product-price ttu">
                <span style='color:#751c1c;text-decoration:line-through'>
                <span style="color: #3a383a;">Цена: <?php echo $price; ?></span>
                </span>
            </div>
          <div class="new-product-price ttu">
              <span>Цена: <?php echo $special; ?></span>
          </div>
          <?php }  else { ?>
          <!-- main price -->
            <div class="new-product-price ttu">
                <span>Цена: <?php echo $price; ?></span>
            </div>
          <?php } ?>
            

<!--         <div class="product-color">
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
        <?php // echo "<h1 style='color:red;'>attribute_groups :</h1><pre>";print_r($attribute_groups);echo "</pre><hr>"; ?>
        <?php if (isset($attribute_groups[63]['attribute']))
          foreach ($attribute_groups[63]['attribute'] as $key => $attr) 
        {?>
        <div class="product-size">
          <div id="input-option" class="custom_h4"><?php echo $attr['name'].": ".$attr['text']; ?></div>
        </div>
        <?php } ?>
        <div class="product-size">
          <?php 
          if ($options)
            foreach ($options as $optkey => $option) 
            {if ($option['option_id']==13) {
            ?>
              <div id="input-option<?php echo $option['product_option_id'];?>" class="custom_h4"><?php echo $option['name']; ?>:</div>
              <?php foreach ($option['product_option_value'] as $option_value) 
                { ?>
                  <label class="radio-inline" >
                      <input type="radio" name="option[<?php echo $option['product_option_id']; ?>]" value="<?php echo $option_value['product_option_value_id']; ?>"><span><?php echo $option_value['name']; ?></span>
                  </label>
          <?php } ?>
      <?php }} ?>
        </div>
          <div class="product-description">
              <?php if ($manufacturer && false) { ?>
             <div class="mt10">Бренд:  <?php echo $manufacturer; ?></div>
             <?php } ?>
             <div class="mt10">Артикул:  <?php echo $model; ?></div>
              <?php foreach ($attribute_groups as $attribute_group) { ?>
                <?php foreach ($attribute_group['attribute'] as $atr_id => $attribute) { 
                        if ( ($atr_id!=41) ) { ?>
                <div class="mt5"><?php echo $attribute['name']; ?>: <?php echo $attribute['text']; ?></div>
                <?php } } ?>
              <?php } ?> 
              <?php if (isset($attribute_groups[61]['attribute'][41]['text'])) { ?>
              <div class="mt5">
                  <a href="#" data-toggle="popover" data-html="true" data-placement="bottom" data-trigger="hover" data-content="
                  <?php echo $attribute_groups[61]['attribute'][41]['text']; ?>
                  "><span class="underline-pointer">Рекомендации по уходу</span></a>
              </div>
              <?php } ?>
              <div class="mt10">
                  <a href="#jacket-size" data-toggle="modal" data-target="#jacket-size"><span class="underline-pointer">Таблица размеров</span></a>
              </div>
              <?php if ($logged) { ?>
              <div class="mt10">
                  <a style="cursor:pointer;" onclick="wishlist.add('<?php echo $product_id; ?>');"><span class="underline-pointer">Добавить в закладки</span></a>
              </div>
              <?php } ?>
          
          </div>
                 
                  <div class="product-buy mt20">
                      <div class="page-product-count">
                          <div class="prod-count"><span class="minus"></span><input class="form-control input-lg" type="text" name="quantity" value="1"><span class="plus"></span></div>
                          <input type="hidden" name="product_id" value="<?php echo $product_id; ?>">

                      </div>
                  
                     <button id="button-cart" class="btn btn-primary btn-lg ttu" data-toggle="modal">В корзину</button>
                     </div>
                     <button class="btn btn-default btn-lg ttu mt10" data-toggle="modal" data-target="#quick-order<?php echo $product_id; ?>">Купить в один клик</button>

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
                                           <div class="modal-product-title h2"><?php echo $heading_title; ?></div>
                                           <div class="modal-product-price h2">
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
                                           </div>

                                           <div class="product-size">
                                               <div class="custom_h4">Размер:</div>
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
                                                 <div class="custom_h4">Кол-во:</div>
                                                 <input type="hidden" value="<?php echo $price_orig; ?>" id="price_orig<?php echo $product_id; ?>">
                                                 <div class="prod-count"><span class="minus" id="minus<?php echo $product_id; ?>"></span><input class="form-control" name="amount<?php echo $product_id; ?>" id="amount<?php echo $product_id; ?>" type="text" value="1"><span class="plus" id="plus<?php echo $product_id; ?>"></span></div>
                                             </div>
                                             <div class="pull-left col-xs-9 pl10 p0">
                                                <div class="custom_h4">Итоговая стоимость:</div>
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
                     
                     <div class="product-description-text">
                         <div class="product-text-title h4">Описание:</div>
                          <?php echo $description; ?>
                    </div>   


<?php if ($tags) { ?>
<div class="tags_product">
  <span class="title_tags">Тэги:</span>
                <?php   
                $total_tag = count($tags);
                $count_tag = 0;
                foreach ($tags as $tag) {  $count_tag++;?>  
                 <a class="one_tag" href="<?php echo $tag['href']; ?>"><?php echo $tag['tag']; ?><?php  if ($count_tag == $total_tag){ echo "."; } else { echo ","; }  ?></a>
                 
               <?php } ?> 

 

</div>
<?php } ?>


      <div class="clearfix"></div>
                
        </div>
        </div>  
    </div>
</section>

<section class="recomend">
    <div class="text-center h1 ttu"><span>Дополни ансамбль</span></div>
    <?php foreach ($products as $pkey => $product) 
    { ?>
    <div class="col-sm-4">
                <div class="product-cart" >
                  <a href="<?php echo $product['href']; ?>"><img src="<?php echo $product['thumb']; ?>"></a>
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
                  </div>
                  <?php } ?>


                  <?php if ($product['price']!=0) { ?>
                  <?php if ($price_orig<1) {?>
                  <div class="product-buttons">
                   <button class="btn btn-default btn-buy" data-toggle="modal" data-target="#quick-order<?php echo $product['product_id']; ?>">Купить</button>
                  <!-- <button class="btn btn-default btn-cart" data-toggle="modal" data-target="#quick-cart">В корзину</button> -->
                  </div>
                  <?php } ?>
                  <?php } else { ?>
                  <div class="product-buttons none">
                   <button class="btn btn-default btn-buy" data-toggle="modal" data-target="#quick-order<?php echo $product['product_id']; ?>">Купить</button>
                  <!-- <button class="btn btn-default btn-cart" data-toggle="modal" data-target="#quick-cart">В корзину</button> -->
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
                          <div class="modal-product-title h2"><?php echo $product['name']; ?></div>
                          <div class="modal-product-price h2"><?php echo $product['price']; ?></div>

                          <div class="product-size">
                              <div class="custom_h4">Размер:</div>
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
                                <div class="custom_h4">Кол-во:</div>
                                <input type="hidden" value="<?php echo $product['price_orig']; ?>" id="price_orig<?php echo $product['product_id']; ?>">
                                <div class="prod-count"><span class="minus" id="minus<?php echo $product['product_id']; ?>"></span><input class="form-control" name="amount<?php echo $product['product_id']; ?>" id="amount<?php echo $product['product_id']; ?>" type="text" value="1"><span class="plus" id="plus<?php echo $product['product_id']; ?>"></span></div>
                            </div>
                            <div class="pull-left col-xs-9 pl10 p0">
                               <div class="custom_h4">Итоговая стоимость:</div>
                               <div class="total-price h2" id="price_tr<?php echo $product['product_id']; ?>">
                                  <?php echo $product['price']; ?>
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
                    data['size']    = $('#size<?php echo $product['product_id'];?>').attr("text-value");


                    $.ajax({
                        url: 'index.php?route=product/fastorder/sender',
                        type: 'post',
                        data: {name: data['name'], phone: data['phone'], mail: data['mail'], address: data['address'], comment: data['comment'], heading_title: data['heading_title'], amount: data['amount'], size: data['size'], price: data['price'] ,product_id: data['product_id']},
                        dataType: 'json',
                        beforeSend: function() {
                            // Do form valdation
                            if (!$('#name<?php echo $product['product_id'];?>').val()
                                    || !$('#phone<?php echo $product['product_id'];?>').val()
                                    || !$('#size<?php echo $product['product_id'];?>').val()
                                    || !$('#mail<?php echo $product['product_id'];?>').val())
                            {
                                $('#error-msg').show();
                                return false;
                            }
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

    <div class="clearfix"></div>
</section>


 <div class="modal fade" id="quick-cart" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close redclose" data-dismiss="modal" aria-hidden="true"></button>
          <div class="modal-title h2 ttu"><span>Товар добавлен в корзину</span></div>
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





    <div class="modal fade" id="jacket-size" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
          <section class="category-title">
          <div class="modal-title fs20 h4"><strong>Таблица размеров</strong></div>
      </section>
      </div>
      <div class="modal-body text-center">
          <div class="table-responsive">
            <?php 
              if (isset($cat_add_data))
                {echo $cat_add_data;}
             ?>
          </div>
      </div>
      
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal --> 
<!-- END NEW FRONTEND -->


<?php echo $content_bottom; ?>

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
$('#button-cart').on('click', function(e) {
  e.preventDefault();
	$.ajax({
		url: 'index.php?route=checkout/cart/add',
		type: 'post',
		data: $('#product input[type=\'text\'], #product input[type=\'hidden\'], #product input[type=\'radio\']:checked, #product input[type=\'checkbox\']:checked, #product select, #product textarea'),
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

        $("#quick-cart").modal("show");
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
<script type="text/javascript"><!--
$('.date').datetimepicker({
	pickTime: false
});

$('.datetime').datetimepicker({
	pickDate: true,
	pickTime: true
});

$('.time').datetimepicker({
	pickDate: false
});

$('button[id^=\'button-upload\']').on('click', function() {
	var node = this;

	$('#form-upload').remove();

	$('body').prepend('<form enctype="multipart/form-data" id="form-upload" style="display: none;"><input type="file" name="file" /></form>');

	$('#form-upload input[name=\'file\']').trigger('click');

	if (typeof timer != 'undefined') {
    	clearInterval(timer);
	}

	timer = setInterval(function() {
		if ($('#form-upload input[name=\'file\']').val() != '') {
			clearInterval(timer);

			$.ajax({
				url: 'index.php?route=tool/upload',
				type: 'post',
				dataType: 'json',
				data: new FormData($('#form-upload')[0]),
				cache: false,
				contentType: false,
				processData: false,
				beforeSend: function() {
					$(node).button('loading');
				},
				complete: function() {
					$(node).button('reset');
				},
				success: function(json) {
					$('.text-danger').remove();

					if (json['error']) {
						$(node).parent().find('input').after('<div class="text-danger">' + json['error'] + '</div>');
					}

					if (json['success']) {
						alert(json['success']);

						$(node).parent().find('input').attr('value', json['code']);
					}
				},
				error: function(xhr, ajaxOptions, thrownError) {
					alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
				}
			});
		}
	}, 500);
});
//--></script>
<script type="text/javascript"><!--
$('#review').delegate('.pagination a', 'click', function(e) {
    e.preventDefault();

    $('#review').fadeOut('slow');

    $('#review').load(this.href);

    $('#review').fadeIn('slow');
});

$('#review').load('index.php?route=product/product/review&product_id=<?php echo $product_id; ?>');

$('#button-review').on('click', function() {
	$.ajax({
		url: 'index.php?route=product/product/write&product_id=<?php echo $product_id; ?>',
		type: 'post',
		dataType: 'json',
		data: $("#form-review").serialize(),
		beforeSend: function() {
			$('#button-review').button('loading');
		},
		complete: function() {
			$('#button-review').button('reset');
		},
		success: function(json) {
			$('.alert-success, .alert-danger').remove();

			if (json['error']) {
				$('#review').after('<div class="alert alert-danger"><i class="fa fa-exclamation-circle"></i> ' + json['error'] + '</div>');
			}

			if (json['success']) {
				$('#review').after('<div class="alert alert-success"><i class="fa fa-check-circle"></i> ' + json['success'] + '</div>');

				$('input[name=\'name\']').val('');
				$('textarea[name=\'text\']').val('');
				$('input[name=\'rating\']:checked').prop('checked', false);
			}
		}
	});
});

$(document).ready(function() {
 

  $(".mini-img2 .owl-stage").lightGallery( {
      download: false,
      subHtmlSelectorRelative: false,
      selector:'.thumbs' ,
      thumbnail:true,
      videoMaxWidth:'800px',
      loadYoutubeThumbnail: true,
      youtubeThumbSize: 'default',
      loadVimeoThumbnail: true,
      vimeoThumbSize: 'thumbnail_medium'
       }
      ); 
 


    var hammer = new Hammer(document.querySelector('.owl-carousel'));
    var $carousel = $(".owl-carousel").carousel({"interval":0});
    hammer.get("swipe");
    hammer.on("swipeleft", function(){
        $carousel.trigger('next.owl.carousel');
    });
    hammer.on("swiperight", function(){
        $carousel.trigger('prev.owl.carousel');
    });

    $(".owl-carousel .video .overlay_video").on("swipeleft", function(){
        $carousel.trigger('next.owl.carousel');
    });
    $(".owl-carousel .video .overlay_video").on("swiperight", function(){
        $carousel.trigger('prev.owl.carousel');
    });

});
//--></script>



<?php if ($video_code) { ?>
<script>
$(document).ready(function() {
  var height_video = $(".mini-img2 .owl-stage .owl-item:last-child").prev().height();

  height_video=  height_video + "px"

  $(".mini-img2 .owl-stage #ytplayer2").height(height_video);
  




  });
</script>
<?php } ?>








<?php echo $footer; ?>
