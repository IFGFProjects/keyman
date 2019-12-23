<?php $pri = 1; foreach($microdata_products as $product){ ?>
<?php if($related_block){ ?>
<span id="related-product-<?php echo $pri; ?>" itemprop="isRelatedTo" itemscope itemtype="http://schema.org/Product">
<?php }else{ ?>
<?php } ?>
</span>
<?php $pri++; } ?>