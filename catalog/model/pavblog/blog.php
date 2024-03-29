<?php 	
/******************************************************
 * @package Pav blog module for Opencart 2.0.x
 * @version 1.0
 * @author http://www.pavothemes.com
 * @edit   https://krumax.info
 * @copyright	Copyright (C) Feb 2013 PavoThemes.com <@emai:pavothemes@gmail.com>.All rights reserved.
 * @license		GNU General Public License version 2
*******************************************************/

/**
 * class ModelPavblogBlog 
 */
class ModelPavblogBlog extends Model {		
	
	
	/**
	 * Get Blog Information by Id 
	 */
	public function getInfo( $id ){
		
		$query = ' SELECT b.*,bd.title,bd.description,cd.title as category_title, bd.content, bd.lang_tags  FROM '
								. DB_PREFIX . "pavblog_blog b LEFT JOIN "
								. DB_PREFIX . "pavblog_blog_description bd ON b.blog_id=bd.blog_id LEFT JOIN "
								. DB_PREFIX . 'pavblog_category c ON c.category_id=b.category_id  LEFT JOIN ' 
								. DB_PREFIX . 'pavblog_category_description cd ON c.category_id=cd.category_id ' ;
				
		$query .=" WHERE bd.language_id=".(int)$this->config->get('config_language_id');
		$query .= " AND b.blog_id=".(int)$id;
		
		
		$query = $this->db->query( $query );
		$blog = $query->row;
		return $blog; 
	}
	
	/**
	 * update hit time after read
	 */
	public function updateHits( $id ){
		$sql = ' UPDATE '.DB_PREFIX.'pavblog_blog SET hits=hits+1 WHERE blog_id='.(int)$id;
		$this->db->query( $sql );
	}
	
	/**
	 * get list of blogs in same category of current
	 */
	public function getSameCategory( $category_id, $blog_id, $limit=10 ){
		$data = array(
			'filter_category_id' => $category_id,

			'not_in'           => $blog_id,
			'sort'               => 'created',
			'order'              => 'DESC',
			'start'              => 0,
			'limit'              => $limit
		);

		return $this->getListBlogs( $data );
	}
	
	/**
	 * get total blog
	 */
	public function getTotal( $data ){
		$sql = ' SELECT count(b.blog_id) as total FROM '
								. DB_PREFIX . "pavblog_blog b LEFT JOIN "
								. DB_PREFIX . "pavblog_blog_description bd ON b.blog_id=bd.blog_id  and bd.language_id=".(int)$this->config->get('config_language_id')." LEFT JOIN "
								. DB_PREFIX . 'pavblog_category c ON c.category_id=b.category_id  LEFT JOIN ' 
								. DB_PREFIX . 'pavblog_category_description cd ON c.category_id=cd.category_id  and cd.language_id='.(int)$this->config->get('config_language_id') ;
				
		$sql .=" WHERE bd.language_id=".(int)$this->config->get('config_language_id');
		
		if( isset($data['filter_category_id']) && $data['filter_category_id'] ){
			if ((int)$data['filter_category_id']>1)
				$sql .= " AND b.category_id=".(int)$data['filter_category_id'];
		}

		if ($data['month'] && $data['year'])
		{
			$monthes=array("Jan"=>1 ,"Feb"=>2 ,"Mar"=>3 ,"Apr"=>4 ,"May"=>5 ,"Jun"=>6 ,"Jul"=>7 ,"Aug"=>8 ,"Sep"=>9 ,"Oct"=>10,"Nov"=>11,"Dec"=>12);
			$sql.=" AND (YEAR(b.`created`) = ".(int)$data['year']." AND MONTH(b.`created`) = ".(int)$monthes[$data['month']].")";
		}

		if (isset($data['search']))
		if ($data['search'])
		{
			$sql.=" AND ( ";
			foreach ($data['search'] as $key => $kwd) 
				{$sql.=" bd.title LIKE '%".trim($kwd)."%' OR  bd.lang_tags LIKE '%".trim($kwd)."%' OR";}
			$sql=trim($sql,"OR")." )";
		}

		// Сортируем по тэгам
		if( isset($data['filter_tag']) && $data['filter_tag'] ){
			$tmp = explode (",",$data['filter_tag'] );
			
			if( count($tmp) > 1  ){
				
				$t = array();
				foreach( $tmp as $tag ){
					$t[] = 'bd.lang_tags LIKE "%'.$this->db->escape( $tag ).'%"';
					
				}
				$sql .= ' AND  '.implode(" OR ", $t ).' ';	

			}else {
				$sql .= ' AND bd.lang_tags LIKE "%'.$this->db->escape( $data['filter_tag'] ).'%"';
			}
		}
		// Сортируем по тэгам END
	
		$query = $this->db->query( $sql );
		return $query->row['total'];

	}
	

