<?php echo $header; ?><?php echo $column_left; ?>
<div id="content">
  <div class="page-header">
    <div class="container-fluid">
      <div class="pull-right">
        <button type="submit" form="form-article" data-toggle="tooltip" title="<?php echo $button_save; ?>" class="btn btn-primary"><i class="fa fa-save"></i></button>
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
    <?php if ($error_warning) { ?>
    <div class="alert alert-danger"><i class="fa fa-exclamation-circle"></i> <?php echo $error_warning; ?>
      <button type="button" class="close" data-dismiss="alert">&times;</button>
    </div>
    <?php } ?>
    <div class="panel panel-default">
      <div class="panel-heading">
        <h3 class="panel-title"><i class="fa fa-pencil"></i> <?php echo $text_form; ?></h3>
      </div>
      <div class="panel-body">
        <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="form-article" class="form-horizontal">
          <ul class="nav nav-tabs">
            <li class="active"><a href="#tab-data" data-toggle="tab"><?php echo $tag_tab_data; ?></a></li>
            <li><a href="#tab-general" data-toggle="tab"><?php echo $tag_tab_general; ?></a></li>
          </ul>
          <div class="tab-content">
            <div class="tab-pane active" id="tab-data">
              <div class="form-group required">
                <label class="col-sm-2 control-label" for="input-name"><?php echo $tag_text_name; ?></label>
                <div class="col-sm-10">
                  <input type="text" name="name" value="<?php echo isset($name) ? $name : ''; ?>" placeholder="<?php echo $tag_text_name; ?>" id="input-name" class="form-control" />
                  <?php if (isset($error_name)) { ?>
                  <div class="text-danger"><?php echo $error_name; ?></div>
                  <?php } ?>
                </div>
              </div>
              <div class="form-group required">
                <label class="col-sm-2 control-label" for="input-link"><span data-toggle="tooltip" title="<?php echo $tag_text_link; ?>"><?php echo $tag_text_link; ?></span></label>
                <div class="col-sm-10">
                  <input type="text" name="link" value="<?php if (isset($link)) {echo $link;} ?>" placeholder="<?php echo $tag_text_link; ?>" id="input-link" class="form-control" />
                  <?php if (isset($error_link)) { ?>
                  <div class="text-danger"><?php echo $error_link; ?></div>
                  <?php } ?>
                </div>
              </div>

              <div class="form-group required">
                <label class="col-sm-2 control-label" for="input-category_id"><?php echo $tag_text_category; ?></label>
                <div class="col-sm-10">
