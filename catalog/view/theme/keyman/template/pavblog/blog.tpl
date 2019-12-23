<?php echo $header; ?>


<section class="category-title title_blog">
    <div class="ttu h1 mb0">Блог</div>
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
<section class="blog-nav">
   <div class="container-fluid">
    <div class="col-xs-12">
        <div class="blog-menu">
                <div class="col-md-9 col-sm-12">
                    <ul>
                      <?php foreach ($children as $key=> $breadcrumb) { ?>
                      <li <?php if (isset($breadcrumb['active'])) {?> class="active" <?php } ?> ><a href="<?php echo $breadcrumb['link']; ?>"><?php echo $breadcrumb['title']; ?></a></li>
                      <?php } ?>
                    </ul>
                </div>
                <div class="col-md-3 col-sm-12">
                    <div class="blog-search">
                    	<form action="<?php echo $search_link; ?>" method="POST">
                    	  <div class="input-group">
                    	    	<input type="text" class="form-control" placeholder="Поиск" name="blog_search">
                    	    	 <span class="input-group-btn">
                    	    	  <button class="btn" type="submit"></button>
                    	    	</span>
                    	  </div><!-- /input-group -->
                    	</form>
                    </div>
                </div>
                <div class="clearfix"></div>
        </div>
    </div>
    </div>
</section>
<section class="blog-page-block">
     <div class="container-fluid">
         <div class="col-sm-8">
       <div class="blog-page-article">
           <h1 class="blog-article-title"><?php echo $blog['title'];?></h1>
           <?php if( $config->get('blog_show_created') ) { ?>
           	<h4 class="article-date"><?php echo rdate("d M Y",strtotime($blog['created']));?></h4>
           <?php } ?>
        <?php if( !empty($tags) ) { ?>
           <div class="article-tags">
               <span>Тэги:</span>
               	<?php 	$i = 1; foreach( $tags as $tag => $tagLink ) { ?>
               		<a href="<?php echo $tagLink; ?>" title="<?php echo $tag; ?>"><?php echo $tag; ?></a> <?php if($i<count($tags)) { echo ","; }; ?>
               	<?php $i++; }  ?>
           </div>
        <?php } ?>
           <?php if( $image_orig ) { ?>
           		<img  class="article-img" src="<?php echo $image_orig;?>" title="<?php echo $blog['title'];?>"/>					
           	<?php } ?>
           <div class="blog-page-article-text">
           		<?php echo str_replace('http://keyman.by', 'https://keyman.by', $content);?>
           </div>
<!--            <blockquote class="blog-quote">
             <p>
                 Любой может эффектно нарядиться, но то, как люди одеваются в свободное время, намного интереснее
             </p>
             <div class="blog-footer-signature">
             <cite title="Автор цитаты">Александр Вэнг</cite></div>
           </blockquote>
           
           <div class="blog-page-article-text">
               <p>
                   К примеру, если вы решили выбрать рубашку, то вам необходимо обратить внимание на ее цвет, фасон и кучу других нюансов, в противном случае, выбрав рубашку, не подходящую под то место, куда вы собрались, вы рискуете выглядеть нелепо. И конечно же, надо помнить самое главное правило: хорошая рубашка та, что хорошо сидит!
               </p>
           </div> -->
<!--            <h3 class="blog-article-h3">Как выбрать мужскую рубашку</h3>
           <div class="blog-page-article-text">
               <p>
                   К примеру, если вы решили выбрать рубашку, то вам необходимо обратить внимание на ее цвет, <span class="text-under">фасон</span> и кучу других нюансов, в противном случае, выбрав рубашку, не подходящую под то место, куда вы собрались, вы рискуете выглядеть нелепо. 
               </p>
           </div>
           <h4 class="blog-article-title h4-article-title">Как выбрать мужскую рубашку</h4>
           <div class="blog-page-article-text">
               <p class="bold-article-text">
                   Если вы решили выбрать рубашку, то вам необходимо обратить внимание на ее цвет, фасон и кучу других нюансов, в противном случае, выбрав <span class="bold-under-text">рубашку</span>, не подходящую под то место, куда вы собрались, вы рискуете выглядеть нелепо.
               </p>
           </div>
           
           <h5 class="h5-blog-title">Как выбрать мужскую рубашку</h5>
           <div class="blog-page-article-text">
               <p class="italic-text">
                   Если вы решили выбрать рубашку, то вам необходимо обратить внимание на ее цвет, <span class="text-under">фасон</span> и кучу других нюансов, в противном случае, выбрав рубашку, не подходящую под то место, куда вы собрались, вы рискуете выглядеть нелепо. 
               </p>
           </div>
           
           <h6 class="h6-blog-title">Как выбрать мужскую рубашку</h6>
           <div class="blog-page-article-text">
               <p>Если вы решили выбрать рубашку, то вам необходимо обратить внимание на ее цвет, фасон и кучу других нюансов, в противном случае, выбрав рубашку, не подходящую под то место, <span class="bold-under-text">куда вы собрались</span>, вы рискуете выглядеть нелепо.
               </p>
           </div>
           
           <div class="table-responsive">
           <table class="size-table">
              <tr>
                  <th>Российский размер</th>
                  <th>Международный размер</th>
                  <th>Обхват талии (см)</th>
              </tr>
              <tr>
                  <td>44</td>
                  <td>XXS</td>
                  <td>70</td>
              </tr>
              <tr>
                  <td>44-46</td>
                  <td>XXS/XS</td>
                  <td>70-76</td>
              </tr>
              <tr>
                  <td>46</td>
                  <td>XS</td>
                  <td>76</td>
              </tr>
              <tr>
                  <td>46-48</td>
                  <td>XS/S</td>
                  <td>76-82</td>
              </tr>
           </table>
           </div>
           <div class="blog-page-article-text">
               <p>
                   Если вы решили выбрать рубашку, то вам необходимо обратить внимание на ее цвет, фасон и кучу других нюансов, в противном случае, выбрав рубашку, не подходящую под то место, куда вы собрались, вы рискуете выглядеть нелепо.
               </p>
           </div> -->
       </div>
       <div id="disqus_thread"></div>
       <script>
       /**
       * RECOMMENDED CONFIGURATION VARIABLES: EDIT AND UNCOMMENT THE SECTION BELOW TO INSERT DYNAMIC VALUES FROM YOUR PLATFORM OR CMS.
       * LEARN WHY DEFINING THESE VARIABLES IS IMPORTANT: https://disqus.com/admin/universalcode/#configuration-variables
       */
       /*
       var disqus_config = function () {
       this.page.url = PAGE_URL; // Replace PAGE_URL with your page's canonical URL variable
       this.page.identifier = PAGE_IDENTIFIER; // Replace PAGE_IDENTIFIER with your page's unique identifier variable
       };
       */
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
             <div class="archive-title h4">Архив:</div>
             <ul>
             	<?php foreach ($archive as $month_id => $arc) 
             	{?>
                 <li><a href="<?php echo $arc['href']; ?>"><?php echo $arc['title']; ?></a></li>
             	<?php } ?>
             </ul>
         </div>

         <div class="tegs-block">
             <div class="archive-title h4">Тэги:</div>
             <div class="tags">
             	<?php foreach( $lang_tags as $id_tag => $ltag ) { ?>
             		<a href="<?php echo $ltag['href']; ?>" title="<?php echo $ltag['name']; ?>"><?php echo $ltag['name']; ?></a>
             	<?php $i++; }  ?>
             </div>
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