	/**
	 * get totals blog
	 */
	public function getTotals( $data ){
		$sql = ' SELECT count(b.blog_id) as total FROM '
								. DB_PREFIX . "pavblog_blog b LEFT JOIN "
								. DB_PREFIX . "pavblog_blog_description bd ON b.blog_id=bd.blog_id  and bd.language_id=".(int)$this->config->get('config_language_id');
				
		$sql .=" WHERE bd.language_id=".(int)$this->config->get('config_language_id');
		


		// Сортируем по тэгам
		if( isset($data['filter_tag']) && $data['filter_tag'] ){
			$tmp = explode (",",$data['filter_tag'] );
			
			if( count($tmp) > 1  ){
				
				$t = array();
				foreach( $tmp as $tag ){
					$t[] = 'bd.lang_tags LIKE "%'.$this->db->escape( $tag ).'%"';
					
				}
				$sql .= ' AND  '.implode(" OR ", $t ).' ';	

			}else {
				$sql .= ' AND bd.lang_tags LIKE "%'.$this->db->escape( $data['filter_tag'] ).'%"';
			}
		}

		if ($data['month'] && $data['year'])
		{
			$monthes=array("Jan"=>1 ,"Feb"=>2 ,"Mar"=>3 ,"Apr"=>4 ,"May"=>5 ,"Jun"=>6 ,"Jul"=>7 ,"Aug"=>8 ,"Sep"=>9 ,"Oct"=>10,"Nov"=>11,"Dec"=>12);
			$sql.=" AND (YEAR(b.`created`) = ".(int)$data['year']." AND MONTH(b.`created`) = ".(int)$monthes[$data['month']].")";
		}

		if (isset($data['search']))
		if ($data['search'])
		{
			$sql.=" AND ( ";
			foreach ($data['search'] as $key => $kwd) 
				{$sql.=" bd.title LIKE '%".trim($kwd)."%' OR  bd.lang_tags LIKE '%".trim($kwd)."%' OR";}
			$sql=trim($sql,"OR")." )";
		}
		// Сортируем по тэгам END
	
		$query = $this->db->query( $sql );
		return $query->row['total'];

	}

