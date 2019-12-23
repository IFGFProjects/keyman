<?php
class ControllerCommonSeoUrl extends Controller {
	public function index() {
		// Add rewrite to url class
		if ($this->config->get('config_seo_url')) {
			$this->url->addRewrite($this);
		}

		 	//HTAGSMGR ------------------
			$this->load->model('htagsmgr/seo_url');
			$this->model_htagsmgr_seo_url->GetTagByUrl();

		 	//BLOGTAGSMGR ------------------
			$this->load->model('blogtagsmgr/seo_url');
			$this->model_blogtagsmgr_seo_url->GetTagByUrl();

			//HALTMETA --------------------
			$haltmeta=$this->db->query("SELECT * FROM haltmeta WHERE `seo_url`='".trim($_SERVER['REQUEST_URI'],'/')."' AND `link`<>'' AND `status`>0");
			if ($haltmeta->num_rows>0)
			{
				$url_data=parse_url($haltmeta->row['link']);
				if (isset($url_data['path']))
					{$this->request->get['_route_']=$url_data['path'];}
				if (isset($url_data['query']))
				{
					parse_str(html_entity_decode($url_data['query']),$get_data);
					$this->request->get=array_merge($this->request->get,$get_data);
				}
			}

			// echo "<h1 style='color:red;'>this->request->get :</h1><pre>";print_r($this->request->get);echo "</pre><hr>";

		// Decode URL
		if (isset($this->request->get['_route_'])) {
			$parts = explode('/', $this->request->get['_route_']);

			// remove any empty arrays from trailing
			if (utf8_strlen(end($parts)) == 0) {
				array_pop($parts);
			}

				/** BEGIN PROCESSING TO DECORD REQUET SEO URL FOR  PAVO BLOG MODULE **/
				$blogConfig = $this->config->get('pavblog');
			 	$seo = isset($blogConfig['keyword_listing_blogs_page'])?trim($blogConfig['keyword_listing_blogs_page']):"blogs"; 
				if( $this->request->get['_route_'] ==  $seo ){
					$this->request->get['route'] =  'pavblog/blogs';
					// return $this->forward($this->request->get['route']);
					new Action($this->request->get['route']);
				} 
				/** END OF PROCESSING TO DECORD REQUET SEO URL FOR  PAVO BLOG MODULE **/
			foreach ($parts as $part) {
				$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "url_alias WHERE keyword = '" . $this->db->escape($part) . "'");

				if ($query->num_rows) {
					$url = explode('=', $query->row['query']);


					if ($url[0] == 'product_id') {
						$this->request->get['product_id'] = $url[1];
					}

					if ($url[0] == 'category_id') {
						if (!isset($this->request->get['path'])) {
							$this->request->get['path'] = $url[1];
						} else {
							$this->request->get['path'] .= '_' . $url[1];
						}
					}

					if ($url[0] == 'manufacturer_id') {
						$this->request->get['manufacturer_id'] = $url[1];
					}

					if ($url[0] == 'information_id') {
						$this->request->get['information_id'] = $url[1];
					}

					if ($query->row['query'] && $url[0] != 'information_id' && $url[0] != 'manufacturer_id' && $url[0] != 'category_id' && $url[0] != 'product_id') {
						$this->request->get['route'] = $query->row['query'];
					}

					 	/** BEGIN PROCESSING TO DECORD REQUET SEO URL FOR  PAVO BLOG MODULE **/
						if( count($url) == 2 && ( preg_match( "#pavblog#", $url[0] ))  ){
						 	$this->request->get['route'] =  $url[0];
						 	$this->request->get['id'] = $url[1];
						}
						/** END OF PROCESSING TO DECORD REQUET SEO URL FOR  PAVO BLOG MODULE **/


				} else {
					$this->request->get['route'] = 'error/not_found';

					break;
				}
			}

			if (!isset($this->request->get['route'])) {
				if (isset($this->request->get['product_id'])) {
					$this->request->get['route'] = 'product/product';
				} elseif (isset($this->request->get['path'])) {
					$this->request->get['route'] = 'product/category';
				} elseif (isset($this->request->get['manufacturer_id'])) {
					$this->request->get['route'] = 'product/manufacturer/info';
				} elseif (isset($this->request->get['information_id'])) {
					$this->request->get['route'] = 'information/information';
				}
			}

			/***  SHOPS PAGE CRUNCH */
			if (isset($url))
			if ( ($url[0]=="information_id") && ($url[1]=="23") )
				{$this->request->get['route'] = 'information/shops';}
			/*** END SHOPS PAGE CRUNCH */ 
			$this->validate();
			if (isset($this->request->get['route'])) {
				return new Action($this->request->get['route']);
			}
		}
	}


	private function validate() {
		if (isset($this->request->get['route']) && $this->request->get['route'] == 'error/not_found') {
			return;
		}
		if(empty($this->request->get['route'])) {
			$this->request->get['route'] = 'common/home';
		}
		if (isset($this->request->server['HTTP_X_REQUESTED_WITH']) && strtolower($this->request->server['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
			return;
		}
		if (isset($this->request->server['HTTPS']) && (($this->request->server['HTTPS'] == 'on') || ($this->request->server['HTTPS'] == '1'))) {
			$url = str_replace('&amp;', '&', $this->config->get('config_ssl') . ltrim($this->request->server['REQUEST_URI'], '/'));
			$seo = str_replace('&amp;', '&', $this->url->link($this->request->get['route'], $this->getQueryString(array('_route_','route')), 'SSL'));
		} else {
			$url = str_replace('&amp;', '&',
				substr($this->config->get('config_url'), 0, strpos($this->config->get('config_url'), '/', 10)) // leave only domain
				. $this->request->server['REQUEST_URI']);
			$seo = str_replace('&amp;', '&', $this->url->link($this->request->get['route'], $this->getQueryString(array('_route_','route')), 'NONSSL'));
		}
		
		if (rawurldecode($url) != rawurldecode($seo)) {
			$this->response->redirect($seo, 301);
		}
	}

	public function rewrite($link) {
		$url_info = parse_url(str_replace('&amp;', '&', $link));

		$url = '';

		$data = array();

		// if ($link=="information/vacancies")

		parse_str($url_info['query'], $data);
		// {echo "<h1 style='color:red;'>link :</h1><pre>";print_r($data);echo "</pre><hr>";}
		if ($data['route']=="information/vacancies")
			{$url="/vacancies";}
		if ($data['route']=="information/reviews")
			{$url="/reviews";}
		if ($data['route']=="product/special")
			{$url="/sale";}
		///----------- NEW MAIN_CATEGORY BASED  TECH --------
		if ( ($data['route'] == 'product/product')  && (isset($data['product_id'])))
		{
			$this->load->model("catalog/category");
			$cat_main=$this->db->query("SELECT p.main_category, url.keyword FROM product as p
				LEFT JOIN url_alias as url ON url.`query`=CONCAT ('product_id=','".(int)$data['product_id']."')
				WHERE p.product_id=".(int)$data['product_id']);
			if ( ((int)$cat_main->row['main_category']!=0) && ($cat_main->row['keyword']!='')  )
			{
				$data=array();
				$cats=$this->model_catalog_category->getCategoryTree($cat_main->row['main_category']);
				$url="/";
				foreach ($cats as $ckey => $cat)
				{
					if ($cat['seo_url']!="")
						$url.=$cat['seo_url']."/";
				}
				$url.=$cat_main->row['keyword'];
			}
		}

		// if ( ($data['route'] == 'product/category')  && (isset($data['path'])))
		// {
		// 	$cat_id=explode("_", $data['path']);
		// 	$cat_id=array_pop($cat_id);
		// 	$this->load->model("catalog/category");
		// 		$no_segment_trig=false;
		// 		$cats=$this->model_catalog_category->getCategoryTree($cat_id);
		// 		echo "<h1 style='color:red;'>$cat_id --- ".$data['path']." :</h1><pre>";print_r($cats);echo "</pre><hr>";
		// 		$url="/";
		// 		foreach ($cats as $ckey => $cat)
		// 		{
		// 			if ($cat['seo_url']!="")
		// 				{$url.=$cat['seo_url']."/";}
		// 			else 
		// 				{$no_segment_trig=true;}
		// 		}
		// 		$url=rtrim($url,"/");
		// 		if (!$no_segment_trig)
		// 			{$data=array();}
		// 		else 
		// 			{$url="";}
		// }

		//----------- END MAIN CATEGORY TECH ----------------
// echo "<h1 style='color:red;'>$url -- :</h1><pre>";print_r($data);echo "</pre><hr>";
// echo "<h1 style='color:red;'>no_segment_trig :</h1><pre>";print_r($no_segment_trig);echo "</pre><hr>";
		foreach ($data as $key => $value) {
			if (isset($data['route'])) {
				//-------- OLD CATEGORY BASED TECH -------
				// if (($data['route'] == 'product/product' && $key == 'product_id') || (($data['route'] == 'product/manufacturer/info' || $data['route'] == 'product/product') && $key == 'manufacturer_id') || ($data['route'] == 'information/information' && $key == 'information_id')) {
				if (
					(
					($data['route'] == 'product/manufacturer/info' || $data['route'] == 'product/product') && $key == 'manufacturer_id') || ($data['route'] == 'information/information' && $key == 'information_id')) {

					$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "url_alias WHERE `query` = '" . $this->db->escape($key . '=' . (int)$value) . "'");

					if ($query->num_rows && $query->row['keyword']) {
						$url .= '/' . $query->row['keyword'];

						unset($data[$key]);
					}
				} elseif ($key == 'path') {
					$categories = explode('_', $value);
					$categories=explode('_',$this->getPathByCategory(end($categories)));
					foreach ($categories as $category) {
						$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "url_alias WHERE `query` = 'category_id=" . (int)$category . "'");

						if ($query->num_rows && $query->row['keyword']) {
							$url .= '/' . $query->row['keyword'];
						} else {
							$url = '';

							break;
						}
					}

					unset($data[$key]);
				}
			}
		}

		/** BEGIN PROCESSING TO REWRITE SEO URL FOR  PAVO BLOG MODULE **/
	if (isset($data['route']))
	{

		if ( ( preg_match( "#pavblog#", $data['route'] ))  && isset($data['id']) ) 
		{ 
			$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "url_alias WHERE `query` = '" . $this->db->escape( $data['route'] . '=' .$data['id']) . "'");
			if ($query->num_rows)
				if (trim($query->row['keyword'])!='') 
				{
					$url .= '/' . $query->row['keyword'];
					// unset($data[$key]);
					unset($data['id']);
				}

			if(preg_match("#pavblog/category#",$data['route']) && preg_match("#\{page\}#",$url_info['query']) && !isset($data['page'])) 
				{$data['page'] = '{page}';}

		} else if( $data['route'] == 'pavblog/blogs' )
		{ 
			$blogConfig = $this->config->get('pavblog');
			$seo = isset($blogConfig['keyword_listing_blogs_page'])?trim($blogConfig['keyword_listing_blogs_page']):"blogs"; 
			$url .= '/'.$seo;
		}
	}
		/** END OF PROCESSING SEO URL FOR PAVO BLOG MODULE **/

		// echo "<h1 style='color:red;'>$url :</h1><pre>";print_r($url_info);echo "</pre><hr>";
		//HTAGSMGR ------------------
		$this->load->model('htagsmgr/seo_url');
			if (isset($data['route']))
				{$this->model_htagsmgr_seo_url->rewriteCategory($data,$data['route'],$url,isset($category)?$category:false);}
		//BLOGTAGSMGR ------------------
		$this->load->model('blogtagsmgr/seo_url');
			if (isset($data['route']))
				{$this->model_blogtagsmgr_seo_url->rewriteCategory($data,$data['route'],$url);}


		//HALTMETA ---------------------
			$query = '';

			if ($data) {
				foreach ($data as $key => $value) 
					if ($key!="route")
					{$query .= '&' . rawurlencode((string)$key) . '=' . rawurlencode((string)$value);}

				if ($query) 
					{$query = '?' . str_replace('&', '&amp;', trim($query, '&'));}
			}


		$haltmeta=$this->db->query("SELECT * FROM haltmeta WHERE `link`='".trim($url . $query,"/")."' AND `seo_url`<>'' AND `status`>0");
		if ($haltmeta->num_rows>0)
		{
			$url="/".$haltmeta->row['seo_url'];
			$data=array();
		}

		if ($url || $data['route']=="common/home") {
			unset($data['route']);

			$query = '';

			if ($data) {
				foreach ($data as $key => $value) {
					$query .= '&' . rawurlencode((string)$key) . '=' . rawurlencode((string)$value);
				}

				if ($query) {
					$query = '?' . str_replace('&', '&amp;', trim($query, '&'));
				}
			}

			return $url_info['scheme'] . '://' . $url_info['host'] . (isset($url_info['port']) ? ':' . $url_info['port'] : '') . str_replace('/index.php', '', $url_info['path']) . $url . $query;
		} else {
			return $link;
		}
	}


	private function getPathByCategory($category_id) {
		$category_id = (int)$category_id;
		if ($category_id < 1) return false;
		static $path = null;
		if (!is_array($path)) {
			$path = $this->cache->get('category.seopath');
			if (!is_array($path)) $path = array();
		}
		if (!isset($path[$category_id])) {
			$max_level = 10;
			$sql = "SELECT CONCAT_WS('_'";
			for ($i = $max_level-1; $i >= 0; --$i) {
				$sql .= ",t$i.category_id";
			}
			$sql .= ") AS path FROM " . DB_PREFIX . "category t0";
			for ($i = 1; $i < $max_level; ++$i) {
				$sql .= " LEFT JOIN " . DB_PREFIX . "category t$i ON (t$i.category_id = t" . ($i-1) . ".parent_id)";
			}
			$sql .= " WHERE t0.category_id = '" . $category_id . "'";
			$query = $this->db->query($sql);
			$path[$category_id] = $query->num_rows ? $query->row['path'] : false;
			$this->cache->set('category.seopath', $path);
		}
		return $path[$category_id];
	}	

	private function getQueryString($exclude = array()) {
		if (!is_array($exclude)) {
			$exclude = array();
			}
		return urldecode(
			http_build_query(
				array_diff_key($this->request->get, array_flip($exclude))
				)
			);
		}
}
