<div class="form-group">
  <label class="col-sm-2 control-label"><?php echo $title; ?></label>
  <div class="col-sm-10">
    <textarea name="<?php echo $hcv_name; ?>"  id="input-description<?php echo $language_id."-".$name; ?>">
    	<?php echo $value; ?>
    </textarea>
  </div>
</div>

  <script type="text/javascript"><!--
$('#input-description<?php echo $language_id."-".$name; ?>').summernote({height: 300});
//--></script>
