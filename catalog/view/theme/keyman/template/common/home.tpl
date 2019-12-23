
<?php  echo $header; ?>
        <?php echo $slider; ?>
       <section class="sale-block">
           <div class="container-fluid">
              <div class="col-sm-12">
              <div class="sale podpiska">
                <img alt="Смотреть" src="<?php echo $sale_data['image']; ?>">
                 <div class="h2-title">
                  <?php echo html_entity_decode($sale_data['text']); ?>
                  <a class="btn btn-info btn-block ttu " href="<?php echo $sale_data['link']; ?>">Смотреть</a>
               </div>
              </div>
          <a class="btn btn-info btn-block ttu podpiska_a" href="<?php echo $sale_data['link']; ?>">Смотреть</a>
<!--            <div class="news-form">
               <div class="form-title">
                   Подпишись на новости
               </div>
                <form action="#" method="post">
                    <div class="form-group">
                        <label for="newsmail" class="sr-only">E-mail:</label>
                         <input type="text" id="newsmail" class="form-control" placeholder="E-mail">
                    </div>
                    <button class="btn btn-info btn-block ttu" type="submit">Подписаться</button>
                </form>
            </div>   --> 
           </div>
           </div>
       </section>
       <section class="catagory-block">
          <div class="catagory-row">
               <div class="container-fluid">

              <?php foreach ($categories[61]['children'] as $cat_id => $cat) 
              { if ($cat['top']>0) {?>
                <div class="col-md-4 col-xs-6 catblock">
                    <div class="catagory">
                        <a href="<?php echo $cat['href']; ?>">
                       <img alt="<?php echo $cat['name']; ?>" src="<?php echo $cat['image']; ?>">
                        <div class="catagory-label ttu">
                            <div class="h3-title"><?php echo $cat['name']; ?></div>
                        </div>
                        </a>
                    </div>
                </div>
              <?php } } ?>
           </div>
       </div>
       </section>
       
       <section class="theme-catagory ttu">
          <div class="container-fluid">
            <a href="<?php echo $categories[68]['href']; ?>" >
           <div class="h2 text-center"><?php echo $categories[68]['name']; ?></div>
            </a>
           <div class="theme-block">
              <div class="catagory-row">
               <div class="container-fluid">
               <?php foreach ($categories[68]['children'] as $cat_id => $cat) 
               { if ($cat['top']>0) {?>
                 <div class="col-md-4 col-xs-6 catblock">
                     <div class="catagory">
                         <a href="<?php echo $cat['href']; ?>">
                           <img alt="<?php echo $cat['name']; ?>" src="<?php echo $cat['image']; ?>">
                         <div class="catagory-label ttu">
                             <div class="h3-title"><?php echo $cat['name']; ?></div>
                         </div>
                         </a>
                     </div>
                 </div>
               <?php } } ?>
                
           </div>
           </div>
           </div>
           </div>
       </section>
       
       <section class="news-block">
          <div class="container-fluid ">
            <section class="category-title category-title_home">
            <a href="<?php echo $blog_link; ?>"><div class="h2 ttu h1">Ключевые новости</div></a>
            </section>
           <div class="news">
            <?php foreach ($latest_news as $nkey => $new) 
            {?>
               <div class="col-sm-6">
                       <div class="news-column <?php if ($nkey>0) {?>hidden-xs<?php } ?>">
                       <div class="h4-title ttu custom_h4"><a href="<?php echo $new['href']; ?>"><?php echo $new['title']; ?></a></div>
                       <div class="news-date"><?php echo $new['date']; ?></div>
                       <a href="<?php echo $new['href']; ?>"><img alt="New" class="lazy" data-src="<?php echo $new['image']; ?>"></a>
                       <div class="news-text">
                           <p>
                            <?php echo $new['description']; ?>
                           </p>
                       </div>
                       </div>
               </div>
            <?php } ?>
               
