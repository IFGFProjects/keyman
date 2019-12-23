<?php 
class ModelHAltMetaHAltMeta extends Model {

	private $main_table="haltmeta";
	private $index_name="altmeta_id";

	private function CustomPrepareField($field_id, $field_data)
	{
		//----- Кастомная обработка полей
		if ( ($field_id=="link") && (strpos($field_data['value'], HTTP_CATALOG)!==false) )
			{$field_data['value']=substr($field_data['value'], strlen(HTTP_CATALOG));}

		if ( ($field_id=="link") && (strpos($field_data['value'], HTTPS_CATALOG)!==false) )
			{$field_data['value']=substr($field_data['value'], strlen(HTTPS_CATALOG));}
		$field_data['value']=trim($field_data['value'],'/');
		return $field_data;
	}

	//----- Обработка полей перед сохранением в базу
	public function prepareField($field_id, $field_data)
	{
		$return="''";
		$field_data=$this->CustomPrepareField($field_id, $field_data);

		//----- Обработка типов
		switch ($field_data['type']) 
		{
			case 'int':
				$return=(int)$field_data['value'];
				break;

			case 'string':
				$return="'".$this->db->escape($field_data['value'])."'";
				break;

			case 'text':
				$return="'".htmlentities($this->db->escape($field_data['value']))."'";
				break;

			case 'date_now':
				$return="NOW()";
				break;
			
			default:
				$field_data['value'];
				break;
		}
		return $return;
	}


	public function insertEntry($data)
	{
		$sql="INSERT IGNORE INTO ".DB_PREFIX.$this->main_table." SET ";
		foreach ($data as $fname => $fvalue) 
		{
			if ($fvalue['insert'])
				{$sql.="`$fname`=".$this->prepareField($fname,$fvalue).",";}
		}
		$sql=trim($sql,',');
		return $this->db->query($sql);
	}

	public function updateEntry($entry_id,$data)
	{
		$sql="UPDATE ".DB_PREFIX.$this->main_table." SET ";
		foreach ($data as $fname => $fvalue) 
		{
			if ($fvalue['update'])
				{$sql.="`$fname`=".$this->prepareField($fname,$fvalue).",";}
		}
		$sql=trim($sql,',')." WHERE `".$this->index_name."`=".(int)$entry_id;
		return $this->db->query($sql);
	}

	public function deleteEntry($entry_id)
		{return $this->db->query("DELETE FROM ".DB_PREFIX.$this->main_table." WHERE `".$this->index_name."`=".(int)$entry_id);}

	private function SQLAddFilters($data=array())
	{
		$sql="";

		if (isset($data['filter_altmeta_id']))
		if ($data['filter_altmeta_id'])
			{$sql.=" AND `altmeta_id`='".$this->db->escape($data['filter_altmeta_id'])."' ";}

		if (isset($data['filter_link']))
		if ($data['filter_link'])
			{$sql.=" AND `link` LIKE '%".$this->db->escape($data['filter_link'])."%' ";}

		return $sql;
	}

	public function getEntry($entry_id,$entry_array)
	{
		$query=$this->db->query("SELECT * FROM ".DB_PREFIX.$this->main_table." WHERE  ".$this->index_name." = ".$entry_id);
		$entry_data=$query->row;

		foreach ($entry_data as $key => $value)
		{
			if (isset($this->request->post[$key]))
				{$entry_data[$key]=$this->request->post[$key];}
		}

		foreach ($entry_array as $field_id => $entry)
		{
			if (isset($entry_data[$field_id]))
			{
				switch ($entry['type']) {
					case 'int':
						$entry_array[$field_id]['value']=(int)$entry_data[$field_id];
						break;
					case 'text':
						$entry_array[$field_id]['value']=html_entity_decode($entry_data[$field_id]);
						break;
					
					default:
						$entry_array[$field_id]['value']=$entry_data[$field_id];
						break;
				}
			}
		}
		return $entry_array;
	}

	public function getEntries($data=array())
	{
		$sql="SELECT * FROM ".DB_PREFIX.$this->main_table." WHERE 1 ";

		$sql.=$this->SQLAddFilters($data);

		if (isset($data['sort']))
			{$sql.=" ORDER BY `".$data['sort']."` ";}
		else 
			{$sql.=" ORDER BY `date_modified` ";}

		if (isset($data['order']))
			{$sql.=strtoupper($data['order']);}
		else 
			{$sql.=" ASC";}

		$sql.=" LIMIT ".$data['start'].",".$data['limit'];

		$query=$this->db->query($sql);
		return $query->rows;
	}

	public function getTotalEntries($data=array())
	{
		$sql = "SELECT COUNT(DISTINCT ".$this->index_name.") AS total FROM " . DB_PREFIX.$this->main_table." WHERE 1 ";
		$sql.=$this->SQLAddFilters($data);
		$query = $this->db->query($sql);
		return $query->row['total'];
	}

	public function GetUrlWithout($data=array())
	{
		$url="";
		if (isset($this->request->get['sort']) && !isset($data['sort']))
			{$url.="&sort=".$this->request->get['sort'];}
		if (isset($this->request->get['order']) && !isset($data['order']))
			{$url.="&order=".$this->request->get['order'];}
		if (isset($this->request->get['page']) && !isset($data['page']))
			{$url.="&page=".$this->request->get['page'];}
		if (isset($this->request->get['limit']) && !isset($data['limit']))
			{$url.="&limit=".$this->request->get['limit'];}

		if (!isset($data['any_filters']))
		foreach ($this->request->get as $key => $var)
		{
			if ( (strpos($key, "filter_")!==false) && (!isset($data[$key])) )
				{$url.="&".$key."=".$var;}
		}
		return $url;
	}
}
?>