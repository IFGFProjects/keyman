<?php 
class ModelHcvFieldsImage extends Model {

	public function load($data)
	{
		$this->load->model('tool/image');
		$data['value_name']=$data['value'];
		$data['value_orig']=$this->model_tool_image->orig($data['value']);
		$data['value']=$this->model_tool_image->resize($data['value'], 600, 600);
		$data['placeholder'] = $this->model_tool_image->resize('no_image.png', 100, 100);
		if ($data['value']) 
			{$data['thumb']=$this->model_tool_image->resize($data['value'], 100, 100);}
		else
			{$data['thumb']=$data['placeholder'];}

		return $data;
	}
}
 ?>