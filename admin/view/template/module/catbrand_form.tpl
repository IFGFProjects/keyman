<?php echo $header; ?><?php echo $column_left; ?>
<div id="content">
  <div class="page-header">
    <div class="container-fluid">
      <div class="pull-right">
        <button type="submit" form="form-catbrand" data-toggle="tooltip" title="Сохранить" class="btn btn-primary"><i class="fa fa-save"></i></button>
        <a href="<?php echo $cancel; ?>" data-toggle="tooltip" title="Отменить" class="btn btn-default"><i class="fa fa-reply"></i></a></div>
      <h1>Редактировать</h1>
      <ul class="breadcrumb">
        <?php foreach ($breadcrumbs as $breadcrumb) { ?>
        <li><a href="<?php echo $breadcrumb['href']; ?>"><?php echo $breadcrumb['text']; ?></a></li>
        <?php } ?>
      </ul>
    </div>
  </div>
  <div class="container-fluid">
    <?php if ($error_warning) { ?>
    <div class="alert alert-danger"><i class="fa fa-exclamation-circle"></i> <?php echo $error_warning; ?>
      <button type="button" class="close" data-dismiss="alert">&times;</button>
    </div>
    <?php } ?>
    <div class="panel panel-default">
      <div class="panel-heading">
        <h3 class="panel-title"><i class="fa fa-pencil"></i>Редактировать размеры</h3>
      </div>
      <div class="panel-body">
        <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="form-catbrand" class="form-horizontal">
          <ul class="nav nav-tabs">
            <li class="active"><a href="#tab-general" data-toggle="tab">Основное</a></li>
          </ul>
          <div class="tab-content">
            <div class="tab-pane active" id="tab-general">
              <div class="tab-content">
                  <div class="form-group required">
                    <label class="col-sm-2 control-label" for="category_id">Категория</label>
                    <div class="col-sm-10">
                      <select name="category_id" id="category_id" class="form-control">
                        <?php foreach ($categories->rows as $key => $cat) 
                        {?>
                          <option value="<?php echo $cat['category_id']; ?>" <?php if ($cat['category_id']==$category_id) {?> selected <?php } ?> ><?php echo $cat['name']; ?></option>
                        <?php } ?>
                      </select>
                    </div>
                  </div>                  
                  <div class="form-group required">
                    <label class="col-sm-2 control-label" for="brand_id">Производитель</label>
                    <div class="col-sm-10">
                      <select name="brand_id" id="brand_id" class="form-control">
                        <?php foreach ($brands->rows as $key => $brand) 
                        {?>
                          <option value="<?php echo $brand['brand_id']; ?>" <?php if ($brand['brand_id']==$brand_id) {?> selected <?php } ?> ><?php echo $brand['name']; ?></option>
                        <?php } ?>
                      </select>
                    </div>
                  </div>
                  <div class="form-group">
                    <label class="col-sm-2 control-label" for="text">Таблица размеров</label>
                    <div class="col-sm-10">
                      <textarea name="text" id="text" class="form-control"><?php echo isset($text) ? $text : ''; ?></textarea>
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
$('#language a:first').tab('show');
//--></script>
<script type="text/javascript"><!--
$('#text').summernote({height: 300});
//--></script>
</div>
<?php echo $footer; ?>