	/**
	 *  get list blogs 
	 */
	public function getListBlogs( $data ){
		
		$sql = ' SELECT b.*,bd.title,bd.description,cd.title as category_title,bd.lang_tags  FROM '
								. DB_PREFIX . "pavblog_blog b LEFT JOIN "
								. DB_PREFIX . "pavblog_blog_description bd ON b.blog_id=bd.blog_id  and bd.language_id=".(int)$this->config->get('config_language_id')." LEFT JOIN "
								. DB_PREFIX . 'pavblog_category c ON c.category_id=b.category_id  LEFT JOIN ' 
								. DB_PREFIX . 'pavblog_category_description cd ON c.category_id=cd.category_id  and cd.language_id='.(int)$this->config->get('config_language_id') ;
				
		$sql .=" WHERE bd.language_id=".(int)$this->config->get('config_language_id');
		
		if( isset($data['filter_category_id']) && $data['filter_category_id'] ){
			if ((int)$data['filter_category_id']>1)
			$sql .= " AND b.category_id=".(int)$data['filter_category_id'];
		}


		if (!empty($data['filter_name'])) {
			$sql .= " AND (";

			if (!empty($data['filter_name'])) {
				$implode = array();

				$words = explode(' ', trim(preg_replace('/\s+/', ' ', $data['filter_name'])));

				foreach ($words as $word) {
					$implode[] = "bd.title LIKE '%" . $this->db->escape($word) . "%'";
				}

				if ($implode) {
					$sql .= " " . implode(" AND ", $implode) . "";
				}

				/*if (!empty($data['filter_description'])) {
					$sql .= " OR pd.description LIKE '%" . $this->db->escape($data['filter_name']) . "%'";
				}*/
			}

			if (!empty($data['filter_name']) && !empty($data['filter_tag'])) {
				$sql .= " OR ";
			}


		$sql .= ")";

		}

		// Сортируем по тэгам
		if( isset($data['filter_tag']) && $data['filter_tag'] ){
			$tmp = explode (",",$data['filter_tag'] );
			
			if( count($tmp) > 1  ){
				
				$t = array();
				foreach( $tmp as $tag ){
					$t[] = 'bd.lang_tags LIKE "%'.$this->db->escape( $tag ).'%"';
					
				}
				$sql .= ' AND  '.implode(" OR ", $t ).' ';	

			}else {
				$sql .= ' AND bd.lang_tags LIKE "%'.$this->db->escape( $data['filter_tag'] ).'%"';
			}
		}
		// Сортируем по тэгам END

		if ( (isset($data['month'])) && (isset($data['year'])) && ($data['month']) )
		{
			$monthes=array("Jan"=>1 ,"Feb"=>2 ,"Mar"=>3 ,"Apr"=>4 ,"May"=>5 ,"Jun"=>6 ,"Jul"=>7 ,"Aug"=>8 ,"Sep"=>9 ,"Oct"=>10,"Nov"=>11,"Dec"=>12);
			$sql.=" AND (YEAR(b.`created`) = ".(int)$data['year']." AND MONTH(b.`created`) = ".(int)$monthes[$data['month']].")";
		}

		if (isset($data['search']))
		if ($data['search'])
		{
			$sql.=" AND ( ";
			foreach ($data['search'] as $key => $kwd) 
				{$sql.=" bd.title LIKE '%".trim($kwd)."%' OR  bd.lang_tags LIKE '%".trim($kwd)."%' OR";}
			$sql=trim($sql,"OR")." )";
		}
				
		
		if( isset($data['featured']) ){
			$sql .= ' AND featured=1 '; 
		}
		$sql .= ' AND status=1 ';
		if( isset($data['not_in']) && $data['not_in'] ){
			$sql .= ' AND b.blog_id NOT IN('.$data['not_in'].')';
		}

		$sort_data = array(
			'bd.title',			
			'b.hits',
			'b.position',
			'b.created'
		);	
		if (isset($data['sort']) && in_array($data['sort'], $sort_data)) {
			if ($data['sort'] == 'pd.name' || $data['sort'] == 'p.model') {
				$sql .= " ORDER BY LCASE(" . $data['sort'] . ")";
			}else {
				$sql .= " ORDER BY " . $data['sort'];
			}
		} else {
			$sql .= " ORDER BY b.`created`";	
		}
		

		if (isset($data['order']) && ($data['order'] == 'DESC')) {
			$sql .= " DESC";
		} else {
			$sql .= " ASC";
		}

		if (isset($data['start']) || isset($data['limit'])) {
			if ($data['start'] < 0) {
				$data['start'] = 0;
			}				

			if ($data['limit'] < 1) {
				$data['limit'] = 3;
			}	
		
			$sql .= " LIMIT " . (int)$data['start'] . "," . (int)$data['limit'];
		}

		//echo 'getListBlogs: '.$sql.'<br>';

		$query = $this->db->query( $sql );
		$blogs = $query->rows;
		return $blogs; 
	}



	/**
	 *  get ALL blogs Krumax Edit 
	 */
	public function getAllBlogs( $data ){
		
		$sql = ' SELECT b.*,bd.title,bd.description,cd.title as category_title,bd.lang_tags  FROM '
								. DB_PREFIX . "pavblog_blog b LEFT JOIN "
								. DB_PREFIX . "pavblog_blog_description bd ON b.blog_id=bd.blog_id  and bd.language_id=".(int)$this->config->get('config_language_id')." LEFT JOIN "
								. DB_PREFIX . 'pavblog_category c ON c.category_id=b.category_id  LEFT JOIN ' 
								. DB_PREFIX . 'pavblog_category_description cd ON c.category_id=cd.category_id  and cd.language_id='.(int)$this->config->get('config_language_id') ;
				
		$sql .=" WHERE bd.language_id=".(int)$this->config->get('config_language_id');


		// Сортируем по тэгам
		if( isset($data['filter_tag']) && $data['filter_tag'] ){

			$tmp = explode (",",$data['filter_tag'] );
			
			if( count($tmp) > 1  ){
				
				$t = array();
				foreach( $tmp as $tag ){
					$t[] = 'bd.lang_tags LIKE "%'.$this->db->escape( $tag ).'%"';
					
				}
				$sql .= ' AND  '.implode(" OR ", $t ).' ';	

			}else {
				$sql .= ' AND bd.lang_tags LIKE "%'.$this->db->escape( $data['filter_tag'] ).'%"';
			}
		}
		// Сортируем по тэгам END

		if (isset($data['month']))
		if ( $data['month'] && $data['year'])
		{
			$monthes=array("Jan"=>1 ,"Feb"=>2 ,"Mar"=>3 ,"Apr"=>4 ,"May"=>5 ,"Jun"=>6 ,"Jul"=>7 ,"Aug"=>8 ,"Sep"=>9 ,"Oct"=>10,"Nov"=>11,"Dec"=>12);
			$sql.=" AND (YEAR(b.`created`) = ".(int)$data['year']." AND MONTH(b.`created`) = ".(int)$monthes[$data['month']].")";
		}

		if (isset($data['search']))
		if ($data['search'])
		{
			$sql.=" AND ( ";
			foreach ($data['search'] as $key => $kwd) 
				{$sql.=" bd.title LIKE '%".trim($kwd)."%' OR  bd.lang_tags LIKE '%".trim($kwd)."%' OR";}
			$sql=trim($sql,"OR")." )";
		}


		// echo $sql."<br>";
		$sql .= ' AND status=1 ';


		$sort_data = array(
			'bd.title',			
			'b.hits',
			'b.created',
			'b.position'
		);	


	
	if ($data['sort'] == 'b.position') {
				$sql .= " ORDER BY b.position";
			} else {


			if (isset($data['sort']) && in_array($data['sort'], $sort_data)) {
				if ($data['sort'] == 'pd.name' || $data['sort'] == 'p.model') {
					$sql .= " ORDER BY LCASE(" . $data['sort'] . ")";
				}else {
					$sql .= " ORDER BY " . $data['sort'];
				}
			} else {
				$sql .= " ORDER BY b.created";	
			}

	}

		if (isset($data['order']) && ($data['order'] == 'DESC')) {
			$sql .= " DESC";
		} else {
			$sql .= " ASC";
		}


		if (isset($data['start']) || isset($data['limit'])) {
			if ($data['start'] < 0) {
				$data['start'] = 0;
			}				

			if ($data['limit'] < 1) {
				$data['limit'] = 3;
			}	
		
			$sql .= " LIMIT " . (int)$data['start'] . "," . (int)$data['limit'];
		}	
	
		//echo 'getAllBlogs: '.$sql.'<br>';

		$query = $this->db->query( $sql );
		$blogs = $query->rows;
		return $blogs; 
	}


