<?php 
class ModelModuleCatBrandInfo extends Model {
	public function by_product_id($product_id)
	{
		$cats=$this->db->query("SELECT category_id FROM product_to_category WHERE product_id=$product_id");
		$cats_str="";
		if (count($cats->rows)>0)
		foreach ($cats->rows as $key => $value) 
			{$cats_str.=" ".$value['category_id'].",";}
		$cats_str=trim($cats_str,",");
		$res=$this->db->query(" SELECT cb.`text` FROM catbrandinfo as cb
			WHERE 
				cb.category_id IN ($cats_str)
			AND
				cb.brand_id=(SELECT manufacturer_id FROM product WHERE product_id=$product_id LIMIT 1)
		");
		if (isset($res->row['text']))
			{return $res->row['text'];}
		else
			{return "";}
	}
}
?>