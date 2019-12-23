<?php echo $header; ?><?php echo $column_left; ?>
<div id="content">
  <div class="page-header">
    <div class="container-fluid">
      <div class="pull-right"><a href="<?php echo $add; ?>" data-toggle="tooltip" title="Добавить" class="btn btn-primary"><i class="fa fa-plus"></i></a> 
        <button type="button" data-toggle="tooltip" title="Удалить" class="btn btn-danger" onclick="confirm('Подтвердите удаление') ? $('#form-catbrand').submit() : false;"><i class="fa fa-trash-o"></i></button>
      </div>
      <h1>Таблицы размеров</h1>
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
    <?php if ($success) { ?>
    <div class="alert alert-success"><i class="fa fa-check-circle"></i> <?php echo $success; ?>
      <button type="button" class="close" data-dismiss="alert">&times;</button>
    </div>
    <?php } ?>
    <div class="panel panel-default">
      <div class="panel-heading">
        <h3 class="panel-title"><i class="fa fa-list"></i>Размеры по категории/бренду</h3>
      </div>
      <div class="panel-body">
        <form action="<?php echo $delete; ?>" method="post" enctype="multipart/form-data" id="form-catbrand">
          <div class="table-responsive">
            <table class="table table-bordered table-hover">
              <thead>
                <tr>
                  <td style="width: 1px;" class="text-center"><input type="checkbox" onclick="$('input[name*=\'selected\']').prop('checked', this.checked);" /></td>
                  <td class="text-left">Категория</td>
                  <td class="text-left">Бренд</td>
                  <td class="text-right"></td>
                </tr>
              </thead>
              <tbody>
                <?php if ($catbrands) { ?>
                <?php foreach ($catbrands as $cb) { ?>
                <tr>
                  <td class="text-center"><?php if (in_array($cb['id'], $selected)) { ?>
                    <input type="checkbox" name="selected[]" value="<?php echo $cb['id']; ?>" checked="checked" />
                    <?php } else { ?>
                    <input type="checkbox" name="selected[]" value="<?php echo $cb['id']; ?>" />
                    <?php } ?></td>
                  <td class="text-left"><?php echo $cb['category']; ?></td>
                  <td class="text-right"><?php echo $cb['brand']; ?></td>
                  <td class="text-right"><a href="<?php echo $cb['href']; ?>" data-toggle="tooltip" title="Редактировать" class="btn btn-primary"><i class="fa fa-pencil"></i></a></td>
                </tr>
                <?php } ?>
                <?php } else { ?>
                <tr>
                  <td class="text-center" colspan="4">Пока ничего нету</td>
                </tr>
                <?php } ?>
              </tbody>
            </table>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
<?php echo $footer; ?>