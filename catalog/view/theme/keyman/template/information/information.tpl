<?php echo $header; ?>
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
<div class=" information">
	<?php /*/ ?>
<?php if (isset($custom_breadcrumbs)) 
{?>
	<section class="blog-nav">
	   <div class="container-fluid">
	    <div class="col-xs-12">
	        <div class="about-menu">
	            <ul>
	        	<?php foreach ($custom_breadcrumbs as $bkey => $crumb) 
	        	{?>
	                <li <?php if(isset($crumb["active"])) {?> class="active" <?php } ?>><a href="<?php echo $crumb["href"]; ?>"><?php echo $crumb["text"]; ?></a></li>
	        	<?php } ?>
	            </ul>
	        </div>
	    </div>
	  </div>
	</section>
<?php } ?>
	<?php /*/ ?>
	<div class="container-fluid">
	<div class="col-sm-12">
	<?php echo $description; ?>
	</div>
	</div>

	
<?php echo $content_bottom; ?>

<?php if (isset($company_about))
{?>


	<section class="about-slide-block">
	    <div class="container-fluid">
	        <div class="col-sm-12">
	            <div class="slider">
	            	<?php foreach ($banner as $bkey => $slide) 
	            	{?>
	                <div class="item"><img src="<?php echo $slide['image']; ?>" alt="<?php echo $slide['title']; ?>"></div>
	            	<?php } ?>
	            </div>
	        </div>
	    </div>
	</section>

	<section class="video-reviews">
	   <div class="container-fluid">
	    <h3 class="about-reviews-title">Видео отзывы</h3>
	     <div class="reviws-block">
	         <div class="col-sm-6">
	            <div class="video">
	                <?php echo html_entity_decode($left_video['description'], ENT_QUOTES, 'UTF-8'); ?>
	            </div>
	         </div>
	         <div class="col-sm-6">
	            <div class="video">
	               <?php echo html_entity_decode($right_video['description'], ENT_QUOTES, 'UTF-8'); ?>
	            </div>
	         </div>
	         <div class="clearfix"></div>
	     </div>
	     </div>
	 </section>


	 <section class="about-company-reviews-block">
	     <div class="container-fluid">
	         <h3 class="about-reviews-title">Отзывы</h3>
	         <?php foreach ($reviews as $rkey => $review) 
	         {?>
	         <div class="col-sm-6 col-md-4">
	             <div class="about-company-reviews">
	                <div class="text-center">
	                     <img src="<?php echo $review['image']; ?>">
	               </div>
	                 <div class="ab-comp-rev-title">
	                 <span><?php echo $review['author']; ?>
	                <?php if ($review['age']!="") { ?> 	, <?php echo $review['age']; ?> лет <?php } ?></span>
	                 </div>
	                 <p>

	                 	<?php
	                 	$review['text'] = mb_substr($review['text'], 0, 205, 'UTF-8') . '...';

	                 	 echo $review['text']; 
	                 	 ?>
	                 </p>
	             </div>
	             <div class="btn_disp_on">
	                 <a class="btn btn-default " href="<?php echo $reviews_link; ?>">Подробнее</a>
	                 </div>
	         </div>
	         <?php } ?>
	         <div class="clearfix"></div>
	         <div class="col-sm-6 col-md-4 btn_disp_off"><a class="btn btn-default" href="<?php echo $reviews_link; ?>">Подробнее</a> </div>
	         <div class="col-sm-6 col-md-4 btn_disp_off"><a class="btn btn-default" href="<?php echo $reviews_link; ?>">Подробнее</a> </div>
	         <div class="col-sm-6 col-md-4 btn_disp_off"><a class="btn btn-default" href="<?php echo $reviews_link; ?>">Подробнее</a> </div>
	     <div class="clearfix"></div>
	 </section>

	 <div class="about-comp-btns col-sm-12">
	     <div class="col-sm-6">
	         <a class="white-a" href="#modal-question" data-toggle="modal" data-target="#modal-question"><button class="btn btn-default btn-block btn-lg">Задать вопрос</button></a>
	     </div>
	     <div class="col-sm-6">
	         <a class="white-a" href="#modal-review" data-toggle="modal" data-target="#modal-review"><button class="btn btn-default btn-block btn-lg">Оставить отзыв</button></a>
	     </div>
	 </div>


	 <section class="about-comp-contact">
	     <div class="container-fluid">
	         <h3 class="about-reviews-title">Контакты</h3>
	         <div class="ab-comp-cont-text">
	             <div class="col-sm-6">
	                 <div class="contact-title">
	                     <span>Телефон:</span>
	                 </div>
	                 <div class="contact-text">
	                     <span><?php echo $config_telephone; ?></span>
	                 </div>
	                 
	                 <div class="contact-title">
	                     <span>Часы работы:</span>
	                 </div>
	                 <div class="contact-text">
	                     <span><?php echo $config_open; ?></span>
	                 </div>
	                               
	                 <div class="contact-title">
	                     <span>Электронная почта:</span>
	                 </div>
	                 <div class="contact-text">
	                     <span class="mail"><?php echo $config_email; ?></span>
	                 </div>
	                 
	                 <div class="contact-title">
	                     <span>Адрес:</span>
	                 </div>
	                 <div class="contact-text">
	                     <span><?php echo $config_address; ?></span>

	                 </div>
	             </div>

	             <div class="col-sm-6">
	                 <div class="ab-comp-contacts-rekvizit">
	                     <div class="contact-title">Реквизиты и юридический адрес:</div>
	                        <div class="contact-text">
	                        	<?php echo $config_comment; ?>
	                     </div>
	                 </div>
	             </div>
	             
	         </div>
	     </div>
	 </section>

	 <div class="container-fluid">
	   <div class="col-md-12">
	     <div class="maps">
	<!--        <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d2350.5701556396643!2d27.551197752938645!3d53.903843612741326!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x46dbcfeba0413c91%3A0xe0fb783d2af93747!2z0YPQu9C40YbQsCDQndC10LzQuNCz0LAgMywg0JzQuNC90YHQuiwg0JHQtdC70LDRgNGD0YHRjA!5e0!3m2!1sru!2sru!4v1468789357268" width="100%" height="450" frameborder="0" style="border:0" allowfullscreen>  -->
	<iframe src="https://www.google.com/maps/d/embed?mid=1QoNskzhEHrvMbwEjEDgEohDgVBQ" width="100%" height="450" frameborder="0" style="border:0" allowfullscreen> 
	       </iframe>
	       </div>
	     <div class="clearfix"></div>
	   </div>
	 </div>

	    <div class="modal fade" id="modal-question" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	 <div class="modal-dialog modal-sm">
	   <div class="modal-content">
	     
	     <div class="modal-body pb0">
	       
	       <div class="">
	           <form action="https://keyman.by/index.php?route=information/contact" method="post" enctype="multipart/form-data">
	               <div class="form-group">
	                 <input type="text" class="form-control uprc" name="name" placeholder="Имя">
	               </div>
	                                
	                <div class="form-group">
	                 <input type="text" class="form-control uprc" name="email" placeholder="E-mail">
	               </div>
	               
	               <div class="form-group mb0">
	                   <textarea rows="5" name="enquiry" class="text-style">Вопрос</textarea>
	               </div>
	               
	                <div class="row form-group">
	               <div class="">
	               	<input type="submit" class="btn btn-primary pull-right uprc ml10" value="Задать вопрос">
	               </div>
	               
	           </div>
	           </form>
	       </div>
	     </div>
	     </div>
	      </div>
	   </div>


	 <div class="modal fade" id="modal-review" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	 <div class="modal-dialog modal-sm">
	   <div class="modal-content">
	     <button type="button" class="close redclose" id="close_review" data-dismiss="modal" aria-hidden="true"></button>
	     <div class="modal-header border-none">
	         <h3 class="h2 ttu"><span>Оставить отзыв</span></h3>
	     </div>
	     <div class="modal-body pb0">
	       
	       <div class="">
	           <form enctype="multipart/form-data" id="form_review" class="form-horizontal">
	               <div class="form-group">
	               	<input type="text" class="form-control uprc" id="recipient-name" name="name" placeholder="Имя Фамилия" required="required">
	       
	               </div>
	                <div class="form-group">
	                  <input type="text" name="email" class="form-control uprc" placeholder="E-mail">
	                </div>
	                <div class="form-group">
	                 <input type="text" name="age" class="form-control uprc" placeholder="Возраст">
	               </div>
	               
	 <!--                <div class="form-group">
	                 <input type="text" class="form-control uprc" placeholder="E-mail">
	               </div> -->
	               
	                   
	               <label class="file_upload">
	                   <span class="button">Загрузить фото</span>
	                   <mark>&nbsp;</mark>
	                   <input type="file" name="image">
	               </label>
	               
	               <div class="form-group mb0">
	                   <textarea rows="5" name="text"  class="text-style">Отзыв</textarea>
	               </div>

	               <input type="hidden" name="rating" value="0">
	               
	                <div class="row form-group">
	               <div class=""><button id="button-review" type="button" class="btn btn-primary pull-right uprc ml10">Оставить отзыв</button></div>
	               
	           </div>
	           </form>
	       </div>
	     </div>
	     </div>
	      </div>
	   </div>


	 <script type="text/javascript">
	 //USAGE: $("#form").serializefiles();
	 (function($) {
	 $.fn.serializefiles = function() {
	     var obj = $(this);
	     /* ADD FILE TO PARAM AJAX */
	     var formData = new FormData();
	     $.each($(obj).find("input[type='file']"), function(i, tag) {
	         $.each($(tag)[0].files, function(i, file) {
	             formData.append(tag.name, file);
	         });
	     });
	     var params = $(obj).serializeArray();
	     $.each(params, function (i, val) {
	         formData.append(val.name, val.value);
	     });
	     return formData;
	 };
	 })(jQuery);


	     $('#button-review').on('click', function() 
	     {

	           var form = document.forms.form_review;

	             var formData = new FormData(form);  

	             var xhr = new XMLHttpRequest();
	             xhr.open("POST", "index.php?route=product/product/write&product_id=0");

	             xhr.onreadystatechange = function() {
	                 if (xhr.readyState == 4) {
	                     if(xhr.status == 200) {
	                         data = xhr.responseText;
	                         var json=JSON.parse(data);
	                         if (json['error']) {
	                             alert(json['error']);
	                         }
	                         if (json['success']) {
	                             $("#close_review").click();
	                         }
	                     }
	                 }
	             };
	             
	             xhr.send(formData);


	     });
	 </script>

<?php } ?>