	public function getBlogRelatedProduct($blog_id) {
		$product_data = array();
		$this->load->model('catalog/product');
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "pavblog_related_product np LEFT JOIN " . DB_PREFIX . "product p ON (np.product_id = p.product_id) LEFT JOIN " . DB_PREFIX . "product_to_store p2s ON (p.product_id = p2s.product_id) WHERE np.blog_id = '" . (int)$blog_id . "' AND p.status = '1' AND p.date_available <= NOW() AND p2s.store_id = '" . (int)$this->config->get('config_store_id') . "'");
		
		foreach ($query->rows as $result) { 
			$product_data[$result['product_id']] = $this->model_catalog_product->getProduct($result['product_id']);
		}

		return $product_data;
	}


	public function getDefaultConfig(){
		return array(
			'children_columns' => '3',
			'general_cwidth' => '250',
			'general_cheight' => '250',
			'general_lwidth'=> '620',
			'general_lheight'=> '300',
			'general_sheight'=> '250',
			'general_swidth'=> '250',
			'general_xwidth' => '80',
			'general_xheight' => '80',
			'cat_show_hits' => '1',
			'cat_limit_leading_blog'=> '1',
			'cat_limit_secondary_blog'=> '5',
			'cat_leading_image_type'=> 'l',
			'cat_secondary_image_type'=> 's',
			'cat_show_title'=> '1',
			'cat_show_image'=> '1',
			'cat_show_author'=> '1',
			'cat_show_category'=> '1',
			'cat_show_created'=> '1',
			'cat_show_readmore' => 1,
			'cat_show_description' => '1',
			'cat_show_comment_counter'=> '1',
			
			'blog_image_type'=> 'l',
			'blog_show_title'=> '1',
			'blog_show_image'=> '1',
			'blog_show_author'=> '1',
			'blog_show_category'=> '1',
			'blog_show_created'=> '1',
			'blog_show_comment_counter'=> '1',
			'blog_show_comment_form'=>'1',
			'blog_show_hits' => 1,
			'cat_columns_leading_blog'=> 1,
			'cat_columns_leading_blogs'=> 1,
			'cat_columns_secondary_blogs' => 2,
			'comment_engine' => 'local',
			'diquis_account' => 'pavothemes',
			'facebook_appid' => '100858303516',
			'facebook_width'=> '600',
			'comment_limit'=> '10',
			'auto_publish_comment'=>0,
			'enable_recaptcha' => 1,
			'recaptcha_public_key'=>'6LcoLd4SAAAAADoaLy7OEmzwjrf4w7bf-SnE_Hvj',
			'recaptcha_private_key'=>'6LcoLd4SAAAAAE18DL_BUDi0vmL_aM0vkLPaE9Ob',
			'rss_limit_item' => 12,
			'keyword_listing_blogs_page'=>'blogs'

		);
	}
	
}
?>
