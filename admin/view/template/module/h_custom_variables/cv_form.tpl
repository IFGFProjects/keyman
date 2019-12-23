<?php echo $header; ?><?php echo $column_left; ?>
<div id="content">
    <div class="page-header">
        <div class="container-fluid">
            <div class="pull-right">
                <button type="submit" form="form-variable" data-toggle="tooltip" title="<?php echo $button_save; ?>" class="btn btn-success"><i class="fa fa-check"></i></button>
                <a href="<?php echo $cancel; ?>" data-toggle="tooltip" title="<?php echo $button_cancel; ?>" class="btn btn-default"><i class="fa fa-times-circle text-danger"></i></a></div>
            <h1><?php echo $heading_title; ?></h1>
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
                <h3 class="panel-title"><i class="fa fa-pencil"></i> <?php echo $text_edit; ?></h3>
            </div>
            <div class="panel-body">
                <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="form-variable" class="form-horizontal">

                    <div class="form-group required">
                        <label class="col-sm-2 control-label" for="input-name"><?php echo $text_hcv_tabs_name_row; ?></label>
                        <div class="col-sm-10">
                            <input type="text" name="name" value="<?php echo $name; ?>" placeholder="<?php echo $text_hcv_tabs_name_row; ?>" id="input-name" class="form-control" />
                            <?php if (isset($error_name)) { ?>
                            <div class="text-danger"><?php echo $error_name; ?></div>
                            <?php } ?>
                        </div>
                    </div>

                    <div class="form-group required">
                        <label class="col-sm-2 control-label" for="input-title"><?php echo $text_hcv_tabs_title_row; ?></label>
                        <div class="col-sm-10">
                            <input type="text" name="title" value="<?php echo $title; ?>" placeholder="<?php echo $text_hcv_tabs_title_row; ?>" id="input-title" class="form-control" />
                            <?php if (isset($error_title)) { ?>
                            <div class="text-danger"><?php echo $error_title; ?></div>
                            <?php } ?>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-sm-2 control-label" for="input-tab"><?php echo $text_hcv_tabs_tab_name_row; ?></label>
                        <div class="col-sm-10">
                            <select name="tab_name">
                                <?php foreach ($tabs_list as $tname => $ttitle) { ?>
                                  <?php if ($tab_name == $tname) { ?>
                                    <option value="<?php echo $tname; ?>" selected="selected"><?php echo $ttitle['title']; ?></option>
                                  <?php } else { ?>
                                    <option value="<?php echo $tname; ?>"><?php echo $ttitle['title']; ?></option>
                                  <?php } ?>
                                <?php } ?>
                            </select>
                        </div>
                    </div>


                    <div class="form-group">
                        <label class="col-sm-2 control-label" for="input-type"><?php echo $text_hcv_tabs_type_row; ?></label>
                        <div class="col-sm-10">
                            <select name="type">
                                <?php foreach ($types_list as $tp) { ?>
                                  <?php if ($type == $tp) { ?>
                                    <option value="<?php echo $tp; ?>" selected="selected"><?php echo $tp; ?></option>
                                  <?php } else { ?>
                                    <option value="<?php echo $tp; ?>"><?php echo $tp; ?></option>
                                  <?php } ?>
                                <?php } ?>
                            </select>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-sm-2 control-label" for="input-required"><?php echo $text_hcv_tabs_required_row; ?></label>
                        <div class="col-sm-10">
                          <div class="checkbox">
                            <label>
                              <input type="checkbox" name="required" <?php if ($required) { ?> checked="checked" <?php } ?>/>
                            </label>
                          </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-sm-2 control-label" for="input-default"><?php echo $text_hcv_tabs_default_row; ?></label>
                        <div class="col-sm-10">
                          <textarea name="default_value" id="" cols="50" rows="5"><?php echo $default_value; ?></textarea>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-sm-2 control-label" for="input-note"><?php echo $text_hcv_tabs_note_row; ?></label>
                        <div class="col-sm-10">
                          <textarea name="note" id="" cols="50" rows="5"><?php echo $note; ?></textarea>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-sm-2 control-label" for="input-status"><?php echo $text_hcv_tabs_status_row; ?></label>
                        <div class="col-sm-10">
                            <select name="status" id="input-status" class="form-control">
                              <?php foreach ($statuses as $skey => $status_text) { ?>
                                <option value="<?php echo $skey; ?>" <?php if ($skey==$status) {?> selected="selected" <?php } ?>>
                                  <?php echo $status_text; ?></option>
                              <?php } ?>
                            </select>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-sm-2 control-label" for="input-sort_order"><?php echo $text_hcv_tabs_sort_order_row; ?></label>
                        <div class="col-sm-10">
                            <input type="text" name="sort_order" value="<?php echo $sort_order;?>" id="input-sort_order" class="form-control"/>
                        </div>
                    </div>


                </form>
            </div>
        </div>
    </div>
</div>
<?php echo $footer; ?>