<?php 
class ModelBlogtagsmgrSeoUrl extends Model {
	public function GetTagByUrl()
	{
		if (!isset($this->request->get['_route_']))
			{return false;}
		$matches=array();
		preg_match("/^(.*)\/tag\/(.*)$/", $this->request->get['_route_'],$matches);
		if (count($matches)<3)
			{return false;}
		$tag_info=$this->db->query("SELECT * FROM ".DB_PREFIX."blogtagsmgr_tag WHERE `link`='".$this->db->escape(trim($matches[2],'/'))."' AND status>0");
		// echo "<h1 style='color:red;'>DATA :</h1><pre>";print_r("SELECT * FROM ".DB_PREFIX."blogtagsmgr_tag WHERE `link`='".$this->db->escape(trim($matches[2],'/'))."' AND status=0");echo "</pre><hr>";
		// echo "<h1 style='color:red;'>tag_info :</h1><pre>";print_r($tag_info);echo "</pre><hr>";
		// echo "<h1 style='color:red;'>matches :</h1><pre>";print_r($matches);echo "</pre><hr>";
		if ($tag_info->num_rows>0)
			{$this->request->get['tag']=$tag_info->row['tag_name'];}  ///----- FOUND IN BASE
		else 
			{$this->request->get['tag']=$matches[2];} //----- FILL AS IT IS
		$this->request->get['_route_']=$matches[1];
		return true;
	}

	public function rewriteCategory(&$data,$route,&$url)
	{
		if ( (isset($data['tag'])) && ($route=="pavblog/category") )
		{
			$tag_info=$this->db->query("SELECT tg . * , url.keyword AS category_url
				FROM ".DB_PREFIX."blogtagsmgr_tag AS tg
				LEFT JOIN ".DB_PREFIX."url_alias AS url ON url.`query` = CONCAT(  'pavblog/category=', tg.category_id ) 
				WHERE tg.tag_name =  '".$this->db->escape($data['tag'])."' AND tg.`status` >0 LIMIT 1");
			if ($tag_info->num_rows>0)
			{
				unset($data['tag']);
				if ($tag_info->row['category_url']<>NULL)
					{$url="/".$tag_info->row['category_url']."/tag/".$tag_info->row['link'];}
				else
					{$url.="/tag/".$tag_info->row['link'];}
			}
		}
		return true;
	}
}
 ?>