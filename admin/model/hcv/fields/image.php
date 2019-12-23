<?php 
class ModelHcvFieldsImage extends Model {

	public function prepare($data=array())
	{return $data;}

	public function load($var_ident, $language, $data)
	{
		$data['language_id']=$language['language_id'];
		$data['hcv_name']=$var_ident;
		$this->load->model('tool/image');
		$data['placeholder'] = $this->model_tool_image->resize('no_image.png', 100, 100);
		if ($data['value']) 
			{$data['thumb']=$this->model_tool_image->resize($data['value'], 100, 100);}
		else
			{$data['thumb']=$data['placeholder'];}
		// $data=array_merge($data,$this->load->language("module/h_custom_variables"));
		return $this->load->view('module/h_custom_variables/fields/image.tpl', $data);
	}
}
 ?>