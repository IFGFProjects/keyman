<?php
class ControllerCommonFooter extends Controller {
	public function getModel( $model='blog' ){
		return $this->{"model_pavblog_{$model}"};
	}
	public function index() {
		$this->load->language('common/footer');

		$data['scripts'] = $this->document->getScripts('footer');

		$data['text_information'] = $this->language->get('text_information');
		$data['text_service'] = $this->language->get('text_service');
		$data['text_extra'] = $this->language->get('text_extra');
		$data['text_contact'] = $this->language->get('text_contact');
		$data['text_return'] = $this->language->get('text_return');
		$data['text_sitemap'] = $this->language->get('text_sitemap');
		$data['text_manufacturer'] = $this->language->get('text_manufacturer');
		$data['text_voucher'] = $this->language->get('text_voucher');
		$data['text_affiliate'] = $this->language->get('text_affiliate');
		$data['text_special'] = $this->language->get('text_special');
		$data['text_account'] = $this->language->get('text_account');
		$data['text_order'] = $this->language->get('text_order');
		$data['text_wishlist'] = $this->language->get('text_wishlist');
		$data['text_newsletter'] = $this->language->get('text_newsletter');
		$data['telephone'] = $this->config->get('config_telephone');

		$this->load->model('catalog/information');

		$data['informations'] = array();

		foreach ($this->model_catalog_information->getInformations() as $result) {
			if ($result['bottom']) {
				$data['informations'][] = array(
					'title' => $result['title'],
					'href'  => $this->url->link('information/information', 'information_id=' . $result['information_id'],"SSL")
				);
			}
		}

		$data['top_menu_links']=array(
            "akcii"=>"https://keyman.by/promotions",
			//"akcii"=>$this->url->link("information/information","information_id=20","SSL"),
			"news"=>$this->url->link('newsblog/category', 'newsblog_path=1','SSL'),
			"blog"=>$this->url->link("pavblog/category","id=1","SSL"),
			"skidki"=>$this->url->link("information/information","information_id=8","SSL"),
			"podarok"=>$this->url->link("information/information","information_id=11","SSL"),
			"business"=>$this->url->link("information/information","information_id=9","SSL"),
			"about"=>$this->url->link("information/information","information_id=12","SSL"),
			"shops"=>$this->url->link("information/information","information_id=23","SSL"),
			"special"=>$this->url->link('product/special','','SSL'),
			"faq"=>$this->url->link('module/faq','','SSL')
		);
	
		$data['internal_menu_links']=array(
			"otzyvy"=>$this->url->link("information/reviews",'',"SSL"),
			"komanda"=>$this->url->link("information/information","information_id=10","SSL"),
			"vacancies"=>$this->url->link("information/vacancies",'',"SSL")
		);

		$data['contact'] = $this->url->link('information/contact','',"SSL");
		$data['return'] = $this->url->link('account/return/add', '', 'SSL');
		$data['sitemap'] = $this->url->link('information/sitemap','',"SSL");
		$data['manufacturer'] = $this->url->link('product/manufacturer','',"SSL");
		$data['voucher'] = $this->url->link('account/voucher', '', 'SSL');
		$data['affiliate'] = $this->url->link('affiliate/account', '', 'SSL');
		$data['special'] = $this->url->link('product/special','',"SSL");
		$data['account'] = $this->url->link('account/account', '', 'SSL');
		$data['order'] = $this->url->link('account/order', '', 'SSL');
		$data['wishlist'] = $this->url->link('account/wishlist', '', 'SSL');
		$data['newsletter'] = $this->url->link('account/newsletter', '', 'SSL');

		$data['powered'] = sprintf($this->language->get('text_powered'), $this->config->get('config_name'), date('Y', time()));

		// Whos Online
		if ($this->config->get('config_customer_online')) {
			$this->load->model('tool/online');

			if (isset($this->request->server['REMOTE_ADDR'])) {
				$ip = $this->request->server['REMOTE_ADDR'];
			} else {
				$ip = '';
			}

			if (isset($this->request->server['HTTP_HOST']) && isset($this->request->server['REQUEST_URI'])) {
				$url = 'http://' . $this->request->server['HTTP_HOST'] . $this->request->server['REQUEST_URI'];
			} else {
				$url = '';
			}

			if (isset($this->request->server['HTTP_REFERER'])) {
				$referer = $this->request->server['HTTP_REFERER'];
			} else {
				$referer = '';
			}

			$this->model_tool_online->addOnline($ip, $this->customer->getId(), $url, $referer);
		}

		

			$this->load->model('pavblog/category');
			$this->load->model("pavblog/blog");


			$data['cat_art'] = $this->model_pavblog_category->getInfo(27);



			
			$data33 = array(
				'filter_category_id' => '27',
				'sort'               => 'b.created',
				'order'              => 'ASC',
				'start'              => '0',
				'limit'              => '5'
			);

			$blogs = $this->getModel( 'blog' )->getListBlogs($data33 );
			$data['articles_menu'] 		 = array_slice( $blogs,0, 5 );

			$this->load->model("tool/image");

			foreach ($data['articles_menu'] as $key => $result) {
				$data['articles_menu'][$key] = array(
					'title' =>  $result['title'],
					'category_id' =>  $result['category_id'],
					'blog_id' =>  $result['blog_id'],
					'keyword' =>  $this->url->link( 'pavblog/blog','id='.$result['blog_id'] ,'SSL'),
					'image' => $this->model_tool_image->resize($result['image'], 400, 400)
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
						'category_id'     => $child['category_id'],
						'name'  => $child['name'] /*. ($this->config->get('config_product_count') ? ' (' . $this->model_catalog_product->getTotalProducts($filter_data) . ')' : '')*/,
						'href'  => $this->url->link('product/category', 'path=' . $category['category_id'] . '_' . $child['category_id'],"SSL"),
						'image' => 'image/' .$child['image']
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
		$data['footer_modal']=str_replace("\n", "<br>", $this->config->get("config_comment"));//$this->model_catalog_information->getInformation(7);

		$data['login_modal']=$this->load->controller('account/login/modal');
		
		if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/common/footer.tpl')) {
			return $this->load->view($this->config->get('config_template') . '/template/common/footer.tpl', $data);
		} else {
			return $this->load->view('default/template/common/footer.tpl', $data);
		}
	}
}
