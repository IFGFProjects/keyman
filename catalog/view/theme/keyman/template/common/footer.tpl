








<footer>
    <div class="container-fluid">
      <div class="col-xs-12 visible-xs social-footer-xs">
        <?php /*/ ?>
      <div class="visible-xs text-center ttu mb10">
             Следите за Keyman
         </div>
         <?php /*/ ?>
          <div class="social-icons">
                  <a class="social-img fb-img" href="https://facebook.com/keymanby/" target="_blank" rel="nofollow"><img alt="facebook" src="catalog/view/theme/keyman/image/social-fb.png"></a>
                  <a class="social-img vk-img" href="https://vk.com/keymanby" target="_blank" rel="nofollow"><img  alt="vk" src="catalog/view/theme/keyman/image/social-vk.png"></a>
                  <a class="social-img insta-img" href="https://instagram.com/keymanby/" target="_blank" rel="nofollow"><img alt="instagram" src="catalog/view/theme/keyman/image/social-insta.png"></a>
                  <a class="social-img youtube-img" href="https://www.youtube.com/channel/UCsXD2sI0leWVrkzedhiD1BA" target="_blank" rel="nofollow"><img alt="youtube" src="catalog/view/theme/keyman/image/social-youtube.png"></a>
              </div>
      </div>
      <div class="clearfix"></div>
       <div class="col-md-3 col-sm-6">
           <div class="catalog">
               <div class="catalog-title" data-toggle="collapse" data-target="#catalog-links"><?php echo $categories[61]['name']; ?></div>
               <ul class="catalog-ul" id="catalog-links">
                <?php foreach ($categories[61]['children'] as $ckey => $cat) 
                {  if ( ($cat['category_id']==106) || ($cat['category_id']==107) ) { ?>
                <?php }else { ?>
                  <li><a href="<?php echo $cat['href']; ?>"><?php echo $cat['name']; ?></a></li>
                <?php } ?>
                <?php } ?>
               </ul>
           </div>
       </div>


        
        <div class="col-md-3 col-sm-6">
            <div class="footer-theme-category">
                <div class="catalog-title" data-toggle="collapse" data-target="#theme-links"> <?php echo $cat_art['title']; ?></div>

               <?php /*/ ?> <div class="catalog-title" data-toggle="collapse" data-target="#theme-links"><?php echo $categories[68]['name']; ?></div><?php /*/ ?>
                <ul class="catalog-ul" id="theme-links">

                    <?php foreach ($articles_menu as $category) { ?>
                         <li><a href="<?php echo $category['keyword']; ?>">

                           <?php if (($category['image']!="") && ($category['image']!="https://keyman.by/image/")) {?>
                           <!-- <img src="<?php echo $category['image']; ?>" alt="<?php echo $category['title']; ?>" class="hidden-xs"> -->
                           <?php } ?><?php echo $category['title']; ?>
                         </a>
                       </li>
                    <?php } ?>

                    <?php foreach ($categories[61]['children'] as $ckey => $cat) {
                        if ( ($cat['category_id']==106) || ($cat['category_id']==107) ) { ?>
                      <li><a href="<?php echo $cat['href']; ?>"><?php echo $cat['name']; ?></a></li>
                      <?php } ?>
                    <?php } ?>

                </ul>
            </div>
       
                
            </div>
        
        
        <div class="col-md-3 col-sm-6">
          <div class="catalog-title" data-toggle="collapse" data-target="#add-links">Дополнительно</div>
           <ul class="catalog-ul" id="add-links">


            <li><a href="<?php echo $top_menu_links['blog']; ?>">Блог</a></li>
            <li><a href="<?php echo $top_menu_links['akcii']; ?>">Акции</a></li>
               <li><a href="<?php echo $top_menu_links['special']; ?>">Распродажа</a></li>
             <li><a href="<?php echo $top_menu_links['podarok']; ?>">Подарки для мужчин</a></li>
              <li><a href="<?php echo $top_menu_links['business']; ?>">Корпоративным клиентам</a></li>

                </ul>
        </div>
        
        <div class="col-md-3 col-sm-6">
            <div class="footer-company" >
                <div class="catalog-title" data-toggle="collapse" data-target="#company-links">О компании</div>
                <ul class="catalog-ul" id="company-links">
                  <li><a href="<?php echo $top_menu_links['skidki']; ?>">Система скидок</a></li>
                    <li><a href="<?php echo $internal_menu_links['otzyvy']; ?>">Отзывы</a></li>
                    <li><a href="<?php echo $top_menu_links['about']; ?>">О нас</a></li>
                    <li><a href="<?php echo $internal_menu_links['komanda']; ?>">Команда</a></li>
                    <li><a href="<?php echo $internal_menu_links['vacancies']; ?>">Вакансии</a></li>
                    <li><a href="#legals" data-toggle="modal" data-target="#legals">Юридическая информация</a></li>
                </ul>
            </div>


          
            <?php /*/ ?>
            <div class="footer-name_company">
              <span>Индивидуальный предприниматель</span> <br>
              <span>Ярмоло Евгений Юрьевич</span>
            </div>
        <span>Все права защищены</span>       
            <?php /*/ ?>
          
    </div>

    <div class="col-md-3 col-sm-6 last">
      <div class="catalog-title"><a href="/delivery">Доставка</a></div>
      <div class="catalog-title"><a href="<?php echo $top_menu_links['shops']; ?>">Наши магазины</a></div>
      <div class="footer-phone">
        <a href="tel:<?php echo $telephone; ?>"><i class="glyphicon glyphicon-earphone"></i> <?php echo $telephone; ?></a>
      </div>
      <br>
       <div class="footer-social hidden-xs">
           <!-- <div class="catalog-title" data-toggle="collapse">Вы можете найти нас на</div> -->
           <div class="social-icons">
              <a class="social fb" href="https://facebook.com/keymanby/" target="_blank" rel="nofollow"></a>
              <a class="social vk" href="https://vk.com/keymanby" target="_blank" rel="nofollow"></a>
              <a class="social insta" href="https://instagram.com/keymanby/" target="_blank" rel="nofollow"></a>
              <a class="social youtube" href="https://www.youtube.com/channel/UCsXD2sI0leWVrkzedhiD1BA" target="_blank" rel="nofollow"></a>
          </div>
      </div>
    </div>


     

