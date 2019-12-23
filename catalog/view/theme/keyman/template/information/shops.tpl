<?php echo $header; ?>
<div class="shops">

  <div class="row row_none"><?php echo $column_left; ?>
    <?php if ($column_left && $column_right) { ?>
    <?php $class = 'col-sm-6'; ?>
    <?php } elseif ($column_left || $column_right) { ?>
    <?php $class = 'col-sm-9'; ?>
    <?php } else { ?>
    <?php $class = 'col-sm-12'; ?>
    <?php } ?>
    <div id="content" class=" information <?php echo $class; ?>"><?php echo $content_top; ?>
      <section class="about-company-block">
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
                  <?php if ($bkey<count($breadcrumbs)-1) {?></a><?php } ?>
                </li>
                <?php } ?>          

              </ol>
        </div>
      <?php echo $description; ?>
      <?php if ($shops) { ?>
<?php foreach ($shops as $shop) { ?>
<div class="container-fluid article-block item">
<div class="col-sm-12 col-md-12 col-lg-4 text_shop">
  <div class="about-company-text-block">
    <h2 class="about-company-title"><?php echo $shop['name']; ?></h2>

      <div class="ab-comp-cont-text">
        <?php if ($shop['address']) { ?>
        <div class="contact-title"><span>АДРЕС:</span></div>
        <div class="contact-text"><span><?php echo $shop['address']; ?></span></div>
        <?php } ?>
        <?php if ($shop['telephone']) { ?>
        <div class="contact-title"><span>Телефон:</span></div>
        <div class="contact-text"><span><?php echo $shop['telephone']; ?></span></div> 
        <?php } ?> 
        <?php if ($shop['fax']) { ?>
        <div class="contact-title"><span>Факс:</span></div>
        <div class="contact-text"><span><?php echo $shop['fax']; ?></span></div>
        <?php } ?>
        <?php if ($shop['comment']) { ?>
        <div class="contact-text">
        	<?php echo $shop['comment']; ?>
        </div>
        <?php } ?>
        <?php if ($shop['open']) { ?>
        <div class="contact-title"><span>ЧАСЫ РАБОТЫ:</span></div>
        <div class="contact-text"><span><?php echo $shop['open']; ?></span></div>
        <?php } ?>

       </div>

 </div>
 <div class="product-buttons ">
 <a href="<?php echo $this_link; ?>#mapss" class="btn btn-default btn-lg">Посмотреть на карте</a>
 </div>
 </div>
<div class=" image_shop col-sm-12 col-md-12 col-lg-8 bg_<?php echo $shop['location_id']; ?>">
  <img  class="bg_none" src="<?php echo $shop['image']; ?>" alt="<?php echo $shop['address']; ?>">
  </div>


</div>



<?php } ?>
<?php } ?>

</section>



	<div class="row magaziny_callme_viewform" id="callme_viewform" role="dialog">
	  	<div  class="col-lg-6 col-md-6 col-sm-6 col-xs-12 col-lg-offset-3 col-sm-offset-3 col-md-offset-3" role="document">
		    <div class="">
		      	<div class="" style="text-align: center;">
		      		<span class="h2 modal-title about-company-title">Обратная Связь</span>
		      	</div>
		      	<div id="callmeform" class="">
		      		<div class="row">
						<div class="callme_inp_around magaziny_form_text col-lg-6 col-md-6 col-sm-6 col-xs-12">
							<div class="cme_name" style="display: block;">Имя</div>
							<input class="magaziny_cme_txt col-lg-12 col-md-12 col-sm-12 col-xs-12" type="text" maxlength="150" id="ccname" placeholder="Ваше имя">
						</div>
						<div class="callme_inp_around magaziny_form_text col-lg-6 col-md-6 col-sm-6 col-xs-12">
							<div class="cme_name" style="display: block;">Телефон</div>
							<input class="magaziny_cme_txt col-lg-12 col-md-12 col-sm-12 col-xs-12" type="text" maxlength="150" value="+375 " id="ccphone">
						</div>
					</div>
					<div class="row">
						<div class="callme_inp_around magaziny_form_big_text col-lg-12 col-md-12 col-sm-12 col-xs-12">
							<div class="" style="display: block;">Сообщение</div>
							<textarea id="ccmessage" class="magaziny_cme_txt col-lg-12 col-md-12 col-sm-12 col-xs-12" rows="5"></textarea>
						</div>
					</div>
					<div class="row" style="text-align: center; margin-bottom: 20px;">
						<div class="callme_inp_around">
							<input id="ccme_btn" class="cme_btn" type="button" value="Перезвоните мне">
						</div>
					</div>
					<div id="callme_result" class="ccallme_result" style="margin: 0px 0px 20px 0px;"></div>
				</div>
		    </div>
	  	</div>
	</div>

  <script>
    jQuery(document).ready(function($){
        jQuery("#ccphone").mask("+375(99) 999-99-99");
    });
  </script>
   
    <section class="sales-partners">
        <div class="container-fluid">
            <h2 class="text-center h1">
              
                <span>Принимаемые платежные карты</span>
              
            </h2>
            <a name="mapss"></a>
            <div class="partners">
                <?php  foreach ($banner as $bkey => $slide) 
                {?>
                  <div class="partner"><img src="<?php echo $slide['image']; ?>" alt="<?php echo $slide['title']; ?>"></div>
                <?php }  ?>
           </div>
        </div>
   
    </section>




    
    
        <div class="container-fluid">
          <div class="col-md-12">
           
            <div class="maps">
              <?php /*/ ?>
              <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d2350.5701556396643!2d27.551197752938645!3d53.903843612741326!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x46dbcfeba0413c91%3A0xe0fb783d2af93747!2z0YPQu9C40YbQsCDQndC10LzQuNCz0LAgMywg0JzQuNC90YHQuiwg0JHQtdC70LDRgNGD0YHRjA!5e0!3m2!1sru!2sru!4v1468789357268" width="100%" height="450" frameborder="0" style="border:0" allowfullscreen> 
              <?php /*/ ?>
              <iframe src="https://www.google.com/maps/d/embed?mid=1QoNskzhEHrvMbwEjEDgEohDgVBQ" width="100%" height="450" frameborder="0" style="border:0" allowfullscreen> 
              </iframe>
              </div>
            <div class="clearfix"></div>
          </div>
        </div>  
    <?php echo $column_right; ?>
    <?php echo $content_bottom; ?>
  </div>
</div>
<?php echo $footer; ?>