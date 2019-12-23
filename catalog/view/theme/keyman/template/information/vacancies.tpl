<?php echo $header; ?>
<section class="category-title">
    <h1 class="ttu h1 mb0"><?php echo $heading_title; ?></h1>
</section>
<div class="container-fluid">
       <ol class="breadcrumb crumbstyle">
        <li><a href="https://keyman.by">Главная</a> </li>
        <!--<li>Вакансии</li>-->
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
<section class="vacation-block">
   <div class="container-fluid">
   	<?php 
    if (isset($vacancies))
    foreach ($vacancies as $vkey => $vacancy) 
   	{?>
    <div class="col-sm-12 col-md-6">
        <div class="vacation">
            <h2 class="vacation-title"><?php echo $vacancy['name']; ?></h2>
            <div class="vacation-text">
                <p>
                    <?php echo $vacancy['text']; ?>
                </p>
            </div>
            <div class="vacation-pay">
                <span><?php echo $vacancy['price']; ?></span>
            </div>
            <div class="vacation-text">
                <p>
                    Отправьте свое резюме по адресу:<br><a href="#" class="mail"><?php echo $vacancy['email']; ?></a>
                </p>
            </div>
        </div>
    </div>
   	<?php } else { ?>
    <div class="col-sm-12 col-md-6">
        <p>На данный момент нет открытых вакансий.</p>
    </div>
    <?php } ?>
    <div class="clearfix"></div>
    </div>
</section>
<?php echo $content_bottom; ?>
<?php echo $footer; ?>