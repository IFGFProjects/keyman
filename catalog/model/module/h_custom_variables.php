<?php 
class ModelModuleHCustomVariables extends Model {
	public function load($category_id)
	{
		$data=array();
		$lng=$this->config->get('config_language_id');
		$res="SELECT val.value as `value`, val.language_id as language_id, var.* FROM ".DB_PREFIX."hcv_variable_value as val 
			JOIN ".DB_PREFIX."hcv_variable as var ON val.variable_id=var.variable_id
			WHERE val.category_id=$category_id AND language_id=$lng";
		$res=$this->db->query($res);
		$res_data=array();
		foreach ($res->rows as $row => $variable) 
		{
			$this->load->model("hcv/fields/".$variable['type']);
			$res_data[$variable['name']]=$this->{"model_hcv_fields_".$variable['type']}->load($variable);
		}
		return $res_data;

	}
}
 ?>