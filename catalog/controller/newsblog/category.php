<?php
class ControllerNewsBlogCategory extends Controller {
	public function index() {
		$this->load->language('newsblog/category');

		$this->load->model('newsblog/category');
		$this->load->model('newsblog/article');

		$this->load->model('tool/image');


		if (isset($this->request->get['page'])) {
			$page = $this->request->get['page'];
		} else {
			$page = 1;
		}

		$data['breadcrumbs'] = array();

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_home'),
			'href' => $this->url->link('common/home','','SSL')
		);

		if (isset($this->request->get['newsblog_path'])) {
			$path = '';

			$parts = explode('_', (string)$this->request->get['newsblog_path']);

			$category_id = (int)array_pop($parts);

			foreach ($parts as $path_id) {
				if (!$path) {
					$path = (int)$path_id;
				} else {
					$path .= '_' . (int)$path_id;
				}

				$category_info = $this->model_newsblog_category->getCategory($path_id);

				if ($category_info) {
					$data['breadcrumbs'][] = array(
						'text' => $category_info['name'],
						'href' => $this->url->link('newsblog/category', 'newsblog_path=' . $path,'SSL')
					);
				}
			}
		} else {
			$category_id = 0;
		}

		$category_info = $this->model_newsblog_category->getCategory($category_id);