<!--               <div class="col-sm-6">
                       <div class="news-column">
                       <h4 class="h4-title ttu"><a href="#">Придумана одежда, которую не надо стирать</a></h4>
                       <div class="news-date">12 апреля 2016</div>
                       <a href="#"><img src="catalog/view/theme/keyman/image/img-news.jpg"></a>
                       <div class="news-text">
                           <p>
                               Столица российских ткачей город Иваново сегодня пустеет и ветшает. Чтобы выжить, ткацкая промышленность переориентируется на одежду будущего. На смену вчерашним швейным комбинатам приходят лаборатории, где разрабатываются совершенно новые материалы. Появилась одежда, которую можно не стирать месяцами, а также ткань, защищающая от микробов и заживляющая царапины.
                           </p>
                       </div>
                       </div>
               </div> -->
               <div class="clearfix"></div>
           </div>
           </div>
       </section>
       <section class="reviews">
        <section class="category-title category-title_home">
       <a href="<?php echo $reviews_link; ?>"><div class="h2 ttu h1">Отзывы наших клиентов</div></a>
        </section>

           
           <div class="reviws-block">
               <div class="col-sm-6">
                  <div class="video">
                      <!-- <iframe width="853" height="480" src="https://www.youtube.com/embed/3orWMtPOAo8?rel=0&amp;showinfo=0" frameborder="0" allowfullscreen></iframe> -->
                      <?php echo html_entity_decode($left_video['description'], ENT_QUOTES, 'UTF-8'); ?>
                  </div>
               </div>
               <div class="col-sm-6">
                  <div class="video hidden-xs">
                     <!-- <iframe width="853" height="480" src="https://www.youtube.com/embed/3orWMtPOAo8?rel=0&amp;showinfo=0" frameborder="0" allowfullscreen></iframe> -->
                     <?php echo html_entity_decode($right_video['description'], ENT_QUOTES, 'UTF-8'); ?>
                  </div>
               </div>
               <div class="clearfix"></div>
           </div>
       </section>

       <section class="social-block">


           <section class="category-title category-title_home">
          <a href="https://instagram.com/keymanby/" target="_blank" rel="nofollow"><div class="h2 ttu h1">#KEYMANBY в Instagram</div></a>
           </section>


          <!-- <h3 class="text-center">Покажи себя! Добавляй свои фото в instagram c <b>#keymanby</b></h3> -->
          <div class="container-fluid">
           <div class="insta-block">
                
           </div>

<?php /*/ ?>
              <div class="social-row hidden-xs">
                     <div class=" block_1">
                      <div id="vk_groups"></div>
                   <div class="vk-block">
  
                   </div>
                   </div>
                   <div class="col-sm-6 block_2">
                       <div class="fb-page" data-href="https://www.facebook.com/keymanby" data-small-header="false" data-adapt-container-width="true" data-tabs="messages" data-width="600" data-height="319" data-hide-cover="false" data-show-facepile="true"><div class="fb-xfbml-parse-ignore"><blockquote cite="https://www.facebook.com/keymanby"><a href="https://www.facebook.com/keymanby" rel="nofollow">Keyman.by</a></blockquote></div></div>
                   </div>
            
                   <div class="col-sm-4 artclel_seo block_3"><?php echo html_entity_decode($article_main['description']); ?></div>
            
               <div class="clearfix"></div>
            </div>
<?php /*/ ?>
<div class="col-sm-12 artclel_seo block_3 hidden-xs"><?php echo html_entity_decode($article_main['description']); ?></div>




           </div>
       </section>
       <?php /*/ if (count($partners)>0) {?>
       <section class="partners-block hidden-xs">
          <div class="container-fluid">
             <section class="category-title category-title_home">
            <div class="h2 ttu h1">Партнеры</div>
             </section>

           <div class="partners">
            
              <?php foreach ($partners as $pkey => $partn) 
              {?>
                <div class="partner"><a href="<?php echo $sales_link; ?>"><img alt="Partner" class="lazy" data-src="<?php echo $partn['image']; ?>"></a></div>
              <?php } ?>
            
                </div>
                </div>
        </section>
       <?php } /*/ ?>
       <hr>

       <?php echo $content_bottom; ?>

       <?php


       if(isset($_COOKIE['version']) && $_COOKIE['version'] == 1) {
             echo '<section>
                 <div class="col-xs-12 text-center">
                     <a href="#" id="delbigversion" class="h1 ttu"><i class="glyphicon glyphicon-resize-small"></i>&nbsp; Вернуться к мобильной версии</a>
                 </div>
                 <div class="clearfix"></div>
               </section>';
             } else {
                echo '<div class="visible-xs">



                 <div class="col-xs-12 text-center">
                     <a href="#" id="bigversion" class="ttu"><i class="glyphicon glyphicon-resize-full"></i>&nbsp; Перейти к полной версии</a>
                 </div>
                 <div class="clearfix"></div>
              </div>';

             }
       ?>

        
        <?php echo $footer; ?>
        <script type="text/javascript" src="https://vk.com/js/api/openapi.js?121"></script>
        <!-- VK Widget -->
        <!-- <script>
          $( document ).ready(function() {
              $('a[href*="www.facebook.com/keymanby"]').attr("rel", "nofollow");
          });
        </script> -->
        <script type="text/javascript">
        VK.Widgets.Group("vk_groups", {mode: 0, width: "auto", height: "319", color1: 'FFFFFF', color2: '2B587A', color3: '5B7FA6'}, 117832789);
        </script>