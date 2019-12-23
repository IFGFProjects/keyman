<div class="form-group">
  <label class="col-sm-2 control-label"><?php echo $title; ?></label>
  <div class="col-sm-10"><a href="" id="thumb-image-<?php echo $language_id."-".$name; ?>" data-toggle="image" class="img-thumbnail"><img src="<?php echo $thumb; ?>" alt="" title="" data-placeholder="<?php echo $placeholder; ?>" /></a>
    <input type="hidden" name="<?php echo $hcv_name; ?>" value="<?php echo $value; ?>" id="input-image-<?php echo $language_id."-".$name; ?>" />
  </div>
</div>