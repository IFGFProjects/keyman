<?php echo $header; ?><?php echo $column_left; ?>
<div id="content">
  <div class="page-header">
    <div class="container-fluid">
      <div class="pull-right">
        <button type="submit" form="form-information" data-toggle="tooltip" title="Сохранить" class="btn btn-primary"><i class="fa fa-save"></i></button>
        <a href="<?php echo $cancel; ?>" data-toggle="tooltip" title="Отменить" class="btn btn-default"><i class="fa fa-reply"></i></a></div>
      <h1><?php echo $heading_title; ?></h1>
      <ul class="breadcrumb">
        <?php foreach ($breadcrumbs as $breadcrumb) { ?>
        <li><a href="<?php echo $breadcrumb['href']; ?>"><?php echo $breadcrumb['text']; ?></a></li>
        <?php } ?>
      </ul>
    </div>
  </div>
  <div class="container-fluid">
    <div class="panel panel-default">
      <div class="panel-heading">
        <h3 class="panel-title"><i class="fa fa-pencil"></i> <?php echo $text_form; ?></h3>
      </div>
      <div class="panel-body">
        <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="form-information" class="form-horizontal">
          <ul class="nav nav-tabs">
            <li class="active"><a href="#tab-general" data-toggle="tab">Основное</a></li>
          </ul>
          <div class="tab-content">
            <div class="tab-pane active" id="tab-general">
              <div class="tab-content">
                  <div class="form-group">
                    <label class="col-sm-2 control-label" for="input-title">Название</label>
                    <div class="col-sm-10">
                      <input type="text" name="vacancies[vc_name]" value="<?php echo $vc_name; ?>" placeholder="Название вакансии" id="input-title" class="form-control" />
                    </div>
                  </div>
                  <div class="form-group">
                    <label class="col-sm-2 control-label" for="input-description">Текст</label>
                    <div class="col-sm-10">
                      <textarea name="vacancies[vc_text]" id="input-description" class="form-control"><?php echo $vc_text?></textarea>
                    </div>
                  </div>
                  <div class="form-group">
                    <label class="col-sm-2 control-label" for="input-price">Цена</label>
                    <div class="col-sm-10">
                      <input type="text" name="vacancies[vc_price]" value="<?php echo $vc_price; ?>" placeholder="0" id="input-price" class="form-control" />
                    </div>
                  </div>
                  <div class="form-group">
                    <label class="col-sm-2 control-label" for="input-email">Email</label>
                    <div class="col-sm-10">
                      <input type="text" name="vacancies[vc_email]" value="<?php echo $vc_email; ?>" id="input-email" class="form-control" />
                    </div>
                  </div>

                  <div class="form-group">
                    <label class="col-sm-2 control-label" for="input-status">Статус</label>
                    <div class="col-sm-10">
                      <select class="form-control" name="vacancies[vc_status]" >
                        <option value="1" <?php if ($vc_status==1) {?> selected <?php } ?>>Включено</option>
                        <option value="0" <?php if ($vc_status==0) {?> selected <?php } ?>>Отключено</option>
                      </select>
                    </div>
                  </div>


              </div>
            </div>

          </div>
        </form>
      </div>
    </div>
  </div>
  <script type="text/javascript"><!--
$('#input-description').summernote({
	height: 300
});
//--></script>
  <script type="text/javascript"><!--
$('#language a:first').tab('show');
//--></script></div>
<?php echo $footer; ?>