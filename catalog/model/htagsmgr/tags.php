<?php 
class ModelHtagsmgrTags extends Model {
	public function getTags($data=array())
	{
		$language_filter="";
		if (!isset($data['language_id']))
			{$language_filter=" AND td.language_id=".(int)$this->config->get('config_language_id')." ";$language_id=(int)$this->config->get('config_language_id');}
		else 
			{$language_filter=" AND td.language_id=".(int)$data['language_id']." ";$language_id=(int)$data['language_id'];}

		$status_filter="";
		if (isset($data['status']))
			{$status_filter=" AND tg.status=".(int)$data['status']." ";}

		$menu_filter="";
		if (isset($data['menu_show']))
			{$menu_filter=" AND tg.menu_show=".(int)$data['menu_show']." ";}

		$id_filter="";
		if (isset($data['tag_id']))
			{$id_filter=" AND tg.tag_id=".(int)$data['tag_id']." ";}

		$tag_name_filter="";
		if (isset($data['tag_name']))
			{$tag_name_filter=" AND tg.tag_name='".$this->db->escape($data['tag_name'])."' ";}

		$category_filter="";
		if (isset($data['category_id']))
			{$category_filter=" AND cat.category_id=".(int)$data['category_id']." ";}

		$limit_fiter="";
		if ( (isset($data['start'])) && (isset($data['limit'])) )
			{$limit_fiter=" \nLIMIT ".$data['start'].", ".$data['limit']." ";}

		$sort_filter="";
		if ( (isset($data['sort'])) && (isset($data['order'])) )
			{$sort_filter="\n ORDER BY ".$data['sort']." ".$data['order']." ";}

		$tags_main=$this->db->query("
			SELECT tg.tag_id, tg.tag_name as `name`, tg.category_id, cat.name as category_name, tg.link, tg.status
			FROM ".DB_PREFIX."htagsmgr_tag as tg
			JOIN ".DB_PREFIX."category_description as cat ON cat.category_id=tg.category_id AND cat.language_id=$language_id
			WHERE 1 
			$status_filter
			$menu_filter
			$id_filter
			$tag_name_filter
			$category_filter
			$sort_filter
			$limit_fiter
		");

		$tags_description="
			SELECT td.* 
			FROM ".DB_PREFIX."htagsmgr_tag as tg
			JOIN ".DB_PREFIX."htagsmgr_tag_description as td ON tg.tag_id=td.tag_id
			WHERE 1
			$language_filter
			$status_filter
			$id_filter
			$tag_name_filter
		";
		$tags_description=$this->db->query($tags_description);
		$tags_descriptions=array();
		foreach ($tags_description->rows as $tdkey => $tag_descr)
			{$tags_descriptions[$tag_descr['tag_id']][$tag_descr['language_id']]=$tag_descr;}

		$tags=array();
		foreach ($tags_main->rows as $tgkey => $tag_info) 
		{
			$tags[$tag_info['tag_id']]=$tag_info;
			if (isset($tags_descriptions[$tag_info['tag_id']]))
				{$tags[$tag_info['tag_id']]=array_merge($tags[$tag_info['tag_id']],end($tags_descriptions[$tag_info['tag_id']]));}
				// {$tags[$tag_info['tag_id']]['tag_description']=$tags_descriptions[$tag_info['tag_id']];}
			// $tags[$tag_info['tag_id']]['edit_link']=$this->url->link("module/htagsmgr/edit",'token=' . $this->session->data['token']."&tag_id=".$tag_info['tag_id'],"SSL");
			// $tags[$tag_info['tag_id']]['href_shop']= HTTP_CATALOG . 'index.php?route=module/htagsmgr&tag_id=' . ($tag_info['tag_id']);
		}

		return $tags;
	}

	public function getTagById($tag_id)
	{
		$result=$this->getTags(array("tag_id"=>$tag_id));
		return $result[$tag_id];
	}

	public function getTagByNameAndCategory($tag_name,$category_id)
	{
		$result=$this->getTags(array("tag_name"=>$tag_name,"category_id"=>$category_id));
		return end($result);
	}
}
 ?>