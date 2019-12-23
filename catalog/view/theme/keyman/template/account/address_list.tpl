<?php // echo $header; ?>
<div class="container" style="display:none;">
  <ul class="breadcrumb">
    <?php foreach ($breadcrumbs as $breadcrumb) { ?>
    <li><a href="<?php echo $breadcrumb['href']; ?>"><?php echo $breadcrumb['text']; ?></a></li>
    <?php } ?>
  </ul>
  <?php if ($success) { ?>
  <div class="alert alert-success"><i class="fa fa-check-circle"></i> <?php echo $success; ?></div>
  <?php } ?>
  <?php if ($error_warning) { ?>
  <div class="alert alert-warning"><i class="fa fa-exclamation-circle"></i> <?php echo $error_warning; ?></div>
  <?php } ?>
  <div class="row"><?php echo $column_left; ?>
    <?php if ($column_left && $column_right) { ?>
    <?php $class = 'col-sm-6'; ?>
    <?php } elseif ($column_left || $column_right) { ?>
    <?php $class = 'col-sm-9'; ?>
    <?php } else { ?>
    <?php $class = 'col-sm-12'; ?>
    <?php } ?>
    <div id="content" class="<?php echo $class; ?>"><?php echo $content_top; ?>
      <h2><?php echo $text_address_book; ?></h2>
      <?php if ($addresses) { ?>
      <table class="table table-bordered table-hover">
        <?php foreach ($addresses as $result) { ?>
        <tr>
          <td class="text-left"><?php echo $result['address']; ?></td>
          <td class="text-right"><a href="<?php echo $result['update']; ?>" class="btn btn-info"><?php echo $button_edit; ?></a> &nbsp; <a href="<?php echo $result['delete']; ?>" class="btn btn-danger"><?php echo $button_delete; ?></a></td>
        </tr>
        <?php } ?>
      </table>
      <?php } else { ?>
      <p><?php echo $text_empty; ?></p>
      <?php } ?>
      <div class="buttons clearfix">
        <div class="pull-left"><a href="<?php echo $back; ?>" class="btn btn-default"><?php echo $button_back; ?></a></div>
        <div class="pull-right"><a href="<?php echo $add; ?>" class="btn btn-primary"><?php echo $button_new_address; ?></a></div>
      </div>
      <?php echo $content_bottom; ?></div>
    <?php echo $column_right; ?></div>
</div>
<?php // echo $footer; ?>


   <div class="form-group delivery-address">
     <h4 class="cabinet-address">Адрес доставки</h4>
