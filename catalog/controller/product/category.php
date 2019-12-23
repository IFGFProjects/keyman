<?php
class ControllerProductCategory extends Controller {
	public function index() {

		$this->load->language('product/category');

		$this->load->model('catalog/category');

		$this->load->model('catalog/product');

		$this->load->model('tool/image');


		$this->load->model("module/h_custom_variables");

		if (isset($this->request->get['filter'])) {
			$filter = $this->request->get['filter'];
		} else {
			$filter = '';
		}

		if (isset($this->request->get['sort'])) {
			$sort = $this->request->get['sort'];
		} else {
			$sort = 'p.sort_order';
		}

		if (isset($this->request->get['order'])) {
			$order = $this->request->get['order'];
		} else {
			$order = 'ASC';
		}

		if (isset($this->request->get['in_stock'])) {
			$in_stock = $this->request->get['in_stock'];
		} else if (isset($this->request->post['in_stock'])) {
			$in_stock = $this->request->post['in_stock'];
		} else{
			$in_stock = '';
		}


		if (isset($this->request->get['page'])) {
			$page = $this->request->get['page'];
		} else {
			$page = 1;
		}

		if (isset($this->request->get['limit'])) {
			$limit = (int)$this->request->get['limit'];
		} else {
			$limit = $this->config->get('config_product_limit');
		}

		$data['breadcrumbs'] = array();

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_home'),
			'href' => $this->url->link('common/home',"",'SSL')
		);



		if (isset($this->request->get['path'])) {
			$url = '';

			if (isset($this->request->get['sort'])) {
				$url .= '&sort=' . $this->request->get['sort'];
			}

			if (isset($this->request->get['order'])) {
				$url .= '&order=' . $this->request->get['order'];
			}

			if (isset($this->request->get['limit'])) {
				$url .= '&limit=' . $this->request->get['limit'];
			}

			$path = '';

			$parts = explode('_', (string)$this->request->get['path']);

			$category_id = (int)array_pop($parts);

			$url_no_tag=$url;

			// foreach ($parts as $path_id) {
			// 	if (!$path) {
			// 		$path = (int)$path_id;
			// 	} else {
			// 		$path .= '_' . (int)$path_id;
			// 	}

			// 	$category_info = $this->model_catalog_category->getCategory($path_id);

			// 	if ($category_info) {
			// 		$data['breadcrumbs'][] = array(
			// 			'text' => $category_info['name'],
			// 			'href' => $this->url->link('product/category', 'path=' . $path . $url)
			// 		);
			// 	}
			// }
		} else {
			$category_id = 0;
		}
		foreach ($this->model_catalog_category->getCategoryTree($category_id) as $category_info) 
		{
			if ($category_info['parent_id']>0)
			{
					$data['breadcrumbs'][] = array(
						'text' => $category_info['name'],
						'href' => $this->url->link('product/category', 'path='.$root_cat.$category_info['category_id'] . $url,'SSL')
					);
				} else {
					$root_cat=$category_info['category_id']."_";
				}
		}



		// $data['tags']=$this->model_catalog_category->getCategoryTags($category_id);
		$data['this_link']= $this->url->link('product/category', 'path=' . $this->request->get['path'] . $url,'SSL');
		$category_info = $this->model_catalog_category->getCategory($category_id);

		if (isset($this->request->get['tag']))
		{
			$url.="&tag=".$this->request->get['tag'];
		}



		//---------- Hfilter session save/load filters --------
		// if (!isset($this->session->data['hfilter_data'][$category_id]))
		// 	{$this->session->data['hfilter_data'][$category_id]=array();}
		// echo "<h1 style='color:red;'>DATA :</h1><pre>";print_r(count($this->session->data['hfilter_data']));echo "</pre><hr>";

			// if ((isset($this->request->get['limit'])))
			// 	{$this->session->data['hfilter_data'][$category_id]['limit']=$this->request->get['limit'];}
			// elseif (isset($this->session->data['hfilter_data'][$category_id]['limit'])) 
			// 	{$limit=$this->session->data['hfilter_data'][$category_id]['limit'];}

