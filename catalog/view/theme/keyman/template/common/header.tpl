<!DOCTYPE html>
<!--[if IE]><![endif]-->
<!--[if IE 8 ]><html dir="<?php echo $direction; ?>" lang="<?php echo $lang; ?>" class="ie8"><![endif]-->
<!--[if IE 9 ]><html dir="<?php echo $direction; ?>" lang="<?php echo $lang; ?>" class="ie9"><![endif]-->
<!--[if (gt IE 9)|!(IE)]><!-->
<html dir="<?php echo $direction; ?>" lang="<?php echo $lang; ?>">
<!--<![endif]-->
<head>
  <meta charset="UTF-8">
  <?php   
  if(isset($_COOKIE['version']) && $_COOKIE['version'] == 1) {
  echo '<meta name="viewport" content="width=1024">';
} else {
echo '<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1,">';
} 
?>
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="cmsmagazine" content="5aec2c765189c02cbf591692a2e48a5e" />
<title><?php echo $title; ?></title>
<base href="<?php echo $base; ?>" />
<?php if ($description) { ?>
<meta name="description" content="<?php echo $description; ?>" />
<?php } ?>
<?php if ($keywords) { ?>
<meta name="keywords" content= "<?php echo $keywords; ?>" />
<?php } ?>
<?php if(strpos($_SERVER['QUERY_STRING'], 'page')){ ?>
<meta name="robots" content="noindex, follow"/>
<?php } ?>
<!-- header_var -->



<link rel="stylesheet" href="catalog/view/theme/keyman/stylesheet/bootstrap.css">
<!-- <link rel="stylesheet" href="catalog/view/theme/keyman/stylesheet/bootstrap_mini.css"> -->
<link rel="stylesheet" href="catalog/view/theme/keyman/stylesheet/owl.carousel.css">
<link rel="stylesheet" href="catalog/view/theme/keyman/stylesheet/jquery.fancybox.css">
<link rel="stylesheet" href="catalog/view/theme/keyman/stylesheet/ion.rangeSlider.css">
<link rel="stylesheet" href="catalog/view/theme/keyman/stylesheet/ion.rangeSlider.skinHTML5.css">
<!-- <link rel="stylesheet" href="catalog/view/theme/keyman/stylesheet/style.css"> -->
<link rel="stylesheet" href="catalog/view/theme/keyman/stylesheet/style_new4.css">
<script src="catalog/view/theme/keyman/js/jquery-1.12.3.min.js"></script>
<script src="catalog/view/theme/keyman/js/bootstrap.min.js"></script>
<script src="catalog/view/theme/keyman/js/owl.carousel.min.js"></script>
<link href='https://fonts.googleapis.com/css?family=Roboto:400,500,100italic,100,300,700&subset=latin,cyrillic' rel='stylesheet' type='text/css'>
<link href='https://fonts.googleapis.com/css?family=Roboto+Condensed:400,300,700&subset=latin,cyrillic' rel='stylesheet' type='text/css'>


