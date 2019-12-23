<?php 
class ModelModuleHAltMeta extends Model {
	public $alt_meta=array();

	function __construct($data)
	{
		parent::__construct($data);
		$res=$this->db->query("SELECT * FROM ".DB_PREFIX."haltmeta WHERE `link`='".trim($_SERVER['REQUEST_URI'],"/")."' OR `seo_url`='".trim($_SERVER['REQUEST_URI'],"/")."' AND `status`=1 LIMIT 1");
		if ($res->num_rows>0)
			{$this->alt_meta=$res->row;}
	}

	public function getTitle()
	{
		if (isset($this->alt_meta['meta_title']))
		{
			if ($this->alt_meta['meta_title']!="")
				{return $this->alt_meta['meta_title'];}
			else
				{return $this->document->getTitle();}
		}
		else
			{return $this->document->getTitle();}
	}

	public function getDescription()
	{
		if (isset($this->alt_meta['meta_description']))
		{
			if ($this->alt_meta['meta_description']!="")
				{return $this->alt_meta['meta_description'];}
			else
				{return $this->document->getDescription();}
		}
		else
			{return $this->document->getDescription();}
	}

	public function getKeywords()
	{
		if (isset($this->alt_meta['meta_keywords']))
		{
			if ($this->alt_meta['meta_keywords']!="")
				{return $this->alt_meta['meta_keywords'];}
			else
				{return $this->document->getKeywords();}
		}
		else
			{return $this->document->getKeywords();}
	}

	public function addTags()
	{
		if (isset($this->alt_meta['add_tags']))
			{return htmlspecialchars_decode(html_entity_decode($this->alt_meta['add_tags']));}
	}
}
 ?>