			// if ((isset($this->request->get['page'])) || ($this->request->server['REQUEST_METHOD'] == 'POST') )
			// 	{$this->session->data['hfilter_data'][$category_id]['page']=$page;}
			// elseif (isset($this->session->data['hfilter_data'][$category_id]['page'])) 
			// 	{$page=$this->session->data['hfilter_data'][$category_id]['page'];}

			if ((!empty($in_stock)) || ($this->request->server['REQUEST_METHOD'] == 'POST') )
				{$this->session->data['in_stock']=$in_stock;}
			elseif (isset($this->session->data['in_stock'])) 
				{$this->request->post['in_stock']=$this->session->data['in_stock'];
				$in_stock=$this->session->data['in_stock'];}

			if ((isset($this->request->post['manufacturer_ids'])) && ($this->request->server['REQUEST_METHOD'] == 'POST') )
				{$this->session->data['hfilter_data'][$category_id]['manufacturer_ids']=$this->request->post['manufacturer_ids'];}
			elseif (isset($this->session->data['hfilter_data'][$category_id]['manufacturer_ids'])) 
				{$this->request->post['manufacturer_ids']=$this->session->data['hfilter_data'][$category_id]['manufacturer_ids'];}

			if ((isset($this->request->post['tags'])) && ($this->request->server['REQUEST_METHOD'] == 'POST') )
				{$this->session->data['hfilter_data'][$category_id]['tags']=$this->request->post['tags'];}
			elseif (isset($this->session->data['hfilter_data'][$category_id]['tags'])) 
				{$this->request->post['tags']=$this->session->data['hfilter_data'][$category_id]['tags'];}

			if ((isset($this->request->post['price'])) || ($this->request->server['REQUEST_METHOD'] == 'POST') )
				{$this->session->data['hfilter_data'][$category_id]['price']=$this->request->post['price'];}
			elseif (isset($this->session->data['hfilter_data'][$category_id]['price'])) 
				{$this->request->post['price']=$this->session->data['hfilter_data'][$category_id]['price'];}

			if ((isset($this->request->post['filter_attributes'])) && ($this->request->server['REQUEST_METHOD'] == 'POST') )
				{$this->session->data['hfilter_data'][$category_id]['filter_attributes']=$this->request->post['filter_attributes'];}
			elseif (isset($this->session->data['hfilter_data'][$category_id]['filter_attributes'])) 
				{$this->request->post['filter_attributes']=$this->session->data['hfilter_data'][$category_id]['filter_attributes'];}

		//---------- Hfilters INFO ---------------
			// echo "<h1 style='color:red;'>this->request->post :</h1><pre>";print_r($this->request->post);echo "</pre><hr>";
			// echo "<h1 style='color:red;'>this->session->data['hfilter_data'] :</h1><pre>";print_r($this->session->data['hfilter_data']);echo "</pre><hr>";
		$man_ids=array();
		if (isset($this->request->post['manufacturer_ids']))
			{$man_ids=$this->request->post['manufacturer_ids'];}
		$data['manufacturers']=$this->model_catalog_category->getCategoryManufacturers($category_id,$man_ids);
		$data['options']=$this->model_catalog_category->getCategoryOptions($category_id);

		$data['selected_tags']=array();
		if (isset($this->request->post['tags']))
			{$data['selected_tags']=$this->request->post['tags'];}

		$data['category_prices']=$this->model_catalog_category->getCategoryMinMaxPrice($category_id);
		$data['category_prices']['set_min']=$data['category_prices']['price_min'];
		$data['category_prices']['set_max']=$data['category_prices']['price_max'];
		if (isset($this->request->post['price']))
		if ($this->request->post['price']!="")
		{
			$prs=explode(";", $this->request->post['price']);
			$data['category_prices']['set_min']=$prs[0];
			$data['category_prices']['set_max']=$prs[1];
		}

		$data['selected_attributes']=array();
		if (isset($this->request->post['filter_attributes']))
		{
			foreach ($this->request->post['filter_attributes'] as $atrkey => $attribute) 
				if ($atrkey>0)
				foreach ($attribute as $atr_val_key => $atr_val)
					{$data['selected_attributes'][$atrkey][$atr_val]=true;}
		}

		$this->load->model("catalog/hfilter");
		