<!--                   <input type="text" name="category_name" value="<?php echo isset($category_name) ? $category_name : "" ; ?>" placeholder="<?php echo $tag_text_category; ?>" id="input-category_id" class="form-control" />
                  <input type="hidden" name="category_id" value="<?php echo isset($category_id) ? $category_id : "" ; ?>" />
                  <?php if (isset($error_category)) { ?>
                  <div class="text-danger"><?php echo $error_category; ?></div>
                  <?php } ?> -->
                  <?php echo $categories; ?>
                </div>
              </div>

              <div class="form-group">
                <label class="col-sm-2 control-label" for="input-status"><?php echo $tag_text_status; ?></label>
                <div class="col-sm-10">
                  <select name="status" id="input-status" class="form-control">
                    <?php if ($status) { ?>
                    <option value="1" selected="selected"><?php echo $text_statuses[1]; ?></option>
                    <option value="0"><?php echo $text_statuses[0]; ?></option>
                    <?php } else { ?>
                    <option value="1"><?php echo $text_statuses[0]; ?></option>
                    <option value="0" selected="selected"><?php echo $text_statuses[1]; ?></option>
                    <?php } ?>
                  </select>
                </div>
              </div>
            </div>
            <div class="tab-pane" id="tab-general">
              <ul class="nav nav-tabs" id="language">
                <?php foreach ($languages as $language) { ?>
                <li><a href="#language<?php echo $language['language_id']; ?>" data-toggle="tab"><img src="view/image/flags/<?php echo $language['image']; ?>" title="<?php echo $language['name']; ?>" /> <?php echo $language['name']; ?></a></li>
                <?php } ?>
              </ul>
              <div class="tab-content">
                <?php foreach ($languages as $language) { ?>
                <div class="tab-pane" id="language<?php echo $language['language_id']; ?>">
                  <div class="form-group">
                    <label class="col-sm-2 control-label" for="input-description<?php echo $language['language_id']; ?>"><?php echo $tag_text_description; ?></label>
                    <div class="col-sm-10">
                      <textarea name="tag_description[<?php echo $language['language_id']; ?>][description]" placeholder="<?php echo $tag_text_description; ?>" id="input-description<?php echo $language['language_id']; ?>"><?php echo isset($tag_description[$language['language_id']]) ? $tag_description[$language['language_id']]['description'] : ''; ?></textarea>
                    </div>
                  </div>
                  <div class="form-group">
                    <label class="col-sm-2 control-label" for="input-meta-title<?php echo $language['language_id']; ?>"><?php echo $tag_text_meta_title; ?></label>
                    <div class="col-sm-10">
                      <input type="text" name="tag_description[<?php echo $language['language_id']; ?>][meta_title]" value="<?php echo isset($tag_description[$language['language_id']]) ? $tag_description[$language['language_id']]['meta_title'] : ''; ?>" placeholder="<?php echo $tag_text_meta_title; ?>" id="input-meta-title<?php echo $language['language_id']; ?>" class="form-control" />
                      <?php if (isset($error_meta_title[$language['language_id']])) { ?>
                      <div class="text-danger"><?php echo $error_meta_title[$language['language_id']]; ?></div>
                      <?php } ?>
                    </div>
                  </div>
				  <div class="form-group">
                    <label class="col-sm-2 control-label" for="input-meta-h1<?php echo $language['language_id']; ?>"><?php echo $tag_text_h1; ?></label>
                    <div class="col-sm-10">
                      <input type="text" name="tag_description[<?php echo $language['language_id']; ?>][meta_h1]" value="<?php echo isset($tag_description[$language['language_id']]) ? $tag_description[$language['language_id']]['meta_h1'] : ''; ?>" placeholder="<?php echo $tag_text_h1; ?>" id="input-meta-title<?php echo $language['language_id']; ?>" class="form-control" />
                      <?php if (isset($error_meta_h1[$language['language_id']])) { ?>
                      <div class="text-danger"><?php echo $error_meta_h1[$language['language_id']]; ?></div>
                      <?php } ?>
                    </div>
                  </div>
                  <div class="form-group">
                    <label class="col-sm-2 control-label" for="input-meta-description<?php echo $language['language_id']; ?>"><?php echo $tag_text_meta_descrition; ?></label>
                    <div class="col-sm-10">
                      <textarea name="tag_description[<?php echo $language['language_id']; ?>][meta_description]" rows="5" placeholder="<?php echo $tag_text_meta_descrition; ?>" id="input-meta-description<?php echo $language['language_id']; ?>" class="form-control"><?php echo isset($tag_description[$language['language_id']]) ? $tag_description[$language['language_id']]['meta_description'] : ''; ?></textarea>
                    </div>
                  </div>
                  <div class="form-group">
                    <label class="col-sm-2 control-label" for="input-meta-keyword<?php echo $language['language_id']; ?>"><?php echo $tag_text_meta_keywords; ?></label>
                    <div class="col-sm-10">
                      <textarea name="tag_description[<?php echo $language['language_id']; ?>][meta_keyword]" rows="5" placeholder="<?php echo $tag_text_meta_keywords; ?>" id="input-meta-keyword<?php echo $language['language_id']; ?>" class="form-control"><?php echo isset($tag_description[$language['language_id']]) ? $tag_description[$language['language_id']]['meta_keyword'] : ''; ?></textarea>
                    </div>
                  </div>
                </div>
                <?php } ?>
              </div>
            </div>

          </div>
        </form>
      </div>
    </div>
  </div>
  <script type="text/javascript"><!--
<?php foreach ($languages as $language) { ?>
$('#input-description<?php echo $language['language_id']; ?>').summernote({height: 300});
<?php } ?>
//--></script> 
<?php /* ?>
<script type="text/javascript"><!--
$('input[name=\'category_name\']').autocomplete({
  'source': function(request, response) {
    $.ajax({
      url: 'index.php?route=catalog/category/autocomplete&token=<?php echo $token; ?>&filter_name=' +  encodeURIComponent(request),
      dataType: 'json',
      success: function(json) {
        json.unshift({
          category_id: 0,
          name: '<?php echo $text_none; ?>'
        });

        response($.map(json, function(item) {
          return {
            label: item['name'],
            value: item['category_id']
          }
        }));
      }
    });
  },
  'select': function(item) {
    $('input[name=\'category_name\']').val(item['label']);
    $('input[name=\'category_id\']').val(item['value']);
  }
});
//--></script> 
<?php */ ?>
  <script type="text/javascript"><!--
$('.date').datetimepicker({
	pickTime: false
});

$('.time').datetimepicker({
	pickDate: false
});

$('.datetime').datetimepicker({
	pickDate: true,
	pickTime: true
});
//--></script> 
  <script type="text/javascript"><!--
$('#language a:first').tab('show');
$('#option a:first').tab('show');
//--></script></div>
<?php echo $footer; ?> 