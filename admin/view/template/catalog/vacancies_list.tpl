<?php echo $header; ?><?php echo $column_left; ?>
<div id="content">
  <div class="page-header">
    <div class="container-fluid">
      <div class="pull-right"><a href="<?php echo $add; ?>" data-toggle="tooltip" title="добавить" class="btn btn-primary"><i class="fa fa-plus"></i></a>
        <button type="button" data-toggle="tooltip" title="удалить" class="btn btn-danger" onclick="confirm('точно удалить?') ? $('#form-information').submit() : false;"><i class="fa fa-trash-o"></i></button>
      </div>
      <h1>Вакансии</h1>
      <ul class="breadcrumb">
        <?php foreach ($breadcrumbs as $breadcrumb) { ?>
        <li><a href="<?php echo $breadcrumb['href']; ?>"><?php echo $breadcrumb['text']; ?></a></li>
        <?php } ?>
      </ul>
    </div>
  </div>
  <div class="container-fluid">
    <?php /* if ($error_warning) { ?>
    <div class="alert alert-danger"><i class="fa fa-exclamation-circle"></i> <?php echo $error_warning; ?>
      <button type="button" class="close" data-dismiss="alert">&times;</button>
    </div>
    <?php } ?>
    <?php if ($success) { ?>
    <div class="alert alert-success"><i class="fa fa-check-circle"></i> <?php echo $success; ?>
      <button type="button" class="close" data-dismiss="alert">&times;</button>
    </div>
    <?php } */ ?>
    <div class="panel panel-default">
      <div class="panel-heading">
        <h3 class="panel-title"><i class="fa fa-list"></i>Вакансии</h3>
      </div>
      <div class="panel-body">
        <form action="<?php echo $delete; ?>" method="post" enctype="multipart/form-data" id="form-information">
          <div class="table-responsive">
            <table class="table table-bordered table-hover">
              <thead>
                <tr>
                  <td style="width: 1px;" class="text-center"><input type="checkbox" onclick="$('input[name*=\'selected\']').prop('checked', this.checked);" /></td>
                  <td class="text-right">
                    <a >ID</a>
                  </td>
                  <td class="text-right">
                  	<a>Название</a>
                  </td>
                  <td class="text-right">
                  	<a>Цена</a>
                  </td>
                  <td class="text-right">
                  	<a>Статус</a>
                  </td>
                  <td class="text-right">Действия</td>
                </tr>
              </thead>
              <tbody>
                <?php if ($vacancies) { ?>
                <?php foreach ($vacancies as $vc_id => $vacancy) { ?>
                <tr>
                  <td class="text-center"><?php if (in_array($vacancy['id'], $selected)) { ?>
                    <input type="checkbox" name="selected[]" value="<?php echo $vacancy['id']; ?>" checked="checked" />
                    <?php } else { ?>
                    <input type="checkbox" name="selected[]" value="<?php echo $vacancy['id']; ?>" />
                    <?php } ?></td>
                  <td class="text-left"><?php echo $vacancy['id']; ?></td>
                  <td class="text-left"><?php echo $vacancy['name']; ?></td>
                  <td class="text-left"><?php echo $vacancy['price']; ?></td>
                  <td class="text-left"><?php if ($vacancy['status']==1) {echo "открыта";} else {echo "закрыта";} ?></td>
                  <td class="text-right"><a href="<?php echo $vacancy['edit']; ?>" data-toggle="tooltip" title="редактировать" class="btn btn-primary"><i class="fa fa-pencil"></i></a></td>
                </tr>
                <?php } ?>
                <?php } else { ?>
                <tr>
                  <td class="text-center" colspan="6">Нет вакансий</td>
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