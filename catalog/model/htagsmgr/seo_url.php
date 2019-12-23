<?php 
class ModelHtagsmgrSeoUrl extends Model {
	public function GetTagByUrl()
	{
		if (!isset($this->request->get['_route_']))
			{return false;}
		$matches=array();
		preg_match("/^(.*)\/tags\/(.*)$/", $this->request->get['_route_'],$matches);
		if (count($matches)<3)
			{return false;}
		$tag_info=$this->db->query("SELECT * FROM ".DB_PREFIX."htagsmgr_tag WHERE `link`='".$this->db->escape(trim($matches[2],'/'))."' AND status>0");
		// echo "<h1 style='color:red;'>DATA :</h1><pre>";print_r("SELECT * FROM ".DB_PREFIX."htagsmgr_tag WHERE `link`='".$this->db->escape(trim($matches[2],'/'))."' AND status=0");echo "</pre><hr>";
		// echo "<h1 style='color:red;'>tag_info :</h1><pre>";print_r($tag_info);echo "</pre><hr>";
		// echo "<h1 style='color:red;'>matches :</h1><pre>";print_r($matches);echo "</pre><hr>";
		if ($tag_info->num_rows>0)
			{$this->request->get['tag']=$tag_info->row['tag_name'];}  ///----- FOUND IN BASE
		else 
			{$this->request->get['tag']=$matches[2];} //----- FILL AS IT IS
		$this->request->get['_route_']=$matches[1];
		return true;
	}

	public function rewriteCategory(&$data,$route,&$url,$cat=false)
	{
		if ( (isset($data['tag'])) && ($route=="product/category") )
		{
			// echo "<h1 style='color:red;'>DATA :</h1><pre>";print_r($cat);echo "</pre><hr>";

			$sql="SELECT * FROM ".DB_PREFIX."htagsmgr_tag WHERE `tag_name`='".$this->db->escape($data['tag'])."' AND status>0";
			if ($cat)
				{$sql.=" AND `category_id`=".$cat;}
			$tag_info=$this->db->query($sql);
			// echo "<h1 style='color:red;'>DATA [".$this->db->escape($data['tag'])."] <br> $sql :</h1><pre>";print_r($tag_info);echo "</pre><hr>";
			// echo "<h1 style='color:red;'>tag_info :</h1><pre>";print_r($tag_info);echo "</pre><hr>";
			if ($tag_info->num_rows>0)
			{
				unset($data['tag']);
				$url.="/tags/".$tag_info->row['link'];
			}
		}
		return true;
	}
}
 ?>