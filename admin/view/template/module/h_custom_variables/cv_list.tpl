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
        <h3 class="panel-title"><i class="fa fa-pencil"></i> <?php echo $text_hcv_tabs_title; ?></h3>
      </div>
      <div class="panel-body">
        <div class="table-responsive">
          <table class="table table-bordered table-hover">
            <thead>
              <tr>
                <td class="text-left"><?php  echo $text_hcv_tabs_title_row; ?></td>
                <td class="text-left"><?php  echo $text_hcv_tabs_name_row; ?></td>
                <td class="text-left"><?php  echo $text_hcv_tabs_action_row; ?></td>
              </tr>
            </thead>
            <tbody>
              <?php foreach ($tabs_list as $tab_name => $tab) { ?>
              <tr>
                <td class="text-left"><a href="<?php echo $tab_link_base."&tab=".$tab_name; ?>"><strong><?php echo $tab['title']; ?></strong></a></td>
                <td class="text-left"><?php echo $tab_name; ?></td>
                <td class="text-right"></td>
              </tr>
            
              <?php if ($selected_tab!="") {?>
                <?php if ($selected_tab==$tab_name) {?>
                  <?php if (isset($variables[$selected_tab])) {?>

                    <?php foreach ($variables[$selected_tab] as $vkey => $var) {?>
                      <tr>
                        <td class="text-left">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href="<?php echo $var['href']; ?>"><?php echo $var['title']; ?></a></td>
                        <td class="text-left">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $var['name']; ?></td>
                        <td class="text-right">
                          <a href="<?php echo $var['href']; ?>" data-toggle="tooltip" title="<?php echo $button_edit; ?>" class="btn btn-primary"><i class="fa fa-pencil"></i></a>
                        </td>
                      </tr>
                    <?php } ?>
    
                  <?php } else { ?>
                      <tr>
                        <td class="text-center" colspan="11"><?php echo $text_no_results; ?></td>
                      </tr>
                  <?php } ?>
                <?php } ?>
              <?php } ?>

              <?php } ?>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
</div>
<style type="text/css">
  .table-hover tr {cursor: pointer;}
</style>
<?php echo $footer; ?>