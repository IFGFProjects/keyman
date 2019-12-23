<?php 
class ModelHcvFunctions extends Model {

	public function addVariable($data)
	{
		$sql="INSERT IGNORE INTO ".DB_PREFIX."hcv_variable SET ";
		if (isset($data['fields']))
			foreach ($data['fields'] as $fname => $fvalue) 
				{$sql.="`$fname`='".$this->db->escape($fvalue)."',";}
			$sql=trim($sql,',');
		return $this->db->query($sql);
	}

	public function updateVariable($var_id,$data)
	{
		$sql="UPDATE ".DB_PREFIX."hcv_variable SET ";
		foreach ($data as $fname => $fvalue) 
			{$sql.="`$fname`='".$this->db->escape($fvalue)."',";}
		$sql=trim($sql,',')." WHERE `variable_id`=".(int)$var_id;
		return $this->db->query($sql);
	}

	public function getVariables($data=array())
	{
		$sql="SELECT * FROM ".DB_PREFIX."hcv_variable WHERE 1 ";

		if (isset($data['tab']))
			{$sql.=" AND `tab_name`='".$this->db->escape($data['tab'])."' ";}

		if (isset($data['variable_id']))
			{$sql.=" AND `variable_id`=".$data['variable_id'];}

		if (isset($data['deny_tabs']))
			{$sql.=" AND `tab_name` NOT IN (".$data['deny_tabs'].") ";}

		if (isset($data['filter_status']))
			{$sql.=" AND status=".$data['filter_status'];}

		if (isset($data['sort']))
			{$sql.=" ORDER BY `".$data['sort']."` ";}
		else 
			{$sql.=" ORDER BY `sort_order` ";}

		if (isset($data['order']))
			{$sql.=strtoupper($data['order']);}
		else 
			{$sql.=" ASC";}

		$query=$this->db->query($sql);
		return $query->rows;
	}

	public function getTypes()
	{
		$res=array();
		foreach (scandir(DIR_APPLICATION."/model/hcv/fields/") as $key => $value)
		{
			if (strpos($value, ".php"))
		 		{$res[]=str_replace(".php", "", $value);}
		}
		return $res;
	}
}
?>