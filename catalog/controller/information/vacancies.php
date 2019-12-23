<?php
class Controllerinformationvacancies extends Controller {
	public function index() {

		$data['breadcrumbs'][] = array(
			'text' => "Команда Keyman",
			'href' => $this->url->link('information/information',"information_id=10",'SSL')
		);

		$data['breadcrumbs'][] = array(
			'text' => "Вакансии",
			'href' => $this->url->link('information/vacancies','','SSL'),
			"active"=>true
		);

		$data['breadcrumbs'][] = array(
			'text' => "Отзывы",
			'href' => $this->url->link('information/reviews','','SSL')
		);

		$data['breadcrumbs'][] = array(
			'text' => "О компании",
			'href' => $this->url->link('information/information',"information_id=12",'SSL')
		);

		$vc=$this->db->query("SELECT * FROM vacancies WHERE vc_status=1 ORDER BY vc_id DESC");

		foreach ($vc->rows as $key => $value) 
		{
			$data["vacancies"][$value['vc_id']]=array(
				"name"=>$value['vc_name'],
				"text"=>html_entity_decode($value['vc_text'], ENT_QUOTES, 'UTF-8'),
				"price"=>$this->currency->format($value['vc_price']),
				"email"=>$value['vc_email']
			);
		}

			$this->document->setTitle("Вакансии Keyman");
			$this->document->setDescription("Вакансии Keyman");
			$this->document->setKeywords("Вакансии Keyman");

			$data['heading_title'] = "Вакансии Keyman";

			$data['column_left'] = $this->load->controller('common/column_left');
			$data['column_right'] = $this->load->controller('common/column_right');
			$data['content_top'] = $this->load->controller('common/content_top');
			$data['content_bottom'] = $this->load->controller('common/content_bottom');
			$data['footer'] = $this->load->controller('common/footer');
			$data['header'] = $this->load->controller('common/header');

			if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/information/vacancies.tpl')) {
				$this->response->setOutput($this->load->view($this->config->get('config_template') . '/template/information/vacancies.tpl', $data));
			} else {
				$this->response->setOutput($this->load->view('default/template/information/vacancies.tpl', $data));
			}
	}

	public function agree() {
		$this->load->model('catalog/information');

		if (isset($this->request->get['information_id'])) {
			$information_id = (int)$this->request->get['information_id'];
		} else {
			$information_id = 0;
		}

		$output = '';

		$information_info = $this->model_catalog_information->getInformation($information_id);

		if ($information_info) {
			$output .= html_entity_decode($information_info['description'], ENT_QUOTES, 'UTF-8') . "\n";
		}

		$this->response->setOutput($output);
	}
}