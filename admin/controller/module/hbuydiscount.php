<?php
class ControllerModuleHbuyDiscount extends Controller {
	private $error = array();

	public function index() {
		$data=$this->load->language('module/hbuydiscount');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('setting/setting');

		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validate()) {
			$this->model_setting_setting->editSetting('buydiscount', $this->request->post);

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
			'href' => $this->url->link('module/hbuydiscount', 'token=' . $this->session->data['token'], 'SSL')
		);

		$data['action'] = $this->url->link('module/hbuydiscount/update', 'token=' . $this->session->data['token'], 'SSL');

		$data['cancel'] = $this->url->link('extension/module', 'token=' . $this->session->data['token'], 'SSL');

		$data['header'] = $this->load->controller('common/header');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer'] = $this->load->controller('common/footer');

		$this->load->model('module/hbuydiscount');
		$data['discounts_data']=$this->model_module_hbuydiscount->GetDiscounts();



		$this->response->setOutput($this->load->view('module/hbuydiscount.tpl', $data));
	}

	public function update()
	{
		$this->load->model('module/hbuydiscount');
		if (isset($this->request->post['discount'])) 
		{
			$this->model_module_hbuydiscount->UpdateDiscounts($this->request->post['discount']);
		}

		return $this->index();
	}

	protected function validate() {
		if (!$this->user->hasPermission('modify', 'module/hbuydiscount')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}

		return !$this->error;
	}
}