<?php 
class ModelHcvProductCategory extends Model {
	public function Content($category_id)
	{
		$data=$this->load->language("module/h_custom_variables");
		$this->load->model('localisation/language');
		$langs = $this->model_localisation_language->getLanguages();
		$data['languages']=$langs;
		$data['language_id'] = $this->config->get('config_language_id');
		$data['category_id']=$category_id;
		
		//------- deny tabs based on category 
		$deny_tabs="";
		$tabs_list=$this->language->get('tabs_list');
		foreach ($tabs_list as $tab_name => $tab)
		{
			$data['tabs_titles'][$tab_name]=$tab['title'];
			$deny_categories=explode(",", $tab['categories']);
			if ( (!in_array($category_id, $deny_categories)) && ($deny_categories[0]!="") )
				{$deny_tabs.="'$tab_name',";}
		}
		$deny_tabs=trim($deny_tabs,",");


		$filter_data['filter_status']=1;
		if ($deny_tabs!="")
			{$filter_data['deny_tabs']=$deny_tabs;}

		$this->load->model("hcv/functions");
		$variables=$this->model_hcv_functions->getVariables($filter_data);

		$data['variables']=array();
		$values=$this->load($category_id);
		foreach ($langs as $lng_key => $lng)
		{
			foreach ($variables as $vkey => $var)
			{

				$var['value']=$var['default_value'];
				if (isset($values[$lng['language_id']][$var['variable_id']]))
				{
					$this->load->model("hcv/fields/".$var['type']);
					$var['value']=$this->{"model_hcv_fields_".$var['type']}->prepare($values[$lng['language_id']][$var['variable_id']]);
				}

				$var_ident="h_custom_variables[".$lng['language_id']."][".$var['variable_id'].']';
				$this->load->model("hcv/fields/".$var['type']);
				$data['variables'][$var['tab_name']][$lng['language_id']][]=$this->{"model_hcv_fields_".$var['type']}->load($var_ident,$lng,$var);

			}
		}

		return $this->load->view('module/h_custom_variables/product_category.tpl', $data);
	}

	public function save($category_id, $data=array())
	{
		if (isset($data['h_custom_variables']))
		{
			$this->db->query("DELETE FROM ".DB_PREFIX."hcv_variable_value WHERE category_id=".$category_id);
			foreach ($data['h_custom_variables'] as $lng_id => $variable) 
			{
				foreach ($variable as $v_id => $value) 
				{
					$val="";
					$this->db->query("INSERT INTO ".DB_PREFIX."hcv_variable_value  SET  
						variable_id = $v_id,
						category_id = $category_id,
						language_id = $lng_id,
						value='".$this->db->escape($value)."'
					");
				}
			}
		}
	}

	public function load($category_id)
	{
		$data=array();
		$res=$this->db->query("SELECT * FROM ".DB_PREFIX."hcv_variable_value WHERE category_id=".$category_id);
		foreach ($res->rows as $row => $variable) 
			{$data[$variable['language_id']][$variable['variable_id']]=$variable['value'];}
		return $data;

	}

}
?>