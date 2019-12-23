<?php 
class ModelModuleCatBrandInfo extends Model {

	public function add_cbinfo($category_id, $brand_id, $text)
	{
		$this->db->query("INSERT INTO catbrandinfo SET category_id=$category_id, brand_id=$brand_id, `text`='".$this->db->escape($text)."' ");
		return $this->db->getLastId();
	}

	public function edit_cbinfo($cbid, $category_id, $brand_id, $text)
	{
		$this->db->query("UPDATE catbrandinfo SET category_id=$category_id, brand_id=$brand_id, `text`='".$this->db->escape($text)."' WHERE `id`=$cbid");
		// die("UPDATE catbrandinfo SET category_id=$category_id, brand_id=$brand_id, `text`='".$this->db->escape($text)."' WHERE `id`=$cbid");
	}



	public function delete_cbinfo($cbid)
	{
		$this->db->query("DELETE FROM catbrandinfo WHERE `id`=$cbid");
	}

	public function get_cbinfo($cbid)
	{
		$res=$this->db->query("SELECT cb.*, cat.`name` as category, man.`name` as brand FROM catbrandinfo as cb 
			JOIN category_description as cat ON cat.category_id=cb.category_id
			JOIN manufacturer as man ON man.manufacturer_id=cb.brand_id
		WHERE cb.`id`=$cbid");
		return $res->row;
	}

	public function get_cbinfo_list()
	{
		$res=$this->db->query("SELECT cb.*, cat.`name` as category, man.`name` as brand FROM catbrandinfo as cb 
			JOIN category_description as cat ON cat.category_id=cb.category_id
			JOIN manufacturer as man ON man.manufacturer_id=cb.brand_id");
		return $res->rows;
	}

}
 ?>