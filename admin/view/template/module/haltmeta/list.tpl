<?php echo $header; ?><?php echo $column_left;?>
<div id="content">
  <div class="page-header">
    <div class="container-fluid">
      <div class="pull-right">

        <a href="<?php echo $add_link; ?>" data-toggle="tooltip" title="<?php echo $button_add; ?>" class="btn btn-primary"><i class="fa fa-plus"></i></a>
      </div>
      <h1><?php echo $heading_title; ?></h1><br>
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
        <h3 class="panel-title"><i class="fa fa-pencil"></i> <?php echo $text_ham_title; ?></h3>
      </div>
      <div class="panel-body">
        <div class="well">
          <?php foreach ($table_fields as $field_id => $field) 
          {
            if ($field['in_filter'])
            {?>
          <div class="row">
            <div class="col-sm-12">
              <div class="form-group">
                <label class="control-label" for="input-<?php echo $field_id; ?>"><?php echo $field['title']; ?></label>
                <input type="text" name="filter_<?php echo $field_id; ?>" value="<?php echo $field['filter_value']; ?>" placeholder="<?php echo $field['title']; ?>" id="input-<?php echo $field_id; ?>" class="form-control" />
              </div>
            </div>
          </div>
            <?php }
          } ?>
          <div class="row">
            <div class="col-sm-12">
              <button type="button" id="button-filter" class="btn btn-primary pull-right"><i class="fa fa-search"></i> <?php echo $button_filter; ?></button>
            </div>
          </div>
        </div>
        <div class="table-responsive">
          <table class="table table-bordered table-hover">
            <thead>
              <tr>
                <?php foreach ($table_fields as $field_id => $field) 
                {?>
                  <td class="text-left">
                    <a href="<?php echo $field['sort_href']; ?>" <?php if ($field['selected']) {echo "class='".$sort_order."'";} ?>><?php  echo $field['title']; ?></a>
                  </td>
                <?} ?>
                <td class="text-left"></td>
              </tr>
            </thead>
            <tbody>
            <?php if (isset($entries)) {?>
              <?php foreach ($entries as $entry_index => $entry) { ?>
              <tr>
                <?php foreach ($table_fields as $field_id => $field) 
                { ?>
                    <td class="text-left"><?php echo $entry[$field_id]; ?></td>
                <?php } ?>
                  
                <td class="text-right">
                  <a href="<?php echo $entry['edit']; ?>" data-toggle="tooltip" title="<?php echo $button_edit; ?>" class="btn btn-primary"><i class="fa fa-pencil"></i></a>
                  <a href="<?php echo $entry['delete']; ?>" data-toggle="tooltip" title="<?php echo $button_delete; ?>" class="btn btn-danger"><i class="fa fa-trash-o"></i></a>
                </td>
              </tr>
              <?php } ?>
            <?php } else {?>
              <td class="text-center" colspan="<?php echo count($table_fields) ?>"><?php echo $text_no_results; ?></td>
            <?php } ?>
            </tbody>
          </table>
        </div>
        <div class="row">
          <div class="col-sm-6 text-left"><?php echo $pagination; ?></div>
          <div class="col-sm-6 text-right"><?php echo $results; ?></div>
        </div>
      </div>
    </div>
  </div>
</div>
  <script type="text/javascript"><!--
$('#button-filter').on('click', function() {
  var url = '<?php echo $filter_href; ?>';

  <?php foreach ($table_fields as $field_id => $field) 
  {
    if ($field['in_filter'])
    {?>
      var filter_<?php echo $field_id; ?> = $('input[name=\'filter_<?php echo $field_id; ?>\']').val();

      if (filter_<?php echo $field_id; ?>) {
        url += '&filter_<?php echo $field_id; ?>=' + encodeURIComponent(filter_<?php echo $field_id; ?>);
      }
    <?php }
  } ?>

  location = url;
});
//--></script>
<style type="text/css">
  .table-hover tr {cursor: pointer;}
</style>

<?php echo $footer; ?>