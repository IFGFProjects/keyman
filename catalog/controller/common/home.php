<?php
class ControllerCommonHome extends Controller {
	public function index() {
		$this->document->setTitle($this->config->get('config_meta_title'));
		$this->document->setDescription($this->config->get('config_meta_description'));
		$this->document->setKeywords($this->config->get('config_meta_keyword'));

		if (isset($this->request->get['route'])) {
			$this->document->addLink(HTTP_SERVER, 'canonical');
		}

		$data['column_left'] = $this->load->controller('common/column_left');
		$data['column_right'] = $this->load->controller('common/column_right');
		$data['content_top'] = $this->load->controller('common/content_top');
		$data['content_bottom'] = $this->load->controller('common/content_bottom');
		$data['footer'] = $this->load->controller('common/footer');
		$data['header'] = $this->load->controller('common/header');
$data['article_main'] = $this->model_catalog_information->getInformation(25); // Вытаскиваем статью id=25
		$data['blog_link']=$this->url->link('pavblog/category', 'id=1',"SSL");
		$data['sales_link']=$this->url->link('information/information', 'information_id=8',"SSL");
		$data['reviews_link']=$this->url->link('information/reviews','',"SSL");



		$data['slider'] = $this->load->controller('module/slideshow',['banner_id'=>9]);
		$this->load->model('catalog/information');
		$data['left_video']= $this->model_catalog_information->getInformation(14);
		$data['right_video']= $this->model_catalog_information->getInformation(15);

		$this->load->model('design/banner');
		$this->load->model('tool/image');

		$data['sale_data']= $this->model_design_banner->getBanner(12);
		$data['sale_data']=$data['sale_data'][0];
		// $data['sale_data']['image']=$this->model_tool_image->orig($data['sale_data']['image']);
		$data['sale_data']['image']='image/' .$data['sale_data']['image'];// $this->model_tool_image->orig($data['sale_data']['image'],100);


		$data['partners'] = array();

		$results = $this->model_design_banner->getBanner(10);

		foreach ($results as $result) {
			if (is_file(DIR_IMAGE . $result['image'])) {
				$data['partners'][] = array(
					'title' => $result['title'],
					'link'  => $result['link'],
					// 'image' => $this->model_tool_image->resize($result['image'],250,125)
					'image' => 'image/'.$result['image']
				);
			}
		}

		$this->load->model("pavblog/blog");
		$latest_news=$this->model_pavblog_blog->getAllBlogs(array("start"=>0,"limit"=>2,"sort"=>"b.date","order"=>"DESC"));
		foreach ($latest_news as $key => $new) 
		{
			$data['latest_news'][]=array(
				"date"=>$new['date_modified'],
				"title"=>$new['title'],
				"description"=>htmlspecialchars_decode($new['description']),
				"image"=>$this->model_tool_image->resize($new['image'],800,500),
				"href"=>$this->url->link("pavblog/blog","id=".$new['blog_id'],"SSL")

			);
		}



		$this->load->model("catalog/category");
		$categories = $this->model_catalog_category->getCategories(0);
		foreach ($categories as $category) {
			if ($category['top']) {
				// Level 2
				$children_data = array();

				$children = $this->model_catalog_category->getCategories($category['category_id']);

				foreach ($children as $child) {
					$filter_data = array(
						'filter_category_id'  => $child['category_id'],
						'filter_sub_category' => true
					);
					// echo "<h1 style='color:red;'>child :</h1><pre>";print_r($child);echo "</pre><hr>";

					$children_data[$child['category_id']] = array(
						'name'  => $child['name'] /*. ($this->config->get('config_product_count') ? ' (' . $this->model_catalog_product->getTotalProducts($filter_data) . ')' : '')*/,
						'href'  => $this->url->link('product/category', 'path=' . $category['category_id'] . '_' . $child['category_id'],"SSL"),
						'image' => $this->model_tool_image->resize($child['image'],792,870),
						'top'	=> $child['top']
					);
				}

				// Level 1
				$data['categories'][$category['category_id']] = array(
					'name'     => $category['name'],
					'children' => $children_data,
					'column'   => $category['column'] ? $category['column'] : 1,
					'href'     => $this->url->link('product/category', 'path=' . $category['category_id'],"SSL")
				);
			}
		}

		$data['news_subs_link']=$this->url->link('account/register', 'news_subs=3',"SSL");


		if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/common/home.tpl')) {
			$this->response->setOutput($this->load->view($this->config->get('config_template') . '/template/common/home.tpl', $data));
		} else {
			$this->response->setOutput($this->load->view('default/template/common/home.tpl', $data));
		}
	}
}