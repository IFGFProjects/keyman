<?php
class ModelCatalogCategory extends Model {
	public function getCategoryTree($category_id,$categories_array=array())
	{
		if ($category_id!=0)
		{
			$cat=$this->getCategory($category_id);
			$su=$this->db->query("SELECT keyword FROM url_alias WHERE query='category_id=$category_id'");
			if (isset($su->row['keyword']))
			{
				$cat['seo_url']=$su->row['keyword'];
				$categories_array[]=$cat;
			}
			return $this->getCategoryTree($cat['parent_id'],$categories_array);
		} else {return array_reverse($categories_array);}
	}


	public function getCategory($category_id) {
		$query = $this->db->query("SELECT DISTINCT * FROM " . DB_PREFIX . "category c LEFT JOIN " . DB_PREFIX . "category_description cd ON (c.category_id = cd.category_id) LEFT JOIN " . DB_PREFIX . "category_to_store c2s ON (c.category_id = c2s.category_id) WHERE c.category_id = '" . (int)$category_id . "' AND cd.language_id = '" . (int)$this->config->get('config_language_id') . "' AND c2s.store_id = '" . (int)$this->config->get('config_store_id') . "' AND c.status = '1'");

		return $query->row;
	}

	public function getCategories($parent_id = 0) {
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "category c LEFT JOIN " . DB_PREFIX . "category_description cd ON (c.category_id = cd.category_id) LEFT JOIN " . DB_PREFIX . "category_to_store c2s ON (c.category_id = c2s.category_id) WHERE c.parent_id = '" . (int)$parent_id . "' AND cd.language_id = '" . (int)$this->config->get('config_language_id') . "' AND c2s.store_id = '" . (int)$this->config->get('config_store_id') . "'  AND c.status = '1' ORDER BY c.sort_order, LCASE(cd.name)");
		// echo "<!-- QUERY\n"."SELECT * FROM " . DB_PREFIX . "category c LEFT JOIN " . DB_PREFIX . "category_description cd ON (c.category_id = cd.category_id) LEFT JOIN " . DB_PREFIX . "category_to_store c2s ON (c.category_id = c2s.category_id) WHERE c.parent_id = '" . (int)$parent_id . "' AND cd.language_id = '" . (int)$this->config->get('config_language_id') . "' AND c2s.store_id = '" . (int)$this->config->get('config_store_id') . "'  AND c.status = '1' ORDER BY c.sort_order, LCASE(cd.name)\n ";
		// echo "<h1 style='color:red;'>SEND :</h1><pre>";print_r($query->rows);echo "</pre><hr> -->";
		return $query->rows;
	}

	public function getCategoryFilters($category_id) {
		$implode = array();

		$query = $this->db->query("SELECT filter_id FROM " . DB_PREFIX . "category_filter WHERE category_id = '" . (int)$category_id . "'");

		foreach ($query->rows as $result) {
			$implode[] = (int)$result['filter_id'];
		}

		$filter_group_data = array();

		if ($implode) {
			$filter_group_query = $this->db->query("SELECT DISTINCT f.filter_group_id, fgd.name, fg.sort_order FROM " . DB_PREFIX . "filter f LEFT JOIN " . DB_PREFIX . "filter_group fg ON (f.filter_group_id = fg.filter_group_id) LEFT JOIN " . DB_PREFIX . "filter_group_description fgd ON (fg.filter_group_id = fgd.filter_group_id) WHERE f.filter_id IN (" . implode(',', $implode) . ") AND fgd.language_id = '" . (int)$this->config->get('config_language_id') . "' GROUP BY f.filter_group_id ORDER BY fg.sort_order, LCASE(fgd.name)");

			foreach ($filter_group_query->rows as $filter_group) {
				$filter_data = array();

				$filter_query = $this->db->query("SELECT DISTINCT f.filter_id, fd.name FROM " . DB_PREFIX . "filter f LEFT JOIN " . DB_PREFIX . "filter_description fd ON (f.filter_id = fd.filter_id) WHERE f.filter_id IN (" . implode(',', $implode) . ") AND f.filter_group_id = '" . (int)$filter_group['filter_group_id'] . "' AND fd.language_id = '" . (int)$this->config->get('config_language_id') . "' ORDER BY f.sort_order, LCASE(fd.name)");

				foreach ($filter_query->rows as $filter) {
					$filter_data[] = array(
						'filter_id' => $filter['filter_id'],
						'name'      => $filter['name']
					);
				}

				if ($filter_data) {
					$filter_group_data[] = array(
						'filter_group_id' => $filter_group['filter_group_id'],
						'name'            => $filter_group['name'],
						'filter'          => $filter_data
					);
				}
			}
		}

		return $filter_group_data;
	}

	public function getCategoryLayoutId($category_id) {
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "category_to_layout WHERE category_id = '" . (int)$category_id . "' AND store_id = '" . (int)$this->config->get('config_store_id') . "'");

		if ($query->num_rows) {
			return $query->row['layout_id'];
		} else {
			return 0;
		}
	}

	public function getTotalCategoriesByCategoryId($parent_id = 0) {
		$query = $this->db->query("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "category c LEFT JOIN " . DB_PREFIX . "category_to_store c2s ON (c.category_id = c2s.category_id) WHERE c.parent_id = '" . (int)$parent_id . "' AND c2s.store_id = '" . (int)$this->config->get('config_store_id') . "' AND c.status = '1'");

		return $query->row['total'];
	}

	public function getCategoryManufacturers($category_id,$selected_manufacturers=array())
	{
		$query=$this->db->query("SELECT man.* FROM " . DB_PREFIX . "manufacturer as man
					JOIN " . DB_PREFIX . "product as p ON p.manufacturer_id=man.manufacturer_id
					JOIN " . DB_PREFIX . "product_to_category as pc ON p.product_id=pc.product_id
					WHERE pc.category_id=$category_id
					GROUP BY man.manufacturer_id
					ORDER BY man.sort_order"
		);
		$result=array();
		foreach ($query->rows as $man_key => $man)
		{
			$selected=false;
			foreach ($selected_manufacturers as $smkey => $smvalue)
				if ($man['manufacturer_id']==$smvalue)
					{$selected=true;}
			$result[]=array(
				"manufacturer_id"=>$man['manufacturer_id'],
				"name"=>$man['name'],
				"image"=>$man['image'],
				"sort_order"=>$man['sort_order'],
				"selected" => $selected
			);
		}
		return $result;
	}

	public function GetCategoryOptions($category_id)
	{
		$query=$this->db->query("SELECT op_val.option_id, op_val.option_value_id, op.`name`, opv.`name` as op_name, SUM(op_val.quantity) as quantity
								FROM " . DB_PREFIX . "product_option_value as op_val
								JOIN `" . DB_PREFIX . "option_description` as op ON op.option_id=op_val.option_id
								JOIN `" . DB_PREFIX . "option_value_description` as opv ON opv.option_value_id=op_val.option_value_id
								JOIN `" . DB_PREFIX . "option_value` as opt_val ON opt_val.option_value_id=op_val.option_value_id
								WHERE op_val.product_id IN( SELECT product_id FROM " . DB_PREFIX . "product_to_category WHERE category_id=$category_id) AND quantity>0 
								GROUP BY op_val.option_value_id
								ORDER BY opt_val.sort_order ASC
								"
		);
		$options=array();
		foreach ($query->rows as $key => $value)
		{
			$options[$value['option_id']]['name']=$value['name'];
			$options[$value['option_id']]['options'][$value['option_value_id']]['name']=$value['op_name'];
			$options[$value['option_id']]['options'][$value['option_value_id']]['quantity']=$value['quantity'];
			$options[$value['option_id']]['options'][$value['option_value_id']]['selected']=false;
			if (isset($this->request->post['filter_options'][$value['option_id']][$value['option_value_id']]))
				{$options[$value['option_id']]['options'][$value['option_value_id']]['selected']=true;}
		}

		return $options;
	}

	public function getCategoryMinMaxPrice($category_id)
	{
		$query="SELECT GREATEST(MAX(p.price), IFNULL(MAX(spec.price),MAX(p.price)) ) as `price_max`, LEAST(MIN(p.price), IFNULL(MIN(spec.price),MIN(p.price)) ) as `price_min` 
									FROM " . DB_PREFIX . "product as p
									JOIN " . DB_PREFIX . "product_to_category as pc ON pc.product_id=p.product_id
									LEFT JOIN " . DB_PREFIX . "product_special as spec ON spec.product_id=p.product_id
									WHERE pc.category_id=$category_id AND p.`status`=1"
		;
		$query=$this->db->query($query);

		return $query->row;
	}

		// OLD NATIVE VARIANT BY PRODUCTS

		// public function getCategoryTags($category_id,$path)
		// {
		// 	$q=$this->db->query('SELECT tag FROM product_description WHERE tag<>"" AND product_id IN (
	 //       SELECT product_id FROM product_to_category WHERE category_id = '.$category_id.' GROUP BY product_id
		// 	)'
		// 	);
		// 	$res=array();
		// 	foreach ($q->rows as $key => $value)
		// 	{
		// 		$exp=explode(",", $value['tag']);
		// 		foreach ($exp as $ekey => $ex_val)
		// 		{
		// 			$res[trim($ex_val)]=$this->url->link("product/category","path=".$path."&tag=".trim($ex_val),'SSL');
		// 			// $res[trim($ex_val)]=$this->url->link("product/search","tag=".trim($ex_val));
		// 		}
		// 	}
		// 	// echo "<h1 style='color:red;'>res :</h1><pre>";print_r($res);echo "</pre><hr>";
		// 	// echo "<h1 style='color:red;'>q->rows :</h1><pre>";print_r($q->rows);echo "</pre><hr>";
		// 	return $res;

		// }

			public function getCategoryTags($category_id,$path)
			{
				$this->load->model("htagsmgr/tags");
				$q=$this->model_htagsmgr_tags->getTags(array("category_id"=>$category_id));
				$res=array();
					foreach ($q as $ekey => $ex_val)
					{
						$res[trim($ex_val['name'])]=$this->url->link("product/category","path=".$path."&tag=".trim($ex_val['name']),'SSL');
						// $res[trim($ex_val)]=$this->url->link("product/search","tag=".trim($ex_val));
					}

				// echo "<h1 style='color:red;'>res :</h1><pre>";print_r($res);echo "</pre><hr>";
				// echo "<h1 style='color:red;'>q->rows :</h1><pre>";print_r($q->rows);echo "</pre><hr>";
				return $res;

			}
}