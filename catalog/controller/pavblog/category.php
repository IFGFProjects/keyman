<?php 
	/******************************************************
	 * @package Pav blog module for Opencart 1.5.x
	 * @version 1.0
	 * @author http://www.pavothemes.com
	 * @copyright	Copyright (C) Feb 2013 PavoThemes.com <@emai:pavothemes@gmail.com>.All rights reserved.
	 * @license		GNU General Public License version 2
	*******************************************************/

/**
 * class ControllerPavblogCategory 
 */
	class ControllerPavblogCategory extends Controller {
	
		private $mparams = '';
		private $mdata = array();

		public function preload(){

			$this->mdata['objlang'] = $this->language;
			$this->mdata['objurl'] = $this->url;
			
			$this->load->model('pavblog/blog');
			$this->load->model('pavblog/comment');
			$this->load->model('tool/image'); 	
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
			
			
			$this->language->load('module/pavblog');
			$this->load->model("pavblog/category");
			if( !defined("_PAVBLOG_MEDIA_") ){
				if (file_exists('catalog/view/theme/' . $this->config->get('config_template') . '/stylesheet/pavblog.css')) {
					$this->document->addStyle('catalog/view/theme/' . $this->config->get('config_template') . '/stylesheet/pavblog.css');
				} else {
					$this->document->addStyle('catalog/view/theme/default/stylesheet/pavblog.css');
				}
				define("_PAVBLOG_MEDIA_",true);
			}
		}
		
		/**
		 * get object model
		 */
		public function getModel($model='category'){
			return $this->{"model_pavblog_{$model}"};
		}
		
		public function getImageType(){
		
		}
		
		/**
		 * index action
	     *
		 */
		public function index() {  
		
			$this->preload();
			
			$this->load->model('pavblog/blog');
			
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
			
			$this->mdata['breadcrumbs'] = array();

			$this->mdata['breadcrumbs'][] = array(
				'text'      => $this->language->get('text_home'),
				'href'      => $this->url->link('common/home','','SSL'),
				'separator' => false
			);

			$this->mdata['breadcrumbs'][] = array(
				'text'      => $this->language->get('text_blog'),
				'href'      => $this->url->link('pavblog/category','id=1','SSL'),
				'separator' => false
			);



			if( !isset($this->request->get['id']) ){
				$this->request->get['id'] = null;
			}
			
			
			$parts = explode('_', (string)$this->request->get['id']);
			$category_id = (int)array_pop($parts);
			
			$category_info = $this->getModel()->getInfo( $category_id );	
			// $children = $this->getModel()->getChildren( $category_id );
			$children = $this->getModel()->getChildren(1);

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
			}


			// выводим теги krumax
			$this->load->model('pavblog/tags');
				$lang_tags = ($category_id == 1) ? $this->model_pavblog_tags->getAllTags() : $lang_tags = $this->model_pavblog_tags->getTags($category_id);

				foreach ($lang_tags as $lang_tag) {
					$this->mdata['lang_tags'][] = array(
						'name'	=> $lang_tag,
						'href'	=> $this->url->link( 'pavblog/category', 'id=1&tag=' . $lang_tag,'SSL')
					);
				}	
			// выводим теги END

			// архив новостей за 3 месяца 

				$month_count=3;
				$arc_monthes=array(
					1 =>array("Jan","Январь"),
					2 =>array("Feb","Ферваль"),
					3 =>array("Mar","Март"),
					4 =>array("Apr","Апрель"),
					5 =>array("May","Май"),
					6 =>array("Jun","Июнь"),
					7 =>array("Jul","Июль"),
					8 =>array("Aug","Август"),
					9 =>array("Sep","Сентябрь"),
					10=>array("Oct","Октябрь"),
					11=>array("Nov","Ноябрь"),
					12=>array("Dec","Декабрь")
				);

				$arc_year=date("Y");
				$arc_month=(int)date("m");

				for ($i=$arc_month; $i>$arc_month-$month_count; $i--)
				{
					if ($i<=0)
					{
						$month_count=$month_count-$arc_month;
						$arc_month=12-$month_count;
						$i=12;
						$arc_year--;
					}
					$this->mdata['archive'][$i]=array(
						"name"=>$arc_monthes[$i][0],
						"title"=> $arc_monthes[$i][1]." ".$arc_year,
						"href"=>$this->url->link("pavblog/category", array("id"=>1,"month"=>$arc_monthes[$i][0],"year"=>$arc_year),'SSL')
					);
				}
				$this->mdata['search_link']=$this->url->link("pavblog/category", array("id"=>1),'SSL');
			// архив новостей END	

			foreach( $children as $key => $sub ){
				$sub['description'] = html_entity_decode($sub['description'], ENT_QUOTES, 'UTF-8');
				if( $sub['image'] ){
					$sub['thumb'] = $this->model_tool_image->resize($sub['image'], $this->mparams->get('general_cwidth'), $this->mparams->get('general_cheight') ,'w');
				}else {
					$sub['thumb'] = '';
				}		
				$data = array(
					'filter_category_id' =>$sub['category_id'],
					"month" =>false,
					"year"	=>false,
					"search"=>explode(" ", $search_keywords)
				);
				
				$sub['count_blogs']	 = $this->getModel( 'blog' )->getTotal( $data );
				$sub['link']  =  $this->url->link( 'pavblog/category', 'id=' .  $sub['category_id'] ,'SSL');
				
				if ($sub['category_id']==$category_id)
					{$sub['active']=true;}
				$children[$key]=$sub;
			}


		//	echo '<pre>'.print_r( $children,1 ); die;
			$this->mdata['children'] = $children; 

			if( isset($this->request->get['tag']) ){
				$filter_tag = $this->request->get['tag'];
				$page_tags = true;
			}else {
				$filter_tag = '';
				$page_tags = false;
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

			$all = $this->language->get('text_all');

			$this->mdata['refAll'] = $this->url->link( 'pavblog/category', 'id=1&tag=' . $all,'SSL');

			if( isset($this->request->get['tag']) && $this->request->get['tag'] == $all) $filter_tag = '';
			
			$data = array(
				'filter_category_id' => $category_id,
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



			if ($category_id == 1 && $page_tags == true) {
			$blogs = $this->getModel('blog')->getAllBlogs(  $data );
			} else {
			$blogs = $this->getModel('blog')->getListBlogs(  $data );
			}

	// крошки  PS:сплошной ГОVНОКОД - ПЕРЕПИСАТЬ !!!	

			if ($category_id != 1)
			{
				$this->mdata['breadcrumbs'][] = array(
					'text'      => $category_info['title'],
					'href'      => $this->url->link('pavblog/category', 'id=' .  $category_id,'SSL'),      		
					'separator' => $this->language->get('text_separator')
				);	
			}
        // крошки END PS:сплошной ГОVНОКОД - ПЕРЕПИСАТЬ !!!	

			//HTAGSMGR ------------------
			if ($filter_tag) 
			{
				$this->load->model('blogtagsmgr/tags');
				$tag_info=$this->model_blogtagsmgr_tags->getTagByNameAndCategory($this->request->get['tag'],$category_id);
				if (!empty($tag_info))
				{
					if ($tag_info['meta_title']) 
						{$this->document->setTitle($tag_info['meta_title']);}
					
					if ($tag_info['meta_h1']) 
						{$this->mdata['heading_title'] = $tag_info['meta_h1'];}					
					if ($tag_info['meta_description']) 
						{$this->document->setDescription($tag_info['meta_description']);}		
					if ($tag_info['meta_keyword']) 
						{$this->document->setKeywords($tag_info['meta_keyword']);}
					if ($tag_info['description']) 
						{$this->mdata['description'] = html_entity_decode($tag_info['description'], ENT_QUOTES, 'UTF-8');}
				}
					$this->mdata['breadcrumbs'][] = array(
						'text' => $this->request->get['tag'],
						'href' => '',
						'id' => 0
					);
			}


			$users = $this->getModel()->getUsers();
			if ($category_info) {
				
			$this->mdata['category_id'] = $category_id;

			if ($category_id == 1 && $page_tags == true) {
			$total = $this->getModel( 'blog' )->getTotals( $data );
			$this->mdata['all_blogs'] = true;
			} else {
			$total = $this->getModel( 'blog' )->getTotal( $data );
			$this->mdata['all_blogs'] = false;
			}


				
				$title = $category_info['meta_title'] ? $category_info['meta_title']:$category_info['title']; 
				$this->document->setTitle( $title ); 


			// сортировка блогов

			$this->mdata['sorts'] = array();

			$this->mdata['sorts'][] = array(
				'text'  => $this->language->get('text_default'),
				'value' => 'b.position-ASC',
				'href'  => $this->url->link('pavblog/category', 'id=' . $this->request->get['id'] . '&sort=b.position&order=ASC','SSL')
			);

			$this->mdata['sorts'][] = array(
				'text'  => $this->language->get('text_name_asc'),
				'value' => 'bd.title-ASC',
				'href'  => $this->url->link('pavblog/category', 'id=' . $this->request->get['id'] . '&sort=bd.title&order=ASC','SSL')
			);

			$this->mdata['sorts'][] = array(
				'text'  => $this->language->get('text_name_desc'),
				'value' => 'bd.title-DESC',
				'href'  => $this->url->link('pavblog/category', 'id=' . $this->request->get['id'] . '&sort=bd.title&order=DESC','SSL')
			);

			$this->mdata['sorts'][] = array(
				'text'  => $this->language->get('text_date_asc'),
				'value' => 'b.created-ASC',
				'href'  => $this->url->link('pavblog/category', 'id=' . $this->request->get['id'] . '&sort=b.created&order=ASC','SSL')
			);

			$this->mdata['sorts'][] = array(
				'text'  => $this->language->get('text_date_desc'),
				'value' => 'b.created-DESC',
				'href'  => $this->url->link('pavblog/category', 'id=' . $this->request->get['id'] . '&sort=b.created&order=DESC','SSL')
			);

			
			$this->mdata['sorts'][] = array(
					'text'  => $this->language->get('text_views_desc'),
					'value' => 'b.hits-DESC',
					'href'  => $this->url->link('pavblog/category', 'id=' . $this->request->get['id'] . '&sort=b.hits&order=DESC','SSL')
				);

			$this->mdata['sorts'][] = array(
					'text'  => $this->language->get('text_views_asc'),
					'value' => 'b.hits-ASC',
					'href'  => $this->url->link('pavblog/category', 'id=' . $this->request->get['id'] . '&sort=b.hits&order=ASC','SSL')
				);
			


			// Сортировка блогов END


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

				if (isset($this->request->get['year'])) {
					$url .= '&year=' . $this->request->get['year'];
				} 

				if (isset($this->request->get['month'])) {
					$url .= '&month=' . $this->request->get['month'];
				} 


				$this->mdata['sort'] = $sort;
				$this->mdata['order'] = $order;
				
				
				$this->mdata['heading_title'] = $category_info['title'];
				$this->mdata['button_continue'] = $this->language->get('button_continue');

				$this->mdata['text_tags'] = $this->language->get('text_tags');

				$this->mdata['text_all'] = $this->language->get('text_all');

				$this->mdata['text_sort'] = $this->language->get('text_sort');
				
				$this->mdata['description'] = html_entity_decode($category_info['description'], ENT_QUOTES, 'UTF-8');
				
				$this->mdata['continue'] = $this->url->link('common/home','','SSL');
				$limit_leading_blogs = (int)$this->mparams->get( 'cat_limit_leading_blog' );

				$type = array('l'=>'thumb_large','s'=>'thumb_small');
				
				$limageType = isset($type[$this->mparams->get('cat_leading_image_type')])?$type[$this->mparams->get('cat_leading_image_type')]:'thumb_xsmall';
				$simageType = isset($type[$this->mparams->get('cat_secondary_image_type')])?$type[$this->mparams->get('cat_secondary_image_type')]:'thumb_xsmall';
				

				foreach( $blogs as $key => $blog ){
					if( $blogs[$key]['image'] ){	
						$blogs[$key]['image_orig']= $this->model_tool_image->orig($blog['image']);
						$blogs[$key]['thumb_large'] = $this->model_tool_image->resize($blog['image'], $this->mparams->get('general_lwidth'), $this->mparams->get('general_lheight'),'w' );
						$blogs[$key]['thumb_small'] = $this->model_tool_image->resize($blog['image'], $this->mparams->get('general_swidth'), $this->mparams->get('general_sheight') ,'w' );
						$blogs[$key]['thumb_xsmall'] = $this->model_tool_image->resize($blog['image'],$this->mparams->get('general_xwidth'), $this->mparams->get('general_xheight') ,'w' );
					}else {
						$blogs[$key]['thumb_large'] = '';
						$blogs[$key]['thumb_small'] = '';
						$blogs[$key]['thumb_xsmall'] = '';
					}
					if( $key < $limit_leading_blogs ){
						$blogs[$key]['thumb'] = $blogs[$key][$limageType];
					}else {
						$blogs[$key]['thumb'] = $blogs[$key][$simageType];
					}					
					
					$blogs[$key]['description'] = html_entity_decode($blog['description'], ENT_QUOTES, 'UTF-8');
					$blogs[$key]['author'] = isset($users[$blog['user_id']])?$users[$blog['user_id']]:$this->language->get('text_none_author');
					$blogs[$key]['category_link'] =  $this->url->link( 'pavblog/category', "id=".$blog['category_id'] ,'SSL');
					
					if( $this->mparams->get( 'cat_show_comment_counter' )  ) {	 
						$blogs[$key]['comment_count'] =  $this->getModel('comment')->countComment( $blog['blog_id'] );
					}else {
						$blogs[$key]['comment_count'] = 0;
					}
					
					$blogs[$key]['link'] =  $this->url->link( 'pavblog/blog','id='.$blog['blog_id'],'SSL' );

					$ttags = explode( ",",$blog['lang_tags']);
					$tags  = array();					
					foreach( $ttags as $tag ){
						$blogs[$key]['tags'][trim($tag)] = $this->url->link( 'pavblog/category&id=1&','tag='.trim($tag),'SSL' );
					}
				}


				$leading_blogs 		 = array_slice( $blogs,0, $limit_leading_blogs );
				$secondary_blogs 	 = array_splice( $blogs, $limit_leading_blogs, count($blogs) );
		
				// echo "<h1 style='color:red;'>total :</h1><pre>";print_r($total);echo "</pre><hr>";
				$this->mdata['total'] = $total;
			 	$this->mdata['config'] = $this->mparams;
				$this->mdata['leading_blogs'] = $leading_blogs;
				$this->mdata['secondary_blogs'] = $secondary_blogs;
				$this->mdata['category_rss'] =  $this->url->link( 'pavblog/category/rss', "id=".$category_id ,'SSL');
				$pagination = new Pagination();
				$pagination->total = $total;
				$pagination->page = $page;
				$pagination->limit =  $limit;
				$pagination->text = $this->language->get('text_pagination');

				if (isset($this->request->get['tag'])) {
				$pagination->url = $this->url->link('pavblog/category', 'id=' . $this->request->get['id'] . $url . '&tag='.$this->request->get['tag'].'&page={page}','SSL');
				} else {
				$pagination->url = $this->url->link('pavblog/category', 'id=' . $this->request->get['id'] . $url . '&page={page}','SSL');				
				}
				
				$this->mdata['pagination'] = $pagination->render();
 
				$this->mdata['column_left'] = $this->load->controller('common/column_left');
				$this->mdata['column_right'] = $this->load->controller('common/column_right');
				$this->mdata['content_top'] = $this->load->controller('common/content_top');
				$this->mdata['content_bottom'] = $this->load->controller('common/content_bottom');
				$this->mdata['footer'] = $this->load->controller('common/footer');
				$this->mdata['header'] = $this->load->controller('common/header');
				// echo "<h1 style='color:red;'>this->mdata :</h1><pre>";print_r($this->mdata);echo "</pre><hr>";die();
				

				if ($category_id==27) {
					if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/pavblog/category_coll.tpl')) {
						$this->response->setOutput($this->load->view($this->config->get('config_template') . '/template/pavblog/category_coll.tpl', $this->mdata));
					} else {
						$this->response->setOutput($this->load->view('default/template/pavblog/category_coll.tpl', $this->mdata));
					}
				} else {
				if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/pavblog/category.tpl')) {
					$this->response->setOutput($this->load->view($this->config->get('config_template') . '/template/pavblog/category.tpl', $this->mdata));
				} else {
					$this->response->setOutput($this->load->view('default/template/pavblog/category.tpl', $this->mdata));
				}	
				}
				



			} else {
				$this->mdata['breadcrumbs'][] = array(
					'text'      => $this->language->get('text_error'),
					'href'      => $this->url->link('information/information', 'category_id=' . $category_id,'SSL'),
					'separator' => $this->language->get('text_separator')
				);
					
				$this->document->setTitle($this->language->get('text_error'));
				
				$this->mdata['heading_title'] = $this->language->get('text_error');

				$this->mdata['text_error'] = $this->language->get('text_error');

				$this->mdata['button_continue'] = $this->language->get('button_continue');

				$this->mdata['continue'] = $this->url->link('common/home','','SSL');

				$this->mdata['column_left'] = $this->load->controller('common/column_left');
				$this->mdata['column_right'] = $this->load->controller('common/column_right');
				$this->mdata['content_top'] = $this->load->controller('common/content_top');
				$this->mdata['content_bottom'] = $this->load->controller('common/content_bottom');
				$this->mdata['footer'] = $this->load->controller('common/footer');
				$this->mdata['header'] = $this->load->controller('common/header');

				echo '<br>allBlogs: '.$this->mdata['all_blogs'];


				if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/error/not_found.tpl')) {
					$this->response->setOutput($this->load->view($this->config->get('config_template') . '/template/error/not_found.tpl', $this->mdata));
				} else {
					$this->response->setOutput($this->load->view('default/template/error/not_found.tpl', $this->mdata));
				}
			}
		}
		
		/**
		 * get rss feed by category id 
		 */
		public function rss(){
			
			$this->preload();
			if( isset($this->request->get['id']) ){
				$id = (int)$this->request->get['id'];
			} else {
				$id = 0;
			}
			
			$category_info = $this->getModel()->getInfo( $id );	
			
			define('DATE_FORMAT_RFC822','r');
			
			$lastBuildDate=date(DATE_FORMAT_RFC822);

			$output = '<?xml version="1.0" encoding="UTF-8" ?>';
			$output .= '<rss version="2.0">';
			$output .= '<channel>';

			$output .= '<title>' . $category_info['title'] . " - " . $this->config->get('config_name') . '</title>';
			$output .= '<description>' . $this->config->get('config_meta_description') . '</description>';
			$output .= '<link>' . HTTP_SERVER . '</link>';



			$output .= '<pubDate>' . $lastBuildDate . '</pubDate>';

		    /*<lastBuildDate>$lastBuildDate</lastBuildDate>
		    <docs>http://blogs.law.harvard.edu/tech/rss</docs>
		    <generator>Weblog Editor 2.0</generator>
		    <copyright>Copyright 2006 mysite.com</copyright>
		    <managingEditor>editor@mysite.com</managingEditor>
		    <webMaster>webmaster@mysite.com</webMaster>*/

		    $output .= '<language>ru</language>';
			
			$page = 1;
			$limit = (int)$this->mparams->get('rss_limit_item')?(int)$this->mparams->get('rss_limit_item'):100;
			
			$data = array(
				'filter_category_id' => $id,
				'sort'               => 'created',
				'order'              => 'ASC',
				'start'              => ($page - 1) * $limit,
				'limit'              => $limit
			);

			$blogs = $this->getModel('blog')->getListBlogs(  $data );
			

			foreach( $blogs as $blog ){

				$link =  $this->url->link( 'pavblog/blog','id='.$blog['blog_id'] ,'SSL');

				if( $blog['image'] ){
					$image = $this->model_tool_image->resize($blog['image'], $this->mparams->get('general_swidth'), $this->mparams->get('general_sheight') ,'w' );
					$description = '<a href="'.$link.'"><img class="rss_blog_image" src="'.$image.'"/></a>'.  html_entity_decode($blog['description'], ENT_QUOTES, 'UTF-8'); 
				}else {
					$description =  html_entity_decode($blog['description'], ENT_QUOTES, 'UTF-8');
				} 

				$description =  strip_tags($blog['description']);

				$date=date("D, d M Y H:i:s", strtotime($blog['created'])). " GMT";

				$output .= '<item>';
				$output .= '<title>' . $blog['title'] . '</title>';
				$output .= '<link>' . $link . '</link>';
				$output .= '<description>' . $description . '</description>';	
				$output .= '<author>' . $this->config->get('config_email') . ' ('. $this->config->get('config_name') . ')</author>';
				$output .= '<pubDate>' . $date . '</pubDate>';
				$output .= '<guid isPermaLink="true">' .$link . '</guid>';
				$output .= '</item>';
			}
			$output .= '</channel>';
			$output .= '</rss>';
			$this->response->addHeader('Content-Type: application/rss+xml');
			$this->response->setOutput($output);
		}
		
	}	
	?>