<?php if (isset($sales))
{?>

	<section class="sales-partners">
	    <div class="container-fluid">
	        <h2 class="text-center h1">
	        	<!-- <a href="#"> -->
	        		<span>Партнеры</span>
	        	<!-- </a> -->
	        </h2>
	        <div class="partners">
	        		<?php foreach ($banner as $bkey => $slide) 
	        		{?>
	        	    <div class="partner"><img src="<?php echo $slide['image']; ?>" alt="<?php echo $slide['title']; ?>"><div class="partner-sale"><?php echo $slide['link']; ?></div></div>
	        		<?php } ?>
	       </div>
	       <div class="text-center mt40 mb30">
	           <a href="#sales-partners" class="a-style" data-toggle="modal" data-target="#sales-partners">Посмотреть все скидки от партнеров</a>
	        </div>
	    </div>
	</section>

	    <div class="modal fade" id="sales-partners" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	  <div class="modal-dialog modal-lg">
	    <div class="modal-content">
	      <div class="modal-header">
	        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
	          <h4 class="ttu h1 mb0"><span>Система скидок</span></h4>
	      </div>
	      <div class="modal-body text-center">
	          <div class="table-responsive">
	             <table class="sales-table">
	                <tbody>
	                	<?php foreach ($banner as $bkey => $slide) 
	                	{?>
	             		<tr>
	                        <td class="col-sm-4">
	                        	<div class="partner">
	                        		<img src="<?php echo $slide['image']; ?>">
	                        		<br>
	                        		<div class="partner-sale"><?php echo $slide['link']; ?></div>
	                            </div>
	                        </td>
	                        <td class="col-sm-4"><?php echo $slide['title']; ?></td>
	                        <td class="col-sm-4"><?php echo $slide['text']; ?></td>
	                    </tr>
	                    <?php } ?>
	                </tbody>
	             </table>
	          </div>
	      </div>
	      
	    </div><!-- /.modal-content -->
	  </div><!-- /.modal-dialog -->
	</div><!-- /.modal --> 

<?php } ?>


<?php if (isset($rules)) 
{ ?>
<!-- УСЛОВИЯ ИСПОЛЬЗОВАНИЯ СЕРТИФИКАТА -->
<div class="modal fade" id="condition" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title">Условия использования подарочного сертификата</h4>
      </div>
      <div class="modal-body">
        <p><?php echo html_entity_decode($rules); ?></p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Закрыть</button>
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal --> 
<?php } ?>

</div>

<?php echo $footer; ?>