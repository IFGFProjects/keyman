<?php 
class ModelHcvFieldsTexteditor extends Model {
	
	public function load($data)
	{
		$this->load->model('tool/image');
		$data['value']=html_entity_decode($data['value']);
		return $data;
	}
	
}
 ?>