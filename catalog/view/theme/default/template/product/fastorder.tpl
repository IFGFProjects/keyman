<!-- Button fastorder -->
<button type="button" style="margin-bottom: 5px;" id="btn-formcall<?php echo $product_id?>" class="btn btn-danger btn-lg btn-block">
  <?php echo $text_fastorder_button;?>
</button>

<div id="fastorder-form-container<?php echo $product_id?>"></div>

<script type="text/javascript">
  $('#btn-formcall<?php echo $product_id?>').on('click', function() {
    var data = [];

    data['heading_title'] = '<?php echo $heading_title;?>';
    data['price']         = '<?php echo $price;?>';
    data['product_id']    = '<?php echo $product_id?>';

    showForm(data);
  });
</script>