<?php echo $header; ?>
    <section class="category-title remind-password">
        <h1 class="ttu h1"><span>Забыли пароль?</span></h1>
    </section>
   
<form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data">    
    <section class="email-in-block">
        <div class="container-fluid">
           <div class="col-sm-12">
            <h2 class="email-in-title">Введите Ваш email и мы вышлем Вам новый пароль</h2>
            <div class="row">
               <div class="col-sm-5">
                   <input type="text" class="form-control input-lg" name="email" value="" placeholder="<?php echo $entry_email; ?>" id="input-email">
               </div>
                <div class="col-sm-7">
                    <input type="submit" class="btn btn-primary btn-lg">
                </div>
                <div class="clearfix"></div>
              </div>
            </div>
          </div>
    </section>
</form>
<!-- 
<div class="container">
  <ul class="breadcrumb">
    <?php foreach ($breadcrumbs as $breadcrumb) { ?>
    <li><a href="<?php echo $breadcrumb['href']; ?>"><?php echo $breadcrumb['text']; ?></a></li>
    <?php } ?>
  </ul>
  <?php if ($error_warning) { ?>
  <div class="alert alert-danger"><i class="fa fa-exclamation-circle"></i> <?php echo $error_warning; ?></div>
  <?php } ?>
  <div class="row"><?php echo $column_left; ?>
    <?php if ($column_left && $column_right) { ?>
    <?php $class = 'col-sm-6'; ?>
    <?php } elseif ($column_left || $column_right) { ?>
    <?php $class = 'col-sm-9'; ?>
    <?php } else { ?>
    <?php $class = 'col-sm-12'; ?>
    <?php } ?>
    <div id="content" class="<?php echo $class; ?>"><?php echo $content_top; ?>
      <h1><?php echo $heading_title; ?></h1>
      <p><?php echo $text_email; ?></p>
      <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" class="form-horizontal">
        <fieldset>
          <legend><?php echo $text_your_email; ?></legend>
          <div class="form-group required">
            <label class="col-sm-2 control-label" for="input-email"><?php echo $entry_email; ?></label>
            <div class="col-sm-10">
              <input type="text" name="email" value="" placeholder="<?php echo $entry_email; ?>" id="input-email" class="form-control" />
            </div>
          </div>
        </fieldset>
        <div class="buttons clearfix">
          <div class="pull-left"><a href="<?php echo $back; ?>" class="btn btn-default"><?php echo $button_back; ?></a></div>
          <div class="pull-right">
            <input type="submit" value="<?php echo $button_continue; ?>" class="btn btn-primary" />
          </div>
        </div>
      </form>
      <?php echo $content_bottom; ?></div>
    <?php echo $column_right; ?></div>
</div>
-->
<?php echo $footer; ?>