<div class="tab-pane" id="tab-h_attributes">
  <div class="table-responsive">
    <table class="table table-bordered table-hover" id="attribute">
      <thead>
        <tr>
          <td class="text-left" style="width:20% !important;"><?php echo $attribute_name; ?></td>
          <td class="text-left" style="width:10% !important;"><?php echo $attribute_type; ?></td>
          <td class="text-left" style="width:5%  !important;" ><?php echo $attribute_enum; ?></td>
          <td class="text-left" style="width:40% !important;"><?php echo $attribute_text_value; ?></td>
          <td class="text-left" style="width:10% !important;"><?php echo $attribute_priority; ?></td>
          <td class="text-left" style="width:10% !important;"><?php echo $attribute_status; ?></td>
          <td class="text-left" style="width:5%  !important;" ></td>

        </tr>
      </thead>
      <!-- <tbody> -->
      <?php foreach ($attributes as $key => $atr) { if (isset($atr['attribute_id'])){ ?>
        <tr id="attribute-row<?php echo $atr['attribute_id']; ?>" atr_index="<?php echo $atr['attribute_id']; ?>"> 
          <td class="text-left">
            <input type="text" style="width:100%;" name="category_attribute[<?php echo $atr['attribute_id']; ?>][name]" value="<?php echo $atr['name']; ?>" />
          </td>


          <td class="text-left" style="min-width: 120px;">
            <select class="atr_type" atr_index="<?php echo $atr['attribute_id']; ?>" name="category_attribute[<?php echo $atr['attribute_id']; ?>][type]" onchange="SetAttributesSettings();" style="width:98%;">
                <?php $i=0; foreach ($attribyte_types as $type_id => $type_title) 
                {
                  echo "<option value='".$type_id."'  ".($atr['type']==$type_id ? " selected='selected' ":"")." >$type_title</option>";$i++;
                } ?>
            </select>
          </td>

          <td class="text-left" style="max-width: 30px;">
              <input type="text" style="width:100%;" name="category_attribute[<?php echo $atr['attribute_id']; ?>][enum]" value="<?php echo $atr['enum']; ?>" />
          </td>




          <td class="text-left" style="width:5%;">      
            
            <div class="type_fld_<?php echo $atr['attribute_id']; ?>" id="atr_combo_<?php echo $atr['attribute_id']; ?>">
              <textarea style="width: 100%;" id="atr_text_<?php echo $atr['attribute_id']; ?>" name="category_attribute[<?php echo $atr['attribute_id']; ?>][text_value]" rows="6" ><?php echo trim($atr['text_value']); ?></textarea>
              <p>* Пункты списка начинаются с новой строки. <br><br></p>
            </div>

            <div class="type_fld_<?php echo $atr['attribute_id']; ?>" id="atr_minmax_<?php echo $atr['attribute_id']; ?>">
              <b><?php echo $attribute_min_value; ?></b>
              <input type="text" name="category_attribute[<?php echo $atr['attribute_id']; ?>][min_value]" size="5" value="<?php echo $atr['min_value']; ?>">
              <b><?php echo $attribute_max_value; ?></b>
              <input type="text" name="category_attribute[<?php echo $atr['attribute_id']; ?>][max_value]" size="5" value="<?php echo $atr['max_value']; ?>">        
            </div>
            
            <div class="type_fld_<?php echo $atr['attribute_id']; ?>"  id="atr_def_val_<?php echo $atr['attribute_id']; ?>">
              <b>Значение по умолчанию:</b><br>
              <input type="text" style="width: 100%;" name="category_attribute[<?php echo $atr['attribute_id']; ?>][default_value]" value="<?php echo $atr['default_value']; ?>">
            </div>
          </td>




          <td class="text-left">
            <select name="category_attribute[<?php echo $atr['attribute_id']; ?>][priority]">
                <?php $i=0; foreach ($attribute_priorities as $priority_id => $priority_title) 
                {
                  echo "<option value='".$priority_id."'  ".($atr['priority']==$priority_id ? " selected='selected' ":"")." >$priority_title</option>";$i++;
                } ?>
            </select>
          </td>
          <td class="text-left">
            <select name="category_attribute[<?php echo $atr['attribute_id']; ?>][status]">
                <?php $i=0; foreach ($attribute_statuses as $status_id => $status_title) 
                {
                  echo "<option value='".$status_id."'  ".($atr['status']==$status_id ? " selected='selected' ":"")." >$status_title</option>";$i++;
                } ?>
            </select>
          </td>


          <td class="text-left">
            <button type="button" onclick="DeleteAttribute(<?php echo $atr['attribute_id']; ?>);" data-toggle="tooltip" title="" class="btn btn-danger" data-original-title="<?php echo $attribute_delete_button; ?>"><i class="fa fa-minus-circle"></i></button>
          </td>
        </tr>
      <?php }} ?>
    </table>
    <button type="button" onclick="AddAttribute();" data-toggle="tooltip" title="" class="btn btn-primary" data-original-title="<?php echo $attribute_add_button; ?>"><i class="fa fa-plus-circle"></i></button>
  </div>
</div>

