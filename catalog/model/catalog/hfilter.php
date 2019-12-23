<?php 
class ModelCatalogHfilter extends Model {

public function GenerateFilterQueryPart($filters_array)
{
	$qu=" ";
	// echo "<h1 style='color:red;'>DATA :</h1><pre>";print_r($filters_array);echo "</pre><hr>";die();
	foreach ($filters_array as $fid => $values) 
	{
		$filter_info=$this->db->query("SELECT * FROM `" . DB_PREFIX . "hfilter` WHERE attribute_id=$fid AND status=0");
		if ($filter_info->num_rows>0)
		if ($values[0]!=$filter_info->row['default_value'])
		{
			$qu.=' AND (';
			foreach ($values as $vkey => $atr_val) 
			{
				if ($vkey>0) {$qu.=" OR ";}
				$atr_val=$this->db->escape($atr_val);
				switch ($filter_info->row['type']) 
				{
					// case 'text':
					// $qu.="
					// ( 
					// 	SELECT COUNT(*)>0  FROM `" . DB_PREFIX . "product_attribute` WHERE product_id=p.product_id AND attribute_id=".$fid." AND 
					// 	text='%$atr_val%'  
						
					// ) ";
					// break;
	
					// case 'combo':
					// $qu.="
					// ( 
					// 	SELECT COUNT(*)>0  FROM `" . DB_PREFIX . "product_attribute` WHERE product_id=p.product_id AND attribute_id=".$fid." AND 
					// 	text='%$atr_val%'  
						
					// ) ";
					// break;
	
	
					case 'minmax':
					$qu.="
					( 
						SELECT COUNT(*)>0  FROM `" . DB_PREFIX . "product_attribute` WHERE product_id=p.product_id AND attribute_id=".$fid." AND text
						BETWEEN ".$values[0]." AND ".$values[1]."
					) ";
					break;
	
	
					case 'int':
					$qu.="
					( 
						SELECT COUNT(*)>0  FROM `" . DB_PREFIX . "product_attribute` WHERE product_id=p.product_id AND attribute_id=".$fid." AND 
						text=$atr_val
					) ";
					break;
	
	
					//--------- DEFAULT ---------
					default:
					$qu.="
					( 
						SELECT COUNT(*)>0  FROM `" . DB_PREFIX . "product_attribute` WHERE product_id=p.product_id AND attribute_id=".$fid."
						AND text='$atr_val' 
					) ";
					break;
				}
			}
			$qu.=" )";
		}
	}
	return $qu;
}

public function GenerateManufacturerFilterQueryPart($manufacturers)
{
	if (is_array($manufacturers)) if (count($manufacturers)>0)
	{
		$bstr="";
		foreach ($manufacturers as $key => $value)
			{$bstr.=(int)$value.',';}
		return " AND p.manufacturer_id IN (".trim($bstr,",").") ";
	}
	 return "";
}

public function GeneratePricesFilterQueryPart($prices)
{
	if ( (isset($prices['price_min'])) && (isset($prices['price_max'])) )
		$sql="AND (p.price BETWEEN ".(int)$prices['price_min']." AND ".(int)$prices['price_max'].") AND 
((SELECT price FROM product_special ps WHERE ps.product_id = p.product_id AND ps.customer_group_id = '1' AND ((ps.date_start = '0000-00-00' OR ps.date_start < NOW()) AND (ps.date_end = '0000-00-00' OR ps.date_end > NOW())) ORDER BY ps.priority ASC, ps.price ASC LIMIT 1) IS NULL OR (SELECT price FROM product_special ps WHERE ps.product_id = p.product_id AND ps.customer_group_id = '1' AND ((ps.date_start = '0000-00-00' OR ps.date_start < NOW()) AND (ps.date_end = '0000-00-00' OR ps.date_end > NOW())) ORDER BY ps.priority ASC, ps.price ASC LIMIT 1) BETWEEN ".(int)$prices['price_min']." AND ".(int)$prices['price_max'].") ";
		{return $sql;}
}


public function GenerateOptionsFilterQueryPart($options)
{
	$qu=" AND ( ";
	foreach ($options as $option_id => $option_values) 
	{
		foreach ($option_values as $value_id => $value) 
		{
			$qu.=" (prod_opt.option_id=$option_id AND prod_opt.option_value_id=$value_id AND prod_opt.quantity>0 ) OR";
		}
	}
	return trim($qu,'OR').") ";
}

public function GetCategoryAttributes($category_id, $priority="")
{
	if ($priority!="")
		{$priority=" AND priority='$priority' ";}
	$all=$this->db->query("SELECT hf.*, atr.name FROM `" . DB_PREFIX . "hfilter` as hf 
		JOIN attribute_description as atr on atr.attribute_id=hf.attribute_id
		WHERE category_id IN (".$category_id.") AND hf.status=0 $priority");
	// echo "<h1 style='color:red;'>DATA :</h1><pre>";print_r("SELECT hf.*, atr.name FROM `" . DB_PREFIX . "hfilter` as hf 
	// 	JOIN attribute_description as atr on atr.attribute_id=hf.attribute_id
	// 	WHERE category_id IN (".$category_id.") AND hf.status=0 $priority");echo "</pre><hr>";
	return $all->rows;
}

public function getProductAttributes($product_id, $priority="")
{
	if ($priority!="")
		{$priority=" AND priority='$priority' ";}
	$query="SELECT pa.attribute_id, descr.`name`, pa.text,cat.`name` as category, cat.category_id, cat.add_data
				FROM `" . DB_PREFIX . "product_attribute` as pa
				JOIN `" . DB_PREFIX . "hfilter` as hf ON hf.attribute_id=pa.attribute_id
				JOIN `" . DB_PREFIX . "attribute_description` as descr ON descr.attribute_id=pa.attribute_id
				JOIN `" . DB_PREFIX . "category_description` as cat ON cat.category_id=hf.category_id
			WHERE pa.product_id=".(int)$product_id." AND hf.status=0 AND pa.text<>'-' $priority
	";
	$query=$this->db->query($query);
	$atrs=array();
	foreach ($query->rows as $atr_key => $attribute) 
	{
		$atrs[$attribute['category_id']]['name']=$attribute['category'];
		$atrs[$attribute['category_id']]['attribute'][$attribute['attribute_id']]=array(
			"name"	=>$attribute['name'],
			"text"	=>$attribute['text'],
		);
	}
	return $atrs;
}


}
 ?>