<?php echo $header; ?>


<section class="category-title title_blog">
    <div class="ttu h1 mb0">Новость</div>
</section>
<div class="container-fluid">
       <ol class="breadcrumb crumbstyle">
        <?php foreach ($breadcrumbs as $bkey=>$breadcrumb) { ?>
        <li>
          <?php if ($bkey<count($breadcrumbs)-1) {?><a href="<?php echo $breadcrumb['href']; ?>"><?php } ?>
            <?php echo $breadcrumb['text']; ?>
          <?php if ($bkey<count($breadcrumbs)-1) {?></a><?php } ?>
        </li>
        <?php } ?>        

      </ol>
</div>

<section class="blog-page-block">
     <div class="container-fluid">
         <div class="col-sm-8">
           <div class="blog-page-article">
               <h1 class="blog-article-title"><?php echo $heading_title;?></h1>
               <?php if( $original ) { ?>
                  <img  class="article-img" src="<?php echo $original;?>" title="<?php echo $heading_title;?>"/>          
                <?php } ?>
               <div class="blog-page-article-text">
                  <?php echo str_replace('http://keyman.by', 'https://keyman.by', $description);?>
               </div>
           </div>
           <div id="disqus_thread"></div>
           <script>
           (function() { // DON'T EDIT BELOW THIS LINE
           var d = document, s = d.createElement('script');

           s.src = '//keymanshop.disqus.com/embed.js';

           s.setAttribute('data-timestamp', +new Date());
           (d.head || d.body).appendChild(s);
           })();
           </script>
           <noscript>Please enable JavaScript to view the <a href="https://disqus.com/?ref_noscript" rel="nofollow">comments powered by Disqus.</a></noscript>
         </div>
         <div class="col-sm-4">
            <div class="right-block">
                <div class="archive">
                    <h4 class="archive-title">Архив:</h4>
                    <ul>
                      <?php foreach ($archive as $month_id => $arc) 
                      {?>
                        <li><a href="<?php echo $arc['href']; ?>"><?php echo $arc['title']; ?></a></li>
                      <?php } ?>
                    </ul>
                </div>
            </div>
        </div>
 </div>
</section>








<?php echo $footer; ?>
<?php
function rdate($param, $time=0) {
    if(intval($time)==0)$time=time();
    $MonthNames=array("Января", "Февраля", "Марта", "Апреля", "Мая", "Июня", "Июля", "Августа", "Сентября", "Октября", "Ноября", "Декабря");
    if(strpos($param,'M')===false) return date($param, $time);
        else return date(str_replace('M',$MonthNames[date('n',$time)-1],$param), $time);
}
 ?>