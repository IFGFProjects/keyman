<?php
class ModelCatalogHfilter extends Model {

	public function GetCategoryAttributes($category_id)
	{
		$all=$this->db->query("SELECT hf.*, atr.name FROM `" . DB_PREFIX . "hfilter` as hf 
			JOIN attribute_description as atr on atr.attribute_id=hf.attribute_id
			WHERE category_id=".(int)$category_id);
		return $all->rows;
	}

	public function AddAttribute($atr_id, $atr_category, $data)
	{
		$q="INSERT INTO " . DB_PREFIX . "hfilter SET 
				attribute_id = '" . (int)$atr_id . "',
				category_id = '" . (int)$atr_category . "',
				type = '" . $this->db->escape($data['type']) . "',
				min_value = '" . floatval($data['min_value']). "',
				max_value = '" . floatval($data['max_value']). "',
				text_value = '" . $this->db->escape($data['text_value']) . "',
				default_value = '" . $this->db->escape($data['default_value']) . "',
				status = '" . (int)$data['status'] . "', 
				priority = '" . $this->db->escape($data['priority']) . "'";
			// die($q);
			$this->db->query($q);
	}

	public function DeleteAttribute($attribute_id)
	{
		return $this->db->query("DELETE FROM " . DB_PREFIX . "hfilter WHERE attribute_id = '" . (int)$attribute_id . "'");
	}


	public function UpdateCategoryAttributes($attributes, $cat_id)
	{
		$queries=array();
		unset($attributes['$atr_id']);
		if (count($attributes)>0)
		{
			// echo "<h1 style='color:red;'>attributes :</h1><pre>";print_r($attributes);echo "</pre><hr>";die();
			
			foreach ($attributes as $atr_id => $attribute) 
			{

				if (isset($attribute['name'])) 
				{
					$this->load->model("catalog/attribute");
					$this->model_catalog_attribute->editAttribute($atr_id,array(
								"attribute_group_id"=>0,
								"sort_order"=>"",
								"attribute_description"=>array((int)$this->config->get('config_language_id')=>array("name"=>$attribute['name'])),
								""
							));
				}
	
				$upd_query="UPDATE " . DB_PREFIX . "hfilter SET category_id=$cat_id,";
	
				if (isset($attribute['type'])) 
					{$upd_query.=' `type`="'.$attribute['type'].'",';}
	
				if (isset($attribute['enum'])) 
					{$upd_query.=' `enum`="'.$attribute['enum'].'",';}
	
				if (isset($attribute['min_value'])) 
					{$upd_query.=' `min_value`="'.$attribute['min_value'].'",';}
	
				if (isset($attribute['max_value'])) 
					{$upd_query.=' `max_value`="'.$attribute['max_value'].'",';}
	
				if (isset($attribute['text_value'])) 
					{$upd_query.=' `text_value`="'.trim($attribute['text_value']).'",';}
	
				if (isset($attribute['default_value'])) 
					{$upd_query.=' `default_value`="'.trim($attribute['default_value']).'",';}
	
				if (isset($attribute['status'])) 
					{$upd_query.=' `status`="'.$attribute['status'].'",';}
	
				if (isset($attribute['priority'])) 
					{$upd_query.=' `priority`="'.$attribute['priority'].'",';}
	
				//---------------------------- UPDATE VALUES IF TYPE IS COMBO ---------------------
				if ($attribute['type']=="combo")
				{
					$old_vals=$this->db->query("SELECT text_value FROM " . DB_PREFIX . "hfilter WHERE attribute_id=$atr_id");
					$old_vals=explode("\n", $old_vals->row['text_value']);
					$new_vals=explode("\n", $attribute['text_value']);

					foreach ($new_vals as $nkey => $new_value)
					{
						if (isset($old_vals[$nkey]))
							if ( trim($old_vals[$nkey])!=trim($new_vals[$nkey]) )
								{$this->db->query("UPDATE " . DB_PREFIX . "product_attribute SET `text`='".trim($new_vals[$nkey])."' WHERE attribute_id=$atr_id AND `text`='".trim($old_vals[$nkey])."'");}
					}
				}

				$upd_query[strlen($upd_query)-1]=" ";
				$upd_query.=" WHERE attribute_id=".$atr_id;
				if ((int)$atr_id>0) 
				{
					$this->db->query($upd_query);
					$queries[]=$upd_query;
				}
			}
			// echo "<h1 style='color:red;'>queries :</h1><pre>";print_r($queries);echo "</pre><hr>";die();
			return $queries;
		} else {
			//-----------  DELETE ALL -------
		}

	}

	public function DeleteCategoryAttributes($cat_id)
	{
		$atrs=$this->GetCategoryAttributes($cat_id);
		$this->load->model("catalog/attribute");
		foreach ($atrs as $key => $atr) {
			$this->model_catalog_attribute->deleteAttribute($atr['attribute_id']);
			$this->DeleteAttribute($atr['attribute_id']);
		}
	}

	public function GetProductAttributes($data)
	{

		$query_where="";
		if (isset($data['category']))
			{$query_where.=" AND hf.`category_id`=".(int)$data['category'];}

		if (isset($data['product_id']))
			{$prod_id=(int)$data['product_id'];}
		else 
			{$prod_id="0";}


		if (isset($data['status']))
			{$query_where.=" AND hf.`status` IN (".(int)$data['status'].") ";}
		else
			{$query_where.=" AND hf.`status`=0";}

		$query="SELECT hf.*, prod.`text` as `val`,cat.`name` as `category`, atr.`name` as `name`
				FROM `" . DB_PREFIX . "hfilter` as hf
				LEFT JOIN `product_attribute` as prod ON (prod.attribute_id=hf.attribute_id AND prod.`product_id`=$prod_id) 
				JOIN `category_description` as cat ON cat.category_id=hf.category_id
				JOIN `attribute_description` as atr ON atr.attribute_id=hf.attribute_id
				WHERE 1 $query_where
		";

		// die($query);

		$q=$this->db->query($query);
		$res=array();
		if (count($q->rows)>0)
		{
			$cat=$q->rows[0]['category'];
			foreach ($q->rows as $key => $value) 
			{
				$res[$cat][$value['attribute_id']]=array(
					"name"=>$value['name'],
					"attribute_id"=>$value['attribute_id'],
					"type"=>$value['type'],
					"enum"=>$value['enum'],
					"min_value"=>$value['min_value'],
					"max_value"=>$value['max_value'],
					"text_value"=>$value['text_value'],
					"default_value"=>$value['default_value'],
					"product_attribute_description"=>array((int)$this->config->get('config_language_id')=>array("text"=>$value['val']))
				);
			}
		}
		return $res;


	}


}