<div class="clearfix"></div>

<div class="col-sm-6 payment_footer">
  <img src="catalog/view/theme/keyman/img/payments_img.png" alt="payments">
</div>
<div class="copyright col-sm-12 ">
    <span>2016-<?php echo date('Y'); ?> ©Keyman.by</span>
</div>






        <div class="clearfix"></div>
        </div>
    </div>
</footer>
<div id="totop" title="Вверх" style="display: inline;"></div>
  
<div class="modal fade" id="legals" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <div class="modal-title h4">Юридическая информаця</div>
      </div>
      <div class="modal-body">
        <p><?php echo html_entity_decode($footer_modal); ?></p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Закрыть</button>
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
  
  <?php echo $login_modal; ?>


  <!-- <link rel="stylesheet" href="catalog/view/theme/keyman/stylesheet/R_C.css"> -->
  <link rel="stylesheet" href="catalog/view/theme/keyman/stylesheet/fixes.css">
  <link rel="stylesheet" href="catalog/view/theme/keyman/stylesheet/css_fix_vers12.css">
  <?php // if ($route!="product/category") {?>
  <link rel="stylesheet" href="catalog/view/theme/keyman/stylesheet/jquery.selectBox.css">
  <?php // } ?>
  <script src="catalog/view/theme/keyman/js/jquery.fancybox.pack.js"></script>
  <script src="catalog/view/theme/keyman/js/instagram.js"></script>
  <script src="catalog/view/theme/keyman/js/ion.rangeSlider.min.js"></script>
  <script src="catalog/view/theme/keyman/js/jquery.maskedinput.js"></script>
  <script type="text/javascript" src="https://keyman.by/callme/js/callme.js"></script>

<script type="text/javascript" src="//cdnjs.cloudflare.com/ajax/libs/jquery.lazy/1.7.9/jquery.lazy.min.js"></script>
<script type="text/javascript" src="//cdnjs.cloudflare.com/ajax/libs/jquery.lazy/1.7.9/jquery.lazy.plugins.min.js"></script>

  
  <!--  -->
  <?php // if ($route!="product/category") {?>
  <?php // } ?>

<!--   
  // <script async src="catalog/view/theme/keyman/js/jquery.selectBox.js"></script>
  // <script async src="catalog/view/theme/keyman/js/jquery.cookie.js"></script>
  // <script async src="catalog/view/theme/keyman/js/main.js"></script>
  // <script async src="catalog/view/theme/keyman/js/zoomsl-3.0.js"></script>
 -->

<!-- min_js -->
  <script async src="catalog/view/theme/keyman/js/min/jquery.selectBox.js"></script>
  <script async src="catalog/view/theme/keyman/js/min/jquery.cookie.js"></script>
  <script async src="catalog/view/theme/keyman/js/min/main.js"></script>
  <script async src="catalog/view/theme/keyman/js/min/zoomsl-3.0.js"></script>
<!-- /////min_js -->

  <script type="text/javascript">
    $(document).ready(function(){
      $('#modal_login_submit').on('click',function(e){
      e.preventDefault();
      $.ajax({
        type: "POST",
        url: $("#modal_login_form").attr("action"),
        data: $("#modal_login_form").serialize(),
        success: function(msg)
        {
          var data=JSON.parse(msg);
          if (data.error_warning!="")
            {$("#modal_auth_message").html(data.error_warning).show();}
          if (data.success!="")
            {
              $("#modal_auth_message").html(data.error_warning).show();
              if (data.redirect!="")
                {window.location.href=data.redirect;}
            }
        }
      });
      });
    });
  </script>

  <!-- Global site tag (gtag.js) - Google Analytics -->
  <script async src="https://www.googletagmanager.com/gtag/js?id=UA-75437837-15"></script>
  <script>
    window.dataLayer = window.dataLayer || [];
    function gtag(){dataLayer.push(arguments);}
    gtag('js', new Date());

    gtag('config', 'UA-75437837-15');
  </script>
  <!-- Yandex.Metrika counter --> <script type="text/javascript" > (function (d, w, c) { (w[c] = w[c] || []).push(function() { try { w.yaCounter46628976 = new Ya.Metrika2({ id:46628976, clickmap:true, trackLinks:true, accurateTrackBounce:true, webvisor:true, trackHash:true, ecommerce:"dataLayer" }); } catch(e) { } }); var n = d.getElementsByTagName("script")[0], s = d.createElement("script"), f = function () { n.parentNode.insertBefore(s, n); }; s.type = "text/javascript"; s.async = true; s.src = "https://mc.yandex.ru/metrika/tag.js"; if (w.opera == "[object Opera]") { d.addEventListener("DOMContentLoaded", f, false); } else { f(); } })(document, window, "yandex_metrika_callbacks2"); </script> <!-- /Yandex.Metrika counter -->
