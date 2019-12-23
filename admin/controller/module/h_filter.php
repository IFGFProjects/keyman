<?php
class ControllerModulehfilter extends Controller {
	private $error = array();

	// public function install()
	// {
	// 	$this->db->query("CREATE TABLE IF NOT EXISTS
 //    		`" . DB_PREFIX . "hfilter` (
 //    			    `attribute_id` int(11) NOT NULL,
 //    			    `category_id` SMALLINT(6) NOT NULL,
 //    			    `type` CHAR(30) NOT NULL,
 //    			    `min_value` FLOAT(12) NULL,
 //    			    `max_value` FLOAT(12) NULL,
 //    			    `text_value` TEXT NULL,
 //    			    `default_value` VARCHAR(250) NULL,
 //    			    `status` SMALLINT(6) NOT NULL,
 //    			     INDEX (`attribute_id`,`category_id`)
 //    			)");
	// }

	// public function uninstall()
	// {
	// 	$this->db->query("DROP TABLE IF EXISTS `" . DB_PREFIX . "hfilter`");
	// }


	public function AjaxAddAttribute()
	{
		$this->load->model("catalog/attribute");
		$atr_id=$this->model_catalog_attribute->addAttribute(array(
			"attribute_group_id"=>0,
			"sort_order"=>"",
			"attribute_description"=>array((int)$this->config->get('config_language_id')=>array("name"=>"")),
			""
		));
		$atr_data['type']="text";
		$atr_data['min_value']="";
		$atr_data['max_value']="";
		$atr_data['text_value']="";
		$atr_data['default_value']="";
		$atr_data['status']=0;
		$atr_data['priority']="attribute";


		$this->load->model("catalog/hfilter");

		$this->model_catalog_hfilter->AddAttribute($atr_id, $this->request->get["category_id"],$atr_data);

		$this->response->setOutput(json_encode(array("status"=>"OK","attribute_id"=>$atr_id)));
	}

	public function AjaxDeleteAttribute()
	{
		if (isset($this->request->get['atr_id']))
		{

			$this->load->model("catalog/attribute");
			$this->model_catalog_attribute->deleteAttribute($this->request->get['atr_id']);
		
			$this->load->model("catalog/hfilter");
			$this->model_catalog_hfilter->DeleteAttribute($this->request->get['atr_id']);
			$this->response->setOutput(json_encode($this->request->get["atr_id"]));
		}

	}

	public function AjaxProductCategoryAttributes()
	{
		// echo "<h1 style='color:red;'>_POST :</h1><pre>";print_r($_POST);echo "</pre><hr>";
		
		if (isset($this->request->post['category']) )
		{
			$this->load->model("catalog/hfilter");
			$product_attributes=array();
			foreach ($this->request->post['category'] as $key => $value) 
			{
				$atrs_data=array("category"=>(int)$value);
				if (isset($this->request->post['product_id'])) 
					{$atrs_data['product_id']=(int)$this->request->post['product_id'];}
				$product_attributes=array_merge($this->model_catalog_hfilter->GetProductAttributes($atrs_data),$product_attributes);
			}


			$data=$this->load->language('module/h_filter');
			$data=$this->load->language('catalog/product');
			$data['enum_text']=$this->language->get("attribute_enum");
			$data['languages'][]=array("language_id"=>$this->config->get('config_language_id'));

			$data['attributes']=$product_attributes;
			$this->response->setOutput($this->load->view('module/h_filter_product_form.tpl', $data));
		}
	}

	public function CategoryForm()
	{
		$data=$this->load->language('module/h_filter');

		$this->load->model("catalog/hfilter");
		$data['attributes']=array();
		if (isset($this->request->get['category_id']))
			{$data['attributes']=$this->model_catalog_hfilter->GetCategoryAttributes($this->request->get['category_id']);}


		return $this->load->view('module/h_filter_category_form.tpl', $data);
	}



	public function ProductForm()
	{
		$data=$this->load->language('module/h_filter');
		$data['enum_text']=$this->language->get("attribute_enum");

		$this->load->model("catalog/hfilter");
		$data['attributes']=array();
		// if (isset($this->request->get['category_id']))
			// {$data['attributes']=$this->model_catalog_hfilter->GetCategoryAttributes($this->request->get['category_id']);}


		return $this->load->view('module/h_filter_product_form.tpl', $data);
	}







	public function index() {
		$this->load->language('module/h_filter');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('setting/setting');

		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validate()) {
			$this->model_setting_setting->editSetting('h_filter', $this->request->post);

			$this->session->data['success'] = $this->language->get('text_success');

			$this->response->redirect($this->url->link('extension/module', 'token=' . $this->session->data['token'], 'SSL'));
		}

		$data['heading_title'] = $this->language->get('heading_title');

		$data['text_edit'] = $this->language->get('text_edit');
		$data['text_enabled'] = $this->language->get('text_enabled');
		$data['text_disabled'] = $this->language->get('text_disabled');

		$data['entry_status'] = $this->language->get('entry_status');

		$data['button_save'] = $this->language->get('button_save');
		$data['button_cancel'] = $this->language->get('button_cancel');

		if (isset($this->error['warning'])) {
			$data['error_warning'] = $this->error['warning'];
		} else {
			$data['error_warning'] = '';
		}

		$data['breadcrumbs'] = array();

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
			'href' => $this->url->link('module/h_filter', 'token=' . $this->session->data['token'], 'SSL')
		);

		$data['action'] = $this->url->link('module/h_filter', 'token=' . $this->session->data['token'], 'SSL');

		$data['cancel'] = $this->url->link('extension/module', 'token=' . $this->session->data['token'], 'SSL');

		if (isset($this->request->post['filter_status'])) {
			$data['filter_status'] = $this->request->post['filter_status'];
		} else {
			$data['filter_status'] = $this->config->get('filter_status');
		}

		$data['header'] = $this->load->controller('common/header');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer'] = $this->load->controller('common/footer');

		$this->response->setOutput($this->load->view('module/h_filter.tpl', $data));
	}

	protected function validate() {
		if (!$this->user->hasPermission('modify', 'module/h_filter')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}

		return !$this->error;
	}
}