<!-- embedded --> 
<?php foreach ($styles as $style) { ?>
<link href="<?php echo $style['href']; ?>" type="text/css" rel="<?php echo $style['rel']; ?>" media="<?php echo $style['media']; ?>" />
<?php } ?>
<?php foreach ($links as $link) { 
if($link['rel'] == 'canonical'){
continue;
}
?>
<link href="<?php echo $link['href']; ?>" rel="<?php echo $link['rel']; ?>" />
<?php } ?>
<?php foreach ($scripts as $script) { ?>
<script src="<?php echo $script; ?>" type="text/javascript"></script>
<?php } ?>
<?php foreach ($analytics as $analytic) { ?>
<?php echo $analytic; ?>
<?php } ?>
<!-- Yandex.Metrika counter --> <script type="text/javascript" > (function (d, w, c) { (w[c] = w[c] || []).push(function() { try { w.yaCounter41117629 = new Ya.Metrika2({ id:41117629, clickmap:true, trackLinks:true, accurateTrackBounce:true, webvisor:true, trackHash:true }); } catch(e) { } }); var n = d.getElementsByTagName("script")[0], s = d.createElement("script"), f = function () { n.parentNode.insertBefore(s, n); }; s.type = "text/javascript"; s.async = true; s.src = "https://mc.yandex.ru/metrika/tag.js"; if (w.opera == "[object Opera]") { d.addEventListener("DOMContentLoaded", f, false); } else { f(); } })(document, window, "yandex_metrika_callbacks2"); </script> <noscript><div><img src="https://mc.yandex.ru/watch/41117629" style="position:absolute; left:-9999px;" alt="" /></div></noscript> <!-- /Yandex.Metrika counter --> 
<!-- Google Tag Manager -->
<script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
  new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
})(window,document,'script','dataLayer','GTM-W24GBPJ');</script>
<!-- End Google Tag Manager -->
<style>
  @media (min-width: 768px) {
      .mini-img.owl-carousel .owl-item {

          float: none;
      }
      .navbar .nav.navbar-nav {
        display: flex;
      }
      .compani_link {
        order:5;
      }
      .button_menu_1 {
        order:2;
      }
      .button_menu_2 {
        order:3;
      }
      .button_menu_3 {
        order:4;
      }
      .button_menu_4 {
        order:5;
      }
      .button_menu_5 {
        order:6;
      }
      .button_menu_6 {
        order:7;
      }
  }  
</style>
</head>
<body>
  <!-- Google Tag Manager (noscript) -->
  <noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-W24GBPJ"
    height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
    <!-- End Google Tag Manager (noscript) -->

    <div id="fb-root"></div>
    <script>(function(d, s, id) {
      var js, fjs = d.getElementsByTagName(s)[0];
      if (d.getElementById(id)) return;
      js = d.createElement(s); js.id = id;
      js.src = "//connect.facebook.net/ru_RU/sdk.js#xfbml=1&version=v2.6&appId=797017173735907";
      fjs.parentNode.insertBefore(js, fjs);
    }(document, 'script', 'facebook-jssdk'));
  </script>
  <div class="fixed-header">
    <header>
      <div class="container-fluid">
       <div class="col-md-3 col-sm-6 col-xs-12">
        <?php if ($logo) { ?>
        <div class="logo">
         <a href="<?php echo $home_link; ?>"><img src="<?php echo $logo; ?>" alt="Keyman.by"></a>
       </div>
       <?php }?>
     </div>
     <?php echo $search; ?>
     <div class="clearfix visible-sm visible-xs"></div>
     <div class="col-md-3 col-sm-6  col-xs-6">
      <div class="social-icons hidden-xs">
       <a class="social fb" href="https://facebook.com/keymanby/" target="_blank" rel="nofollow"></a>
       <a class="social vk" href="https://vk.com/keymanby" target="_blank" rel="nofollow"></a>
       <a class="social insta" href="https://instagram.com/keymanby/" target="_blank" rel="nofollow"></a>
       <a class="social youtube" href="https://www.youtube.com/channel/UCsXD2sI0leWVrkzedhiD1BA" target="_blank" rel="nofollow"></a>
     </div>
   </div>
   <div class="col-md-3 col-sm-6 col-xs-12">
     <div class="user hidden-xs">
       <div class="personal-in">
         <span>
          <?php if ($logged) { ?>
          <?php if ($controller=="account") { ?>
          <a href="<?php echo $logout; ?>"><?php echo $text_logout; ?></a>
          <?php } else { ?> 
          <a href="<?php echo $account; ?>"><?php echo $text_account; ?></a>
          <?php } ?>  
          <?php } else { ?>
          <a href="#modal-in" data-toggle="modal" data-target="#modal-in"><i class="glyphicon glyphicon-user"></i><?php echo $text_login; ?></a>
          <?php // echo $login_modal; ?>
          <?php } ?>
        </span>
      </div>
      <?php echo $cart; ?>
    </div>
  </div>
</div>

</header>


