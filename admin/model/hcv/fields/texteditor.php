<?php 
class ModelHcvFieldsTexteditor extends Model {

	public function prepare($data=array("value"=>""))
	{
		// echo "<h1 style='color:red;'>data :</h1><pre>";print_r($data);echo "</pre><hr>";
		// if (!isset($data['value']))
		// 	{$data['value']="";}		
		// elseif ($data['value']!="")
		// 	{$data['value']= html_entity_decode($data['value']);}
		return $data;
	}
	
	public function load($var_ident, $language, $data)
	{
		$data['language_id']=$language['language_id'];
		$data['hcv_name']=$var_ident;
		$this->load->model('tool/image');
		$data['value']= isset($data['value'])?html_entity_decode($data['value']):"";
		// $data=array_merge($data,$this->load->language("module/h_custom_variables"));
		return $this->load->view('module/h_custom_variables/fields/texteditor.tpl', $data);
	}
	
}
 ?>