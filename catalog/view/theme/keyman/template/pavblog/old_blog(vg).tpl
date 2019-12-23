<?php echo $header; ?>


<section class="category-title title_blog">
    <h1 class="ttu h1 mb0">Блог</h1>
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
           		<?php echo $content;?>
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
             <h4 class="archive-title">Архив:</h4>
             <ul>
             	<?php foreach ($archive as $month_id => $arc) 
             	{?>
                 <li><a href="<?php echo $arc['href']; ?>"><?php echo $arc['title']; ?></a></li>
             	<?php } ?>
             </ul>
         </div>

         <div class="tegs-block">
             <h4 class="archive-title">Тэги:</h4>
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
    <?php $class = 'col-sm-9 col-lg-9 col-md-12 col-xs-12'; ?>
    <?php } else { ?>
    <?php $class = 'col-sm-12'; ?>
    <?php } ?>
    <div id="content" class="<?php echo $class; ?>"><?php echo $content_top; ?>
		<h1><?php echo $blog['title'];?></h1>
		<div class="well">
		<!-- Start Div Content -->
		<div>
				<?php if( $blog['thumb_large'] ) { ?>
						<img class="img-responsive" src="<?php echo $blog['thumb_large'];?>" title="<?php echo $blog['title'];?>"/>					
					<?php } ?>

				 	<div class="col-sm-12 col-lg-12 col-sm-12 col-xs-12">

					<div class="content-wrap clearfix">
						<?php echo $content;?>
					</div>

 				 	<div class="lead"><?php echo $description;?></div>
				
					<?php if( $blog['video_code'] ) { ?>
					<div align="center" class="embed-responsive embed-responsive-16by9">
					<?php echo html_entity_decode($blog['video_code'], ENT_QUOTES, 'UTF-8');?>
					</div>
					<?php } ?>			
				 </div>
				<hr>
				<ul class="list-inline">
				  	<li><?php if( $config->get('blog_show_author') ) { ?>
					<span class="author"><b><?php echo $objlang->get("text_write_by");?></b> <?php echo $blog['author'];?></span>
					<?php } ?>
					</li>

					<li>
					<?php if( $config->get('blog_show_category') ) { ?>
					<span class="publishin">
						<b><?php echo $objlang->get("text_published_in");?></b>
						<a class="color" href="<?php echo $blog['category_link'];?>" title="<?php echo $blog['category_title'];?>"><?php echo $blog['category_title'];?></a>
					</span>
					<?php } ?>	
					</li>

					<li>
					<?php if( $config->get('blog_show_created') ) { ?>
					<span class="created"><b><?php echo $objlang->get("text_created_date");?></b><?php echo rdate("d M Y",strtotime($blog['created']));?></span>
					<?php } ?>
					</li>

					<li>
					<?php if( $config->get('blog_show_hits') ) { ?>
					<span class="hits"><b><?php echo $objlang->get("text_hits");?></b> <?php echo $blog['hits'];?></span>
					<?php } ?>		
					</li>

					<li>
					<?php if( $config->get('blog_show_comment_counter') ) { ?>
					<span class="comment_count"><b><?php echo $objlang->get("text_comment_count");?></b> <?php echo $blog['comment_count'];?></span>
					<?php } ?>	
					</li>
				</ul>

				<hr>
				 <?php if( !empty($tags) ) { ?>
				 <div class="blog-tags">
					<span class="glyphicon glyphicon-tag" title="<?php echo $objlang->get('text_tags');?>"></span>
					<?php 	$i = 1; foreach( $tags as $tag => $tagLink ) { ?>
						<a class="color" href="<?php echo $tagLink; ?>" title="<?php echo $tag; ?>"><?php echo $tag; ?></a> <?php if($i<count($tags)) { echo ","; }; ?>
					<?php $i++; }  ?>
					<hr>
				 </div>
				 <?php } ?>
					
				 <div class="row">

						<?php if( !empty($samecategory) ) { ?>						
						<div class="col-sm-6 col-lg-6 col-sm-12 col-xs-12">
							<h4><?php echo $objlang->get('text_in_same_category');?></h4>
							<ul class="list-arrow">
								<?php foreach( $samecategory as $item ) { ?>
								<li><a href="<?php echo $objurl->link('pavblog/blog',"id=".$item['blog_id']);?>"><?php echo $item['title'];?></a></li>
								<?php } ?>
							</ul>
						</div>
						<?php } ?>

						<?php if( !empty($related) ) { ?>
						<div class="col-sm-6 col-lg-6 col-sm-12 col-xs-12">
							<h4><?php echo $objlang->get('text_in_related_by_tag');?></h4>
							<ul class="list-arrow">
								<?php foreach( $related as $item ) { ?>
								<li><a href="<?php echo $objurl->link('pavblog/blog',"id=".$item['blog_id']);?>"><?php echo $item['title'];?></a></li>
								<?php } ?>
							</ul>
						</div>
						<?php } ?>
				</div>
				
				 <div class="pav-comment">
					<?php if( $config->get('blog_show_comment_form') ) { ?>
						<?php if( $config->get('comment_engine') == 'diquis' ) { ?>
					    <div id="disqus_thread"></div>
							<script type="text/javascript">
								//CONFIGURATION VARIABLES: EDIT BEFORE PASTING INTO YOUR WEBPAGE 
								var disqus_shortname = '<?php echo $config->get('diquis_account');?>'; // required: replace example with your forum shortname

								//DON'T EDIT BELOW THIS LINE
								(function() {
									var dsq = document.createElement('script'); dsq.type = 'text/javascript'; dsq.async = true;
									dsq.src = '//' + disqus_shortname + '.disqus.com/embed.js';
									(document.getElementsByTagName('head')[0] || document.getElementsByTagName('body')[0]).appendChild(dsq);
								})();
							</script>
							<noscript>Please enable JavaScript to view the <a href="http://disqus.com/?ref_noscript">comments powered by Disqus.</a></noscript>
							<a href="http://disqus.com" class="dsq-brlink">comments powered by <span class="logo-disqus">Disqus</span></a>

						<?php } elseif( $config->get('comment_engine') == 'facebook' ) { ?>
						<div id="fb-root"></div>
							<script>(function(d, s, id) {
							  var js, fjs = d.getElementsByTagName(s)[0];
							  if (d.getElementById(id)) {return;}
							  js = d.createElement(s); js.id = id;
							  js.src = "//connect.facebook.net/en_US/all.js#xfbml=1&appId=<?php echo $config->get("facebook_appid");?>";
							  fjs.parentNode.insertBefore(js, fjs);
							}(document, 'script', 'facebook-jssdk'));</script>
							<div class="fb-comments" data-href="<?php echo $link; ?>" 
									data-num-posts="<?php echo $config->get("comment_limit");?>" data-width="<?php echo $config->get("facebook_width")?>">
							</div>
						<?php }else { ?>
							<?php if( count($comments) ) { ?>
							<h4><?php echo $objlang->get('text_list_comments'); ?></h4>
							<div class="pave-listcomments">
								<?php foreach( $comments as $comment ) {  $default='';?>
								<div class="comment-item clearfix" id="comment<?php echo $comment['comment_id'];?>">
									
									<div class="comment-wrap">
										<div class="comment-meta">
										<img class ="img-responsive" src="<?php echo "http://www.gravatar.com/avatar/" . md5( strtolower( trim( $comment['email'] ) ) ) . "?d=" . urlencode( $default ) . "&s=30" ?>" align="left"/>
										<span class="comment-created"><?php echo $objlang->get('text_created');?> <span><?php echo $comment['created'];?></span></span>
										<span class="comment-postedby"><?php echo $objlang->get('text_postedby');?> <span><?php echo $comment['user'];?></span></span>
										</div>
										<?php echo $comment['comment'];?>
										<span class="comment-link"><a href="<?php echo $link;?>#comment<?php echo $comment['comment_id'];?>"><?php echo $objlang->get('text_comment_link');?></a></span>
									</div>
								</div>
								<?php } ?>
								<div class="pagination">
									<?php echo $pagination;?>
								</div>
							</div>
							<?php } ?>
							<h4><?php echo $objlang->get("text_leave_a_comment");?></h4>
							<form action="<?php echo $comment_action;?>" method="post" id="comment-form" class="form-horizontal">
								<fieldset>
									
									<div class="message" style="display:none"></div>
									<div class="form-group required">
										<div class="col-sm-4 col-lg-4 col-sm-12 col-xs-12">
											<input class="form-control" type="text" name="comment[user]" value="" id="comment-user" placeholder="<?php echo $objlang->get('entry_name');?>" />
										</div>
									</div>

									<div class="form-group required">
										<div class="col-sm-4 col-lg-4 col-sm-12 col-xs-12">
											<input class="form-control" type="text" name="comment[email]" value="" id="comment-email" placeholder="<?php echo $objlang->get('entry_email');?>"/>
										</div>
									</div>

									<div class="form-group required">
										<div class="col-sm-12 col-lg-12 col-sm-12 col-xs-12">
											<textarea class="form-control" name="comment[comment]"  id="comment-comment" placeholder="<?php echo $objlang->get('entry_comment');?>"></textarea>
										</div>
									</div>

									<?php if( $config->get('enable_recaptcha') ) { ?>
									<div class="form-group required captcha">
									<div class="col-sm-12 col-lg-12 col-sm-12 col-xs-12"><label><?php echo $entry_captcha; ?></label></div>
											<div class="col-sm-2 col-lg-3 col-md-12 col-xs-12">
												<img src="index.php?route=tool/captcha" alt="" aligh="left"/>
											</div>										 
										 <div class="col-sm-2 col-lg-3 col-sm-12 col-xs-12">										    
										    <input class="form-control" type="text" name="captcha" value="<?php echo $captcha; ?>" size="10" />
									    </div>
									
								<input type="hidden" name="comment[blog_id]" value="<?php echo $blog['blog_id']; ?>" />									
									<div class="buttons col-sm-6">
				                        <div class="pull-right">
				                            <button class="btn btn-primary pull-right" type="submit">
												<span><?php echo $objlang->get('text_submit');?></span>
											</button>
				                        </div>
			                    	</div>

									</div>
									<?php } ?>

								</fieldset>
							</form>
							<script type="text/javascript">
								$( "#comment-form .message" ).hide();
								$("#comment-form").submit( function(){
									$.ajax( {type: "POST",url:$("#comment-form").attr("action"),data:$("#comment-form").serialize(), dataType: "json",}).done( function( data ){
										if( data.hasError ){
											$( "#comment-form .message" ).html( data.message ).show();	
										}else {
											location.href='<?php echo str_replace("&amp;","&",$link);?>';
										}
									} );
									return false;
								} );
								
							</script>
						<?php } ?>
					<?php } ?>
			</div>
	</div>		
