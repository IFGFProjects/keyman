<?php echo $header; ?><?php echo $column_left; ?>
<div id="content">
  <div class="page-header">
    <div class="container-fluid">
      <div class="pull-right">
        <button type="submit" form="form-product" data-toggle="tooltip" title="<?php echo $button_save; ?>" class="btn btn-primary"><i class="fa fa-save"></i></button>
        <a href="<?php echo $cancel; ?>" data-toggle="tooltip" title="<?php echo $button_cancel; ?>" class="btn btn-default"><i class="fa fa-reply"></i></a></div>
      <h1><?php echo $heading_title; ?></h1>
      <ul class="breadcrumb">
        <?php foreach ($breadcrumbs as $breadcrumb) { ?>
        <li><a href="<?php echo $breadcrumb['href']; ?>"><?php echo $breadcrumb['text']; ?></a></li>
        <?php } ?>
      </ul>
    </div>
  </div>
  <div class="container-fluid">
    <?php if (isset($errors)) { 
      foreach ($errors as $error_name => $error) 
        { ?>
    <div class="alert alert-danger"><i class="fa fa-exclamation-circle"></i> <?php echo $error; ?>
      <button type="button" class="close" data-dismiss="alert">&times;</button>
    </div>
      <?php }?>
    <?php } ?>
    <div class="panel panel-default">
      <div class="panel-heading">
        <h3 class="panel-title"><i class="fa fa-pencil"></i> <?php echo $text_form; ?></h3>
      </div>
      <div class="panel-body">
        <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="form-product" class="form-horizontal">
        <div class="tab-content">

          <?php foreach ($entry as $field_id => $field) 
          { if ($field['show_on_form'])
            { 
            ?>
            <div class="form-group <?php if ($field['required']) { ?> required <?php } ?> ">
              <label class="col-sm-2 control-label" for="input-<?php echo $field_id; ?>">
                <?php echo $field['title']; ?>
              </label>

              <div class="col-sm-10">

                <?php if ($field['type']=="text") 
                {?>
                  <textarea <?php if (isset($errors['error_'.$field_id])) {?> style="border-color:red;" <?php } ?> name="<?php echo $field_id; ?>" rows="6" placeholder="<?php echo $field['title']; ?>" id="<?php echo $field_id; ?>" class="form-control"><?php echo $field['value']; ?></textarea>

                <?php } elseif ($field_id=="status") { ?>

                  <select <?php if (isset($errors['error_'.$field_id])) {?> style="border-color:red;" <?php } ?> name="<?php echo $field_id; ?>" id="input-<?php echo $field_id; ?>" class="form-control">
                      <?php  foreach ($statuses as $option_value => $option_name) 
                      { ?>
                        <option value="<?php echo $option_value; ?>" <?php if ($field['value']==$option_value) {?> selected <?php } ?> >
                          <?php echo $option_name; ?>
                        </option>
                      <?php } ?>
                  </select>

                <?php } else { ?>

                  <input <?php if (isset($errors[$field_id])) {?> style="border-color:red;" <?php } ?> type="text" name="<?php echo $field_id; ?>" value="<?php echo $field['value']; ?>" placeholder="<?php echo $field['title']; ?>" id="input-tag<?php echo $field_id; ?>" class="form-control" <?php if (!$field['enabled_on_form']) { ?>disabled="disabled"<?php } ?> />
                <?php } ?>
              </div>
            </div>

          <?}
          } ?>
        </div>
        </form>
      </div>
    </div>  
  </div>
</div>