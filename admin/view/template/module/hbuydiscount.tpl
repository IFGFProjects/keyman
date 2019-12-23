<?php echo $header; ?><?php echo $column_left; ?>
<div id="content">
  <div class="page-header">
  <div class="container-fluid">
    <div class="pull-right">
      <button type="submit" form="discount_form" data-toggle="tooltip" title="<?php echo $button_save; ?>" class="btn btn-primary"><i class="fa fa-save"></i></button>
      <a href="<?php echo $cancel; ?>" data-toggle="tooltip" title="<?php echo $button_cancel; ?>" class="btn btn-default"><i class="fa fa-reply"></i></a></div>
    <h1><?php echo $heading_title; ?></h1>
    <ul class="breadcrumb">
      <?php foreach ($breadcrumbs as $breadcrumb) { ?>
      <li><a href="<?php echo $breadcrumb['href']; ?>"><?php echo $breadcrumb['text']; ?></a></li>
      <?php } ?>
    </ul>
  </div>
    <div class="container-fluid">
      <div class="panel panel-default">
        <div class="panel-heading">
          <h3 class="panel-title"><i class="fa fa-pencil"></i> Настройки модуля</h3>
        </div>
        <div class="panel-body">
          <form action="<?php echo $action; ?>" id="discount_form" method="post" enctype="multipart/form-data" class="form-horizontal">

              <table class="table table-bordered table-hover" id="attribute">
               <thead>
                 <tr>
                   <td class="text-left" style="width:25% !important;"><?php echo $table_col_from; ?></td>
                   <td class="text-left" style="width:25% !important;"><?php echo $table_col_to; ?></td>
                   <td class="text-left" style="width:25% !important;"><?php echo $table_col_discount; ?> (%)</td>
                   <td class="text-left" style="width:25% !important;"><?php echo $table_col_status; ?></td>
                 </tr>
               </thead>
               <tbody>
                 <?php foreach ($discounts_data as $dkey => $discount) 
                 {?>
                   <tr>
                     <td>
                      <input class="form-control" type="text" style="width:100%;" name="discount[<?php echo $discount['discount_id']; ?>][from_value]" value="<?php echo $discount['from_value']; ?>" />
                     </td>
                     <td>
                      <input class="form-control" type="text" style="width:100%;" name="discount[<?php echo $discount['discount_id']; ?>][to_value]" value="<?php echo $discount['to_value']; ?>" />
                     </td>
                     <td>
                      <input class="form-control" type="text" style="width:100%;" name="discount[<?php echo $discount['discount_id']; ?>][discount_percent]" value="<?php echo $discount['discount_percent']; ?>" />
                     </td>
                     <td>
                       <select class="form-control" name="discount[<?php echo $discount['discount_id']; ?>][status]" >
                        <?php foreach ($text_statuses as $skey => $tstatus)
                        {?>
                          <option <?php if ($skey==$discount['status']) {?> selected="selected" <?php } ?> value="<?php echo $skey; ?>"><?php echo $tstatus; ?></option>
                        <?php } ?>
                       </select>
                     </td>
                   </tr>
                 <?php } ?>
               </tbody>
              </table>

            </form>
          </div>
        </div>
      </div>
  </div>

</div>
<?php echo $footer; ?>
