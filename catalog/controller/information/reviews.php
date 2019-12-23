<?php
class Controllerinformationreviews extends Controller {
	public function index() {

		$data['breadcrumbs'][] = array(
			'text' => "Команда Keyman",
			'href' => $this->url->link('information/information',"information_id=10",'SSL')
		);

		$data['breadcrumbs'][] = array(
			'text' => "Вакансии",
			'href' => $this->url->link('information/vacancies','','SSL')
			
		);

		$data['breadcrumbs'][] = array(
			'text' => "Отзывы",
			'href' => $this->url->link('information/reviews','','SSL'),
			"active"=>true
		);

		$data['breadcrumbs'][] = array(
			'text' => "О компании",
			'href' => $this->url->link('information/information',"information_id=12",'SSL')
		);

		$this->document->addScript('catalog/view/theme/'.$this->config->get('config_template').'/js/jquery.selectBox.js');

		$this->document->setTitle("Отзывы Keyman");
		$this->document->setDescription("Отзывы Keyman");
		$this->document->setKeywords("Отзывы Keyman");

		$this->load->model("catalog/review");
		$this->load->model("tool/image");
		if (isset($this->request->get['page'])) {
			$page = $this->request->get['page'];
			$this->document->setTitle("Отзывы Keyman - страница ".$page);
			$this->document->setDescription("Отзывы Keyman - страница ".$page);
		} else {
			$page = 1;
		}
		$start=0;$limit=5;
		if (isset($this->request->get['page']))
			{$start=($page-1)*$limit;}
		foreach ($this->model_catalog_review->getReviewsNoProduct($start,$limit) as $key => $value) 
		{
			$image="https://keyman.by/image/user.png";
			if ($value['image']!="")
				{$value['image']=$this->model_tool_image->resize($value['image'],98,98);}
			$data["reviews"][]=array(
				"review_id"=>$value['review_id'],
				"author"=>$value['author'],
				"age"=>$value['age'],
				"text"=>html_entity_decode($value['text'], ENT_QUOTES, 'UTF-8'),
				"image"=>$image,
				"answer_name"=>$value['answer_name'],
				"answer_text"=>html_entity_decode($value['answer_text'], ENT_QUOTES, 'UTF-8')
			);
		}

		$this->load->model('catalog/information');
		$data['video'][]=$this->model_catalog_information->getInformation(17);
		$data['video'][]=$this->model_catalog_information->getInformation(18);
		$data['video'][]=$this->model_catalog_information->getInformation(19);


			$data['heading_title'] = "Отзывы";

			$data['column_left'] = $this->load->controller('common/column_left');
			$data['column_right'] = $this->load->controller('common/column_right');
			$data['content_top'] = $this->load->controller('common/content_top');
			$data['content_bottom'] = $this->load->controller('common/content_bottom');
			$data['footer'] = $this->load->controller('common/footer');
			$data['header'] = $this->load->controller('common/header');

			$pagination = new Pagination();
			$pagination->total = $this->model_catalog_review->getTotalReviewsNoProduct();
			$pagination->page = $page;
			$pagination->limit = $limit;
			$pagination->url = $this->url->link('information/reviews', '&page={page}','SSL');

			$data['pagination'] = $pagination->render();

			if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/information/reviews.tpl')) {
				$this->response->setOutput($this->load->view($this->config->get('config_template') . '/template/information/reviews.tpl', $data));
			} else {
				$this->response->setOutput($this->load->view('default/template/information/reviews.tpl', $data));
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