<div class="navbar-block">
 <div class="navbar navbar-default" role="navigation">
  <div class="container-fluid">
    <div class="navbar-header mobile-header">
      <button type="button" class="navbar-toggle" id="navbar-toggle">
        <span class="sr-only">Раскрыть меню</span>
        <span class="icon-bar ib1"></span>
        <span class="icon-bar ib2"></span>
        <span class="icon-bar ib3"></span>
      </button>
      <div class="visible-xs nav-buttons">
        <div class="text-right" style="text-align: right; float: none; margin-bottom: 0px;">
          <span data-toggle="collapse" data-target="#minisearch" ><i class="glyphicon glyphicon-search"></i></span>
          <?php if ($logged) { ?>
          <?php if ($controller=="account") { ?>
          <a href="<?php echo $logout; ?>"><i class="glyphicon glyphicon-user"></i></a>
          <?php } else { ?> 
          <a href="<?php echo $account; ?>"><i class="glyphicon glyphicon-user"></i></a>
          <?php } ?>  
          <?php } else { ?>
          <a href="#modal-in" data-toggle="modal" data-target="#modal-in"><i class="glyphicon glyphicon-user"></i></a>
          <?php // echo $login_modal; ?>
          <?php } ?>
          <!-- <a href="#"><i class="glyphicon glyphicon-user"></i></a> -->
          <a class="" href="<?php echo $cart_link; ?>"><i class="glyphicon glyphicon-shopping-cart"></i></a>
          <div class="dropdown">
            <div class="callme_button_view dropdown-toggle" id="dropdownMenuCallme" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="glyphicon glyphicon-earphone"></i><span class="hidden-xs"><?php echo $telephone; ?></span></div>
            <div class="dropdown-menu callme__dropdown__menu" aria-labelledby="dropdownMenuCallme" >
              <div class="box">
                <div class="dropdown-mobile">
                  <div class="dropdown-item callme_viewform" data-toggle="modal" data-target="#callme_viewform">Заказать звонок</div>
                  <div class="dropdown-item callme__text">Мы перезвоним вам в рабочее время с 10:00 до 21:00</div>
                  <div class="dropdown-mobile__title callme__text">Напишите нам:</div>
                  <div class="dropdown-mobile__items"><a href="tel:<?php echo str_replace(array(' ', '+', '(', ')'), '', $telephone); ?>" class="dropdown-mobile__items-link"><?php echo $telephone; ?></a>

                    <a href="<?php echo $viber_link; ?>" class="dropdown-mobile__items-link">
                      <img src="catalog/view/theme/keyman/img/icon-viber.png" class="dropdown-mobile__items-icon" alt="viber" style="width: 12%;">
                    </a>
                  </div>
                  <div class="dropdown-mobile__mail">
                    <a href="mailto:info@keyman.by" class="dropdown-mobile__mail-link">
                      <div class="dropdown-mobile__mail-text">
                        <img src="catalog/view/theme/keyman/img/icon-mail.png" class="dropdown-mobile__mail-icon" alt="mail" style="width: 9%;">
                        info@keyman.by
                      </div>
                    </a>
                  </div>
                </div>
              </div>
              
            </div>
          </div>
        </div>
        <div class="mini-search-block collapse" id="minisearch">
         <div class="search">
          <form method="get" action="<?php echo $search_link; ?>">
           <div class="input-group">
            <input type="hidden" name="route" value="product/search">
            <input type="text" class="form-control" placeholder="Поиск" name="search">
            <span class="input-group-btn">
              <button class="btn" type="submit"><img src="catalog/view/theme/keyman/image/icon-search.png" alt="Поиск"></button>
            </span>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