</div>
		
<?php if ($products) { ?>
      <h3><?php echo $text_related; ?></h3>
      <div class="row">
        <?php $i = 0; ?>
        <?php foreach ($products as $product) { ?>
        <?php if ($column_left && $column_right) { ?>
        <?php $class = 'col-lg-6 col-md-6 col-sm-12 col-xs-12'; ?>
        <?php } elseif ($column_left || $column_right) { ?>
        <?php $class = 'col-lg-4 col-md-4 col-sm-6 col-xs-12'; ?>
        <?php } else { ?>
        <?php $class = 'col-lg-3 col-md-3 col-sm-6 col-xs-12'; ?>
        <?php } ?>
        <div class="<?php echo $class; ?>">
          <div class="product-thumb transition">
            <div class="image"><a href="<?php echo $product['href']; ?>"><img src="<?php echo $product['thumb']; ?>" alt="<?php echo $product['name']; ?>" title="<?php echo $product['name']; ?>" class="img-responsive" /></a></div>
            <div class="caption">
              <h4><a href="<?php echo $product['href']; ?>"><?php echo $product['name']; ?></a></h4>
              <p><?php echo $product['description']; ?></p>
              <?php if ($product['rating']) { ?>
              <div class="rating">
                <?php for ($i = 1; $i <= 5; $i++) { ?>
                <?php if ($product['rating'] < $i) { ?>
                <span class="fa fa-stack"><i class="fa fa-star-o fa-stack-1x"></i></span>
                <?php } else { ?>
                <span class="fa fa-stack"><i class="fa fa-star fa-stack-1x"></i><i class="fa fa-star-o fa-stack-1x"></i></span>
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
              <button type="button" onclick="cart.add('<?php echo $product['product_id']; ?>', '<?php echo $product['minimum']; ?>');"><span class="hidden-xs hidden-sm hidden-md"><?php echo $button_cart; ?></span> <i class="fa fa-shopping-cart"></i></button>
              <button type="button" data-toggle="tooltip" title="<?php echo $button_wishlist; ?>" onclick="wishlist.add('<?php echo $product['product_id']; ?>');"><i class="fa fa-heart"></i></button>
              <button type="button" data-toggle="tooltip" title="<?php echo $button_compare; ?>" onclick="compare.add('<?php echo $product['product_id']; ?>');"><i class="fa fa-exchange"></i></button>
            </div>
          </div>
        </div>
       
      
		
		 <?php if (($column_left && $column_right) && ($i % 2 == 0)) { ?>
       
        <?php } elseif (($column_left || $column_right) && ($i % 3 == 0)) { ?>
        
        <?php } elseif ($i % 4 == 0) { ?>
      
        <?php } ?>
        <?php $i++; ?>
        <?php } ?>
		
		</div>
      <?php } ?>
		
		<?php echo $content_bottom; ?></div>
    <?php echo $column_right; ?></div>
</div>
<?php echo $footer; ?>
<?php
function rdate($param, $time=0) {
    if(intval($time)==0)$time=time();
    $MonthNames=array("Января", "Февраля", "Марта", "Апреля", "Мая", "Июня", "Июля", "Августа", "Сентября", "Октября", "Ноября", "Декабря");
    if(strpos($param,'M')===false) return date($param, $time);
        else return date(str_replace('M',$MonthNames[date('n',$time)-1],$param), $time);
}
 ?>