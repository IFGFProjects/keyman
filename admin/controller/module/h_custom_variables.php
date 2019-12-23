<?php 
class ControllerModuleHCustomVariables extends Controller {
	private $error = array();

	public function index() {
		$data=$this->load->language('module/h_custom_variables');
		$this->document->setTitle($this->language->get('heading_title'));

		$data['selected_tab']=isset($this->request->get['tab'])?$this->request->get['tab']:"";


		// if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validate()) {
		// 	$this->model_setting_setting->editSetting('h_low_variables_tabs', $this->request->post);

		// 	$data['success'] = $this->language->get('text_success');

		// 	$this->response->redirect($this->url->link('extension/module', 'token=' . $this->session->data['token'], 'SSL'));
		// }
		$this->GetList($data);
	}


	public function add()
	{
		$data=$this->load->language('module/h_custom_variables');
		$this->document->setTitle($this->language->get('heading_title'));

		$url="";
		if (isset($this->request->get['tab']))
			{$url.="&tab=".$this->request->get['tab'];}

		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validate())
		{
			$this->load->model("hcv/functions");
			$this->model_hcv_functions->addVariable(array('fields'=>$this->request->post));
			$data['success'] = $this->language->get('text_success');
			$this->response->redirect($this->url->link('module/h_custom_variables', 'token=' . $this->session->data['token'].$url, 'SSL'));
		}

		$tab="general";
		if (isset($this->request->get['tab']))
			{$tab=$this->request->get['tab'];}

		if (isset($this->request->post['tab']))
			{$tab=$this->request->post['tab'];}


		$data['name']=isset($this->request->post['name'])?$this->request->post['name']:"";
		$data['title']=isset($this->request->post['title'])?$this->request->post['title']:"";
		$data['tab_name']=$tab;
		$data['type']=isset($this->request->post['type'])?$this->request->post['type']:"input";
		$data['required']=isset($this->request->post['required'])?$this->request->post['required']:0;
		$data['default_value']=isset($this->request->post['default_value'])?$this->request->post['default_value']:"";
		$data['note'] = isset($this->request->post['note'])?$this->request->post['note']:"";
		$data['status']=isset($this->request->post['status'])?$this->request->post['status']:1;
		$data['sort_order']=isset($this->request->post['sort_order'])?$this->request->post['sort_order']:0;

		$data['action'] = $this->url->link('module/h_custom_variables/add', 'token=' . $this->session->data['token'].$url, 'SSL');

