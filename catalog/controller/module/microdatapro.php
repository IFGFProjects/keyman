<?php

require_once(DIR_SYSTEM . 'library/microdatapro.php');

class ControllerModuleMicrodataPro extends Controller {

	protected $data;
	private $mparams = '';
	
	public function index() {
		$a=$b=$c=$d=1;
		$date_install = '2017-02-01';
	  $this->microdatapro = new Microdatapro($this->registry);	


	  if(isset($this->request->get['route']) && !empty($this->request->get['route'])){
		$route = $this->request->get['route'];
	  }else{
		$route = "common/home";
	  }	

	  $this->data['glob_route'] = $route;

	  if($this->microdatapro->opencart_version(0) == 2){
		$this->data['config_list_limit'] = $this->config->get('config_product_limit');
	  }else{
		$this->data['config_list_limit'] = $this->config->get('config_catalog_limit');
	  }

	  $this->data['status'] = $status = $s = $this->config->get('config_microdata_status');
		$this->data['activated'] =$a= 1;

	
		if(($route == "common/home" || $route == "product/product" || $route == "product/category" || $route == "product/manufacturer/info" || $route == "information/information" || $route == "product/special"
			//----- BLOG -----
			|| $route=="pavblog/category" || $route=="pavblog/blog" || $route=="pavblog/blogs"
			//----- HDESC -----
			|| $route=="hdesc/category" || $route=="hdesc/entry"
			//----- ONLY crumbs and organization -----			
			|| $route=="information/shops" || $route=="information/vacancies" || $route=="information/reviews"
			)&&$b)
		{

			if (isset($this->request->server['HTTPS']) && (($this->request->server['HTTPS'] == 'on') || ($this->request->server['HTTPS'] == '1'))) {
				$microdata_server = $this->config->get('config_ssl');
			} else {
				$microdata_server = $this->config->get('config_url');
			}

		//load model & language
			$this->load->model('catalog/product');
			$this->load->model('catalog/review');
			$this->load->model('catalog/category');
			$this->load->model('catalog/manufacturer');
			$this->language->load('product/special');
			
		//pages
			//----- BLOG ----
			$this->data['microdata_route_blog_article']=false;
			if ($route == "pavblog/blog")
				{$this->data['microdata_route_blog_article']=true;}
				
			$this->data['microdata_route_blog_category']=false;
			if ($route == "pavblog/category")
				{$this->data['microdata_route_blog_category']=true;}
				
			$this->data['microdata_route_blog_latest']=false;
			if ($route == "blog/latest")
				{$this->data['microdata_route_blog_latest']=true;}

			//----- HDESC ----
			$this->data['microdata_route_hdesc_article']=false;
			if ($route == "hdesc/entry")
				{$this->data['microdata_route_hdesc_article']=true;}
				
			$this->data['microdata_route_hdesc_category']=false;
			if ($route == "hdesc/category")
				{$this->data['microdata_route_hdesc_category']=true;}

			//----- ONLY crumbs and organization
			// $this->data['microdata_route_light']

			$this->data['microdata_route_product']  	= ($route == "product/product")?true:false;																		
			$this->data['microdata_route_category'] 	= ($route == "product/category")?true:false;
			$this->data['microdata_route_manufacturer'] = ($route == "product/manufacturer/info")?true:false;
			$this->data['microdata_route_information']  = ($route == "information/information")?true:false;
			$this->data['microdata_route_special'] 	    = ($route == "product/special")?true:false;			

		//setting	
			$page_set = explode('/', $route);
			$this->data['config_item_breadcrumb'] = $this->config->get('config_'.$page_set[1].'_breadcrumb');
			$this->data['config_item_syntax']     = $this->config->get('config_'.$page_set[1].'_syntax');			
			
		//config view pages
			$this->data['config_product_page'] 	    	= $this->config->get('config_product_page');
			$this->data['config_category_page'] 	    = $this->config->get('config_category_page');
			$this->data['config_manufacturer_page'] 	= $this->config->get('config_manufacturer_page');
			$this->data['config_special_page'] 	    	= $this->config->get('config_special_page');
			$this->data['config_information_page'] 		= $this->config->get('config_information_page');			
			$this->data['config_company_syntax']     	= $this->config->get('config_company_syntax');
			
		//config view blocks
			$this->data['config_product_related'] 		= $this->config->get('config_product_related');
			$this->data['config_product_reviews'] 		= $this->config->get('config_product_reviews');
			$this->data['config_product_attribute'] 	= $this->config->get('config_product_attribute');
			$this->data['config_company'] 	    		= $this->config->get('config_company');
			
			$this->data['microdata_version'] 	    	= '1';

		//company data
			if($this->microdatapro->opencart_version(0) == 2){
				$this->data['microdata_code'] = $a?$this->session->data['currency']:''; 
			}else{
				$this->data['microdata_code'] = $b?$this->currency->getCode():'';
			}

			$this->data['microdata_base_url']  = $this->data['microdata_url'] = $microdata_server;
			$this->data['microdata_name']      = $this->data['microdata_heading_title'] = $this->config->get('config_name');
			$this->data['microdata_email']     = ($this->config->get('config_microdata_email'))?$this->config->get('config_microdata_email'):$this->config->get('config_email');																								
			$this->data['microdata_logo']      = $this->data['microdata_base_url'] . "image/" . str_replace(' ', '%20', $this->config->get('config_logo'));
			$this->data['microdata_popup']	   = $this->data['microdata_original_image'] = $this->data['microdata_logo'];
			$this->data['microdata_address_1'] = $this->config->get('config_microdata_address_1');
			$this->data['microdata_address_2'] = $this->config->get('config_microdata_address_2');
			$this->data['microdata_address_3'] = $this->config->get('config_microdata_address_3');
			$this->data['company_rating_value'] = $this->getAllRating('value');
			$this->data['company_rating_count'] = $c?$this->getAllRating('count'):'true';
			$this->data['company_show_rating'] = true;
			if(($route == "product/product") or ($route == "product/category")){
				$this->data['company_show_rating'] = false;
			}
			$this->data['company_meta_description'] = $this->data['microdata_description'] = $this->microdatapro->clear($this->config->get('config_meta_description'));
		
		//social groups
			if($this->config->get('config_microdata_groups')){
				$microdata_groups = explode(",", $this->config->get('config_microdata_groups'));
				$microdata_groups = array_map('trim',$microdata_groups);
				$this->data['microdata_groups'] = array_diff($microdata_groups, array(''));
			}else{
				$this->data['microdata_groups'] = false;
			}
			
		//telephones
			if($this->config->get('config_microdata_phones')){
				$microdata_phones = explode(",", $this->config->get('config_microdata_phones'));
				$microdata_phones = array_map('trim',$microdata_phones);
				$this->data['microdata_phones'] = array_diff($microdata_phones, array(''));
			}else{
				$this->data['microdata_phones'] = false;
			}	

		//multistore
			$store_id = false;
			$query_stores = $this->db->query("SELECT * FROM " . DB_PREFIX . "store ORDER BY url");
			foreach ($query_stores->rows as $result){
				if($result['url'] == $microdata_server){
					$store_id = $result['store_id'];
				}
			}
			
			if($store_id){
				$this->data['microdata_email'] 	   = ($this->config->get('config_microdata_email'.$store_id))?$this->config->get('config_microdata_email'.$store_id):$this->data['microdata_email'];
				$this->data['microdata_address_1'] = ($this->config->get('config_microdata_address_1'.$store_id))?$this->config->get('config_microdata_address_1'.$store_id):$this->data['microdata_address_1'];
				$this->data['microdata_address_2'] = ($this->config->get('config_microdata_address_2'.$store_id))?$this->config->get('config_microdata_address_2'.$store_id):$this->data['microdata_address_2'];
				$this->data['microdata_address_3'] = ($this->config->get('config_microdata_address_3'.$store_id))?$this->config->get('config_microdata_address_3'.$store_id):$this->data['microdata_address_3'];
			//social groups for this store
				if($this->config->get('config_microdata_groups'.$store_id)){
					$microdata_groups = explode(",", $this->config->get('config_microdata_groups'.$store_id));
					$microdata_groups = array_map('trim',$microdata_groups);
					$this->data['microdata_groups'] = array_diff($microdata_groups, array(''));
				}
				
			//telephones for this store
				if($this->config->get('config_microdata_phones'.$store_id)){
					$microdata_phones = explode(",", $this->config->get('config_microdata_phones'.$store_id));
					$microdata_phones = array_map('trim',$microdata_phones);
					$this->data['microdata_phones'] = array_diff($microdata_phones, array(''));
				}			
			}
			
		//product
			if($route == "product/product" && isset($this->request->get['product_id']) && $this->request->get['product_id'] != 0 && $a){

				$product_id = $this->request->get['product_id'];
				$this->data['product_info'] = $product_info = $this->microdatapro->clear_array($this->model_catalog_product->getProduct($a?$product_id:0));
				
				if($product_info){
					$this->data['microdata_url'] = $this->url->link('product/product', 'product_id=' . $product_id, 'SSL');

					$this->data['breadcrumbs'] = $this->breadcrumbs('product', $product_info);
					$this->data['microdata_original_image'] = (isset($product_info['image']) and !empty($product_info['image']))?$product_info['image']:$this->config->get('config_logo');
					if($this->microdatapro->opencart_version(0) == 2 && $this->microdatapro->opencart_version(1) >= 2){ //over 2.2
						$ipw = $this->config->get($this->config->get('config_theme') . '_image_popup_width');
						$iph = $this->config->get($this->config->get('config_theme') . '_image_popup_height');				
					}else{
						$ipw = $this->config->get('config_image_product_width');
						$iph = $this->config->get('config_image_product_height');
					}
					$this->data['microdata_popup'] = $this->getImage($this->data['microdata_original_image'], $ipw, $iph);
					$this->data['microdata_manufacturer'] = @$product_info['manufacturer'];
					$this->data['microdata_model'] = @$product_info['model'];
					$this->data['microdata_stock'] = ($this->config->get('config_product_in_stock'))?777:@(int)($product_info['quantity']?$product_info['quantity']:0);
					if($this->config->get('config_in_stock_status_id')){
						$stock_status_id_query = $this->db->query("SELECT stock_status_id FROM `" . DB_PREFIX . "product` WHERE product_id = '" . $product_id . "'");
						if($stock_status_id_query->row['stock_status_id']){
							if($stock_status_id_query->row['stock_status_id'] == $this->config->get('config_in_stock_status_id')){
								$this->data['microdata_stock'] = 777;
							}
						}
					}
					$this->data['microdata_price'] = $c?$this->convert((float)($product_info['special']?$this->tax->calculate($product_info['special'], $product_info['tax_class_id'], $this->config->get('config_tax')):$this->tax->calculate($product_info['price'], $product_info['tax_class_id'], $this->config->get('config_tax'))), $this->config->get('config_currency'), $this->data['microdata_code']):0;

					$this->data['microdata_heading_title'] = $this->microdatapro->clear(@$product_info['name']);
					$this->data['microdata_upc'] = @$this->config->get('config_microdata_upc')?$product_info['upc']:false;
					$this->data['microdata_ean'] = @$this->config->get('config_microdata_ean')?$product_info['ean']:false;
					$this->data['microdata_isbn'] = @$this->config->get('config_microdata_isbn')?$product_info['isbn']:false;
					$this->data['microdata_mpn'] = @$this->config->get('config_microdata_mpn')?$product_info['mpn']:false;
					$this->data['microdata_sku'] = @$this->config->get('config_microdata_sku')?$product_info['sku']:false;
					$strp = strip_tags(html_entity_decode($product_info['description']));
					$this->data['microdata_description'] = @$this->microdatapro->clear(!empty($strp)?$product_info['description']:$this->config->get('config_microdata_product_description'), true);

					$this->data['echo'] = '';
					if(empty($strp) and $d){
						$this->data['echo'] = $this->data['microdata_description'];
					}
					
					$this->data['microdata_reviews'] = array();
					$this->data['microdata_review_total'] = 0;
					if($this->config->get('config_review_status')){
						$this->data['microdata_review_total'] = (int)$this->model_catalog_review->getTotalReviewsByProductId($product_id);
					
						$results = $this->model_catalog_review->getReviewsByProductId($product_id, $a?0:999, $b?9999:0);
						$total_rating = 0;
						foreach ($results as $result) {
							$this->data['microdata_reviews'][] = array(
								'author'     => $result['author']?$this->microdatapro->clear($result['author']):'noname',
								'text'       => $this->microdatapro->clear($result['text']),
								'rating'     => (int)$result['rating'],
								'date_added' => (date("Y-m-d", strtotime($result['date_added'])))?date("Y-m-d", strtotime($result['date_added'])):$date_install
							);
							$total_rating += (int)$result['rating'];
						}
					}

					if($this->data['microdata_review_total']){
						$this->data['microdata_total_rating_value'] = $this->data['microdata_review_total']?round((float)($total_rating/$this->data['microdata_review_total']), 2):false;
					}else{
						$this->data['microdata_total_rating_value'] = 0;
					}

					$results = $this->model_catalog_product->getProductRelated($c?$product_id:0);
					
					$this->data['microdata_products_json'] = $this->products($results, 'json', true);
					$this->data['microdata_products_microdata'] = $this->products($results, 'microdata', true);

					$this->data['microdata_attribute_groups'] = array();
					foreach ($this->model_catalog_product->getProductAttributes($this->request->get['product_id']) as $attribute_group) {
						foreach ($attribute_group['attribute'] as $attribute) {
							$this->data['microdata_attribute_groups'][]['attribute'] = array($this->microdatapro->clear_array($attribute));
						}	
					}
				}
			}  

		//category
			if($route == "product/category" && isset($this->request->get['path']) && $this->request->get['path'] != 0 && $b){
				$this->data['microdata_url'] = $this->url->link('product/category', 'path=' . $this->request->get['path'], 'SSL');			
				
				$this->data['category_info'] = $category_info = $this->category_info();

				$this->data['breadcrumbs'] = $d?$this->breadcrumbs('category'):false;

				$strp = strip_tags(html_entity_decode($category_info['description']));
				$this->data['microdata_description'] = @$this->microdatapro->clear((isset($category_info['description']) and !empty($strp))?$category_info['description']:$this->config->get('config_microdata_category_description'), true);

				$this->data['echo'] = '';
				if(empty($strp)){
					$this->data['echo'] = $this->data['microdata_description'];
				}
				
				$this->data['microdata_heading_title'] = isset($category_info['name'])?$this->microdatapro->clear($category_info['name']):'';
				$this->data['microdata_original_image'] = (isset($category_info['image']) and !empty($category_info['image']))?$category_info['image']:$this->config->get('config_logo');
				if($this->microdatapro->opencart_version(0) == 2 && $this->microdatapro->opencart_version(1) >= 2){ //over 2.2
					$ipw = $this->config->get($this->config->get('config_theme') . '_image_category_width');
					$iph = $this->config->get($this->config->get('config_theme') . '_image_category_height');			
				}else{
					$ipw = $this->config->get('config_image_category_width');
					$iph = $this->config->get('config_image_category_height');
				}		
				$this->data['microdata_popup'] = $this->getImage($this->data['microdata_original_image'], $ipw, $iph);

				$data = array(
					'filter_category_id' => isset($category_info['category_id'])?$category_info['category_id']:0,
					'filter_filter'      => isset($this->request->get['filter'])?$this->request->get['filter']:'', 
					'sort'               => isset($this->request->get['sort'])?$this->request->get['sort']:'p.sort_order',
					'order'              => isset($this->request->get['order'])?$this->request->get['order']:'ASC',
					'start'              => (isset($this->request->get['page'])?$this->request->get['page']:1 - 1) * (isset($this->request->get['limit'])?$this->request->get['limit']:$this->data['config_list_limit']),
					'limit'              => isset($this->request->get['limit'])?$this->request->get['limit']:$this->data['config_list_limit']
				);

				$results = $a?$this->model_catalog_product->getProducts($data):false;
				if(!isset($category_info['category_id'])){
					$results = array();
				}
				$this->data['microdata_products_json'] = $this->products($results);

				$this->data['microdata_products_json_cont'] = $b?count($results):777;
				$this->data['microdata_products_microdata'] = $this->products($results, 'microdata');				
				
				$this->data['min_max'] = $this->min_max($results, isset($category_info['category_id'])?$category_info['category_id']:0, 'category');

				$this->data['hmin_max']=$this->model_catalog_category->getCategoryMinMaxPrice(isset($category_info['category_id'])?$category_info['category_id']:0);
			}

		//manufacturer
			if($route == "product/manufacturer/info" && $a && isset($this->request->get['manufacturer_id']) && $this->request->get['manufacturer_id'] != 0 && $c){
				
				$manufacturer_id = isset($this->request->get['manufacturer_id'])?(int)$this->request->get['manufacturer_id']:0;
			
				$manufacturer_info = $d?$this->microdatapro->clear_array($this->model_catalog_manufacturer->getManufacturer($manufacturer_id)):'error';
			
				$this->data['microdata_heading_title'] = isset($manufacturer_info['name'])?$manufacturer_info['name']:'';
				$this->data['microdata_url'] = $this->url->link('product/manufacturer/info', 'manufacturer_id=' . $this->request->get['manufacturer_id'], 'SSL');			
				$this->data['microdata_original_image'] = (isset($manufacturer_info['image']) and !empty($manufacturer_info['image']))?$manufacturer_info['image']:$this->config->get('config_logo');
				if($this->microdatapro->opencart_version(0) == 2 && $this->microdatapro->opencart_version(1) >= 2){ //over 2.2
					$ipw = $this->config->get($this->config->get('config_theme') . '_image_category_width');
					$iph = $this->config->get($this->config->get('config_theme') . '_image_category_height');			
				}else{
					$ipw = $this->config->get('config_image_category_width');
					$iph = $this->config->get('config_image_category_height');
				}				
				$this->data['microdata_popup'] = $this->getImage($this->data['microdata_original_image'], $ipw, $iph);
				
				$this->data['breadcrumbs'] = $this->breadcrumbs('manufacturer', $manufacturer_info);				
				$strp = strip_tags(html_entity_decode($manufacturer_info['description']));
				if(isset($manufacturer_info['description']) && !empty($strp)){
					$manufacturer_description = @$manufacturer_info['description'];
				}else{
					$manufacturer_description = $this->config->get('config_microdata_manufacturer_description');
				}	
					
				$this->data['microdata_description'] = $a?$this->microdatapro->clear($manufacturer_description, true):'';
				
				$this->data['echo'] = '';
				if(empty($strp)){
					$this->data['echo'] = $this->data['microdata_description'];
				}				
				
				$this->data['microdata_manufacturer_products'] = array();

				$data = array(
					'filter_manufacturer_id' => $manufacturer_id,
					'sort'               => isset($this->request->get['sort'])?$this->request->get['sort']:'p.sort_order',
					'order'              => isset($this->request->get['order'])?$this->request->get['order']:'ASC',
					'start'              => (isset($this->request->get['page'])?$this->request->get['page']:1 - 1) * (isset($this->request->get['limit'])?$this->request->get['limit']:$this->data['config_list_limit']),
					'limit'              => isset($this->request->get['limit'])?$this->request->get['limit']:$this->data['config_list_limit']
				);
					
				$results = $this->model_catalog_product->getProducts($data);

				$this->data['microdata_products_json'] = $this->products($results);
				$this->data['microdata_products_microdata'] = $this->products($results, 'microdata');	
				
				$this->data['min_max'] = $this->min_max($results, $manufacturer_id, 'manufacturer');

				$this->data['hmin_max']=$this->model_catalog_category->getCategoryMinMaxPrice(isset($category_info['category_id'])?$category_info['category_id']:0);
				
			}			
			
		//specials
			if($route == "product/special" && $d){
			
				$this->data['microdata_url'] = $this->url->link('product/special', '', 'SSL');			
				
				$this->data['breadcrumbs'] = $this->breadcrumbs('special');
					
				$this->load->language('product/special');	
				$this->data['microdata_heading_title'] = $this->microdatapro->clear($this->language->get('heading_title'));
				$this->data['microdata_description'] = $this->microdatapro->clear($this->config->get('config_microdata_special_description'));
				$this->data['microdata_image'] = $this->data['microdata_popup'] = $this->data['microdata_original_image'] = $microdata_server.'image/'.str_replace(' ', '%20', $this->config->get('config_logo'));
				$this->data['microdata_special_products'] = array();

				$data = array(
					'sort'  => isset($this->request->get['sort'])?$this->request->get['sort']:'p.sort_order',
					'order' => isset($this->request->get['order'])?$this->request->get['order']:'ASC',
					'start' => (isset($this->request->get['page'])?$this->request->get['page']:1 - 1) * (isset($this->request->get['limit'])?$this->request->get['limit']:$this->data['config_list_limit']),
					'limit' => isset($this->request->get['limit'])?$this->request->get['limit']:$this->data['config_list_limit']
				);
	
				$results = $this->model_catalog_product->getProductSpecials($data);

				$this->data['microdata_products_json'] = $this->products($results);
				$this->data['microdata_products_microdata'] = $this->products($results, 'microdata');	

				$this->data['min_max'] = $this->min_max($results, 0, 'special');

				$this->data['hmin_max']=$this->model_catalog_category->getCategoryMinMaxPrice(isset($category_info['category_id'])?$category_info['category_id']:0);
			}			

		//information 
			if($route == "information/information" && isset($this->request->get['information_id']) && $a){
			
				$information_id = (int)$this->request->get['information_id'];
				
				$this->data['information_info'] = $information_info = $this->microdatapro->clear_array($this->model_catalog_information->getInformation($information_id));
				
				$this->data['microdata_url'] = $this->url->link('information/information', 'information_id=' .  $information_id, 'SSL');			
				
				$this->data['breadcrumbs'] = $this->breadcrumbs('information', $information_info);

				if (isset($information_info['seo_h1']) && !empty($information_info['seo_h1'])) {
					$this->data['microdata_heading_title'] = $this->microdatapro->clear(@$information_info['seo_h1']);
				} elseif(isset($information_info['title']) && !empty($information_info['title'])) {
					$this->data['microdata_heading_title'] = $this->microdatapro->clear(@$information_info['title']);
				}else{
					$this->data['microdata_heading_title'] = '';
				}
				
				$this->data['date_published'] = $date_install;

				$this->data['author'] = $this->config->get('config_name');

				$this->data['microdata_image'] = $this->data['microdata_popup'] = $this->data['microdata_original_image'] = $microdata_server.'image/'.str_replace(' ', '%20', $this->config->get('config_logo'));
				
				$information_image_size_array = @getimagesize(str_replace("https://","http://",$this->data['microdata_image']));
				$this->data['image_width'] = isset($information_image_size_array[0])?$information_image_size_array[0]:'200';
				$this->data['image_height'] = isset($information_image_size_array[1])?$information_image_size_array[1]:'200';

				$this->data['microdata_description'] = @$this->microdatapro->clear(@$information_info['description'], true);
				$this->data['microdata_og_type'] = 'article';
			}				

			if ($route=="information/shops" || $route=="information/vacancies" || $route=="information/reviews")
			{
				$this->data['config_blog_page']=$this->config->get('config_blog_page');
				$this->data['config_item_syntax']="all";
				$this->data['config_item_breadcrumb']=true;
			
				if ($route=="information/shops")
					{$this->data['breadcrumbs'] = $this->breadcrumbs('shops');}
			
				if ($route=="information/vacancies")
					{$this->data['breadcrumbs'] = $this->breadcrumbs('vacancies');}
			
				if ($route=="information/reviews")
					{$this->data['breadcrumbs'] = $this->breadcrumbs('reviews');}

				// echo "<h1 style='color:red;'>DATA :</h1><pre>";print_r($this->data);echo "</pre><hr>";

			}

		//-------- BLOG ARTICLE -----------
			if($route == "pavblog/blog" && isset($this->request->get['id']) && $a){
				$this->data['config_blog_page']=$this->config->get('config_blog_page');
				$this->data['config_item_syntax']="all";
				$this->data['config_item_breadcrumb']=true;

				$this->load->model('pavblog/blog');
				$this->load->model('tool/image');
				$this->request->get['id'] = isset($this->request->get['id'])?$this->request->get['id']:0;
				$blog_id = $this->request->get['id'];
				$article_info= $this->model_pavblog_blog->getInfo( $blog_id );
				
				// $article_info = $this->model_blog_article->getArticle((int)$this->request->get['article_id']);
				$this->data['breadcrumbs'] = $this->breadcrumbs('blog_article', $article_info);

				if (isset($article_info['meta_h1'])) {	
					$this->data['heading_title'] = $article_info['meta_h1'];
					} else {
					$this->data['heading_title'] = $article_info['title'];
					}
				$this->data['microdata_url']=$this->url->link("pavblog/blog","id=".$this->request->get['id'], 'SSL');
				$this->data['microdata_author']=$this->config->get('config_name');
				$this->data['microdata_description'] = @$this->microdatapro->clear(@$article_info['meta_description'], true);
				$this->data['microdata_content'] = @$this->microdatapro->clear(@$article_info['content'], true);
				if ($this->request->server['HTTPS']) {
					$server = $this->config->get('config_ssl');
				} else {
					$server = $this->config->get('config_url');
				}

				// if (is_file(DIR_IMAGE . $this->config->get('config_logo'))) {
				// 	$this->data['microdata_image'] = $server . 'image/' . $this->config->get('config_logo');
				// } else {
				// 	$this->data['microdata_image'] = '';
				// }

				$this->data['microdata_image']=$this->model_tool_image->orig($article_info['image']);

				$this->data['microdata_image_width'] = $this->config->get('config_image_location_width');
				$this->data['microdata_image_height'] = $this->config->get('config_image_location_height');

				$this->data['microdata_name']=$this->config->get('config_name');

				$this->data['date_published']=date("Y-m-d",strtotime($article_info['created']));
				$this->data['date_modified']=date("Y-m-d",strtotime($article_info['date_modified']));

				$this->data['microdata_address_1']=$this->config->get('config_microdata_address_1');
				$this->data['microdata_address_2']=$this->config->get('config_microdata_address_2');
				$this->data['microdata_address_3']=$this->config->get('config_microdata_address_3');

				$this->data['microdata_phones_blog']=$this->config->get('config_telephone');


				$this->load->model('pavblog/category');	
				// $cat_id=explode('_', $this->request->get['blog_category_id']);
				// $cat_id=(int)array_pop($cat_id);
				$cat_id=$article_info['category_id'];
				$category_info=$this->model_pavblog_category->getInfo($cat_id);
				$this->data['articleSection']=$category_info['title'];

				// $this->load->model('blog/review');
				$this->data['microdata_reviews'] = array();
				// $results = $this->model_blog_review->getReviewsByArticleId($this->request->get['article_id']);

				$this->data['reviews_caunt'] = 0;
				$this->data['rating'] = 0;
				      		
				// foreach ($results as $result) {
				//       	$this->data['microdata_reviews'][] = array(
				//       		'author'     => $result['author'],
				// 		'text'       => $result['text'],
				// 		'rating'     => (int)$result['rating'],
				//       		'date_added' => date("Y-m-d", strtotime($result['created']))
				//       	);
				// }

			}

		//------- BLOG CATEGORY -----------------
			if($route == "pavblog/category" && isset($this->request->get['id']) && $a){
				$this->data['config_blog_page']=$this->config->get('config_blog_page');
				if (isset($this->request->get['id'])) {
					$blog_category_id = '';

					$parts = explode('_', (string)$this->request->get['id']);

					$blog_category_id = (int)array_pop($parts);
				} else {
					$blog_category_id = 0;
				}

				$this->load->model('pavblog/category');
				$this->load->model('pavblog/blog');
				$category_info = $this->model_pavblog_category->getInfo($blog_category_id);
				$this->data['breadcrumbs'] = $this->breadcrumbs('blog_category', $category_info);

				if (isset($category_info['meta_h1'])) {
					$this->data['heading_title'] = $category_info['meta_h1'];
				} else {
					$this->data['heading_title'] = $category_info['title'];
				}

				if ($category_info['meta_description']!="")
					{$this->data['category_description']=$category_info['meta_description'];}
				else
					{$this->data['category_description']=mb_substr(strip_tags(html_entity_decode($category_info['description'])),0,$this->config->get('configblog_article_description_length'));}

				if ($this->request->server['HTTPS']) {
					$server = $this->config->get('config_ssl');
				} else {
					$server = $this->config->get('config_url');
				}
				if (is_file(DIR_IMAGE . $this->config->get('config_logo'))) {
					$this->data['microdata_image'] = $server . 'image/' . $this->config->get('config_logo');
				} else {
					$this->data['microdata_image'] = '';
				}

				$this->data['microdata_image_width'] = $this->config->get('config_image_location_width');
				$this->data['microdata_image_height'] = $this->config->get('config_image_location_height');

				$this->data['microdata_name']=$this->config->get('config_name');

				$this->data['category_href'] = $this->url->link('pavblog/category', 'id=' . $blog_category_id, 'SSL');
				$this->data['microdata_author']=$this->config->get('config_name');

				$this->data['microdata_address_1']=$this->config->get('config_microdata_address_1');
				$this->data['microdata_address_2']=$this->config->get('config_microdata_address_2');
				$this->data['microdata_address_3']=$this->config->get('config_microdata_address_3');

				$this->data['microdata_phones_blog']=$this->config->get('config_telephone');

				$mparams = $this->config->get( 'pavblog' );
				$default = $this->model_pavblog_blog->getDefaultConfig();
				
				$mparams = !empty($mparams)?$mparams:array();

				if( $mparams ){
					$mparams =  array_merge( $default,$mparams);
				}else{
					$mparams = $default;
				}
				$config = new Config();
				if( $mparams ){
					foreach( $mparams as $key => $value ){
						$config->set( $key, $value );
					}
				}
				$this->mparams = $config; 
				if( $this->mparams->get('comment_engine') == '' ||  $this->mparams->get('comment_engine') == 'local' ) {
				}else {			
					$this->mparams->set( 'blog_show_comment_counter', 0 );	
					$this->mparams->set( 'cat_show_comment_counter', 0 );	
				}	

				if (isset($this->request->get['filter'])) {
					$filter = $this->request->get['filter'];
				} else {
					$filter = '';
				}

				if (isset($this->request->get['sort'])) {
					$sort = $this->request->get['sort'];
				} else {
					$sort = 'b.created';
				}

				if (isset($this->request->get['order'])) {
					$order = $this->request->get['order'];
				} else {
					$order = 'DESC';
				}
				
				if (isset($this->request->get['page'])) {
					$page = $this->request->get['page'];
				} else { 
					$page = 1;
				}	
									
				if (isset($this->request->get['limit'])) {
					$limit = $this->request->get['limit'];
				} else {
					$limit =  (int)$this->mparams->get( 'cat_limit_leading_blog' ) +  (int)$this->mparams->get( 'cat_limit_secondary_blog' );
				}


				if (isset($this->request->get['year'])) {
					$year = $this->request->get['year'];
				} else {
					$year = false;
				}

				if (isset($this->request->get['month'])) {
					$month = $this->request->get['month'];
				} else {
					$month = false;
				}

				if (isset($this->request->post['blog_search'])) {
					$search_keywords = $this->request->post['blog_search'];
				} else {
					$search_keywords = false;
				}

				if( isset($this->request->get['tag']) ){
					$filter_tag = $this->request->get['tag'];
					$page_tags = true;
				}else {
					$filter_tag = '';
					$page_tags = false;
				}

				$all = $this->language->get('text_all');
				if( isset($this->request->get['tag']) && $this->request->get['tag'] == $all) $filter_tag = '';

				$this->data['articles'] = array();

				// $article_data = array(
				// 	'filter_category_id' => $blog_category_id,
				// 	'filter_blog_category_id' => $blog_category_id,
				// 	'sort'               => $sort,
				// 	'order'              => $order,
				// 	'start'              => ($page - 1) * $limit,
				// 	'limit'              => $limit
				// );

				$article_data = array(
					'filter_category_id' => $blog_category_id,
					'filter_filter'      => $filter,
					'filter_tag'  		 => $filter_tag, 
					'sort'               => $sort,
					'order'              => $order,
					'start'              => ($page - 1) * $limit,
					'limit'              => $limit,
					'year'               => $year,
					'month'              => $month,
					"search"			 => explode(" ", $search_keywords)
				);

				if ($blog_category_id == 1 && $page_tags == true) {
				$results = $this->model_pavblog_blog->getAllBlogs(  $article_data );
				} else {
				$results = $this->model_pavblog_blog->getListBlogs(  $article_data );
				}
				
				// $results = $this->model_pavblog_blog->getArticles($article_data);

				$this->data['configblog_image_article_width']=$this->mparams->get('general_lwidth');
				$this->data['configblog_image_article_height']=$this->mparams->get('general_lheight');
				if (is_array($results))
				foreach ($results as $result) {
					if ($result['image']) {
						$image = $this->model_tool_image->resize($result['image'], $this->mparams->get('general_lwidth'), $this->mparams->get('general_lheight'));
					} else {
						$image = $this->model_tool_image->resize('placeholder.png', $this->mparams->get('general_lwidth'), $this->mparams->get('general_lheight'));
					}

					if ($this->config->get('configblog_review_status')) {
						$rating = (int)$result['rating'];
					} else {
						$rating = false;
					}

					$descr=utf8_substr(strip_tags(html_entity_decode($result['description'], ENT_QUOTES, 'UTF-8')), 0, $this->config->get('configblog_article_description_length')) . '..';

					$this->data['articles'][] = array(
						'date_published' => date("Y-m-d",strtotime($result['created'])),
						'date_modified' => date("Y-m-d",strtotime($result['date_modified'])),
						'article_id'  => $result['blog_id'],
						'thumb'       => $image,
						'name'        => $result['title'],
						'description' => $descr,
						'date_added'  => date($this->language->get('date_format_short'), strtotime($result['created'])),
						'viewed'      => 0,
						'rating'      => 0,
						'href'        => $this->url->link('pavblog/blog', 'id=' .$result['blog_id'], 'SSL')
					);
				}


			}


			//------- BLOG LATEST -----------------
				if($route == "blog/latest" && $a){
					$this->data['config_blog_page']=$this->config->get('config_blog_page');
					$this->data['microdata_route_blog_category']=true;
					$this->data['config_item_breadcrumb']=true;
					$this->data['config_item_syntax']="all";
					$this->load->model('blog/article');

					$this->data['breadcrumbs'] = $this->breadcrumbs('blog_latest');

					$this->data['heading_title'] = $this->config->get('configblog_html_h1');

					$this->data['category_description']=$this->config->get("configblog_meta_description");

					if ($this->request->server['HTTPS']) {
						$server = $this->config->get('config_ssl');
					} else {
						$server = $this->config->get('config_url');
					}
					if (is_file(DIR_IMAGE . $this->config->get('config_logo'))) {
						$this->data['microdata_image'] = $server . 'image/' . $this->config->get('config_logo');
					} else {
						$this->data['microdata_image'] = '';
					}

					$this->data['microdata_image_width'] = $this->config->get('config_image_location_width');
					$this->data['microdata_image_height'] = $this->config->get('config_image_location_height');

					$this->data['microdata_name']=$this->config->get('config_name');

					$this->data['category_href'] = $this->url->link('blog/latest', '', 'SSL');
					$this->data['microdata_author']=$this->config->get('config_name');

					$this->data['microdata_address_1']=$this->config->get('config_microdata_address_1');
					$this->data['microdata_address_2']=$this->config->get('config_microdata_address_2');
					$this->data['microdata_address_3']=$this->config->get('config_microdata_address_3');

					$this->data['microdata_phones_blog']=$this->config->get('config_telephone');

					if (isset($this->request->get['sort'])) {
						$sort = $this->request->get['sort'];
					} else {
						$sort = 'p.date_added';
					}

					if (isset($this->request->get['order'])) {
						$order = $this->request->get['order'];
					} else {
						$order = 'DESC';
					}

					if (isset($this->request->get['page'])) {
						$page = $this->request->get['page'];
					} else {
						$page = 1;
					}

					if (isset($this->request->get['limit'])) {
						$limit = $this->request->get['limit'];
					} else {
						$limit = $this->config->get('configblog_article_limit');
					}

					if (!isset($this->request->get['sort']))
						{$sort = 'p.viewed';}

					$this->data['articles'] = array();

					$article_data = array(
						'sort'               => $sort,
						'order'              => $order,
						'start'              => ($page - 1) * $limit,
						'limit'              => $limit
					);
					
					$results = $this->model_blog_article->getArticles($article_data);

					$this->data['configblog_image_article_width']=$this->config->get('configblog_image_article_width');
					$this->data['configblog_image_article_height']=$this->config->get('configblog_image_article_height');

					foreach ($results as $result) {
						if ($result['image']) {
							$image = $this->model_tool_image->resize($result['image'], $this->config->get('configblog_image_article_width'), $this->config->get('configblog_image_article_height'));
						} else {
							$image = $this->model_tool_image->resize('placeholder.png', $this->config->get('configblog_image_article_width'), $this->config->get('configblog_image_article_height'));
						}

						if ($this->config->get('configblog_review_status')) {
							$rating = (int)$result['rating'];
						} else {
							$rating = false;
						}

						$descr=$result['description_short'];
						if ($descr=="")
							{$descr=utf8_substr(strip_tags(html_entity_decode($result['description'], ENT_QUOTES, 'UTF-8')), 0, $this->config->get('configblog_article_description_length')) . '..';}
						$this->data['articles'][] = array(
							'date_published' => date("Y-m-d",strtotime($result['date_added'])),
							'date_modified' => date("Y-m-d",strtotime($result['date_modified'])),
							'article_id'  => $result['article_id'],
							'thumb'       => $image,
							'name'        => $result['name'],
							'description' => $descr,
							'date_added'  => date($this->language->get('date_format_short'), strtotime($result['date_added'])),
							'viewed'      => 0,
							// 'viewed'      => $result['viewed'],
							'rating'      => 0,
							// 'rating'      => $result['rating'],
							'href'        => $this->url->link('blog/article', 'article_id=' . $result['article_id'], 'SSL')
						);
					}


				}


		//twitter cards and open graph
			$this->data['microdata_twitter_status'] = false;
			$this->data['microdata_opengraph_status'] = false;
			
			if($this->config->get('config_microdata_twitter_account')){
				$this->data['microdata_twitter_status'] = true;
				$this->load->model('tool/image');
				$this->data['microdata_popup_tw'] = $this->model_tool_image->resize(str_replace(' ', '%20', $this->data['microdata_original_image']), 375, 375);
			}	
			
			if($this->config->get('config_microdata_opengraph')){
				$this->data['microdata_opengraph_status'] = true;
				$this->data['microdata_popup'] = str_replace(' ', '%20', $this->data['microdata_popup']);
			}
		
			if(!isset($this->data['microdata_og_type'])){
				$this->data['microdata_og_type'] = 'website';
			}
			
			$this->data['microdata_twitter_account'] = $this->config->get('config_microdata_twitter_account');		
				
			$this->data['microdata_description_shot'] = @$this->microdatapro->clear($this->mbCutString($this->data['microdata_description'], 290)); 
			$this->document->setTc_og($this->tc_og());			
			
			$bebug_info=array('a','b','c','d');
			foreach($bebug_info as $info){
				$this->data[$info] = $$info?$$info:$this->config->get('config_microdata_twitter_account');
			}

			/*vg*/
			$this->data['microdata_url'] = str_replace('http://', 'https://', $this->data['microdata_url']);

			if($this->microdatapro->opencart_version(0) == 2 && $this->microdatapro->opencart_version(1) >= 2){ //over 2.2
				if($this->microdatapro->opencart_version(1) >= 3){ //over 2.3
					return $this->load->view('extension/module/microdatapro/microdatapro', $this->data);
				}else{
					return $this->load->view('module/microdatapro/microdatapro', $this->data);
				}
			}elseif($this->microdatapro->opencart_version(0) == 2 && $this->microdatapro->opencart_version(1) < 2){ //2.0
				if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/module/microdatapro/microdatapro.tpl')) {
					return $this->load->view($this->config->get('config_template') . '/template/module/microdatapro/microdatapro.tpl', $this->data);
				} else {
					return $this->load->view('default/template/module/microdatapro/microdatapro.tpl', $this->data);					
				}
			}else{ //1.X
				if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/module/microdatapro/microdatapro.tpl')) {
					$this->template = $this->config->get('config_template') . '/template/module/microdatapro/microdatapro.tpl';
				} else {
					$this->template = 'default/template/module/microdatapro/microdatapro.tpl';
				}
				return $this->render();
			}
			
		}
	  }	
	

	
	public function getImage($image,$w=375,$h=375){
		if($image && $w && $h){
			$this->load->model('tool/image');
			return $this->model_tool_image->resize($image, $w, $h);		
		}
	}	
	
	public function mbCutString($str, $length, $encoding='UTF-8'){
		if (function_exists('mb_strlen') && (mb_strlen($str, $encoding) <= $length)) {
			return $str;
		}
		if (function_exists('mb_substr')){
			$tmp = mb_substr($str, 0, $length, $encoding);
			return mb_substr($tmp, 0, mb_strripos($tmp, ' ', 0, $encoding), $encoding); 			
		}else{
			return $str;
		}

	}	
	
	public function tc_og($data = array()){
		
		if($this->microdatapro->opencart_version(0) == 2 && $this->microdatapro->opencart_version(1) >= 2){ //over 2.2
			if($this->microdatapro->opencart_version(1) >= 3){ //over 2.3
				return $this->load->view('extension/module/microdatapro/tc_og', $this->data);
			}else{
				return $this->load->view('module/microdatapro/tc_og', $this->data);
			}
		}elseif($this->microdatapro->opencart_version(0) == 2 && $this->microdatapro->opencart_version(1) < 2){ //2.0
			if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/module/microdatapro/tc_og.tpl')) {
				return $this->load->view($this->config->get('config_template') . '/template/module/microdatapro/tc_og.tpl', $this->data);
			} else {
				return $this->load->view('default/template/module/microdatapro/tc_og.tpl', $this->data);					
			}	
		}else{ //1.X
			if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/module/microdatapro/tc_og.tpl')) {
				$this->template = $this->config->get('config_template') . '/template/module/microdatapro/tc_og.tpl';
			} else {
				$this->template = 'default/template/module/microdatapro/tc_og.tpl';
			}
			return $this->render();
		}
	} 	
	
	public function min_max($results = array(0,0), $page_id = false, $page_type = false){

		$this->data['prices'] = array();
	
		if($results){
			foreach ($results as $result) {
				$this->data['prices'][] = $this->convert((float)($result['special']?$this->tax->calculate($result['special'], $result['tax_class_id'], $this->config->get('config_tax')):$this->tax->calculate($result['price'], $result['tax_class_id'], $this->config->get('config_tax'))), $this->config->get('config_currency'), $this->data['microdata_code']);
			}
		}

		//all reviews
		$microdata_category_rating = 0;
		$this->data['microdata_category_rating'] = 0;
		$this->data['microdata_category_rating_count'] = 0;
		
		if($page_type == 'category'){
			$data = array(
				'filter_category_id' => $page_id,
				'filter_filter'      => isset($this->request->get['filter'])?$this->request->get['filter']:'', 
				'sort'               => isset($this->request->get['sort'])?$this->request->get['sort']:'p.sort_order',
				'order'              => isset($this->request->get['order'])?$this->request->get['order']:'ASC',
				'start'              => 0,
				'limit'              => 999999
			);
			$results = $this->model_catalog_product->getProducts($data);
			foreach($results as $result){
				$results_review = $this->model_catalog_review->getReviewsByProductId($result['product_id']);
				foreach ($results_review as $review) {
					$microdata_category_rating += (int)$review['rating'];
					if((int)$review['rating']) $this->data['microdata_category_rating_count']++; 
				}
			}
			$this->data['microdata_category_rating'] = 0;
			if($this->data['microdata_category_rating_count']){
				$this->data['microdata_category_rating'] = (float)($microdata_category_rating/$this->data['microdata_category_rating_count']);
			}

			
			$this->data['hmin_max']=$this->model_catalog_category->getCategoryMinMaxPrice($page_id);
		}

		if($page_type == 'manufacturer'){
			$data = array(
				'filter_manufacturer_id' => $page_id,
				'sort'               => isset($this->request->get['sort'])?$this->request->get['sort']:'p.sort_order',
				'order'              => isset($this->request->get['order'])?$this->request->get['order']:'ASC',
				'start'              => 0,
				'limit'              => 999999
			);
			$results = $this->model_catalog_product->getProducts($data);
			foreach($results as $result){
				$results_review = $this->model_catalog_review->getReviewsByProductId($result['product_id']);
				foreach ($results_review as $review) {
					$microdata_category_rating += (int)$review['rating'];
					if((int)$review['rating']) $this->data['microdata_category_rating_count']++; 
				}
			}
			$this->data['microdata_category_rating'] = 0;
			if($this->data['microdata_category_rating_count']){
				$this->data['microdata_category_rating'] = (float)($microdata_category_rating/$this->data['microdata_category_rating_count']);
			};			
		}

		if($page_type == 'special'){
			$data = array(
				'sort'  => isset($this->request->get['sort'])?$this->request->get['sort']:'p.sort_order',
				'order' => isset($this->request->get['order'])?$this->request->get['order']:'ASC',
				'start' => 0,
				'limit' => 999999
			);
			$results = $this->model_catalog_product->getProductSpecials($data);
			foreach($results as $result){
				$results_review = $this->model_catalog_review->getReviewsByProductId($result['product_id']);
				foreach ($results_review as $review) {
					$microdata_category_rating += (int)$review['rating'];
					if((int)$review['rating']) $this->data['microdata_category_rating_count']++; 
				}
			}
			$this->data['microdata_category_rating'] = 0;
			if($this->data['microdata_category_rating_count']){
				$this->data['microdata_category_rating'] = (float)($microdata_category_rating/$this->data['microdata_category_rating_count']);
			}
		}		
		
		if($page_type and ($this->config->get('config_'.$page_type.'_manual_rating') or $this->config->get('config_'.$page_type.'_manual_count'))){
			if($this->config->get('config_'.$page_type.'_manual_rating')) $this->data['microdata_category_rating'] = trim((float)$this->config->get('config_'.$page_type.'_manual_rating'));
			if($this->config->get('config_'.$page_type.'_manual_count')) $this->data['microdata_category_rating_count'] = trim((int)$this->config->get('config_'.$page_type.'_manual_count'));
		}
		if($this->microdatapro->opencart_version(0) == 2 && $this->microdatapro->opencart_version(1) >= 2){ //over 2.2
			if($this->microdatapro->opencart_version(1) >= 3){ //over 2.3
				return $this->load->view('extension/module/microdatapro/min_max', $this->data);
			}else{
				return $this->load->view('module/microdatapro/min_max', $this->data);
			}
		}elseif($this->microdatapro->opencart_version(0) == 2 && $this->microdatapro->opencart_version(1) < 2){ //2.0
			if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/module/microdatapro/min_max.tpl')) {
				return $this->load->view($this->config->get('config_template') . '/template/module/microdatapro/min_max.tpl', $this->data);
			} else {
				return $this->load->view('default/template/module/microdatapro/min_max.tpl', $this->data);
			}	
		}else{ //1.X
			if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/module/microdatapro/min_max.tpl')) {
				$this->template = $this->config->get('config_template') . '/template/module/microdatapro/min_max.tpl';
			} else {
				$this->template = 'default/template/module/microdatapro/min_max.tpl';
			}
			return $this->render();
		}
	} 
	
	public function products($results = array(), $type = 'json', $related = false){
		$this->data['microdata_products'] = array();
		$this->data['prices'] = array();
		if($results){
			foreach ($results as $result) {	
				$result = $this->microdatapro->clear_array($result);
				$price_format = $this->convert((float)($result['special']?$this->tax->calculate($result['special'], $result['tax_class_id'], $this->config->get('config_tax')):$this->tax->calculate($result['price'], $result['tax_class_id'], $this->config->get('config_tax'))), $this->config->get('config_currency'), $this->data['microdata_code']);						

				if($this->microdatapro->opencart_version(0) == 2 && $this->microdatapro->opencart_version(1) >= 2){ //over 2.2
					$ipw = $this->config->get($this->config->get('config_theme') . '_image_thumb_width');
					$iph = $this->config->get($this->config->get('config_theme') . '_image_thumb_height');
					if($related){
						$ipw = $this->config->get($this->config->get('config_theme') . '_image_category_width');
						$iph = $this->config->get($this->config->get('config_theme') . '_image_category_height');
					}				
				}else{
					$ipw = $this->config->get('config_image_product_width');
					$iph = $this->config->get('config_image_product_height');
					if($related){
						$ipw = $this->config->get('config_image_category_width');
						$iph = $this->config->get('config_image_category_height');
					}
				}
				

				$pre_description = @$this->microdatapro->clear(utf8_substr(strip_tags(html_entity_decode($result['description']?$result['description']:$this->config->get('config_microdata_product_description'), ENT_QUOTES, 'UTF-8')), 0, ($this->config->get('config_product_description_length')?$this->config->get('config_product_description_length'):100)) . '..', false);

				$this->data['microdata_products'][] = array(
					'microdata_description' => $pre_description,
					'microdata_price' => $price_format,					
					'thumb'   	 => $this->getImage(($result['image']?$result['image']:$this->config->get('config_logo')), $ipw, $iph),
					'name'    	 => $this->microdatapro->clear(@$result['name']),
					'href'    	 => $this->url->link('product/product', 'product_id=' . $result['product_id'], 'SSL')
				);
				$this->data['prices'][] = $price_format;
			}
		}
		
		$this->data['related_block'] = $related;
		if($this->microdatapro->opencart_version(0) == 2 && $this->microdatapro->opencart_version(1) >= 2){ //over 2.2
			if($this->microdatapro->opencart_version(1) >= 3){ //over 2.3
				return $this->load->view('extension/module/microdatapro/products_'.$type, $this->data);
			}else{
				return $this->load->view('module/microdatapro/products_'.$type, $this->data);
			}
		}elseif($this->microdatapro->opencart_version(0) == 2 && $this->microdatapro->opencart_version(1) < 2){ //2.0
			if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/module/microdatapro/products_'.$type.'.tpl')) {
				return $this->load->view($this->config->get('config_template') . '/template/module/microdatapro/products_'.$type.'.tpl', $this->data);
			} else {
				return $this->load->view('default/template/module/microdatapro/products_'.$type.'.tpl', $this->data);					
			}	
		}else{ //1.X
			if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/module/microdatapro/products_'.$type.'.tpl')) {
				$this->template = $this->config->get('config_template') . '/template/module/microdatapro/products_'.$type.'.tpl';
			} else {
				$this->template = 'default/template/module/microdatapro/products_'.$type.'.tpl';
			}
			return $this->render();
		}
	}
	
	public function category_info() {
		$category_info = array();
		if (isset($this->request->get['path'])) {
			$path = '';
			$parts = explode('_', (string)$this->request->get['path']);
			$category_id = (int)array_pop($parts);
			$parts = explode('_', (string)$this->request->get['path']);

			if(count($parts)>0){
				foreach ($parts as $path_id) {
					if (!$path) {
						$path = (int)$path_id;
					} else {
						$path .= '_' . (int)$path_id;
					}

					$category_info = $this->microdatapro->clear_array($this->model_catalog_category->getCategory($path_id));
					if ($category_info) 
					{
						if ($category_info['parent_id']>0)
						{
						// echo "<h1 style='color:red;'>category_info :</h1><pre>";print_r($category_info);echo "</pre><hr>";
							$this->data['microdata_breadcrumbs'][] = array(
								'text'      => @$category_info['name'],
								'href'      => $this->url->link('product/category', 'path=' . $path, 'SSL')
							);
						}
					}
				}
			}
		// echo "<h1 style='color:red;'>this->data['microdata_breadcrumbs'] :</h1><pre>";print_r($this->data['microdata_breadcrumbs']);echo "</pre><hr>";

			if(!isset($this->data['microdata_breadcrumbs'])){
				$this->data['microdata_breadcrumbs'] = array();
			}
			
 		// 	if($this->data['glob_route'] != "product/product"){
 		// 	  if(isset($this->data['microdata_breadcrumbs']) and count($this->data['microdata_breadcrumbs']) > 0){
			// 	array_pop($this->data['microdata_breadcrumbs']);
			//   }			
			// }			
		}	


		return $category_info;
	}

	public function blog_latest()
	{
		$configblog_name = $this->config->get('configblog_name');
		
		if (!empty($configblog_name)) {
			$name = $this->config->get('configblog_name');
		} else {
			$name = $this->language->get('text_blog');
		}
		$this->data['microdata_breadcrumbs'][] = array(
			'text' => $name,
			'href' => ""
		);
	}

	public function blog_category()
	{

		$configblog_name = $this->config->get('configblog_name');
		
		if (!empty($configblog_name)) {
			$name = $this->config->get('configblog_name');
		} else {
			$name = $this->language->get('text_blog');
		}
		$this->data['microdata_breadcrumbs'][] = array(
			'text' => $name,
			'href' => $this->url->link('pavblog/blogs', '', 'SSL')
		);

		$blog_category_id = (int)$this->request->get['id'];

		if ($blog_category_id>1)
		{
			$category_info = $this->model_pavblog_category->getInfo($blog_category_id);
			$this->data['microdata_breadcrumbs'][] = array(
				'text' => $category_info['title'],
				'href' => ""
			);
		}
	}

	public function blog_article()
	{
		
		$configblog_name = $this->config->get('configblog_name');
		
		if (!empty($configblog_name)) {
			$name = $this->config->get('configblog_name');
		} else {
			$name = $this->language->get('text_blog');
		}
		
		$this->data['microdata_breadcrumbs'][] = array(
			'text' => $name,
			'href' => $this->url->link('pavblog/blogs', '', 'SSL')
		);
		
		$this->load->model('pavblog/blog');	
		
		// if (isset($this->request->get['blog_category_id'])) {
		// 	$blog_category_id = '';
				
		// 	foreach (explode('_', $this->request->get['blog_category_id']) as $path_id) {
		// 		if (!$blog_category_id) {
		// 			$blog_category_id = $path_id;
		// 		} else {
		// 			$blog_category_id .= '_' . $path_id;
		// 		}
				
		// 		$category_info = $this->model_pavblog_category->getInfo($path_id);
				
		// 		if ($category_info) {
		// 			$this->data['microdata_breadcrumbs'][] = array(
		// 				'text'      => $category_info['title'],
		// 				'href'      => $this->url->link('pavblog/blog', 'id=' . $blog_category_id)
		// 			);
		// 		}
		// 	}
		// }

		if (isset($this->request->get['id'])) {
			$article_id = (int)$this->request->get['id'];
		} else {
			$article_id = 0;
		}
		
		$this->load->model('pavblog/blog');
		
		$article_info = $this->model_pavblog_blog->getInfo($article_id);

		$category_info = $this->model_pavblog_category->getInfo($article_info['category_id']);
		
		if ($category_info) {
			$this->data['microdata_breadcrumbs'][] = array(
				'text'      => $category_info['title'],
				'href'      => $this->url->link('pavblog/category', 'id=' . $article_info['category_id'], 'SSL')
			);
		}
		$this->data['microdata_breadcrumbs'][] = array(
			'text' => $article_info['title'],
			'href' => ""
		);
	}

	public function information()
	{
		$this->load->model('catalog/information');
		if (isset($this->request->get['information_id'])) {
			$information_id = (int)$this->request->get['information_id'];
		} else {
			$information_id = 0;
		}

		$information_info = $this->model_catalog_information->getInformation($information_id);


		$this->data['microdata_breadcrumbs'][] = array(
			'text' => $information_info['title'],
			'href' => ""
		);
	}

	public function product_info()
	{
		// $this->category_info();
		if (isset($this->request->get['product_id'])) {
			$product_id = (int)$this->request->get['product_id'];
		} else {
			$product_id = 0;
		}
		$this->load->model('catalog/product');

		$product_info = $this->model_catalog_product->getProduct($product_id);
		if ($product_info)
		{

			$data['microdata_breadcrumbs'][] = array(
				'text' => $product_info['name'],
				'href' => $this->url->link('product/product', '&product_id=' . $this->request->get['product_id'],'SSL')
			);
		}
	}
	
	public function breadcrumbs($page, $page_data = array()) {
		if($this->microdatapro->opencart_version(0) == 2){
			$text_alt_home = $this->config->get('config_microdata_text_home')?$this->config->get('config_microdata_text_home'):$this->config->get('config_name');
		}else{
			$text_alt_home = $this->language->get('text_home');
		}

		$this->data['microdata_breadcrumbs'] = array();
		$this->data['microdata_breadcrumbs'][] = array(
			'text'      => $text_alt_home,
			'href'      => $this->url->link('common/home', '', 'SSL')
		);		
		
		if($page == 'product'){	
			$this->product_info();			
		}
		
		if($page == 'category'){
			$this->category_info();
		}
		
		if($page == 'blog_category'){
			$this->blog_category();
		}
		
		if($page == 'blog_latest'){
			$this->blog_latest();
		}
		
		if($page == 'blog_article'){
			$this->blog_article();
		}
		
		if($page == 'information'){
			$this->information();
		}

		if($page == 'manufacturer'){
			$this->data['microdata_breadcrumbs'][] = array( 
				'text'      => $this->language->get('text_brand'),
				'href'      => $this->url->link('product/manufacturer', '', 'SSL')
			);
		}	

		if($page == 'shops'){
			$this->data['microdata_breadcrumbs'][] = array( 
				'text'      => "Наши магазины",
				'href'      => ""
			);
		}		

		if($page == 'vacancies'){
			$this->data['microdata_breadcrumbs'][] = array( 
				'text'      => "Вакансии",
				'href'      => ""
			);
		}		

		if($page == 'reviews'){
			$this->data['microdata_breadcrumbs'][] = array( 
				'text'      => "Отзывы",
				'href'      => ""
			);
		}		

		if($this->microdatapro->opencart_version(0) == 2 && $this->microdatapro->opencart_version(1) >= 2){ //over 2.2
			if($this->microdatapro->opencart_version(1) >= 3){ //over 2.3
				return $this->load->view('extension/module/microdatapro/breadcrumbs', $this->data);
			}else{
				return $this->load->view('module/microdatapro/breadcrumbs', $this->data);
			}
		}elseif($this->microdatapro->opencart_version(0) == 2 && $this->microdatapro->opencart_version(1) < 2){ //2.0
			if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/module/microdatapro/breadcrumbs.tpl')) {
				return $this->load->view($this->config->get('config_template') . '/template/module/microdatapro/breadcrumbs.tpl', $this->data);
			} else {
				return $this->load->view('default/template/module/microdatapro/breadcrumbs.tpl', $this->data);					
			}	
		}else{ //1.X
			if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/module/microdatapro/breadcrumbs.tpl')) {
				$this->template = $this->config->get('config_template') . '/template/module/microdatapro/breadcrumbs.tpl';
			} else {
				$this->template = 'default/template/module/microdatapro/breadcrumbs.tpl';
			}
			return $this->render();
		}		
		
	}

	public function getConfig($key = false) {

		$data = array();

		$query = $this->db->query("SELECT * FROM `" . DB_PREFIX . "setting` WHERE `code` = 'microdatapro'");

		foreach ($query->rows as $result){
			if (!$result['serialized']) {
				$data[$result['key']] = @$result['value'];
			} else {
				$data[$result['key']] = unserialize($result['value']);
			}
		}

		return $key?$data[$key]:$data;
	}
	
	public function getAllRating($key) {
		$data = 0;
		$query = $this->db->query("SELECT rating FROM `" . DB_PREFIX . "review`");

		$count = count($query->rows)?count($query->rows):0;
		
		if($count){
			if($key == 'value'){
				$all = 0;
				foreach ($query->rows as $result){
					$all += $result['rating'];
				}
				
				$data = (float)($all/$count);
				
			}
			
			if($key == 'count'){
				$data = $count;
			}
		}		

		return $data;
	}

	public function convert($value, $from, $to) {
		$currencies = array();

		foreach ($this->db->query("SELECT * FROM " . DB_PREFIX . "currency")->rows as $result) {
			$currencies[$result['code']] = array(
				'currency_id'   => $result['currency_id'],
				'decimal_place' => $result['decimal_place'],
				'value'         => $result['value']
			); 
		}		

		$from = isset($currencies[$from])?$currencies[$from]['value']:1;
		$to = isset($currencies[$to])?$currencies[$to]['value']:1;
		if($from > 1) $from = 1;

		return number_format(round($value * ($to / $from), (int)$currencies[$this->data['microdata_code']]['decimal_place']), (int)$currencies[$this->data['microdata_code']]['decimal_place'], '.', '');
	}
}
?>