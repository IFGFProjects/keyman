<?php 
class ModelHcvFieldsInput extends Model {

	public function prepare($data=array())
	{
		// $data['value']=$this->db->escape($data['value']);
		return $data;
	}
	
	public function load($var_ident, $language, $data)
	{
		$data['language_id']=$language['language_id'];
		$data['hcv_name']=$var_ident;
		$data['value']=$data['value'];
		// $data=array_merge($data,$this->load->language("module/h_custom_variables"));
		return $this->load->view('module/h_custom_variables/fields/input.tpl', $data);
	}
	
}
 ?>