		$this->GetForm($data);
	}

	public function edit()
	{
		$data=$this->load->language('module/h_custom_variables');
		$this->document->setTitle($this->language->get('heading_title'));
		$this->load->model("hcv/functions");

		$url="";
		if (isset($this->request->get['tab']))
			{$url.="&tab=".$this->request->get['tab'];}

		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validate())
		{
			$this->model_hcv_functions->updateVariable($this->request->get['var_id'],$this->request->post);
			$data['success'] = $this->language->get('text_success');
			$this->response->redirect($this->url->link('module/h_custom_variables', 'token=' . $this->session->data['token'].$url, 'SSL'));
		}

		$result=$this->model_hcv_functions->getVariables(array("variable_id"=>(int)$this->request->get['var_id']));
		$var=end($result);

		// $this->load->model("hcv/fields/".$var['type']);
		// $this->{"model_hcv_fields_".$var['type']}->prepare($var);

		$tab=$var['tab_name'];
		if (isset($this->request->post['tab']))
			{$tab=$this->request->post['tab'];}

		$data['name']=isset($this->request->post['name'])?$this->request->post['name']:$var['name'];
		$data['title']=isset($this->request->post['title'])?$this->request->post['title']:$var['title'];
		$data['tab_name']=$tab;
		$data['type']=isset($this->request->post['type'])?$this->request->post['type']:$var['type'];
		$data['required']=isset($this->request->post['required'])?$this->request->post['required']:$var['required'];
		$data['default_value']=isset($this->request->post['default_value'])?$this->request->post['default_value']:$var['default_value'];
		$data['note'] = isset($this->request->post['note'])?$this->request->post['note']:$var['note'];
		$data['status']=isset($this->request->post['status'])?$this->request->post['status']:$var['status'];
		$data['sort_order']=isset($this->request->post['sort_order'])?$this->request->post['sort_order']:$var['sort_order'];

		$data['action'] = $this->url->link('module/h_custom_variables/edit', 'token=' . $this->session->data['token'].$url."&var_id=".$var['variable_id'], 'SSL');

		$this->GetForm($data);
	}

	public function GetList($data)
	{
		if (isset($this->error['warning'])) {
			$data['error_warning'] = $this->error['warning'];
		} else {
			$data['error_warning'] = '';
		}

		if (!isset($data['success'])) 
			{$data['success'] = '';}

		$url="";
		if (isset($this->request->get['tab']))
			{$url.="&tab=".$this->request->get['tab'];}


		$data['add_link']=$this->url->link('module/h_custom_variables/add', 'token=' . $this->session->data['token'].$url, 'SSL');

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_home'),
			'href' => $this->url->link('common/dashboard', 'token=' . $this->session->data['token'], 'SSL')
		);
		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_module'),
			'href' => $this->url->link('extension/module', 'token=' . $this->session->data['token'], 'SSL')
		);
		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('heading_title'),
			'href' => $this->url->link('module/h_custom_variables', 'token=' . $this->session->data['token'], 'SSL')
		);

		$data['tab_link_base']=$this->url->link('module/h_custom_variables', 'token=' . $this->session->data['token'], 'SSL');

		// GET VARIABLES ARRAY
		$this->load->model("hcv/functions");
		$variables=$this->model_hcv_functions->getVariables(array("extension"=>"product_category"));
		foreach ($variables as $key => $var)
		{
			$var['href']=$this->url->link('module/h_custom_variables/edit',"token=".$this->session->data['token']."&var_id=".$var['variable_id'].$url,"SSL");
			$data['variables'][$var['tab_name']][]=$var;
		}

		$data['action'] = $this->url->link('module/h_low_variables', 'token=' . $this->session->data['token'], 'SSL');
		$data['cancel'] = $this->url->link('extension/module', 'token=' . $this->session->data['token'], 'SSL');
		$data['header'] = $this->load->controller('common/header');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer'] = $this->load->controller('common/footer');

		$this->response->setOutput($this->load->view('module/h_custom_variables/cv_list.tpl', $data));
		// $this->response->setOutput($this->load->view('module/h_low_variables/tabs_list.tpl', $data));
	}

	public function GetForm($data)
	{
		if (isset($this->error['warning'])) {
			$data['error_warning'] = $this->error['warning'];
			$data=array_merge($data,$this->error);
		} else {
			$data['error_warning'] = '';
		}

		if (!isset($data['success'])) 
			{$data['success'] = '';}

		$url="";

		if (isset($this->request->get['tab']))
			{$url.="&tab=".$this->request->get['tab'];}

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_home'),
			'href' => $this->url->link('common/dashboard', 'token=' . $this->session->data['token'], 'SSL')
		);
		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_module'),
			'href' => $this->url->link('extension/module', 'token=' . $this->session->data['token'], 'SSL')
		);
		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('heading_title'),
			'href' => $this->url->link('module/h_custom_variables', 'token=' . $this->session->data['token'].$url, 'SSL')
		);

		$this->load->model("hcv/functions");
		$data['types_list']=$this->model_hcv_functions->getTypes();

		$data['cancel'] = $this->url->link('module/h_custom_variables', 'token=' . $this->session->data['token'].$url, 'SSL');
		$data['header'] = $this->load->controller('common/header');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer'] = $this->load->controller('common/footer');

		$this->response->setOutput($this->load->view('module/h_custom_variables/cv_form.tpl', $data));
	}

	public function validate()
	{
		$valid=true;

		if (preg_match("/^[^a-z0-9_]$/i", $this->request->post['name']))
			{$this->error['error_name']=$this->language->get('text_error_name');$valid=false;}

		if (strlen($this->request->post['name'])<3 || strlen($this->request->post['name'])>50)
			{$this->error['error_name']=$this->language->get('text_error_name');$valid=false;}

		if (strlen($this->request->post['title'])<3 || strlen($this->request->post['title'])>150)
			{$this->error['error_title']=$this->language->get('text_error_title');$valid=false;}

		if (!$valid)
			{$this->error['warning']=$this->language->get('text_errors');}
		return $valid;
	}




}
 ?>