<?php 
class ModelHcvFieldsInput extends Model {
	
	public function load($data)
	{
		$this->load->model('tool/image');
		$data['value']=$data['value'];
		return $data;
	}
	
}
 ?>