<?php foreach ($addresses as $result) { ?>     
<form action="<?php echo $result['href']; ?>" method="post" enctype="multipart/form-data" class="form-horizontal" role="form">
  <input type="hidden" name="firstname" value="<?php echo $customer_info['firstname']; ?>" id="input-firstname" class="form-control" />
  <input type="hidden" name="lastname" value="<?php echo $customer_info['lastname']; ?>" id="input-lastname" class="form-control" />
  <input type="hidden" name="company" value="" id="input-company" class="form-control" />
  <input type="hidden" name="address_2" value="" id="input-address-2" class="form-control" />
  <input type="hidden" name="country_id" value="20" id="input-country" class="form-control" />

     <div class="form-group">
     <label for="region" class="col-sm-3 control-label">Область:</label>
     <div class="col-sm-9">
       <select class="form-control" name="zone_id" id="input-zone">
        <option <?php if ($result['adress_info']['zone_id']==""){?>selected<?php } ?> value=""> --- Выберите--- </option>
        <option <?php if ($result['adress_info']['zone_id']=="339"){?>selected<?php } ?> value="339">Город Минск</option>
        <option <?php if ($result['adress_info']['zone_id']=="342"){?>selected<?php } ?> value="342">Минская</option>
        <option <?php if ($result['adress_info']['zone_id']=="337"){?>selected<?php } ?> value="337">Брестская (Brest)</option>
        <option <?php if ($result['adress_info']['zone_id']=="338"){?>selected<?php } ?> value="338">Гомельская (Homyel')</option>
        <option <?php if ($result['adress_info']['zone_id']=="340"){?>selected<?php } ?> value="340">Гродненская (Hrodna)</option>
        <option <?php if ($result['adress_info']['zone_id']=="341"){?>selected<?php } ?> value="341">Могилёвская (Mahilyow)</option>
        <option <?php if ($result['adress_info']['zone_id']=="343"){?>selected<?php } ?> value="343">Витебская (Vitsyebsk)</option>
     </select>
     <?php if ( ($result['adress_info']['zone_id']=="")) {?>
     <div class="text-danger">Необходимо заполнить!</div>
     <?php } ?>
   </div>
  </div>
     
     <div class="form-group">
     <label for="town" class="col-sm-3 control-label">Город:</label>
     <div class="col-sm-9">
      <input type="text" name="city" value="<?php echo $result['adress_info']['city']; ?>" placeholder="г. Минск, Минский район" id="input-city" class="form-control" />
      <?php if ( ($result['adress_info']['city']=="")) {?>
      <div class="text-danger">Необходимо город!</div>
      <?php } ?>
     </div>
   </div>
    
    <div class="form-group">
     <label for="index" class="col-sm-3 control-label">Индекс:</label>
     <div class="col-sm-9">
      <input type="text" name="postcode" value="<?php echo $result['adress_info']['postcode']; ?>" placeholder="000000" id="input-postcode" class="form-control" />
      <?php if ( ($result['adress_info']['postcode']=="")) {?>
      <div class="text-danger">Необходимо почтовый Индекс!</div>
      <?php } ?>
     </div>
   </div>
    
    <div class="form-group">
     <label for="street" class="col-sm-3 control-label">Улица:</label>
     <div class="col-sm-9">
      <input type="text" name="address_1" value="<?php echo $result['adress_info']['address_1']; ?>" placeholder="Ивановская, ул." id="input-address-1" class="form-control" />
      <?php if ( ($result['adress_info']['address_1']=="")) {?>
      <div class="text-danger">Необходимо почтовый улицу!</div>
      <?php } ?>
       </div>
       </div>
       
       
    <div class="form-group">
     <div class="col-sm-9 col-sm-offset-3 col-xs-offset-0">
     <div class="address-form">
           <label for="house" class="control-label">Дом:
            <input type="text" class="form-control" id="house" name="custom_field[2]" placeholder="5" value="<?php if (isset($result['adress_info']['custom_field'][2])) { echo $result['adress_info']['custom_field'][2];} ?>"></label>                        
           <label for="entrance" class="control-label">Подъезд:
            <input type="text" name="custom_field[3]" class="form-control" id="entrance" placeholder="5" value="<?php if (isset($result['adress_info']['custom_field'][3])) { echo $result['adress_info']['custom_field'][3];} ?>"></label>
           <label for="flat" class="control-label">Квартира:
            <input type="text" name="custom_field[4]" class="form-control" id="flat" placeholder="5" value="<?php if (isset($result['adress_info']['custom_field'][4])) { echo $result['adress_info']['custom_field'][4];} ?>"></label>
           <label for="floor" class="control-label">Этаж:
            <input type="text" name="custom_field[5]" class="form-control" id="floor" placeholder="5" value="<?php if (isset($result['adress_info']['custom_field'][5])) { echo $result['adress_info']['custom_field'][5];} ?>"></label>
      </div>
      <label class="by-default">
           <input style="display:none;" type="radio" name="default" id="default" value="0" <?php if ($result['address_id']!=$customer_info['address_id']) {?> checked <?php } ?>>
           <input type="radio" name="default" id="default" value="1" <?php if ($result['address_id']==$customer_info['address_id']) {?> checked <?php } ?>>Использовать по умолчанию
      </label>
      </div>
    </div>
    <div class="form-group">
      <!-- <div class="col-xs-12"> -->
      <div class="col-sm-9 col-sm-offset-3 col-xs-offset-0">
        <button class="btn btn-default ttu btn-lg " type="submit">Сохранить изменения</button>
          <a href="<?php echo $cancel_href; ?>" class="btn-right-link">Отменить</a>
      </div>
    </div>

    <div class="clearfix"></div>
</form>
<?php } ?>
<form class="form-horizontal" role="form">
<div class="form-group">
  <div class="col-sm-9 col-sm-offset-3 col-xs-offset-0">
    <a href="javascript:$('#add_address_form').show();" class="add-address">Добавить еще один адрес</a>
  </div>
</div>
<hr>
<div class="clearfix"></div>
</form>

<form  action="<?php echo $add_action; ?>" method="post" enctype="multipart/form-data" class="form-horizontal" role="form" id="add_address_form">
  <input type="hidden" name="firstname" value="<?php echo $customer_info['firstname']; ?>" id="input-firstname" class="form-control" />
  <input type="hidden" name="lastname" value="<?php echo $customer_info['lastname']; ?>" id="input-lastname" class="form-control" />
  <input type="hidden" name="company" value="" id="input-company" class="form-control" />
  <input type="hidden" name="address_2" value="" id="input-address-2" class="form-control" />
  <input type="hidden" name="country_id" value="20" id="input-country" class="form-control" />

     <div class="form-group">
     <label for="region" class="col-sm-3 control-label">Область:</label>
     <div class="col-sm-9">
       <select class="form-control" name="zone_id" id="input-zone" style="width:100%;">
        <option value=""> --- Выберите--- </option>
        <option value="339">Город Минск</option>
        <option value="342">Минская</option>
        <option value="337">Брестская (Brest)</option>
        <option value="338">Гомельская (Homyel')</option>
        <option value="340">Гродненская (Hrodna)</option>
        <option value="341">Могилёвская (Mahilyow)</option>
        <option value="343">Витебская (Vitsyebsk)</option>
     </select>
   </div>
  </div>
     
     <div class="form-group">
     <label for="town" class="col-sm-3 control-label">Город:</label>
     <div class="col-sm-9">
      <input type="text" name="city" value="" placeholder="г. Минск, Минский район" id="input-city" class="form-control">
     </div>
   </div>
    
    <div class="form-group">
     <label for="index" class="col-sm-3 control-label">Индекс:</label>
     <div class="col-sm-9">
      <input type="text" name="postcode" value="" placeholder="" id="input-postcode" class="form-control">
     </div>
   </div>
    
    <div class="form-group">
     <label for="street" class="col-sm-3 control-label">Улица:</label>
     <div class="col-sm-9">
      <input type="text" name="address_1" value="" placeholder="Ивановская, ул." id="input-address-1" class="form-control">
       </div>
       </div>
       
       
    <div class="form-group">
     <div class="col-sm-9 col-sm-offset-3 col-xs-offset-0">
     <div class="address-form">
           <label for="house" class="control-label">Дом:
            <input type="text" class="form-control" id="house" name="custom_field[2]" placeholder="5" value=""></label>                        
           <label for="entrance" class="control-label">Подъезд:
            <input type="text" name="custom_field[3]" class="form-control" id="entrance" placeholder="5" value=""></label>
           <label for="flat" class="control-label">Квартира:
            <input type="text" name="custom_field[4]" class="form-control" id="flat" placeholder="5" value=""></label>
           <label for="floor" class="control-label">Этаж:
            <input type="text" name="custom_field[5]" class="form-control" id="floor" placeholder="5" value=""></label>
      </div>
      <label class="by-default">
           <input style="display:none;" type="radio" id="default" name="default" value="0" checked="">
           <input type="radio" name="default" id="default" value="1" >Использовать по умолчанию
      </label>
      </div>
    </div>
    <div class="form-group">
      <!-- <div class="col-xs-12"> -->
      <div class="col-sm-9 col-sm-offset-3 col-xs-offset-0">
        <button class="btn btn-default ttu btn-lg " type="submit">Добавить адрес</button>
          <a href="http://keyman.by/index.php?route=address/address" class="btn-right-link">Отменить</a>
      </div>
    </div>
    <hr>
    
</form>

    </div>



  <script type="text/javascript">
  $(document).ready(function(){
    $('#add_address_form').hide();
  });


  <!--
  // $('select[name=\'country_id\']').on('change', function() {
  //   $.ajax({
  //     url: 'index.php?route=account/account/country&country_id=' + this.value,
  //     dataType: 'json',
  //     beforeSend: function() {
  //       $('select[name=\'country_id\']').after(' <i class="fa fa-circle-o-notch fa-spin"></i>');
  //     },
  //     complete: function() {
  //       $('.fa-spin').remove();
  //     },
  //     success: function(json) {
  //       if (json['postcode_required'] == '1') {
  //         $('input[name=\'postcode\']').parent().parent().addClass('required');
  //       } else {
  //         $('input[name=\'postcode\']').parent().parent().removeClass('required');
  //       }

  //       html = '<option value=""><?php echo $text_select; ?></option>';

  //       if (json['zone'] && json['zone'] != '') {
  //         for (i = 0; i < json['zone'].length; i++) {
  //           html += '<option value="' + json['zone'][i]['zone_id'] + '"';

  //           if (json['zone'][i]['zone_id'] == '<?php echo $addresses[0]['adress_info']['zone_id']; ?>') {
  //             html += ' selected="selected"';
  //             }

  //             html += '>' + json['zone'][i]['name'] + '</option>';
  //         }
  //       } else {
  //         html += '<option value="0" selected="selected"><?php echo $text_none; ?></option>';
  //       }

  //       $('select[name=\'zone_id\']').html(html);
  //     },
  //     error: function(xhr, ajaxOptions, thrownError) {
  //       alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
  //     }
  //   });
  // });

  // $('select[name=\'country_id\']').trigger('change');

  // $('input[name=\'default\']').on('click', function() {
  //   $('input[name=\'default\'][value=\'0\']').prop("checked",true);
  //   $(this).prop("checked",true);
  // });

  //--></script>