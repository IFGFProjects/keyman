<div class="tab-pane" id="tab-attribute">
  <div class="table-responsive">
    <a data-toggle="tooltip" title="" class="btn btn-info" data-original-title="Обновить" onclick="UpdateCategoriesAttributes();"><i class="fa fa-refresh"></i></a>
    <table id="attribute" class="table table-striped table-bordered table-hover">
      <thead>
        <tr>
          <td class="text-left"><?php echo $entry_attribute; ?></td>
          <td class="text-left"><?php echo $entry_text; ?></td>
          <td><?php echo $enum_text; ?></td>
        </tr>
      </thead>
      <tbody>
        <?php $attribute_row = 0;  ?>
        <?php  
        foreach ($attributes as $category_name => $product_attributes) 
        {?>
      <tr>
        <td colspan="3"><strong style="text-align:center; width:100%;float:left;"><?php echo $category_name; ?></strong></td>
      </tr>
        <?php foreach ($product_attributes as $product_attribute) { ?>
        <tr id="attribute-row<?php echo $attribute_row; ?>">
          <td class="text-left" style="width: 20%;">
            <input type="text" disabled="disabled" name="product_attribute[<?php echo $attribute_row; ?>][name]" value="<?php echo $product_attribute['name']; ?>" placeholder="<?php echo $entry_attribute; ?>" class="form-control" />
            <input type="hidden" name="product_attribute[<?php echo $attribute_row; ?>][attribute_id]" value="<?php echo $product_attribute['attribute_id']; ?>" />
          </td>
          <td class="text-left">
            <?php foreach ($languages as $language) { ?>
            <!-- <div class="input-group"> -->
              <?php if ($product_attribute['type']=="combo") 
              { //----------- COMBOBOX FRONT-END -------------- 
                $options=explode("\n", $product_attribute['text_value']);
              ?>
                <select name="product_attribute[<?php echo $attribute_row; ?>][product_attribute_description][<?php echo $language['language_id']; ?>][text]"  class="form-control">
                    <?php foreach ($options as $key => $opt) 
                    {?>
                      <option <?php if ($product_attribute['product_attribute_description'][$language['language_id']]['text']==trim($opt) ) 
                      {echo  " selected='selected' ";}?> value="<?php echo trim($opt) ; ?>"><?php echo trim($opt) ; ?></option>
                    <?php } ?>
                </select>
              <?php } else { 
                //----------  ANY OTHER TYPE OF ATTRIBUTE -----?>
                <input type="text" name="product_attribute[<?php echo $attribute_row; ?>][product_attribute_description][<?php echo $language['language_id']; ?>][text]" placeholder="<?php echo $product_attribute['default_value']; ?>" class="form-control" value="<?php echo $product_attribute['product_attribute_description'][$language['language_id']]['text'] ?>">

              <?php } ?>
            <!-- </div> -->
            <?php } ?></td>
          <td class="text-left" style="width:5%;">
            <?php echo $product_attribute['enum']; ?>
          </td>
        </tr>
        <?php $attribute_row++; ?>
        <?php } ?>
        <?php } ?>
      </tbody>
    </table>
  </div>
</div>

<script type="text/javascript">
  function UpdateCategoriesAttributes()
  {
    var categories="";
    $("#product-category input").each(function(indx, element)
      {categories+="&category[]="+$(element).val();});

    <?php if (isset($_GET['product_id'])) {echo "categories+='&product_id=".(int)$_GET['product_id']."';";} ?>

    $.ajax({
      url: 'index.php?route=module/h_filter/AjaxProductCategoryAttributes&token=<?php echo $_GET["token"]; ?>',
      type: "POST",
      data: categories,
      success: function(data){
        // alert( "Прибыли данные: " + msg );
        $("table#attribute").html($(data).find("table#attribute"));
      }
    });

    // console.log(categories);
  }

  $(document).ready(function(){
    UpdateCategoriesAttributes();
  });
</script>