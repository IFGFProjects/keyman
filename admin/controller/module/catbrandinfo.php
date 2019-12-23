<?php
class ControllerModuleCatbrandinfo extends Controller {
	private $error = array();

	public function index() {

		$this->document->setTitle('Таблицы размеров');

		$this->get_list();
	}

	public function add()
	{
		$this->load->model("module/catbrandinfo");
		if (($this->request->server['REQUEST_METHOD'] == 'POST') ) {
			$this->model_module_catbrandinfo->add_cbinfo($this->request->post['category_id'],$this->request->post['brand_id'],$this->request->post['text']);

			$this->session->data['success'] = "Успешно добавлено";

			$this->response->redirect($this->url->link('module/catbrandinfo', 'token=' . $this->session->data['token'], 'SSL'));
		}
		$this->GetForm();
	}

	public function edit()
	{
		$this->load->model('module/catbrandinfo');

		if (($this->request->server['REQUEST_METHOD'] == 'POST')) {
			$this->model_module_catbrandinfo->edit_cbinfo($this->request->get['cbid'],$this->request->post['category_id'],$this->request->post['brand_id'],$this->request->post['text']);

			$this->session->data['success'] = "Успешно изменено";

			$this->response->redirect($this->url->link('module/catbrandinfo', 'token=' . $this->session->data['token'], 'SSL'));
		}

		$this->GetForm();
	}

	public function delete() {

		$this->document->setTitle("Таблицы размеров");

		$this->load->model('catalog/category');

		if (isset($this->request->post['selected']) ) {
			$this->load->model("module/catbrandinfo");
			foreach ($this->request->post['selected'] as $cbid) {
				$this->model_module_catbrandinfo->delete_cbinfo($cbid);
			}

			$this->session->data['success'] = "Успешно удалено";

			$this->response->redirect($this->url->link('module/catbrandinfo', 'token=' . $this->session->data['token'], 'SSL'));
		}

		$this->getList();
	}

	function get_list()
	{


		if (isset($this->request->post['selected'])) {
			$data['selected'] = (array)$this->request->post['selected'];
		} else {
			$data['selected'] = array();
		}

		$data['heading_title'] = 'Таблицы размеров';

		$data['breadcrumbs'] = array();
		
		$this->load->language('module/category');
		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_home'),
			'href' => $this->url->link('common/dashboard', 'token=' . $this->session->data['token'], 'SSL')
		);

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_module'),
			'href' => $this->url->link('extension/module', 'token=' . $this->session->data['token'], 'SSL')
		);

		$data['breadcrumbs'][] = array(
			'text' => "Таблицы размеров",
			'href' => $this->url->link('module/catbrandinfo', 'token=' . $this->session->data['token'], 'SSL')
		);

		if (isset($this->error['warning'])) {
			$data['error_warning'] = $this->error['warning'];
		} else {
			$data['error_warning'] = '';
		}

		if (isset($this->session->data['success'])) {
			$data['success'] = $this->session->data['success'];

			unset($this->session->data['success']);
		} else {
			$data['success'] = '';
		}

		$data['add'] = $this->url->link('module/catbrandinfo/add', 'token=' . $this->session->data['token'], 'SSL');
		$data['delete'] = $this->url->link('module/catbrandinfo/delete', 'token=' . $this->session->data['token'], 'SSL');
		$this->load->model("module/catbrandinfo");
		$catbrands=$this->model_module_catbrandinfo->get_cbinfo_list();
		$data['catbrands']=array();
		if (count($catbrands)>0)
		foreach ($catbrands as $key => $value)
		{
			$data['catbrands'][]=array(
				"category"=>$value['category'],
				"category_id"=>$value['category_id'],
				"brand"=>$value['brand'],
				"brand_id"=>$value['brand_id'],
				"text"=>$value['text'],
				"id"=>$value['id'],
				"href"=>$this->url->link("module/catbrandinfo/edit",'token=' . $this->session->data['token']."&cbid=".$value['id'])
			);
		}


		$data['header'] = $this->load->controller('common/header');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer'] = $this->load->controller('common/footer');

		$this->response->setOutput($this->load->view('module/catbrandinfo.tpl', $data));
	}

	function GetForm()
	{

		if (isset($this->error['warning'])) {
			$data['error_warning'] = $this->error['warning'];
		} else {
			$data['error_warning'] = '';
		}

		if (isset($this->error['name'])) {
			$data['error_name'] = $this->error['name'];
		} else {
			$data['error_name'] = array();
		}

		$data['breadcrumbs'] = array();

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_home'),
			'href' => $this->url->link('common/dashboard', 'token=' . $this->session->data['token'], 'SSL')
		);

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('heading_title'),
			'href' => $this->url->link('module/catbrandinfo', 'token=' . $this->session->data['token'], 'SSL')
		);

		if (!isset($this->request->get['cbid'])) {
			$data['action'] = $this->url->link('module/catbrandinfo/add', 'token=' . $this->session->data['token'] , 'SSL');
		} else {
			$data['action'] = $this->url->link('module/catbrandinfo/edit', 'token=' . $this->session->data['token'] . '&cbid=' . $this->request->get['cbid'], 'SSL');
		}

		$data['cancel'] = $this->url->link('module/catbrandinfo', 'token=' . $this->session->data['token'], 'SSL');

		$this->load->model("module/catbrandinfo");
		if (isset($this->request->get['cbid']) && ($this->request->server['REQUEST_METHOD'] != 'POST')) {
			$catbrand_info = $this->model_module_catbrandinfo->get_cbinfo($this->request->get['cbid']);
		}

		$data['token'] = $this->session->data['token'];

		if (isset($this->request->post['category_id'])) {
			$data['category_id'] = $this->request->post['category_id'];
		} elseif (!empty($catbrand_info)) {
			$data['category_id'] = $catbrand_info['category_id'];
		} else {
			$data['category_id'] = 0;
		}

		// if (isset($this->request->post['category'])) {
		// 	$data['category'] = $this->request->post['category'];
		// } elseif (!empty($catbrand_info)) {
		// 	$data['category'] = $catbrand_info['category'];
		// } else {
		// 	$data['category'] = "";
		// }

		if (isset($this->request->post['text'])) {
			$data['text'] = $this->request->post['text'];
		} elseif (!empty($catbrand_info)) {
			$data['text'] = $catbrand_info['text'];
		} else {
			$data['text'] = "";
		}

		if (isset($this->request->post['brand_id'])) {
			$data['brand_id'] = $this->request->post['brand_id'];
		} elseif (!empty($catbrand_info)) {
			$data['brand_id'] = $catbrand_info['brand_id'];
		} else {
			$data['brand_id'] = 0;
		}

		// if (isset($this->request->post['brand'])) {
		// 	$data['brand'] = $this->request->post['brand'];
		// } elseif (!empty($catbrand_info)) {
		// 	$data['brand'] = $catbrand_info['brand'];
		// } else {
		// 	$data['brand'] = "";
		// }

		$data['categories']=$this->db->query("SELECT category_id, name FROM category_description");
		$data['brands']=$this->db->query("SELECT manufacturer_id as brand_id, name FROM manufacturer");

		$data['header'] = $this->load->controller('common/header');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer'] = $this->load->controller('common/footer');

		$this->response->setOutput($this->load->view('module/catbrand_form.tpl', $data));

	}

}