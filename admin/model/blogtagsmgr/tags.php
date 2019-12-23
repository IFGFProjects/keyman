<?php 
class ModelBlogtagsmgrTags extends Model {
	public function getTags($data=array())
	{
		$language_filter="";
		if (!isset($data['language_id']))
			{$language_id=(int)$this->config->get('config_language_id');}
		else 
			{$language_filter=" AND td.language_id=".(int)$data['language_id']." ";}

		$status_filter="";
		if (isset($data['status']))
			{$status_filter=" AND tg.status=".(int)$data['status']." ";}

		$id_filter="";
		if (isset($data['tag_id']))
			{$id_filter=" AND tg.tag_id=".(int)$data['tag_id']." ";}

		$limit_fiter="";
		if ( (isset($data['start'])) && (isset($data['limit'])) )
			{$limit_fiter=" \nLIMIT ".$data['start'].", ".$data['limit']." ";}

		$sort_filter="";
		if ( (isset($data['sort'])) && (isset($data['order'])) )
			{$sort_filter="\n ORDER BY ".$data['sort']." ".$data['order']." ";}

		$tags_main=$this->db->query("
			SELECT tg.tag_id, tg.tag_name as `name`, tg.category_id, cat.title as category_name, tg.link, tg.status
			FROM ".DB_PREFIX."blogtagsmgr_tag as tg
			JOIN ".DB_PREFIX."pavblog_category_description as cat ON cat.category_id=tg.category_id AND cat.language_id=$language_id
			WHERE 1 
			$status_filter
			$id_filter
			$sort_filter
			$limit_fiter
		");

		$tags_description="
			SELECT td.* 
			FROM ".DB_PREFIX."blogtagsmgr_tag as tg
			JOIN ".DB_PREFIX."blogtagsmgr_tag_description as td ON tg.tag_id=td.tag_id
			WHERE 1
			$language_filter
			$status_filter
			$id_filter
		";
		$tags_description=$this->db->query($tags_description);
		$tags_descriptions=array();
		foreach ($tags_description->rows as $tdkey => $tag_descr)
			{$tags_descriptions[$tag_descr['tag_id']][$tag_descr['language_id']]=$tag_descr;}

		$tags=array();
		if ( isset($tags_main->rows) )
		foreach ($tags_main->rows as $tgkey => $tag_info) 
		{
			$tags[$tag_info['tag_id']]=$tag_info;
			if (isset($tags_descriptions[$tag_info['tag_id']]))
				{$tags[$tag_info['tag_id']]['tag_description']=$tags_descriptions[$tag_info['tag_id']];}
			$tags[$tag_info['tag_id']]['edit_link']=$this->url->link("module/blogtagsmgr/edit",'token=' . $this->session->data['token']."&tag_id=".$tag_info['tag_id'],"SSL");
			$tags[$tag_info['tag_id']]['href_shop']= HTTP_CATALOG . 'index.php?route=module/blogtagsmgr&tag_id=' . ($tag_info['tag_id']);
		}

		return $tags;
	}

	public function getTag($tag_id)
	{
		$result=$this->getTags(array("tag_id"=>$tag_id));
		return $result[$tag_id];
	}

	public function addTag($data)
	{
		$this->db->query("INSERT INTO " . DB_PREFIX . "blogtagsmgr_tag SET 
			tag_name='".$this->db->escape($data['name'])."',
			category_id=".(int)$data['category_id'].",
			link='".$this->db->escape($data['link'])."',
			status=".(int)$data['status'].",
			date_add = NOW()"
		);

		$tag_id = $this->db->getLastId();

		foreach ($data['tag_description'] as $language_id => $value) {
			$this->db->query("INSERT INTO " . DB_PREFIX . "blogtagsmgr_tag_description SET 
				tag_id = '" . (int)$tag_id . "', 
				language_id = '" . (int)$language_id . "', 
				description = '" . $this->db->escape($value['description']) . "', 
				meta_h1 = '" . $this->db->escape($value['meta_h1']) . "', 
				meta_title = '" . $this->db->escape($value['meta_title']) . "', 
				meta_description = '" . $this->db->escape($value['meta_description']) . "', 
				meta_keyword = '" . $this->db->escape($value['meta_keyword']) . "'"
			);
		}		
		return $tag_id;
	}


	public function editTag($tag_id, $data)
	{
		$this->db->query("UPDATE " . DB_PREFIX . "blogtagsmgr_tag SET 
			tag_name='".$this->db->escape($data['name'])."',
			category_id=".(int)$data['category_id'].",
			link='".$this->db->escape($data['link'])."',
			status=".(int)$data['status']."
			WHERE tag_id=".(int)$tag_id."
		");

		foreach ($data['tag_description'] as $language_id => $value) {
			$query="UPDATE " . DB_PREFIX . "blogtagsmgr_tag_description SET 
				description = '" . $this->db->escape($value['description']) . "', 
				meta_h1 = '" . $this->db->escape($value['meta_h1']) . "', 
				meta_title = '" . $this->db->escape($value['meta_title']) . "', 
				meta_description = '" . $this->db->escape($value['meta_description']) . "', 
				meta_keyword = '" . $this->db->escape($value['meta_keyword']) . "'
				WHERE tag_id=".(int)$tag_id." AND language_id=" . (int)$language_id . "
			";
			$this->db->query($query);
		}
		return $tag_id;
	}

	public function deleteTag($tag_id)
	{
		$this->db->query("DELETE FROM " . DB_PREFIX . "blogtagsmgr_tag WHERE tag_id = '" . (int)$tag_id . "'");
		$this->db->query("DELETE FROM " . DB_PREFIX . "blogtagsmgr_tag_description WHERE tag_id = '" . (int)$tag_id . "'");

		return true;
	}
}
 ?>