<?php
class ControllerInformationInformation extends Controller {
	public function index() {
		$this->load->language('information/information');

		$this->load->model('catalog/information');

		$data['breadcrumbs'] = array();

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_home'),
			'href' => $this->url->link('common/home','','SSL')
		);




		if (isset($this->request->get['information_id'])) {
			$information_id = (int)$this->request->get['information_id'];
		} else {
			$information_id = 0;
		}
		$data['information_id']=$information_id;

		if ($information_id==11)
		{
			$rules=$this->model_catalog_information->getInformation(16);
			$data['rules']=$rules['description'];
		}

		if ( ($information_id==10) || ($information_id==12) )
		{
			$data['custom_breadcrumbs'][] = array(
				'text' => "Команда Keyman",
				'href' => $this->url->link('information/information',"information_id=10",'SSL')
			);
	
			$data['custom_breadcrumbs'][] = array(
				'text' => "Вакансии",
				'href' => $this->url->link('information/vacancies','','SSL')
				
			);
	
			$data['custom_breadcrumbs'][] = array(
				'text' => "Отзывы",
				'href' => $this->url->link('information/reviews','','SSL')			
			);
	
			$data['custom_breadcrumbs'][] = array(
				'text' => "О компании",
				'href' => $this->url->link('information/information',"information_id=12",'SSL')
			);
			if ($information_id==10)
				{$data['custom_breadcrumbs'][0]['active']=true;}
			if ($information_id==12)
			{
				$data['custom_breadcrumbs'][3]['active']=true;
				$data['reviews_link']=$this->url->link("information/reviews",'','SSL');
			}
		}

		if ($information_id==12)
		{
			$this->document->addScript('catalog/view/theme/'.$this->config->get('config_template').'/js/jquery.selectBox.js');
			$this->document->addScript('catalog/view/theme/'.$this->config->get('config_template').'/js/ion.rangeSlider.min.js');
			$this->document->addStyle('catalog/view/theme/'.$this->config->get('config_template').'/stylesheet/jquery.selectBox.css');
			$this->document->addStyle('catalog/view/theme/'.$this->config->get('config_template').'/stylesheet/ion.rangeSlider.css');
			$this->document->addStyle('catalog/view/theme/'.$this->config->get('config_template').'/stylesheet/ion.rangeSlider.skinHTML5.css');

			$data['company_about']=true;

			$this->load->model('design/banner');
			$this->load->model("tool/image");
			
			$results = $this->model_design_banner->getBanner(11);
			foreach ($results as $result) 
			{
				if (is_file(DIR_IMAGE . $result['image'])) {
					$data['banner'][] = array(
						'title' => $result['title'],
						'link'  => $result['link'],
						'image' => 'image/'.$result['image']
					);
				}
			}

			$this->load->model("catalog/review");
			foreach ($this->model_catalog_review->getReviewsNoProduct(0,3) as $key => $value) 
			{
				$image=$this->model_tool_image->resize($value['image'],98,98);
				if ($image=="")
					{$image="https://keyman.by/image/user.png";}
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

			$data['config_telephone']=$this->config->get("config_telephone");
			$data['config_open']=str_replace("\n", "<br>", $this->config->get("config_open") );
			$data['config_email']=$this->config->get("config_email");
			// $data['config_address']=$this->config->get("config_address");
			$data['config_address']= preg_replace("/(\r\n)/", "<br/>", $this->config->get("config_address"));
			$data['config_comment']=str_replace("\n", "<br>", $this->config->get("config_comment") );

			$this->load->model('catalog/information');
			$data['left_video']= $this->model_catalog_information->getInformation(14);
			$data['right_video']= $this->model_catalog_information->getInformation(15);
		}

		if ($information_id==8)
		{
			$this->document->addScript('catalog/view/theme/'.$this->config->get('config_template').'/js/jquery.selectBox.js');
			$this->document->addScript('catalog/view/theme/'.$this->config->get('config_template').'/js/ion.rangeSlider.min.js');
			$this->document->addStyle('catalog/view/theme/'.$this->config->get('config_template').'/stylesheet/jquery.selectBox.css');
			$this->document->addStyle('catalog/view/theme/'.$this->config->get('config_template').'/stylesheet/ion.rangeSlider.css');
			$this->document->addStyle('catalog/view/theme/'.$this->config->get('config_template').'/stylesheet/ion.rangeSlider.skinHTML5.css');

			$data['sales']=true;

			$this->load->model('design/banner');
			$this->load->model("tool/image");
			
			$results = $this->model_design_banner->getBanner(10);
			foreach ($results as $result) 
			{
				if (is_file(DIR_IMAGE . $result['image'])) {
					$data['banner'][] = array(
						'title' => $result['title'],
						'link'  => $result['link'],
						'text'  => $result['text'],
						'image' => 'image/'.$result['image']
					);
				}
			}
			// $data['partners_table']= $this->model_catalog_information->getInformation(13);
		}

		$information_info = $this->model_catalog_information->getInformation($information_id);

		if ($information_info) {
			$this->document->setTitle($information_info['meta_title']);
			$this->document->setDescription($information_info['meta_description']);
			$this->document->setKeywords($information_info['meta_keyword']);

			$data['breadcrumbs'][] = array(
				'text' => $information_info['title'],
				'href' => $this->url->link('information/information', 'information_id=' .  $information_id,'SSL')
			);

			$data['heading_title'] = $information_info['title'];

			$data['button_continue'] = $this->language->get('button_continue');

			$data['description'] = html_entity_decode($information_info['description'], ENT_QUOTES, 'UTF-8');

			$data['continue'] = $this->url->link('common/home','','SSL');

			$data['column_left'] = $this->load->controller('common/column_left');
			$data['column_right'] = $this->load->controller('common/column_right');
			$data['content_top'] = $this->load->controller('common/content_top');
			$data['content_bottom'] = $this->load->controller('common/content_bottom');
			$data['footer'] = $this->load->controller('common/footer');
			$data['header'] = $this->load->controller('common/header');

			if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/information/information.tpl')) {
				$this->response->setOutput($this->load->view($this->config->get('config_template') . '/template/information/information.tpl', $data));
			} else {
				$this->response->setOutput($this->load->view('default/template/information/information.tpl', $data));
			}
		} else {
			$data['breadcrumbs'][] = array(
				'text' => $this->language->get('text_error'),
				'href' => $this->url->link('information/information', 'information_id=' . $information_id,'SSL')
			);

			$this->document->setTitle($this->language->get('text_error'));

			$data['heading_title'] = $this->language->get('text_error');

			$data['text_error'] = $this->language->get('text_error');

			$data['button_continue'] = $this->language->get('button_continue');

			$data['continue'] = $this->url->link('common/home','','SSL');

			$this->response->addHeader($this->request->server['SERVER_PROTOCOL'] . ' 404 Not Found');

			$data['column_left'] = $this->load->controller('common/column_left');
			$data['column_right'] = $this->load->controller('common/column_right');
			$data['content_top'] = $this->load->controller('common/content_top');
			$data['content_bottom'] = $this->load->controller('common/content_bottom');
			$data['footer'] = $this->load->controller('common/footer');
			$data['header'] = $this->load->controller('common/header');

			if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/error/not_found.tpl')) {
				$this->response->setOutput($this->load->view($this->config->get('config_template') . '/template/error/not_found.tpl', $data));
			} else {
				$this->response->setOutput($this->load->view('default/template/error/not_found.tpl', $data));
			}
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