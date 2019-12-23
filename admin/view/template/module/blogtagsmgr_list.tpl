<?php echo $header; ?><?php echo $column_left; ?>
<div id="content">
  <div class="page-header">
    <div class="container-fluid">
      <div class="pull-right">
          <a href="<?php echo $link_add; ?>" data-toggle="tooltip" title="<?php echo $button_add; ?>" class="btn btn-primary">
            <i class="fa fa-plus"></i>
          </a>
          <button type="button" data-toggle="tooltip" title="<?php echo $button_delete; ?>" class="btn btn-danger" onclick="confirm('<?php echo $text_confirm; ?>') ? $('#form-tag').submit() : false;"><i class="fa fa-trash-o"></i></button>
            </div>
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

                <form action="<?php echo $link_delete; ?>" method="post" enctype="multipart/form-data" id="form-tag">
                  <div class="table-responsive">
                    <table class="table table-bordered table-hover">
                      <thead>
                        <tr>
                          <td style="width: 1px;" class="text-center"><input type="checkbox" onclick="$('input[name*=\'selected\']').prop('checked', this.checked);" /></td>
                          <td class="text-left"><?php if ($sort == 'tg.tag_name') { ?>
                            <a href="<?php echo $link_list.'&sort='.$sort.'&order='.$un_order; ?>" class="<?php echo strtolower($order); ?>"><?php echo $tag_text_name; ?></a>
                            <?php } else { ?>
                            <a href="<?php echo $link_list.'&sort=tg.tag_name'; ?>"><?php echo $tag_text_name; ?></a>
                            <?php } ?>
                          </td>
                          <td class="text-left"><?php if ($sort == 'tg.link') { ?>
                            <a href="<?php echo $link_list.'&sort='.$sort.'&order='.$un_order; ?>" class="<?php echo strtolower($order); ?>"><?php echo $tag_text_link; ?></a>
                            <?php } else { ?>
                            <a href="<?php echo $link_list.'&sort=tg.link'; ?>"><?php echo $tag_text_link; ?></a>
                            <?php } ?>
                          </td>
                          <td class="text-left"><?php if ($sort == 'tg.category_id') { ?>
                            <a href="<?php echo $link_list.'&sort='.$sort.'&order='.$un_order; ?>" class="<?php echo strtolower($order); ?>"><?php echo $tag_text_category; ?></a>
                            <?php } else { ?>
                            <a href="<?php echo $link_list.'&sort=tg.category_id'; ?>"><?php echo $tag_text_category; ?></a>
                            <?php } ?>
                          </td>
                          <td class="text-right"><?php echo $column_action; ?></td>
                        </tr>
                      </thead>
                      <tbody>
                        <?php if ($tags) { ?>
                        <?php foreach ($tags as $tag) { ?>
                        <tr>
                          <td class="text-center"><?php if (in_array($tag['tag_id'], $selected)) { ?>
                            <input type="checkbox" name="selected[]" value="<?php echo $tag['tag_id']; ?>" checked="checked" />
                            <?php } else { ?>
                            <input type="checkbox" name="selected[]" value="<?php echo $tag['tag_id']; ?>" />
                            <?php } ?></td>
                          <td class="text-left"><?php echo $tag['name']; ?></td>
                          <td class="text-left"><?php echo $tag['link']; ?></td>
                          <td class="text-left"><?php echo $tag['category_name']; ?></td>                          
                          <td class="text-right">
                  <a target="_blank" href="<?php echo $tag['href_shop']; ?>" data-toggle="tooltip" title="<?php echo $button_shop; ?>" class="btn btn-success"><i class="fa fa-eye"></i></a>
                  <a href="<?php echo $tag['edit_link']; ?>" data-toggle="tooltip" title="<?php echo $button_edit; ?>" class="btn btn-primary"><i class="fa fa-pencil"></i></a>
                  </td>
                        </tr>
                        <?php } ?>
                        <?php } else { ?>
                        <tr>
                          <td class="text-center" colspan="11"><?php echo $text_no_results; ?></td>
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