<?php
class ControllerCommonHeader extends Controller {
	public function getModel( $model='blog' ){
		return $this->{"model_pavblog_{$model}"};
	}



	public function index() {
		// Analytics
		$this->load->model('extension/extension');
		$this->load->model('tool/image');
		$this->load->model('module/haltmeta');

		$this->document->addScript('https://ulogin.ru/js/ulogin.js');
		$this->document->addScript('catalog/view/javascript/ulogin.js');
		$this->document->addStyle('catalog/view/theme/'.$this->config->get('config_template').'/stylesheet/ulogin.css');
		$this->document->addStyle('https://ulogin.ru/css/providers.css');

		$data['top_menu_links']=array(
			//"akcii"=>"#",
			"akcii"=>"https://keyman.by/promotions",
			"blog"=>$this->url->link("pavblog/category","id=1","SSL"),
			"skidki"=>$this->url->link("information/information","information_id=8","SSL"),
			"podarok"=>$this->url->link("information/information","information_id=11","SSL"),
			"business"=>$this->url->link("information/information","information_id=9","SSL"),
			"about"=>$this->url->link("information/information","information_id=12","SSL"),
			"shops"=>$this->url->link("information/information","information_id=23","SSL"),
			"reviews"=>$this->url->link('information/reviews','','SSL'),
			"special"=>$this->url->link('product/special','','SSL'),
			"team"=>$this->url->link('information/information',"information_id=10",'SSL'),
			"vacancies"=>$this->url->link('information/vacancies','','SSL')


		);



		$this->load->model("htagsmgr/tags");
		$menu_tags=$this->model_htagsmgr_tags->getTags(array("status"=>1,"menu_show"=>1,"start"=>0,"limit"=>5));
		foreach ($menu_tags as $tgkey => $tag)
		{
			$data['menu_tags'][]=array(
				"name"=> $tag['name'],
				"href"=> $this->url->link('product/category','path=' . $tag['category_id']."&tag=".$tag['name'],'SSL')
			);
		}

		$data['cart_link']=$this->url->link("checkout/cart","","SSL");

		$data['analytics'] = array();

		$analytics = $this->model_extension_extension->getExtensions('analytics');

		foreach ($analytics as $analytic) {
			if ($this->config->get($analytic['code'] . '_status')) {
				$data['analytics'][] = $this->load->controller('analytics/' . $analytic['code']);
			}
		}

		$data['analytics'][]=$this->model_module_haltmeta->addTags();

		if ($this->request->server['HTTPS']) {
			$server = $this->config->get('config_ssl');
		} else {
			$server = $this->config->get('config_url');
		}
		$data['home_link']=$server;

		if (is_file(DIR_IMAGE . $this->config->get('config_icon'))) {
			$this->document->addLink($server . 'image/' . $this->config->get('config_icon'), 'icon');
		}

		$data['route']="";
		if (isset($this->request->get['route']))
			{$data['route']=$this->request->get['route'];}
		if (isset($this->request->get['route']))
		{
			$cr=explode("/", $this->request->get['route']);
			$data['controller']=$cr[0];
		} else {$data['controller']="common";}
		
		// $data['title'] = $this->document->getTitle();
		$data['title'] = $this->model_module_haltmeta->getTitle();

		$data['base'] = $server;
		$data['description'] = $this->model_module_haltmeta->getDescription();
		$data['keywords'] = $this->model_module_haltmeta->getKeywords();
		$data['links'] = $this->document->getLinks();
		$data['styles'] = $this->document->getStyles();
		$data['scripts'] = $this->document->getScripts();
		$data['lang'] = $this->language->get('code');
		$data['direction'] = $this->language->get('direction');

		$data['name'] = $this->config->get('config_name');

		if (is_file(DIR_IMAGE . $this->config->get('config_logo'))) {
			$data['logo'] = $server . 'image/' . $this->config->get('config_logo');
		} else {
			$data['logo'] = '';
		}

		$this->load->language('common/header');

		$data['text_home'] = $this->language->get('text_home');

		// Wishlist
		if ($this->customer->isLogged()) {
			$this->load->model('account/wishlist');

			$data['text_wishlist'] = sprintf($this->language->get('text_wishlist'), $this->model_account_wishlist->getTotalWishlist());
		} else {
			$data['text_wishlist'] = sprintf($this->language->get('text_wishlist'), (isset($this->session->data['wishlist']) ? count($this->session->data['wishlist']) : 0));
		}

		$data['text_shopping_cart'] = $this->language->get('text_shopping_cart');
		$data['text_logged'] = sprintf($this->language->get('text_logged'), $this->url->link('account/account', '', 'SSL'), $this->customer->getFirstName(), $this->url->link('account/logout', '', 'SSL'));

		$data['text_account'] = $this->language->get('text_account');
		$data['text_register'] = $this->language->get('text_register');
		$data['text_login'] = $this->language->get('text_login');
		$data['text_order'] = $this->language->get('text_order');
		$data['text_transaction'] = $this->language->get('text_transaction');
		$data['text_download'] = $this->language->get('text_download');
		$data['text_logout'] = $this->language->get('text_logout');
		$data['text_checkout'] = $this->language->get('text_checkout');
		$data['text_category'] = $this->language->get('text_category');
		$data['text_all'] = $this->language->get('text_all');

		$data['home'] = $this->url->link('common/home','',"SSL");
		$data['wishlist'] = $this->url->link('account/wishlist', '', 'SSL');
		$data['logged'] = $this->customer->isLogged();
		$data['account'] = $this->url->link('account/account', '', 'SSL');
		$data['register'] = $this->url->link('account/register', '', 'SSL');
		$data['login'] = $this->url->link('account/login', '', 'SSL');
		$data['order'] = $this->url->link('account/order', '', 'SSL');
		$data['transaction'] = $this->url->link('account/transaction', '', 'SSL');
		$data['download'] = $this->url->link('account/download', '', 'SSL');
		$data['logout'] = $this->url->link('account/logout', '', 'SSL');
		$data['shopping_cart'] = $this->url->link('checkout/cart','',"SSL");
		$data['checkout'] = $this->url->link('checkout/checkout', '', 'SSL');
		$data['contact'] = $this->url->link('information/contact','',"SSL");
		$data['telephone'] = $this->config->get('config_telephone');
		$status = true;





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

				foreach ($data['articles_menu'] as $key => $result) {
					$data['articles_menu'][$key] = array(
				'title' =>  $result['title'],
				'category_id' =>  $result['category_id'],
				'blog_id' =>  $result['blog_id'],
				'keyword' =>  $this->url->link( 'pavblog/blog','id='.$result['blog_id'] ,'SSL'),
				'image' => $this->model_tool_image->resize($result['image'], 400, 400)
			);
		}















		$mobile_agent_array = array('android', 'pocket', 'palm', 'windows ce', 'windowsce', 'cellphone', 'opera mobi', 'ipod', 'small', 'sharp', 'sonyericsson', 'symbian', 'opera mini', 'nokia', 'htc_', 'samsung', 'motorola', 'smartphone', 'blackberry', 'playstation portable', 'tablet browser');
		$ios_agent = array('ipad', 'iphone', 'mac os', 'macintosh');
		$agent = strtolower($_SERVER['HTTP_USER_AGENT']);

		foreach($mobile_agent_array as $value) {    
	        if (strpos($agent, $value) !== false){
	        	$is_mobile = true;
	        	break;
		    }
	    }
	    if(!isset($is_mobile)){
	    	foreach ($ios_agent as $value) {
	    		if (strpos($agent, $value) !== false){
		        	$is_ios = true;
		        	break;
			    }
	    	}
	    	$is_mobile = false;
		}

		if($is_mobile){
			$data['viber_link'] = 'viber://chat?number='.str_replace(array(' ', '+', '(', ')'), '', $this->config->get('config_telephone'));
		}else if(isset($is_ios) && $is_ios){
			$data['viber_link'] = 'viber://add?number='.str_replace(array(' ', '+', '(', ')'), '', $this->config->get('config_telephone'));
		}else{
			$data['viber_link'] = 'viber://chat?number='.str_replace(array(' ', '(', ')'), '', $this->config->get('config_telephone'));
		}


		if (isset($this->request->server['HTTP_USER_AGENT'])) {
			$robots = explode("\n", str_replace(array("\r\n", "\r"), "\n", trim($this->config->get('config_robots'))));

			foreach ($robots as $robot) {
				if ($robot && strpos($this->request->server['HTTP_USER_AGENT'], trim($robot)) !== false) {
					$status = false;

					break;
				}
			}
		}

		// Menu
		$this->load->model('catalog/category');

		$this->load->model('catalog/product');

		$data['categories'] = array();

		$categories = $this->model_catalog_category->getCategories(0);

		foreach ($categories as $category) {
			if ($category['top']) {
				// Level 2
				$children_data = array();

				$children = $this->model_catalog_category->getCategories($category['category_id']);
				// echo "<!-- <h1 style='color:red;'>ACCEPT :</h1><pre>";print_r($children);echo "</pre><hr> -->";
				foreach ($children as $child) {
					$filter_data = array(
						'filter_category_id'  => $child['category_id'],
						'filter_sub_category' => true
					);
					// Level 3
					$children_l3 = $this->model_catalog_category->getCategories($child['category_id']);
					$children_data_l3 = array();
					foreach ($children_l3 as $child_l3) 
					{
						$filter_data_l3 = array(
							'filter_category_id'  => $child_l3['category_id'],
							'filter_sub_category' => true
						);
						// $tst=array(
						// 	'image' =>$this->model_tool_image->resize($child_l3['image'],$this->model_tool_image->property_recount_width($child_l3['image'],0.4),$this->model_tool_image->property_recount_height($child_l3['image'],0.4)),
						// 	'image_mobile' =>$this->model_tool_image->resize($child_l3['image_mobile'],$this->model_tool_image->property_recount_width($child['image_mobile'],0.4),$this->model_tool_image->property_recount_height($child['image_mobile'],0.4))
						// 	);
						$children_data_l3[] = array(
							'name'  => $child_l3['name'] . ($this->config->get('config_product_count') ? ' (' . $this->model_catalog_product->getTotalProducts($filter_data_l3) . ')' : ''),
							'image' =>$this->model_tool_image->resize($child_l3['image'],870,870),
							'image_mobile' =>$this->model_tool_image->resize($child_l3['image_mobile'],540,580),
							'category_id' =>$category['category_id'],
							'href'  => $this->url->link('product/category', 'path=' . $category['category_id'] . '_' . $child_l3['category_id'],"SSL")
						);
					}
					// echo "<h1 style='color:red;'>child :</h1><pre>";print_r($child);echo "</pre><hr>";

					$children_data[] = array(
						'name'  => $child['name'] . ($this->config->get('config_product_count') ? ' (' . $this->model_catalog_product->getTotalProducts($filter_data) . ')' : ''),
						'href'  => $this->url->link('product/category', 'path=' . $category['category_id'] . '_' . $child['category_id'],"SSL"),
						'image' =>$this->model_tool_image->resize($child['image'],870,870),
						'image_mobile' =>$this->model_tool_image->resize($child['image_mobile'],540,580),
						'category_id' =>$child['category_id'],
						'children' => $children_data_l3
					);
				}

				// Level 1
				$data['categories'][$category['category_id']] = array(
					'name'     => $category['name'],
					'children' => $children_data,
					'column'   => $category['column'] ? $category['column'] : 1,
					'image' =>$this->model_tool_image->resize($category['image'],870,870),
					'image_mobile' =>$this->model_tool_image->resize($category['image_mobile'],580,580),
					'href'     => $this->url->link('product/category', 'path=' . $category['category_id'],"SSL")
				);
			}
		}

		$data['language'] = $this->load->controller('common/language');
		$data['currency'] = $this->load->controller('common/currency');
		$data['search'] = $this->load->controller('common/search');
		$data['cart'] = $this->load->controller('common/cart');
		// $data['login_modal']=$this->load->controller('account/login/modal');

		// For page specific css
		if (isset($this->request->get['route'])) {
			if (isset($this->request->get['product_id'])) {
				$class = '-' . $this->request->get['product_id'];
			} elseif (isset($this->request->get['path'])) {
				$class = '-' . $this->request->get['path'];
			} elseif (isset($this->request->get['manufacturer_id'])) {
				$class = '-' . $this->request->get['manufacturer_id'];
			} else {
				$class = '';
			}

			$data['class'] = str_replace('/', '-', $this->request->get['route']) . $class;
		} else {
			$data['class'] = 'common-home';
		}

		$data['search_link']=$this->url->link("product/search",'',"SSL");

		if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/common/header.tpl')) {
			return $this->load->view($this->config->get('config_template') . '/template/common/header.tpl', $data);
		} else {
			return $this->load->view('default/template/common/header.tpl', $data);
		}
	}
}
