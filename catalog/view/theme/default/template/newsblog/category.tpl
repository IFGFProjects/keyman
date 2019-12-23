<?php echo $header; ?>



<section class="category-title title_blog">
    <!-- <h1 class="ttu h1 mb0">Блог</h1> -->
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
<?php 
	if(isset($categories) && !empty($categories)):
?>
<section class="blog-nav">
   <div class="container-fluid">
    <div class="col-xs-12">
        <div class="blog-menu">
                <div class="col-md-9 col-sm-12">
                    <ul>
                        <?php foreach ($categories as $category) { ?>
                        <li <?php if (isset($category['active']) && !empty($category['active'])) {?> class="active" <?php } ?> ><a href="<?php echo $category['href']; ?>"><?php echo $category['name']; ?></a></li>
                        <?php } ?>
                    </ul>
                </div>
                <div class="clearfix"></div>
        </div>
    </div>
    </div>
</section>
<?php endif; ?>
<section class="blog-content">
	<div class="container-fluid container-wrap">
		<div class="col-md-12 flex-wrapper">
			<?php foreach( $articles as $article) { ?>
				<div class="article-newsblog-block custom_news_block col-md-4 col-sm-12 col-xs-12">
				    <div class="article-newsblog-block-wrap">
	                    <a href="<?php echo $article['href'];?>" class="artimg">
	                    	<img class="article-newsblog-img" src="<?php echo $article['original']; ?>">
	                    </a>
	                    <div class="article-newsblog-titles">
				            <h3 class=""><a href="<?php echo $article['href'];?>"><?php echo $article['name'];?></a></h3>
				        </div>
			    	</div>
				</div>
			<?php } ?>
    	</div>
      <!-- <div class="col-sm-4">
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
      </div> -->
	<div class="clearfix"></div>
	</div>
</section>

<div class="paging text-center"><?php echo $pagination;?></div>

<!-- <?php if (!$categories && !$articles) { ?>
	<p><?php echo $text_empty; ?></p>
	<div class="buttons">
		<div class="pull-right"><a href="<?php echo $continue; ?>" class="btn btn-primary"><?php echo $button_continue; ?></a></div>
	</div>
<?php } ?> -->

<?php echo $content_bottom; ?>
<?php echo $column_right; ?>
<?php echo $footer; ?>

<?php
function rdate($param, $time=0) {
    if(intval($time)==0)$time=time();
    $MonthNames=array("Января", "Февраля", "Марта", "Апреля", "Мая", "Июня", "Июля", "Августа", "Сентября", "Октября", "Ноября", "Декабря");
    if(strpos($param,'M')===false) return date($param, $time);
        else return date(str_replace('M',$MonthNames[date('n',$time)-1],$param), $time);
}
 ?>