<script type="text/javascript">

String.prototype.replaceAll = function(search, replace){
  return this.split(search).join(replace);
}

function HcaInitPage()
{
  SetAttributesSettings();
}


  function SetAttributesSettings()
  {
    $("#attribute .atr_type").each(function (index) 
      {
        $(".type_fld_"+$(this).attr("atr_index")).hide();
        if ($(this).val()=="combo")
          {
            $("#atr_combo_"+$(this).attr("atr_index")).show();
            $("#atr_def_val_"+$(this).attr("atr_index")).show();
          }
        else if ($(this).val()=="minmax")
          {
            $("#atr_minmax_"+$(this).attr("atr_index")).show();
          }
        else 
        {
          // $("#atr_text_"+$(this).attr("atr_index")).show();
          $("#atr_def_val_"+$(this).attr("atr_index")).show();
        }  
      });
  }

  function AddAttribute()
  {

    $.ajax({
      url: 'index.php?route=module/h_filter/AjaxAddAttribute&token=<?php echo $_GET["token"]; ?>&category_id=<?php echo $_GET["category_id"] ?>',
      dataType: 'json',
      success: function(data) 
      {
        if (data.status=="OK")
        {
          atr_id=data.attribute_id;
          template=$("#attribute_template").html();
          $("#attribute").append(template.replaceAll("$atr_id",atr_id));
          SetAttributesSettings();
        } else {
          alert(data.status);
        }

      }
    });

  }


  function DeleteAttribute(atr_id)
  {
    var r = confirm("Удаление приведёт к потере всех данных, связанных с этим атрибутом! \n\n Продолжить?");
    if (r == true) 
    {
        $.ajax({
          url: 'index.php?route=module/h_filter/AjaxDeleteAttribute&token=<?php echo $_GET["token"]; ?>&atr_id='+atr_id,
          dataType: 'json',
          success: function(data) 
          {
            console.debug($("#attribute-row"+data));
            $("#attribute-row"+data).remove();
              SetAttributesSettings();
          }
        });
    } 
  }

  $(document).ready(HcaInitPage);
</script>








<!-- ----------------------------------  TEMPLATE FOR NEW ATTRIBUTE ----------------------------------  -->

<table id="attribute_template" style="display:none;">
  <!-- <tbody id="attribute-row$atr_id"> -->
  <tr id="attribute-row$atr_id" atr_index="$atr_id"> 
    <td class="left">
      <input type="text" style="width:100%;" name="category_attribute[$atr_id][name]" value="-" />
    </td>


    <td class="left" style="min-width:120px;">
      <select class="atr_type" atr_index="$atr_id" name="category_attribute[$atr_id][type]" onchange="SetAttributesSettings();" style="width:98%;">
          <?php $i=0; foreach ($attribyte_types as $type_id => $type_title) 
          {
            echo "<option value='".$type_id."'  ".($i==0 ? " selected='selected' ":"")." >$type_title</option>";$i++;
          } ?>
      </select>
    </td>

    <td class="left" style="max-width:30px;">
        <input type="text" name="category_attribute[$atr_id][enum]" value="" style="width:100%;" />
    </td>




    <td class="left">      
      
      <div class="type_fld_$atr_id" id="atr_combo_$atr_id">
        <textarea id="atr_text_$atr_id" name="category_attribute[$atr_id][text_value]" style="width:100%;" rows="6" ></textarea>
        <p>* Пункты списка начинаются с новой строки. <br><br></p>
      </div>

      <div class="type_fld_$atr_id" id="atr_minmax_$atr_id">
        <b><?php echo $attribute_min_value; ?></b>
        <input type="text" name="category_attribute[$atr_id][min_value]" size="5" value="">
        <b><?php echo $attribute_max_value; ?></b>
        <input type="text" name="category_attribute[$atr_id][max_value]" size="5" value="">        
      </div>
      
      <div class="type_fld_$atr_id"  id="atr_def_val_$atr_id">
        <b>Значение по умолчанию:</b>
        <input type="text" name="category_attribute[$atr_id][default_value]" style="width:100%;" value="">
      </div>
    </td>




    <td class="left">
      <select name="category_attribute[$atr_id][priority]">
          <?php $i=0; foreach ($attribute_priorities as $priority_id => $priority_title) 
          {
            echo "<option value='".$priority_id."'  ".($i==0 ? " selected='selected' ":"")." >$priority_title</option>";$i++;
          } ?>
      </select>
    </td>
    <td class="left">
      <select name="category_attribute[$atr_id][status]">
          <?php $i=0; foreach ($attribute_statuses as $status_id => $status_title) 
          {
            echo "<option value='".$status_id."'  ".($i==0 ? " selected='selected' ":"")." >$status_title</option>";$i++;
          } ?>
      </select>
    </td>


    <td class="left">
      <button type="button" onclick="DeleteAttribute($atr_id);" data-toggle="tooltip" title="" class="btn btn-danger" data-original-title="<?php echo $attribute_delete_button; ?>"><i class="fa fa-minus-circle"></i></button>
    </td>
  </tr>
<!-- </tbody> -->
</table>