		if ($category_info) {

			//for no errors with versions < 20160920
			$articles_image_size=array($this->config->get('config_image_product_width'),$this->config->get('config_image_product_height'));
	        $category_image_size=array($this->config->get('config_image_category_width'),$this->config->get('config_image_category_height'));
			$date_format=$this->language->get('date_format_short');
			if ($category_info['settings']) {
				$settings=unserialize($category_info['settings']);
	            $category_info=array_merge($category_info,$settings);

	            $articles_image_size=array($settings['images_size_width'],$settings['images_size_height']);
	            $category_image_size=array($settings['image_size_width'],$settings['image_size_height']);
	            $date_format=$settings['date_format'];
            }

			if ($category_info['meta_title']) {
				$this->document->setTitle($category_info['meta_title']);
			} else {
				$this->document->setTitle($category_info['name']);
			}

			$this->document->setDescription($category_info['meta_description']);
			$this->document->setKeywords($category_info['meta_keyword']);

			if ($category_info['meta_h1']) {
				$data['heading_title'] = $category_info['meta_h1'];
			} else {
				$data['heading_title'] = $category_info['name'];
			}

			$data['text_empty'] = $this->language->get('text_empty');
			$data['button_continue'] = $this->language->get('button_continue');
			$data['text_refine'] = $this->language->get('text_refine');
			$data['text_attributes'] = $this->language->get('text_attributes');

			$data['continue'] = $this->url->link('common/home','','SSL');

			// Set the last category breadcrumb
			$data['breadcrumbs'][] = array(
				'text' => $category_info['name'],
				'href' => $this->url->link('newsblog/category', 'newsblog_path=' . $this->request->get['newsblog_path'], 'SSL')
			);

			if ($category_info['image']) {
				$data['original']	= HTTPS_SERVER.'image/'.$category_info['image'];
				$data['thumb'] 		= $this->model_tool_image->resize($category_info['image'], $category_image_size[0], $category_image_size[1]);
			} else {
				$data['original'] 	= '';
				$data['thumb'] 		= '';
			}

			$data['description'] = html_entity_decode($category_info['description'], ENT_QUOTES, 'UTF-8');

			$data['categories'] = array();

			$categories = $this->model_newsblog_category->getCategories(0);    	

			foreach ($categories as $category) {
				
            	if($category['category_id'] == $category_info['category_id']){
            		$active = true;
            	} else{
            		$active = '';
            	}
            	
				if ($category['image']) {
					$original 	= HTTPS_SERVER.'image/'.$category['image'];
					$thumb 		= $this->model_tool_image->resize($category['image'], $articles_image_size[0], $articles_image_size[1]);
				} else {
					$original 	= false;
					$thumb 		= false;
				}

				$filter_data = array(
					'filter_category_id' 	=> $category['category_id'],
					'filter_sub_category' 	=> true
				);

				$articles_total = $this->model_newsblog_article->getTotalArticles($filter_data);

				$data['categories'][] = array(
					'name' 			=> $category['name'],
					'total'       	=> $articles_total,
					'original'		=> $original,
					'thumb'			=> $thumb,
					'href' 			=> $this->url->link('newsblog/category', 'newsblog_path=' . $category['category_id'], 'SSL'),
					'active'        => $active
				);
			}

			/*if(($category_id-1) != 0){
				$categories_top =  $this->model_newsblog_category->getCategories($category_id-1);

				foreach ($categories_top as $category) {
					if ($category['image']) {
						$original 	= HTTPS_SERVER.'image/'.$category['image'];
						$thumb 		= $this->model_tool_image->resize($category['image'], $articles_image_size[0], $articles_image_size[1]);
					} else {
						$original 	= false;
						$thumb 		= false;
					}

					$filter_data = array(
						'filter_category_id' 	=> $category['category_id'],
						'filter_sub_category' 	=> true
					);

					$articles_total = $this->model_newsblog_article->getTotalArticles($filter_data);

					$data['categories_top'][] = array(
						'name' 			=> $category['name'],
						'total'       	=> $articles_total,
						'original'		=> $original,
						'thumb'			=> $thumb,
						'href' 			=> $this->url->link('newsblog/category', 'newsblog_path=' . $this->request->get['newsblog_path'] . '_' . $category['category_id'], 'SSL')
					);
				}
			}*/
			// архив новостей за 3 месяца 

			$month_count=3;
			$arc_monthes=array(
				1 =>array("Jan","Январь"),
				2 =>array("Feb","Февраль"),
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
				$data['archive'][$i]=array(
					"name"=>$arc_monthes[$i][0],
					"title"=> $arc_monthes[$i][1]." ".$arc_year,
					"href"=>$this->url->link("newsblog/category", 'newsblog_path='.$this->request->get['newsblog_path'].'&month='.$arc_monthes[$i][0].'&year='.$arc_year,'SSL')
					//"href"=>$this->url->link("newsblog/category", array("month"=>$arc_monthes[$i][0],"year"=>$arc_year),'SSL')
				);
			}
			// архив новостей END	


			$data['articles'] = array();

			$limit = $category_info['limit'];

			if ($limit>0) {
				if (isset($this->request->get['year'])) {
					$year = $this->request->get['year'];
				} else {
					$year = false;
				}

				if (isset($this->request->get['month'])) {
					$month = $this->request->get['month'];
					for ($i = count($arc_monthes); $i > 0; $i--){
						if($arc_monthes[$i][0] == $month){
							$month = $i;
							break;
						}
					}
				} else {
					$month = false;
				}

				$sort = $category_info['sort_by'];
				$order = $category_info['sort_direction'];

				$filter_data = array(
					'filter_category_id' => $category_id,
					'sort'               => $sort,
					'order'              => $order,
					'start'              => ($page - 1) * $limit,
					'limit'              => $limit,
					'year'               => $year,
					'month'              => $month
				);

				$article_total = $this->model_newsblog_article->getTotalArticles($filter_data);

				$results = $this->model_newsblog_article->getArticles($filter_data);

				foreach ($results as $result) {

					if ($result['image']) {
						$original 	= HTTPS_SERVER.'image/'.$result['image'];
						$thumb 		= $this->model_tool_image->resize($result['image'], $articles_image_size[0], $articles_image_size[1]);
					} else {
						$original 	= '';
						$thumb 		= '';	//or use 'placeholder.png' if you need
					}

					$data['articles'][] = array(
						'article_id'  		=> $result['article_id'],
						'original'			=> $original,
						'thumb'       		=> $thumb,
						'name'        		=> $result['name'],
						'preview'     		=> html_entity_decode($result['preview'], ENT_QUOTES, 'UTF-8'),
						'attributes'  		=> $result['attributes'],
						'href'        		=> $this->url->link('newsblog/article', 'newsblog_path=' . $this->request->get['newsblog_path'] . '&newsblog_article_id=' . $result['article_id'],'SSL'),
						'date'		  		=> ($date_format ? date($date_format, strtotime($result['date_available'])) : false),
						'date_modified'		=> ($date_format ? date($date_format, strtotime($result['date_modified'])) : false),
						'viewed' 			=> $result['viewed']
					);
				}

				$pagination = new Pagination();
				$pagination->total = $article_total;
				$pagination->page = $page;
				$pagination->limit = $limit;
				$pagination->url = $this->url->link('newsblog/category', 'newsblog_path=' . $this->request->get['newsblog_path'] . '&page={page}','SSL');

				$data['pagination'] = $pagination->render();

				$data['results'] = sprintf($this->language->get('text_pagination'), ($article_total) ? (($page - 1) * $limit) + 1 : 0, ((($page - 1) * $limit) > ($article_total - $limit)) ? $article_total : ((($page - 1) * $limit) + $limit), $article_total, ceil($article_total / $limit));

				// http://googlewebmastercentral.blogspot.com/2011/09/pagination-with-relnext-and-relprev.html
				if ($page == 1) {
				    $this->document->addLink($this->url->link('newsblog/category', 'newsblog_path=' . $category_info['category_id'], 'SSL'), 'canonical');
				} elseif ($page == 2) {
				    $this->document->addLink($this->url->link('newsblog/category', 'newsblog_path=' . $category_info['category_id'], 'SSL'), 'prev');
				} else {
				    $this->document->addLink($this->url->link('newsblog/category', 'newsblog_path=' . $category_info['category_id'] . '&page='. ($page - 1), 'SSL'), 'prev');
				}

				if ($limit && ceil($article_total / $limit) > $page) {
				    $this->document->addLink($this->url->link('newsblog/category', 'newsblog_path=' . $category_info['category_id'] . '&page='. ($page + 1), 'SSL'), 'next');
				}
			}

			$data['canonical']=$this->url->link('newsblog/category', 'newsblog_path=' . $category_info['category_id'], 'SSL');

			//for no errors with versions < 20170906
			$data['comments_vk'] = false;
			$data['comments_fb'] = false;
			$data['comments_dq'] = false;
			if ($settings && isset($settings['show_comments_vk_id'])) {
				if ($settings && $settings['show_comments_vk_id'] && $settings['show_comments_vk_category']) {
		            $data['comments_vk'] = $settings['show_comments_vk_id'];
		            $this->document->addScript('//vk.com/js/api/openapi.js');
	            }

	            if ($settings && $settings['show_comments_fb_category'])
	            $data['comments_fb'] = true;

	            if ($settings && $settings['show_comments_dq_id'] && $settings['show_comments_dq_category'])
	            $data['comments_dq'] = $settings['show_comments_dq_id'];
            }

			$data['column_left'] = $this->load->controller('common/column_left');
			$data['column_right'] = $this->load->controller('common/column_right');
			$data['content_top'] = $this->load->controller('common/content_top');
			$data['content_bottom'] = $this->load->controller('common/content_bottom');
			$data['footer'] = $this->load->controller('common/footer');
			$data['header'] = $this->load->controller('common/header');

			$template_default='category.tpl';
			if ($category_info['template_category']) $template_default=$category_info['template_category'];

			if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/newsblog/'.$template_default)) {
				$this->response->setOutput($this->load->view($this->config->get('config_template') . '/template/newsblog/'.$template_default, $data));
			} else {
				$this->response->setOutput($this->load->view('default/template/newsblog/'.$template_default, $data));
			}
		} else {
			$data['breadcrumbs'][] = array(
				'text' => $this->language->get('text_error'),
				'href' => $this->url->link('newsblog/category','','SSL')
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
}