		$data['attributes']=$this->model_catalog_hfilter->GetCategoryAttributes($category_id,"filter");
		// $data['attributes']=$this->model_catalog_hfilter->GetCategoryAttributes(str_replace("_", ",", $this->request->get['path']),"filter");



		$this->document->addStyle('catalog/view/theme/'.$this->config->get('config_template').'/stylesheet/ion.rangeSlider.css');
		$this->document->addScript('catalog/view/theme/'.$this->config->get('config_template').'/js/ion.rangeSlider.min.js');
		$this->document->addScript('catalog/view/theme/'.$this->config->get('config_template').'/js/ajaxes.js');

		if ($category_info) {

			if ($page>1)
			{
				$category_info['meta_title'].=" | Страница ".(int)$page;
				$category_info['meta_description'].=" | Страница ".(int)$page;
				$category_info['description']="";
			}
			
			$this->document->setTitle($category_info['meta_title']);
			$this->document->setDescription($category_info['meta_description']);
			$this->document->setKeywords($category_info['meta_keyword']);


			$data['heading_title'] = $category_info['name'];
			$data['description'] = $category_info['description'];

			$data['text_refine'] = $this->language->get('text_refine');
			$data['text_empty'] = $this->language->get('text_empty');
			$data['text_quantity'] = $this->language->get('text_quantity');
			$data['text_manufacturer'] = $this->language->get('text_manufacturer');
			$data['text_model'] = $this->language->get('text_model');
			$data['text_price'] = $this->language->get('text_price');
			$data['text_tax'] = $this->language->get('text_tax');
			$data['text_points'] = $this->language->get('text_points');
			$data['text_compare'] = sprintf($this->language->get('text_compare'), (isset($this->session->data['compare']) ? count($this->session->data['compare']) : 0));
			$data['text_sort'] = $this->language->get('text_sort');
			$data['text_limit'] = $this->language->get('text_limit');

			$data['button_cart'] = $this->language->get('button_cart');
			$data['button_wishlist'] = $this->language->get('button_wishlist');
			$data['button_compare'] = $this->language->get('button_compare');
			$data['button_continue'] = $this->language->get('button_continue');
			$data['button_list'] = $this->language->get('button_list');
			$data['button_grid'] = $this->language->get('button_grid');

			// Set the last category breadcrumb
			// $data['breadcrumbs'][] = array(
			// 	'text' => $category_info['name'],
			// 	'href' => $this->url->link('product/category', 'path=' . $this->request->get['path'])
			// );

			if ($category_info['image']) {
				$data['thumb'] = $this->model_tool_image->resize($category_info['image'], $this->config->get('config_image_category_width'), $this->config->get('config_image_category_height'));
			} else {
				$data['thumb'] = '';
			}

			$data['description'] = html_entity_decode($category_info['description'], ENT_QUOTES, 'UTF-8');
			$data['compare'] = $this->url->link('product/compare','','SSL');

			$url = '';


			if (isset($this->request->get['tag']))
			{
				$url.="&tag=".$this->request->get['tag'];
			}

			if (isset($this->request->get['filter'])) {
				$url .= '&filter=' . $this->request->get['filter'];
			}

			if (isset($this->request->get['sort'])) {
				$url .= '&sort=' . $this->request->get['sort'];
			}

			if (isset($this->request->get['order'])) {
				$url .= '&order=' . $this->request->get['order'];
			}

			if (isset($this->request->get['limit'])) {
				$url .= '&limit=' . $this->request->get['limit'];
			}

			if (isset($this->request->get['in_stock'])) {
				$url .= '&in_stock=' . $this->request->get['in_stock'];
			}

			$data['categories'] = array();

			$results = $this->model_catalog_category->getCategories($category_id);

			foreach ($results as $result) {
				$filter_data = array(
					'filter_category_id'  => $result['category_id'],
					'filter_sub_category' => true
				);

				$data['categories'][] = array(
					'category_id' => $result['category_id'],
					'name' => $result['name'] . ($this->config->get('config_product_count') ? ' (' . $this->model_catalog_product->getTotalProducts($filter_data) . ')' : ''),
					'href' => $this->url->link('product/category', 'path=' . $this->request->get['path'] . '_' . $result['category_id'] . $url,'SSL')
				);
			}

			$data['products'] = array();

			$filter_data = array(
				'filter_category_id' => $category_id,
				'filter_filter'      => $filter,
				'sort'               => $sort,
				'order'              => $order,
				'start'              => ($page - 1) * $limit,
				'limit'              => $limit,
				'in_stock'			 => $in_stock
			);

			$product_total = $this->model_catalog_product->getTotalProducts($filter_data);
			$results = $this->model_catalog_product->getProducts($filter_data);



			$data['hcv_category']=$this->model_module_h_custom_variables->load($category_id);

	



			foreach ($results as $result) {
				if ($result['image']) {
					

					if ( ($data['hcv_category']) && (isset($data['hcv_category']['width_product_category']['value'])) && ($data['hcv_category']['width_product_category']['value']>0) ) {
					$image = $this->model_tool_image->resize($result['image'], trim($data['hcv_category']['width_product_category']['value']), trim($data['hcv_category']['height_product_category']['value']));	
					} else {
					$image = $this->model_tool_image->resize($result['image'], $this->config->get('config_image_category_width'), $this->config->get('config_image_category_height'));
					}

					
				} else {
					$image = $this->model_tool_image->resize('placeholder.png', $this->config->get('config_image_category_width'), $this->config->get('config_image_category_height'));
				}

				if (($this->config->get('config_customer_price') && $this->customer->isLogged()) || !$this->config->get('config_customer_price')) {
					$price = $this->currency->format($this->tax->calculate($result['price'], $result['tax_class_id'], $this->config->get('config_tax')));
				} else {
					$price = false;
				}

				if ((float)$result['special']) {
					$special = $this->currency->format($this->tax->calculate($result['special'], $result['tax_class_id'], $this->config->get('config_tax')));
				} else {
					$special = false;
				}

				if ($this->config->get('config_tax')) {
					$tax = $this->currency->format((float)$result['special'] ? $result['special'] : $result['price']);
				} else {
					$tax = false;
				}

				if ($this->config->get('config_review_status')) {
					$rating = (int)$result['rating'];
				} else {
					$rating = false;
				}
				
				$data['products'][] = array(
					'product_id'  => $result['product_id'],
					'thumb'       => $image,
					'image'       => $this->model_tool_image->orig($result['image']),
					'name'        => $result['name'],
					'model'        => $result['model'],
					'meta_description'        => $result['meta_description'],
					'description' => utf8_substr(strip_tags(html_entity_decode($result['description'], ENT_QUOTES, 'UTF-8')), 0, $this->config->get('config_product_description_length')) . '..',
					'price'       => $price,
					'special'     => $special,
					'price_orig'  => $this->tax->calculate($special? $result['special'] : $result['price'], $result['tax_class_id'], $this->config->get('config_tax')),
					'tax'         => $tax,
					'options'         => $this->model_catalog_product->getProductOptions($result['product_id']),
					'minimum'     => $result['minimum'] > 0 ? $result['minimum'] : 1,
					'rating'      => $result['rating'],
					'href'        => $this->url->link('product/product', 'path=' . $this->request->get['path'] . '&product_id=' . $result['product_id'] . $url,'SSL')
				);
			}

			$url = '';


			if (isset($this->request->get['tag']))
			{
				$url.="&tag=".$this->request->get['tag'];
			}

			if (isset($this->request->get['filter'])) {
				$url .= '&filter=' . $this->request->get['filter'];
			}

			if (isset($this->request->get['limit'])) {
				$url .= '&limit=' . $this->request->get['limit'];
			}

			$data['sorts'] = array();

			$data['sorts'][] = array(
				'text'  => $this->language->get('text_default'),
				'value' => 'p.sort_order-ASC',
				'href'  => $this->url->link('product/category', 'path=' . $this->request->get['path'] . '&sort=p.sort_order&order=ASC' . $url,'SSL')
			);

			$data['sorts'][] = array(
				'text'  => $this->language->get('text_name_asc'),
				'value' => 'pd.name-ASC',
				'href'  => $this->url->link('product/category', 'path=' . $this->request->get['path'] . '&sort=pd.name&order=ASC' . $url,'SSL')
			);

			$data['sorts'][] = array(
				'text'  => $this->language->get('text_name_desc'),
				'value' => 'pd.name-DESC',
				'href'  => $this->url->link('product/category', 'path=' . $this->request->get['path'] . '&sort=pd.name&order=DESC' . $url,'SSL')
			);

			$data['sorts'][] = array(
				'text'  => $this->language->get('text_price_asc'),
				'value' => 'p.price-ASC',
				'href'  => $this->url->link('product/category', 'path=' . $this->request->get['path'] . '&sort=p.price&order=ASC' . $url,'SSL')
			);

			$data['sorts'][] = array(
				'text'  => $this->language->get('text_price_desc'),
				'value' => 'p.price-DESC',
				'href'  => $this->url->link('product/category', 'path=' . $this->request->get['path'] . '&sort=p.price&order=DESC' . $url,'SSL')
			);

			if ($this->config->get('config_review_status')) {
				$data['sorts'][] = array(
					'text'  => $this->language->get('text_rating_desc'),
					'value' => 'rating-DESC',
					'href'  => $this->url->link('product/category', 'path=' . $this->request->get['path'] . '&sort=rating&order=DESC' . $url,'SSL')
				);

				$data['sorts'][] = array(
					'text'  => $this->language->get('text_rating_asc'),
					'value' => 'rating-ASC',
					'href'  => $this->url->link('product/category', 'path=' . $this->request->get['path'] . '&sort=rating&order=ASC' . $url,'SSL')
				);
			}

			$data['sorts'][] = array(
				'text'  => $this->language->get('text_model_asc'),
				'value' => 'p.model-ASC',
				'href'  => $this->url->link('product/category', 'path=' . $this->request->get['path'] . '&sort=p.model&order=ASC' . $url,'SSL')
			);

			$data['sorts'][] = array(
				'text'  => $this->language->get('text_model_desc'),
				'value' => 'p.model-DESC',
				'href'  => $this->url->link('product/category', 'path=' . $this->request->get['path'] . '&sort=p.model&order=DESC' . $url,'SSL')
			);


			$url = '';


			if (isset($this->request->get['tag']))
			{
				$url.="&tag=".$this->request->get['tag'];
			}

			if (isset($this->request->get['filter'])) {
				$url .= '&filter=' . $this->request->get['filter'];
			}

			if (isset($this->request->get['in_stock'])) {
				$url .= '&in_stock=' . $this->request->get['in_stock'];
			}

			if (isset($this->request->get['sort'])) {
				$url .= '&sort=' . $this->request->get['sort'];
			}

			if (isset($this->request->get['order'])) {
				$url .= '&order=' . $this->request->get['order'];
			}

			$data['limits'] = array();

			$limits = array_unique(array($this->config->get('config_product_limit'), 25, 50, 75, 100));

			sort($limits);

			foreach($limits as $value) {
				$data['limits'][] = array(
					'text'  => $value,
					'value' => $value,
					'href'  => $this->url->link('product/category', 'path=' . $this->request->get['path'].$url . '&limit=' . $value,'SSL')
				);
			}

			$url = '';

			if (isset($this->request->get['filter'])) {
				$url .= '&filter=' . $this->request->get['filter'];
			}

			if (isset($this->request->get['tag']))
			{
				$url.="&tag=".$this->request->get['tag'];
			}

			if (isset($this->request->get['sort'])) {
				$url .= '&sort=' . $this->request->get['sort'];
			}

			if (isset($this->request->get['order'])) {
				$url .= '&order=' . $this->request->get['order'];
			}

			if (isset($this->request->get['in_stock'])) {
				$url .= '&in_stock=' . $this->request->get['in_stock'];
			}

			if (isset($this->request->get['limit'])) {
				$url .= '&limit=' . $this->request->get['limit'];
			}

			$pagination = new Pagination();
			$pagination->total = $product_total;
			$pagination->page = $page;
			$pagination->limit = $limit;
			$pagination->url = $this->url->link('product/category', 'path=' . $this->request->get['path']  . $url . '&page={page}','SSL');

			$data['pagination'] = $pagination->render();

			$data['results'] = sprintf($this->language->get('text_pagination'), ($product_total) ? (($page - 1) * $limit) + 1 : 0, ((($page - 1) * $limit) > ($product_total - $limit)) ? $product_total : ((($page - 1) * $limit) + $limit), $product_total, ceil($product_total / $limit));

			// http://googlewebmastercentral.blogspot.com/2011/09/pagination-with-relnext-and-relprev.html
			if ($page == 1) {
				if (!isset($this->request->get['tag']))
			    $this->document->addLink($this->url->link('product/category', 'path=' . $category_info['category_id'], 'SSL'), 'canonical');
			} elseif ($page == 2) {
			    $this->document->addLink($this->url->link('product/category', 'path=' . $category_info['category_id'], 'SSL'), 'prev');
			    // $this->document->addLink($this->url->link('product/category', 'path=' . $category_info['category_id'], 'SSL'), 'canonical');
			} else {
			    $this->document->addLink($this->url->link('product/category', 'path=' . $category_info['category_id'] . '&page='. ($page - 1), 'SSL'), 'prev');
			    // $this->document->addLink($this->url->link('product/category', 'path=' . $category_info['category_id'], 'SSL'), 'canonical');
			}

			if ($limit && ceil($product_total / $limit) > $page) {
			    $this->document->addLink($this->url->link('product/category', 'path=' . $category_info['category_id'] . '&page='. ($page + 1), 'SSL'), 'next');
			}

			$data['sort'] = $sort;
			$data['order'] = $order;
			$data['limit'] = $limit;
			$data['in_stock'] = $in_stock;

			$data['continue'] = $this->url->link('common/home');

			$data['column_left'] = $this->load->controller('common/column_left');
			$data['column_right'] = $this->load->controller('common/column_right');
			$data['content_top'] = $this->load->controller('common/content_top');
			$data['content_bottom'] = $this->load->controller('common/content_bottom');
			$data['footer'] = $this->load->controller('common/footer');
			$data['header'] = $this->load->controller('common/header');
			$data['fast_order_href']=$this->url->link('product/fastorder/sender','','SSL');
			$data['url']=$this->url->link('product/category','path=' . $this->request->get['path'],'SSL').$url;
			$data['category_url']=$this->url->link('product/category','path=' . $this->request->get['path'].$url_no_tag,'SSL');

			$data['tags']=$this->model_catalog_category->getCategoryTags($category_id,$this->request->get['path']);
			if  (isset($this->request->get['tag']))
			{
				$data['selected_tags'][$this->request->get['tag']]=true;
				$data['url']=$this->url->link('product/category','path=' . $this->request->get['path']."&tag=".$this->request->get['tag'],'SSL').$url;
			}

			if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/product/category.tpl')) {
				$this->response->setOutput($this->load->view($this->config->get('config_template') . '/template/product/category.tpl', $data));
			} else {
				$this->response->setOutput($this->load->view('default/template/product/category.tpl', $data));
			}
		} else {
			$url = '';

			if (isset($this->request->get['path'])) {
				$url .= '&path=' . $this->request->get['path'];
			}


			if (isset($this->request->get['tag']))
			{
				$url.="&tag=".$this->request->get['tag'];
			}

			if (isset($this->request->get['filter'])) {
				$url .= '&filter=' . $this->request->get['filter'];
			}

			if (isset($this->request->get['sort'])) {
				$url .= '&sort=' . $this->request->get['sort'];
			}

			if (isset($this->request->get['order'])) {
				$url .= '&order=' . $this->request->get['order'];
			}

			if (isset($this->request->get['in_stock'])) {
				$url .= '&in_stock=' . $this->request->get['in_stock'];
			}

			if (isset($this->request->get['page'])) {
				$url .= '&page=' . $this->request->get['page'];
			}

			if (isset($this->request->get['limit'])) {
				$url .= '&limit=' . $this->request->get['limit'];
			}

			$data['breadcrumbs'][] = array(
				'text' => $this->language->get('text_error'),
				'href' => $this->url->link('product/category', $url,'SSL')
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

			$data['fast_order_href']=$this->url->link('product/fastorder/sender','','SSL');
			$data['url']=$url;
			

			if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/error/not_found.tpl')) {
				$this->response->setOutput($this->load->view($this->config->get('config_template') . '/template/error/not_found.tpl', $data));
			} else {
				$this->response->setOutput($this->load->view('default/template/error/not_found.tpl', $data));
			}
		}
	}
}
