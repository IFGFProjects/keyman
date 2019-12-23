<?php
class ModelLocalisationLocation extends Model {
	public function getLocation($location_id) {
		$query = $this->db->query("SELECT location_id, name, address, geocode, telephone, fax, image, open, comment FROM " . DB_PREFIX . "location WHERE location_id = '" . (int)$location_id . "'");

		return $query->row;
	}

	public function getLocations() {
		$query = $this->db->query("SELECT location_id, name, address, geocode, telephone, fax, image, open, comment FROM " . DB_PREFIX . "location");
		$locs=$this->config->get("config_location");
		// echo "<h1 style='color:red;'>locs :</h1><pre>";print_r($locs);echo "</pre><hr>";
		$res=array();
		foreach ($query->rows as $qkey => $qvalue) 
		{
			foreach ($locs as $l_id) 
			{
				if ($qvalue['location_id']==$l_id)
					{$res[]=$qvalue;}
			}
		}
		return $res;
	}
}