<div class="navbar-collapse collapse navbar-mobile">
  <ul class="nav navbar-nav" data-i32temscope_mdp="" data-i32temtype_mdp="http://www.schema.org/SiteNavigationElement">
    <li class="dropdown">
      <a href="#" class="dropdown-toggle" data-toggle="dropdown">Каталог</a>
      <div class="dropdown-menu">
        <div class="container-fluid">
          <div class="col-md-8">

            <div class="row" id="total-categories">
              <div class="col-md-4 col-sm-12 pc_off">
                <ul class="high-categories" id="big-categories">
                 <li class="active"><a data-target="#catalog"><?php echo $categories[61]['name']; ?></a></li>
                 <li><a data-target="#thematic"><?php echo $categories[68]['name']; ?></a></li>
               </ul>
             </div>
             <div class="clearfix visible-sm"></div>

             

             <div class="col-md-4 col-sm-6 width_pc">
              <div id="middle-categories">
                <ul class="middle-categories cat_pc" id="catalog">
                  <div class="col-md-4 col-sm-6">
                    <?php 
                    $cat_caunt=0;
                    foreach ($categories[61]['children'] as $cat_id => $category) { 
                    $cat_caunt++;
                    ?>
                    <?php  if (($cat_caunt == 4)||($cat_caunt == 9)) {  ?>
                    <br class="mobile_off">
                    <?php } ?>


                  <?php if (($category['category_id']==106) || ($category['category_id']==107)) { ?>
                  <?php   $cat_caunt--;  ?>
                  <?php }else { ?>
                    <?php if (!empty($category['children'])) { ?>
                    <li  data-i32temprop_mdp="name" class="child_cat boild_li">
                      <?php } else { ?>
                      <li  data-i32temprop_mdp="name" class="boild_li"><?php } ?>
                        <a data-i32temprop_mdp="url" href="<?php echo $category['href']; ?>" data-target="#level3_61_<?php echo $cat_id; ?>" data-img="<?php echo $category['image']; ?>">
                          <?php if (($category['image_mobile']!="") && ($category['image_mobile']!="https://keyman.by/image/")) {?><img src="<?php echo $category['image_mobile']; ?>" alt="<?php echo $category['name']; ?>" class="visible-xs"><?php } ?><?php echo $category['name']; ?></a>
                        </li>
                        <?php foreach ($category['children'] as $category_child ) { ?>
                        <li data-i32temprop_mdp="name" class="mobile_off">
                          <a data-i32temprop_mdp="url" href="<?php echo $category_child['href']; ?>" data-target="#level3_61_<?php echo $cat_id; ?>" data-img="<?php echo $category_child['image']; ?>">
                            <?php echo $category_child['name']; ?></a>
                          </li>
                          <?php } ?>

                          <?php  if ($cat_caunt == 7) {  ?>
                        </div>
                        <div class="col-md-4 col-sm-6">
                         <?php } ?>
                         <?php } ?>
                       


                  <?php } ?>


                       </div>
                     </ul>
                     
                     <div class="col-md-4 col-sm-6 collections">
                       <ul class="middle-categories   on_block" id="">
                        <li data-i32temprop_mdp="name" class=" boild_li">
                          <a data-i32temprop_mdp="url" data-target="#level3_61_">
                            <?php echo $cat_art['title']; ?>
                          </a>
                        </li>


                            <?php foreach ($articles_menu as $category) { ?>

                            <li data-i32temprop_mdp="name" ><a data-i32temprop_mdp="url" href="<?php echo $category['keyword']; ?>" data-target="#level3_68_"  data-img="<?php echo $category['image']; ?>">

                              <?php if (($category['image']!="") && ($category['image']!="https://keyman.by/image/")) {?>
                              <!-- <img src="<?php echo $category['image']; ?>" alt="<?php echo $category['title']; ?>" class="hidden-xs"> -->
                              <?php } ?><?php echo $category['title']; ?>
                            </a>
                          </li>
                              <?php } ?>


                              <?php foreach ($categories[61]['children']  as $cat_id => $category) { ?>
                              <?php if (($category['category_id']==106) || ($category['category_id']==107)) { ?>

                              <li data-i32temprop_mdp="name" ><a data-i32temprop_mdp="url" href="<?php echo $category['href']; ?>" data-target="#level3_68_<?php echo $cat_id; ?>"  data-img="<?php echo $category['image']; ?>">
                                <?php if (($category['image_mobile']!="") && ($category['image_mobile']!="https://keyman.by/image/")) {?><img src="<?php echo $category['image_mobile']; ?>" alt="<?php echo $category['name']; ?>" class="visible-xs"><?php } ?><?php echo $category['name']; ?></a></li>
                                <?php } ?>

                              <?php } ?>

                      
                              <br class="hidden-xs">
                              <br class="hidden-xs">

                            </ul> 
                          </div>



                     <div class="col-md-4 col-sm-6">
                       <ul class="middle-categories hidden pc_off on_block" id="thematic">
                        <li data-i32temprop_mdp="name" class="child_cat boild_li">
                          <a data-i32temprop_mdp="url" href="<?php echo $categories[68]['href']; ?>" data-target="#level3_61_<?php echo $cat_id; ?>" 
                            data-img="<?php echo $categories[68]['image']!="" ? $categories[68]['image'] : $categories[68]['children'][0]['image']; ?>">
                            <?php echo $categories[68]['name']; ?></a></li>
                            
                            <?php foreach ($categories[68]['children'] as $cat_id => $category) { ?>

                            <li data-i32temprop_mdp="name" ><a data-i32temprop_mdp="url" href="<?php echo $category['href']; ?>" data-target="#level3_68_<?php echo $cat_id; ?>"  data-img="<?php echo $category['image']; ?>">
                              <?php if (($category['image_mobile']!="") && ($category['image_mobile']!="https://keyman.by/image/")) {?><img src="<?php echo $category['image_mobile']; ?>" alt="<?php echo $category['name']; ?>" class="visible-xs"><?php } ?><?php echo $category['name']; ?></a></li>
                              <?php } ?>
                            </ul> 
                          </div>

                        </div>
                        <div class="col-md-4 col-sm-6">
                          <br class="mobile_off">
                          <ul class="middle-categories hidden pc_off on_block" id="">
                            <li class="child_cat boild_li active" >
                              <a class="color_red" href="<?php echo $top_menu_links['special']; ?>" data-img="https://keyman.by/image/cache/catalog/system_images/DSC_3286_77_kvadrat_2-870x870.jpg">Распродажа</a> 
                              <!-- <a class="color_red" href="<?php echo $top_menu_links['special']; ?>" data-img="https://keyman.by/image/cache/catalog/system_images/foto_catalog-540x580.jpg">Распродажа</a> -->
                            </li>
                          </ul> 
                        </div>

                        <div class="col-md-4 col-sm-6">
                          <br class="mobile_off">
                          <ul class="middle-categories hidden pc_off on_block spec_url tags_menu" id="">
                            <li class="child_cat boild_li active" ><span>Популярные костюмы:</span></li>
                            <?php foreach ($menu_tags as $tgkey => $tag) 
                            {?>
                             <li class="child_cat boild_li active" >
                               <a href="<?php echo $tag['href']; ?>"><span>#</span><?php echo $tag['name']; ?></a> 
                             </li> 
                             <?php } ?>
                           </ul> 
                         </div>
                       </div>

                       <div class="col-md-4 col-sm-6 pc_off">
                        <div id="low-categories">

                          <?php foreach ($categories[61]['children'] as $cat_id => $category) 
                          { ?>
                            
                            

                            <ul class="low-categories hidden" id="level3_61_<?php echo $cat_id; ?>">
                             
                              <?php foreach ($category['children'] as $ch_id => $ch_category) 
                              { ?>






                                <li>
                                  <a href="<?php echo $ch_category['href']; ?>" data-img="<?php echo $ch_category['image']; ?>">
                                    <?php if (($category['image_mobile']!="") && ($category['image_mobile']!="https://keyman.by/image/")) {?><img src="<?php echo $ch_category['image_mobile']; ?>" alt="<?php echo $category['name']; ?>" class="visible-xs"><?php } ?><?php echo $ch_category['name']; ?></a></li>
                                    <?php } ?>
                                  </ul>
                                  <?php } ?>
                                  <?php foreach ($categories[68]['children'] as $cat_id => $category) {
                                  ?>
                                  <ul class="low-categories hidden" id="level3_68_<?php echo $cat_id; ?>">
                                    <?php foreach ($category['children'] as $ch_id => $ch_category) 
                                    {?>
                                      <li><a href="<?php echo $ch_category['href']; ?>" data-img="<?php echo $ch_category['image']; ?>"><?php if (($category['image_mobile']!="") && ($category['image_mobile']!="https://keyman.by/image/")) {?><img src="<?php echo $category['image_mobile']; ?>" alt="<?php echo $category['name']; ?>" class="visible-xs"><?php } ?><?php echo $ch_category['name']; ?></a></li>
                                      <?php } ?>
                                    </ul>
                                    <?php } ?>
                                  </div>
                                </div>

                                <div class="clearfix"></div>
                              </div>
                            </div>
                            <div class="col-md-4 col-md-offset-0 col-sm-offset-3 col-sm-6 col-xs-12 dropdown-img hidden-xs">
                             <img class="img-categories" src="<?php echo $categories[61]['image']; ?>">
                           </div>
                           <div class="clearfix"></div>
                           
                         </div>
                       </div>
                     </li>
                        
                        <li data-i32temprop_mdp="name" class="compani_link dropdown">
                          <a href="#" class="dropdown-toggle" data-toggle="dropdown">О компании <span></span></a>
                          <div class="dropdown-menu">
                            <div class="container-fluid">
                              <div class="col-md-8">
                                <div class="row" id="total-categories">

                                 <div class="col-md-4 col-sm-6 width_pc">
                                   <ul class="middle-categories cat_pc" id="catalog2">
                                     <div class="col-md-4 col-sm-6">
                                     <li data-i32temprop_mdp="name" class="child_cat boild_li active">
                                         <a data-i32temprop_mdp="url" href="<?php echo $top_menu_links['skidki']; ?>">
                                                       Система скидок
                                         </a>
                                     </li>

                                     <li data-i32temprop_mdp="name" class="child_cat boild_li active">
                                         <a data-i32temprop_mdp="url" href="<?php echo $top_menu_links['reviews']; ?>">
                                                      Отзывы
                                         </a>
                                     </li>

                                     <li data-i32temprop_mdp="name" class="child_cat boild_li active">
                                         <a data-i32temprop_mdp="url" href="<?php echo $top_menu_links['about']; ?>">
                                                       О нас
                                         </a>
                                     </li>

                                     <li data-i32temprop_mdp="name" class="child_cat boild_li active">
                                         <a data-i32temprop_mdp="url" href="<?php echo $top_menu_links['team']; ?>">
                                                      Команда Keyman
                                         </a>
                                     </li>

                                     <li data-i32temprop_mdp="name" class="child_cat boild_li active">
                                         <a data-i32temprop_mdp="url" href="<?php echo $top_menu_links['vacancies']; ?>">
                                                     Вакансии
                                         </a>
                                     </li>

                                     </div>     
                                   </ul>

                                 </div>     

                                   </div>
                                 </div>

                                     <!--            <div class="col-md-4 col-md-offset-0 col-sm-offset-3 col-sm-6 col-xs-12 dropdown-img hidden-xs">
                                                 <img class="img-categories" src="<?php // echo $categories[61]['image']; ?>">
                                               </div> -->
                                               <div class="clearfix"></div>
                                               
                             
                           </div>
                       </div>
                     </li>
                     <li class="button_menu_5" data-i32temprop_mdp="name"><a data-i32temprop_mdp="url" href="<?php echo $top_menu_links['shops']; ?>">Наши магазины</a></li>   
                     <li class="button_menu_6" data-i32temprop_mdp="name"><a data-i32temprop_mdp="url" href="/delivery">Доставка</a></li>

                     <li class="button_menu_2" data-i32temprop_mdp="name"><a data-i32temprop_mdp="url" href="<?php echo $top_menu_links['akcii']; ?>">Акции</a></li>
                     <li class="button_menu_3" data-i32temprop_mdp="name"><a data-i32temprop_mdp="url" href="<?php echo $top_menu_links['special']; ?>">Распродажа</a></li>


                     
                     <li class="visible-xs"><a href="<?php echo $categories[68]['href']; ?>" data-target="#thematic"><?php echo $categories[68]['name']; ?></a></li>
                     <li class="button_menu_1" data-i32temprop_mdp="name"><a data-i32temprop_mdp="url" href="<?php echo $top_menu_links['blog']; ?>">Блог</a></li>
                         

                     <?php /*/ ?>
                     <li data-i32temprop_mdp="name"><a data-i32temprop_mdp="url" href="<?php echo $top_menu_links['reviews']; ?>">Отзывы</a></li> 
                     <li data-i32temprop_mdp="name"><a data-i32temprop_mdp="url" href="<?php echo $top_menu_links['skidki']; ?>">Система скидок</a></li>
                    <li data-i32temprop_mdp="name"><a data-i32temprop_mdp="url" href="<?php echo $top_menu_links['podarok']; ?>">Подарки для мужчин</a></li>

                    <?php /*/ ?>



                     
                     
                     
                   </ul>
                 </div><!--/.nav-collapse -->
               </div><!--/.container-fluid -->
               
               
               
               <div class="dropdown hidden-xs">
                <div class="callme_button_view dropdown-toggle" id="dropdownMenuCallme" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="glyphicon glyphicon-earphone"></i><span class="hidden-xs"><?php echo $telephone; ?></span></div>
                <div class="dropdown-menu callme__dropdown__menu" aria-labelledby="dropdownMenuCallme" >
                  <div class="box">
                    <div class="dropdown-mobile">
                      <div class="dropdown-item callme_viewform" data-toggle="modal" data-target="#callme_viewform">Заказать звонок</div>
                      <div class="dropdown-item callme__text">Мы перезвоним вам в рабочее время с 10:00 до 21:00</div>
                      <div class="dropdown-mobile__title callme__text">Напишите нам:</div>
                      <div class="dropdown-mobile__items"><a href="tel:<?php echo str_replace(array(' ', '+', '(', ')'), '', $telephone); ?>" class="dropdown-mobile__items-link"><?php echo $telephone; ?></a>

                        <a href="<?php echo $viber_link; ?>" class="dropdown-mobile__items-link">
                          <img src="catalog/view/theme/keyman/img/icon-viber.png" class="dropdown-mobile__items-icon" alt="viber" style="width: 12%;">
                        </a>
                      </div>
                      <div class="dropdown-mobile__mail">
                        <a href="mailto:info@keyman.by" class="dropdown-mobile__mail-link">
                          <div class="dropdown-mobile__mail-text">
                            <img src="catalog/view/theme/keyman/img/icon-mail.png" class="dropdown-mobile__mail-icon" alt="mail" style="width: 9%;">
                            info@keyman.by
                          </div>
                        </a>
                      </div>
                    </div>
                  </div>
                  
                </div>
              </div>
            </div>
          </div>
        </div>







        <?php /*/ 
        $cat_caunt=0;
        foreach ($categories as $cat_id => $category) {
        $cat_caunt++;
        if ($cat_caunt!=1) {

        <span data-i32temscope_mdp="" data-i32temtype_mdp="http://www.schema.org/SiteNavigationElement">

         ?>
         <span>
          <link data-i32temprop_mdp="url" href="<?php echo $category['href']; ?>">
          <meta data-i32temprop_mdp="name" content="<?php echo $category['name']; ?>">
        </span> 
        <?php    } ?>
        <?php foreach ($category['children'] as $category_child ) { ?>


        <span>
         <link data-i32temprop_mdp="url" href="<?php echo $category_child['href']; ?>">
         <meta data-i32temprop_mdp="name" content="<?php echo $category_child['name']; ?>">
       </span> 


       <?php foreach ($category_child['children'] as $category_child3 ) { ?>


       <span>
         <link data-i32temprop_mdp="url" href="<?php echo $category_child3['href']; ?>">
         <meta data-i32temprop_mdp="name" content="<?php echo $category_child3['name']; ?>">
       </span> 
       <?php } ?>


       <?php } ?>



       <?php } ?>

     </span>



     <?php foreach ($categories[68]['children'] as $cat_id => $category) {
     ?>
     <a href=" <?php echo $category['href']; ?> "><?php echo $category['name']; ?></a>
     
     
     <?php } /*/ ?>