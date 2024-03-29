<?php
// *	@copyright	OPENCART.PRO 2011 - 2015.
// *	@forum	http://forum.opencart.pro
// *	@source		See SOURCE.txt for source and other copyright.
// *	@license	GNU General Public License version 3; see LICENSE.txt

class ControllerModuleRobotsWriter extends Controller {
	private $error = array();

	public function index() {
		$this->load->language('module/robots_writer');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('setting/setting');

		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validate()) {

			$robots_file=str_replace("system/", "", DIR_SYSTEM)."robots.txt";
			if (!file_exists($robots_file))
			{
				$myfile = fopen($robots_file, "w") or die("Unable to open/create robots file!");
				fclose($myfile);
			}
			$data['text']=file_put_contents($robots_file,html_entity_decode($this->request->post['text']));
			unset($this->request->post['text']);

			$this->model_setting_setting->editSetting('robots_writer', $this->request->post);
			$this->session->data['success'] = $this->language->get('text_success');

			$this->response->redirect($this->url->link('extension/module', 'token=' . $this->session->data['token'], 'SSL'));
		}

		$data['heading_title'] = $this->language->get('heading_title');

		$data['text_edit'] = $this->language->get('text_edit');
		$data['text_enabled'] = $this->language->get('text_enabled');
		$data['text_disabled'] = $this->language->get('text_disabled');

		$data['entry_content'] = $this->language->get('entry_content');
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
			'href' => $this->url->link('module/robots_writer', 'token=' . $this->session->data['token'], 'SSL')
		);

		$data['action'] = $this->url->link('module/robots_writer', 'token=' . $this->session->data['token'], 'SSL');

		$data['cancel'] = $this->url->link('extension/module', 'token=' . $this->session->data['token'], 'SSL');

		if (isset($this->request->post['robots_writer_status'])) {
			$data['robots_writer_status'] = $this->request->post['robots_writer_status'];
		} else {
			$data['robots_writer_status'] = $this->config->get('robots_writer_status');
		}

		$robots_file=str_replace("system/", "", DIR_SYSTEM)."robots.txt";
		if (!file_exists($robots_file))
		{
			$myfile = fopen($robots_file, "w") or die("Unable to open/create robots file!");
			fclose($myfile);
		}
		$data['text']=html_entity_decode(file_get_contents($robots_file));

		$data['header'] = $this->load->controller('common/header');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer'] = $this->load->controller('common/footer');

		$this->response->setOutput($this->load->view('module/robots_writer.tpl', $data));
	}

	protected function validate() {
		if (!$this->user->hasPermission('modify', 'module/robots_writer')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}

		return !$this->error;
	}
}