<?php
class Controllercatalogvacancies extends Controller {
	private $error = array();

	public function index() {
		$this->document->setTitle("Вакансии");

		$this->getList();
	}

	public function add() {
		$this->document->setTitle("Новая вакансия");

		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()) {
			// $this->model_catalog_information->addInformation($this->request->post);
			$query="INSERT INTO vacancies SET 
				vc_name='".$this->request->post['vacancies']['vc_name']."', 
				vc_text='".$this->request->post['vacancies']['vc_text']."', 
				vc_price=".$this->request->post['vacancies']['vc_price'].", 
				vc_email='".$this->request->post['vacancies']['vc_email']."', 
				vc_status=".$this->request->post['vacancies']['vc_status']."
			";
			$this->db->query($query);

			$this->session->data['success'] = "Успешно добавлено";

			$url = '';

			$this->response->redirect($this->url->link('catalog/vacancies', 'token=' . $this->session->data['token'] . $url, 'SSL'));
		}

		$this->getForm();
	}

	public function edit() {
		$this->language->load('catalog/information');

		$this->document->setTitle("Новая вакансия");

		$this->load->model('catalog/information');

		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()) {
			// $this->model_catalog_information->editInformation($this->request->get['information_id'], $this->request->post);
			$query="UPDATE vacancies SET 
				vc_name='".$this->request->post['vacancies']['vc_name']."', 
				vc_text='".$this->request->post['vacancies']['vc_text']."', 
				vc_price=".$this->request->post['vacancies']['vc_price'].", 
				vc_email='".$this->request->post['vacancies']['vc_email']."', 
				vc_status=".$this->request->post['vacancies']['vc_status']."
				WHERE vc_id=".$this->request->get['vc_id']."
			";
			$this->db->query($query);

			$this->session->data['success'] = $this->language->get('text_success');

			$url = '';

			$this->response->redirect($this->url->link('catalog/vacancies', 'token=' . $this->session->data['token'] . $url, 'SSL'));
		}

		$this->getForm();
	}

	public function delete() {
		$this->document->setTitle("Вакансии");

		if (isset($this->request->post['selected']) && $this->validateDelete()) {
			foreach ($this->request->post['selected'] as $vc_id) {
				$this->db->query("DELETE FROM vacancies WHERE vc_id=$vc_id");
			}
			$this->session->data['success'] = $this->language->get('text_success');

			$url = '';

			$this->response->redirect($this->url->link('catalog/vacancies', 'token=' . $this->session->data['token'] . $url, 'SSL'));
		}

		$this->getList();
	}

	protected function getList() {
		$data['breadcrumbs'] = array();
		$url="";
		$this->language->load('catalog/information');

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_home'),
			'href' => $this->url->link('common/dashboard', 'token=' . $this->session->data['token'], 'SSL')
		);

		$data['breadcrumbs'][] = array(
			'text' => "Вакансии",
			'href' => $this->url->link('catalog/vacancies', 'token=' . $this->session->data['token'] . $url, 'SSL')
		);

		$data['add'] = $this->url->link('catalog/vacancies/add', 'token=' . $this->session->data['token'] . $url, 'SSL');
		$data['delete'] = $this->url->link('catalog/vacancies/delete', 'token=' . $this->session->data['token'] . $url, 'SSL');

		$vc=$this->db->query("SELECT * FROM vacancies ORDER BY vc_id DESC");
		$data['vacancies']=array();
		foreach ($vc->rows as $key => $value) 
		{
			$data['vacancies'][$value['vc_id']]=array(
				"id"	=>	$value['vc_id'],
				"name"	=>	$value['vc_name'],
				"text"	=>	$value['vc_text'],
				"price"	=>	$value['vc_price'],
				"email"	=>	$value['vc_email'],
				"status"	=>	$value['vc_status'],
				"edit"	=>	$data['action'] = $this->url->link('catalog/vacancies/edit', 'token=' . $this->session->data['token'] . '&vc_id=' . $value['vc_id'] . $url, 'SSL')

			);
		}

		if (isset($this->request->post['selected'])) {
			$data['selected'] = (array)$this->request->post['selected'];
		} else {
			$data['selected'] = array();
		}

		$data['header'] = $this->load->controller('common/header');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer'] = $this->load->controller('common/footer');

		$this->response->setOutput($this->load->view('catalog/vacancies_list.tpl', $data));
	}

	protected function getForm() {
		$data['heading_title'] = "Вакансия";

		$data['text_form'] = !isset($this->request->get['vc_id']) ? "Новая " : "Редактирование";

		$data['button_save'] = "Сохранить";
		$data['button_cancel'] = "Отменить";

		if (isset($this->error['warning'])) {
			$data['error_warning'] = $this->error['warning'];
		} else {
			$data['error_warning'] = '';
		}
		$url = '';

		$data['breadcrumbs'] = array();

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_home'),
			'href' => $this->url->link('common/dashboard', 'token=' . $this->session->data['token'], 'SSL')
		);

		$data['breadcrumbs'][] = array(
			'text' => "Вакансии",
			'href' => $this->url->link('catalog/vacancies', 'token=' . $this->session->data['token'] . $url, 'SSL')
		);

		if (!isset($this->request->get['vc_id'])) {
			$data['action'] = $this->url->link('catalog/vacancies/add', 'token=' . $this->session->data['token'] . $url, 'SSL');
		} else {
			$data['action'] = $this->url->link('catalog/vacancies/edit', 'token=' . $this->session->data['token'] . '&vc_id=' . $this->request->get['vc_id'] . $url, 'SSL');
		}

		$data['cancel'] = $this->url->link('catalog/vacancies', 'token=' . $this->session->data['token'] . $url, 'SSL');

		if (isset($this->request->get['vc_id']) && ($this->request->server['REQUEST_METHOD'] != 'POST')) 
		{
			$vc=$this->db->query("SELECT * FROM vacancies WHERE vc_id='".$this->request->get['vc_id']."' ORDER BY vc_id DESC");
			$vc_info=$vc->row;
		}

		$data['token'] = $this->session->data['token'];

		$this->load->model('setting/store');

		if (isset($this->request->post['vc_name'])) {
			$data['vc_name'] = $this->request->post['vc_name'];
		} elseif (!empty($vc_info)) {
			$data['vc_name'] = $vc_info['vc_name'];
		} else {
			$data['vc_name'] = "";
		}

		if (isset($this->request->post['vc_text'])) {
			$data['vc_text'] = $this->request->post['vc_text'];
		} elseif (!empty($vc_info)) {
			$data['vc_text'] = $vc_info['vc_text'];
		} else {
			$data['vc_text'] = "";
		}

		if (isset($this->request->post['vc_price'])) {
			$data['vc_price'] = $this->request->post['vc_price'];
		} elseif (!empty($vc_info)) {
			$data['vc_price'] = $vc_info['vc_price'];
		} else {
			$data['vc_price'] = 0;
		}

		if (isset($this->request->post['vc_email'])) {
			$data['vc_email'] = $this->request->post['vc_email'];
		} elseif (!empty($vc_info)) {
			$data['vc_email'] = $vc_info['vc_email'];
		} else {
			$data['vc_email'] = "";
		}

		if (isset($this->request->post['vc_status'])) {
			$data['vc_status'] = $this->request->post['vc_status'];
		} elseif (!empty($vc_info)) {
			$data['vc_status'] = $vc_info['vc_status'];
		} else {
			$data['vc_status'] = 1;
		}

		$data['header'] = $this->load->controller('common/header');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer'] = $this->load->controller('common/footer');

		$this->response->setOutput($this->load->view('catalog/vacancy_form.tpl', $data));
	}

	protected function validateForm() {
		if (!$this->user->hasPermission('modify', 'catalog/vacancies')) {
			$this->error['warning'] = "Доступ к модулю запрещён";
		}

		return !$this->error;
	}

	protected function validateDelete() {
		if (!$this->user->hasPermission('modify', 'catalog/information')) {
			$this->error['warning'] = "Доступ к модулю запрещён";
		}

		return !$this->error;
	}
}