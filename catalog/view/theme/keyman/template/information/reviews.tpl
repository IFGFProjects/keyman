<?php echo $header; ?>
<section class="category-title">
    <h1 class="ttu h1 mb0"><?php echo $heading_title; ?></h1>
</section>
<div class="container-fluid">
       <ol class="breadcrumb crumbstyle">
        <li><a href="https://keyman.by">Главная</a></li>
        <!--<li>Отзывы</li>-->

      </ol>
</div><?php /*/ ?>
<section class="blog-nav">
   <div class="container-fluid">
    <div class="col-xs-12">
        <div class="about-menu">
            <ul>
        	<?php foreach ($breadcrumbs as $bkey => $crumb)
        	{?>
                <li <?php if(isset($crumb["active"])) {?> class="active" <?php } ?>><a href="<?php echo $crumb["href"]; ?>"><?php echo $crumb["text"]; ?></a></li>
        	<?php } ?>
            </ul>
        </div>
    </div>
  </div>
</section>
<?php /*/ ?>
<section class="reviews-block">
    <div class="container-fluid">
        <div class="col-md-5 col-sm-12">
           <h3 class="review-title">Отзывы</h3>
           <?php foreach ($reviews as $rkey => $review) 
           {?>
            <div class="a-reviw">
                 <div class="col-sm-4">
                     <img src="<?php echo $review['image']; ?>">
                 </div>
                <div class="col-sm-8">
                    <div class="review-name">
                        <span><?php echo $review['author']; ?></span>
                        <div><?php echo $review['age']; ?> <?php if ($review['age']!='') {?>лет<?php } ?></div>
                    </div>
                </div>
                <div class="clearfix"></div>
                <div class="review-text">
                    <p>
                        <?php echo $review['text']; ?>
                    </p>
                </div>
            </div>
                 <?php if ( $review['answer_text']!="" )
                 {?>
                 <?php if ($review['answer_name']=="") {$review['answer_name']="Менеджер магазина";} ?>
                 <div class="review-answer">
                     <div class="signature"><?php echo $review['answer_name']; ?></div>
                     <div class="text-answer">
                         <p>
                             <?php echo $review['answer_text']; ?>
                         </p>
                     </div>
                 </div>
                <?php } ?>
           <?php } ?>

        </div>
        
        <div class="col-md-6 col-md-offset-1 col-sm-12 col-sm-offset-0">
            <h3 class="video-review-title">Видео отзывы</h3>
            <div class="video-reviews">
            <div class="video">
              <?php echo html_entity_decode( $video[0]['description'],ENT_QUOTES, 'UTF-8'); ?>
            </div>
            </div>
            
            <div class="video-reviews">
            <div class="video">
                <?php echo html_entity_decode( $video[1]['description'],ENT_QUOTES, 'UTF-8'); ?>
            </div>
            </div>
            
            <div class="video-reviews">
            <div class="video">
                <?php echo html_entity_decode( $video[2]['description'],ENT_QUOTES, 'UTF-8'); ?>
            </div>
            </div>
        </div>
        <div class="add-review col-xs-12">
           <div class="col-md-4 col-md-offset-4 col-sm-6 col-sm-offset-3 col-xs-offset-0 col-xs-12">
               <a class="white-a" href="#modal-review" data-toggle="modal" data-target="#modal-review"><button class="btn btn-default btn-block btn-lg">Оставить отзыв</button></a>
            </div>
            <div class="clearfix"></div>
        </div>
    </div>
    <div class="paging text-center">
<!--           <ul class="pagination">
            <li><a href="#">1</a></li>
            <li class="active"><a href="#">2</a></li>
            <li><a href="#">3</a></li>
            <li><a href="#">4</a></li>
            <li><a href="#">5</a></li>
            <li><a href="#">Следующая</a></li>
            <li><a href="#">&raquo;</a></li>
          </ul> -->
          <?php  echo $pagination; ?>
        </div>
</section>

<div class="modal fade" id="modal-review" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
<div class="modal-dialog modal-sm">
  <div class="modal-content">
    <button type="button" class="close redclose" id="close_review" data-dismiss="modal" aria-hidden="true"></button>
    <div class="modal-header border-none">
        <h3 class="h2 ttu"><span>Оставить отзыв</span></h3>
    </div>
    <div class="modal-body pb0">
      
      <div class="">
          <form enctype="multipart/form-data" id="form_review">
              <div class="form-group">
                <input type="text" name="name" class="form-control uprc" placeholder="Имя Фамилия">
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

  <?php echo $content_bottom; ?>
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
                            alert(json['success']);
                            $("#close_review").click();
                        }
                    }
                }
            };
            
            xhr.send(formData);


    });
</script>

<?php echo $footer; ?>