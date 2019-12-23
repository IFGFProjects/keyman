<ul class="nav nav-tabs" id="hcvtab">
<?php foreach ($tabs_titles as $tab_name => $tab_title) {?>
	<?php if (isset($variables[$tab_name])) {?>
  		<li <?php if ($tab_name=="general") {?>class="active" <?php } ?> ><a href="#hcvtab-<?php echo $tab_name; ?>" data-toggle="tab">
  		<?php echo $tab_title; ?></a></li>
  	<?php } ?>
<?php } ?>
</ul>





<div class="tab-content">
<?php foreach ($variables as $tab_name => $lng_tab) {?>
	<div class="tab-pane <?php if ($tab_name=="general") {?>active<?php } ?>" id="hcvtab-<?php echo $tab_name; ?>">
		<ul class="nav nav-tabs" id="language<?php echo $tab_name; ?>">
		  <?php foreach ($languages as $language) { ?>
		  <li <?php if ($language_id==$language['language_id']) {?> class="active"<?php } ?> ><a href="#language<?php echo $tab_name.$language['language_id']; ?>" data-toggle="tab"><img src="view/image/flags/<?php echo $language['image']; ?>" title="<?php echo $language['name']; ?>" /> <?php echo $language['name']; ?></a></li>
		  <?php } ?>
		</ul>
	
		<div class="tab-content">
		<?php  foreach ($lng_tab as $lng_id => $vars) 
		{ ?>
			<div class="tab-pane <?php if ($language_id==$lng_id) {?> active<?php } ?>"  id="language<?php echo $tab_name.$lng_id; ?>">
				<?php 
					foreach ($vars as $vkey => $var) 
					{
						echo $var;
					} 
				?>

			</div>		
		<?php } ?>
		</div>
	</div>
<?php } ?>
</div>

