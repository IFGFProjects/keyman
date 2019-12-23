<?php 
class ControllerModuleBlogtagsmgr extends Controller {
	private $error = array();

	public function index()
	{
		$data=$this->load->language('module/blogtagsmgr');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('setting/setting');

		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validate()) {
			$this->model_setting_setting->editSetting('blogtagsmgr', $this->request->post);

			$this->session->data['success'] = $this->language->get('text_success');

			$this->response->redirect($this->url->link('extension/module', 'token=' . $this->session->data['token'], 'SSL'));
		}


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
				'href' => $this->url->link('module/blogtagsmgr', 'token=' . $this->session->data['token'], 'SSL')
			);

			$data_filter=array();
			if (isset($this->request->get['sort']))
				{$data_filter['sort']=$this->request->get['sort'];}
			else
				{$data_filter['sort']="tg.tag_id";}

			if (isset($this->request->get['order']))
				{$data_filter['order']=$this->request->get['order'];}
			else
				{$data_filter['order']="ASC";}

			if (isset($this->request->get['selected']))
				{$data['selected']=$this->request->get['selected'];}
			else
				{$data['selected']=array();}



			$data['sort']=$data_filter['sort'];
			$data['order']=$data_filter['order'];
			$data['un_order']=strtolower(trim($data_filter['order']))=="asc"?"DESC":"ASC";

			$url="&sort=".$data_filter['sort']."&order=".$data_filter['order'];

			$data['link_list']= $this->url->link('module/blogtagsmgr', 'token=' . $this->session->data['token'], 'SSL');
			$data['link_add'] = $this->url->link('module/blogtagsmgr/add', 'token=' . $this->session->data['token'].$url, 'SSL');
			$data['link_delete'] = $this->url->link('module/blogtagsmgr/delete', 'token=' . $this->session->data['token'].$url, 'SSL');

			$data['sort_tag_name_link']= $this->url->link('module/blogtagsmgr', 'token=' . $this->session->data['token'].$url, 'SSL');

			// $data['cancel'] = $this->url->link('extension/module', 'token=' . $this->session->data['token'], 'SSL');

			$this->load->model('blogtagsmgr/tags');
			$data['tags']=$this->model_blogtagsmgr_tags->getTags($data_filter);

			$data['header'] = $this->load->controller('common/header');
			$data['column_left'] = $this->load->controller('common/column_left');
			$data['footer'] = $this->load->controller('common/footer');

			$this->response->setOutput($this->load->view('module/blogtagsmgr_list.tpl', $data));
		}


		public function add()
		{
			$data=$this->load->language('module/blogtagsmgr');

			$this->document->setTitle($this->language->get('heading_title'));

			if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()) {
				$this->load->model("blogtagsmgr/tags");
				$this->model_blogtagsmgr_tags->addTag($this->request->post);
				$this->session->data['success'] = $this->language->get('text_success');

				$this->response->redirect($this->url->link('module/blogtagsmgr', 'token=' . $this->session->data['token'], 'SSL'));
			}

			if (isset($this->error['warning'])) {
				$data['error_warning'] = $this->error['warning'];
			} else {
				$data['error_warning'] = '';
			}

			if (isset($this->error['name']))
				{$data['error_name'] = $this->error['name'];}

			if (isset($this->error['link']))
				{$data['error_link'] = $this->error['link'];}

			if (isset($this->error['category']))
				{$data['error_category'] = $this->error['category'];}

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
					'href' => $this->url->link('module/blogtagsmgr', 'token=' . $this->session->data['token'], 'SSL')
				);


				$data['cancel'] = $this->url->link('module/blogtagsmgr', 'token=' . $this->session->data['token'], 'SSL');

				$data['text_form'] = $this->language->get('form_text_add');
				$this->load->model("blogtagsmgr/tags");

				// if (isset($this->request->get['tag_id']) && ($this->request->server['REQUEST_METHOD'] != 'POST')) {
				// 	$tag_info = $this->model_blogtagsmgr_tags->getTag($this->request->get['tag_id']);
				// }
				$data['status']=1;

				$data['action'] = $this->url->link('module/blogtagsmgr/add', 'token=' . $this->session->data['token'], 'SSL');

				$data['token'] = $this->session->data['token'];

				$this->load->model('localisation/language');
				$data['languages'] = $this->model_localisation_language->getLanguages();

				// $this->load->model("catalog/category");
				// $data['categories'] = $this->model_catalog_category->getAllCategories();
				$this->load->model('pavblog/menu');
				$data['categories'] = $this->model_pavblog_menu->getDropdown(null, isset($data['category_id']) ? $data['category_id'] :0, 'category_id' );

				$data['header'] = $this->load->controller('common/header');
				$data['column_left'] = $this->load->controller('common/column_left');
				$data['footer'] = $this->load->controller('common/footer');

				$this->response->setOutput($this->load->view('module/blogtagsmgr_form.tpl', $data));
		}

		public function edit()
		{
			$data=$this->load->language('module/blogtagsmgr');

			$this->document->setTitle($this->language->get('heading_title'));

			if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()) {
				$this->load->model("blogtagsmgr/tags");
				$this->model_blogtagsmgr_tags->editTag($this->request->get['tag_id'],$this->request->post);
				$this->session->data['success'] = $this->language->get('text_success');

				$this->response->redirect($this->url->link('module/blogtagsmgr', 'token=' . $this->session->data['token'], 'SSL'));
			}

			if (isset($this->error['warning'])) {
				$data['error_warning'] = $this->error['warning'];
			} else {
				$data['error_warning'] = '';
			}

			if (isset($this->error['name']))
				{$data['error_name'] = $this->error['name'];}

			if (isset($this->error['link']))
				{$data['error_link'] = $this->error['link'];}

			if (isset($this->error['category']))
				{$data['error_category'] = $this->error['category'];}

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
					'href' => $this->url->link('module/blogtagsmgr', 'token=' . $this->session->data['token'], 'SSL')
				);


				$data['cancel'] = $this->url->link('module/blogtagsmgr', 'token=' . $this->session->data['token'], 'SSL');

				$data['text_form'] = $this->language->get('form_text_add');
				$this->load->model("blogtagsmgr/tags");

				if (isset($this->request->get['tag_id']) && ($this->request->server['REQUEST_METHOD'] != 'POST')) {
					$data=array_merge($data, $this->model_blogtagsmgr_tags->getTag($this->request->get['tag_id']));
				}

				$data['action'] = $this->url->link('module/blogtagsmgr/edit', 'token=' . $this->session->data['token']."&tag_id=".$data['tag_id'], 'SSL');

				$data['token'] = $this->session->data['token'];

				$this->load->model('localisation/language');
				$data['languages'] = $this->model_localisation_language->getLanguages();

				// $this->load->model("catalog/category");
				// $data['categories'] = $this->model_catalog_category->getAllCategories();

				$this->load->model('pavblog/menu');
				$data['categories'] = $this->model_pavblog_menu->getDropdown(null, isset($data['category_id']) ? $data['category_id'] :0, 'category_id' );

				$data['header'] = $this->load->controller('common/header');
				$data['column_left'] = $this->load->controller('common/column_left');
				$data['footer'] = $this->load->controller('common/footer');

				$this->response->setOutput($this->load->view('module/blogtagsmgr_form.tpl', $data));
		}

		public function delete() {
			$this->load->language('module/blogtagsmgr');

			$this->document->setTitle($this->language->get('heading_title'));

			$this->load->model('blogtagsmgr/tags');

			if (isset($this->request->post['selected']) && $this->validateDelete()) {
				foreach ($this->request->post['selected'] as $tag_id) {
					$this->model_blogtagsmgr_tags->deleteTag($tag_id);
				}

				$this->session->data['success'] = $this->language->get('text_success');

				$url = '';

				if (isset($this->request->get['sort'])) {
					$url .= '&sort=' . $this->request->get['sort'];
				}

				if (isset($this->request->get['order'])) {
					$url .= '&order=' . $this->request->get['order'];
				}

				// if (isset($this->request->get['page'])) {
				// 	$url .= '&page=' . $this->request->get['page'];
				// }
			}

			$this->response->redirect($this->url->link('module/blogtagsmgr', 'token=' . $this->session->data['token'] . $url, 'SSL'));
		}



		protected function validate() {
			if (!$this->user->hasPermission('modify', 'module/blogtagsmgr')) {
				$this->error['warning'] = $this->language->get('error_permission');
			}

			return !$this->error;
		}

		protected function validateForm() {
			if (!$this->user->hasPermission('modify', 'module/blogtagsmgr')) {
				$this->error['warning'] = $this->language->get('error_permission');
			}

			if ($this->request->server['REQUEST_METHOD'] == 'POST')
			{
				if (strlen($this->request->post['name'])<2)
					{$this->error['name']=$this->language->get("text_error_name");}
	
				if (strlen($this->request->post['link'])<2)
					{$this->error['link']=$this->language->get("text_error_link");}
	
				if ((int)$this->request->post['category_id']<1)
					{$this->error['category']=$this->language->get("text_error_category");}
			}

			return !$this->error;
		}

		protected function validateDelete() {
			if (!$this->user->hasPermission('modify', 'module/blogtagsmgr')) {
				$this->error['warning'] = $this->language->get('error_permission');
			}

			return !$this->error;
		}
}
 ?>