<?php
class ControllerModuleBitproSync extends Controller {
	

	private $msdb;
	private $ost_array=array();
	private $price_array=array();
	public function index() 
	{
		$serverName = "usn.bitpro.by"; //serverName\instanceName
		$port="14338";
		$connectionInfo = array( "Database"=>"bitpro1040", "UID"=>"bitpro1040", "PWD"=>"jd-afe1979");
		$conn=mssql_connect($serverName. ':' . $port, $connectionInfo['UID'], $connectionInfo['PWD']);
		if( $conn === false ) 
			{die( print_r( sqlsrv_errors(), true));}
		mssql_select_db($connectionInfo['Database'], $conn);
		mssql_query("set ANSI_NULLS ON");
		mssql_query("SET ANSI_WARNINGS ON");
		$this->msdb=$conn;

		$ost_updates=array();
		$this->MapCategories();
		$i=0;
		foreach ($this->select_proc("ProductList") as $key => $prod) 
		{
			// echo "<h1 style='color:red;'>$key :</h1><pre>";print_r($prod);echo "</pre><hr>";die();
			$int_pid=$this->db->query("SELECT product_id FROM product WHERE map_id='".iconv("cp1251", "utf8",$prod['art'])."' OR sku='".iconv("cp1251", "utf8",$prod['art'])."'");
			if (isset($int_pid->row['product_id']))
			{
				$product_id=$int_pid->row['product_id'];
			} else {
				//-----------  Добавить товар -----------
				$real_articul=iconv("cp1251", "utf8",$prod['art']);
				$manufacturer=$this->Manufacturer_id(iconv("cp1251", "utf8",$prod['trademark']));

				

				$this->db->query("INSERT INTO product SET model='$real_articul', sku='$real_articul', map_id='$real_articul', shipping=0,  subtract=1,  manufacturer_id=$manufacturer");
				
				$product_id=$this->db->getLastId();

				$this->db->query("INSERT INTO product_description SET product_id=$product_id, language_id=2, `name`='".iconv("cp1251", "utf8",$prod['ProductName'])."', `meta_title`='".iconv("cp1251", "utf8",$prod['ProductName'])."'");				

				$this->db->query("INSERT INTO product_to_store SET product_id=$product_id, store_id=0");

				$this->db->query("INSERT INTO product_option SET product_id=$product_id, option_id=13");

				//--------- Привязать к категории 
				$catid=$this->db->query("SELECT category_id, parent_id FROM category WHERE map_id='".iconv("cp1251", "utf8",$prod['idgr'])."'");
				if (isset($catid->row['category_id']))
				{
					$this->db->query("INSERT INTO product_to_category SET product_id=$product_id, category_id=".$catid->row['category_id']);
					$this->db->query("INSERT INTO product_to_category SET product_id=$product_id, category_id=".$catid->row['parent_id']);
				}


			}

			$buh_int_id=(int)iconv("cp1251", "utf8",$prod['idProduct']);
			if (!isset($ost_updates[$product_id]))
				{$ost_updates[$product_id]=$this->db->query("UPDATE product_option_value SET quantity=0 WHERE product_id=".$product_id);}
			if ( ($buh_int_id>0) && (iconv("cp1251", "utf8",$prod['productsize'])!="") )
			{
				$this->ProductSizeID($product_id,iconv("cp1251", "utf8",$prod['productsize']),$buh_int_id);
				$this->UpdateOst($buh_int_id);
				$this->UpdatePrice($product_id,$buh_int_id);
			}
			$i++;
			// echo "<h1 style='color:red;'>prod :</h1><pre>";print_r($prod);echo "</pre><hr>";
			// if ($i>10) break;
		}
			// die("<hr>DONE");
		// echo "<hr>DONE";
		$this->response->redirect($this->url->link('catalog/product', 'token=' . $this->session->data['token'], 'SSL'));
	}



	function ProductSizeID($product_id,$size_name,$buh_id)
	{		
		// $prod_size_id_q=$this->db->query("SELECT product_option_value_id FROM product_option_value WHERE product_id=$produ `name`='$size_name'");
		// // echo "<h1 style='color:red;'>prod_size_id_q :</h1><pre>";print_r($prod_size_id_q);echo "</pre><hr>";
		// if (isset($prod_size_id_q->row['product_option_value_id']))
		// {
		// 	$product_size_id=$prod_size_id_q->row['product_option_value_id'];
		// } else 
		// { id=124, size=50
			//----------- Добавляем размер товару
			$size_id_q=$this->db->query("SELECT option_value_id FROM option_value_description WHERE option_id=13 AND `name`='$size_name'");
			if ($size_id_q->num_rows>0)
			{
				$size_id=$size_id_q->row['option_value_id'];
			} else {
				//---------- Создаём такой размер в опции
				$this->db->query("INSERT INTO option_value SET option_id=13");
				$opt_id=$this->db->getLastId();
				$this->db->query("INSERT INTO option_value_description SET option_value_id=$opt_id, language_id=2, option_id=13, `name`='$size_name'");
				$size_id=$this->db->getLastId();
			}
			//$size_id=9

			//-----  Проверяем таблицу product_option на предмет наличия размера
			$po_id=$this->db->query("SELECT product_option_id FROM product_option WHERE product_id=$product_id AND option_id=13");
			if ($po_id->num_rows>0) 
			{
				$po_id=$po_id->row['product_option_id'];
				
			} else {
				$this->db->query("INSERT INTO product_option SET product_id=$product_id , option_id=13");
				$po_id=$this->db->getLastId();
			}
			//po_id=55


			//----- Проверяем таблицу product_option_value на предмет наличия ИМЕННО ТАКОГО размера
			$pov_id=$this->db->query("SELECT product_option_value_id, map_id FROM product_option_value WHERE 
				product_option_id=$po_id AND
				product_id=$product_id AND
				option_id=13 AND 
				option_value_id=$size_id");
			if ($pov_id->num_rows>0) 
			{
				if ($pov_id->row['map_id']!=$buh_id)
					{$this->db->query("UPDATE product_option_value SET map_id=$buh_id WHERE product_option_value_id=".$pov_id->row['product_option_value_id']);}
				$product_size_id=$pov_id->row['product_option_value_id'];
				
			} else {
				
				$this->db->query("INSERT INTO product_option_value SET 
				product_option_id=$po_id,
				product_id=$product_id,
				option_value_id=$size_id,
				option_id=13,
				subtract=1,
				map_id='$buh_id'
			");

			$product_size_id=$this->db->getLastId();
			}
		// }
		return $product_size_id;
	}

	function UpdateOst($product_id=0)
	{
		if (count($this->ost_array)<1)
		{
			$ost_all=$this->select_proc("ProductsOst",array("@idsklad"=>1));
			foreach ($ost_all as $key => $value) 
				{$this->ost_array[$value['idproduct']]=$value['ost'];}
		}

		if ( ($product_id>0) && (isset($this->ost_array[$product_id])) ) 
		{
			$this->db->query("UPDATE product_option_value SET quantity=".$this->ost_array[$product_id]." WHERE map_id=".$product_id);
		}
	}

	function UpdatePrice($product_id=0, $bitpro_id=0)
	{
		if (count($this->price_array)<1)
		{
			$ost_all=$this->select_proc("Prise");
			foreach ($ost_all as $key => $value) 
				{$this->price_array[$value['idproduct']]=$value['roznprise'];}
		}

		if ( ($product_id>0) && ($bitpro_id>0) && (isset($this->price_array[$bitpro_id])) ) 
		{
			$this->db->query("UPDATE product SET price=".$this->price_array[$bitpro_id]." WHERE product_id=".$product_id);
		}
	}


	function MapCategories()
	{
		foreach ($this->select_proc("Products_group") as $key => $cat) 
		{
			$this->db->query("UPDATE category SET map_id='".$cat['idpGroup']."' WHERE category_id=(SELECT category_id FROM category_description WHERE LOWER(`name`)=LOWER('".iconv("cp1251", "utf8",$cat['NameGroup'])."') LIMIT 1)");
		}		
	}

	function Manufacturer_id($brand_name)
	{
		$tmp=$this->db->query("SELECT manufacturer_id FROM manufacturer WHERE LOWER(`name`)=LOWER('$brand_name') LIMIT 1");
		if (isset($tmp->row['manufacturer_id']))
			{$man_id=$tmp->row['manufacturer_id'];}
		else 
		{
			//------------- Добавить Производителя
			$this->db->query("INSERT INTO manufacturer SET `name`='$brand_name', sort_order=0");
			$man_id=$this->db->getLastId();
			$this->db->query("INSERT INTO manufacturer_to_store SET manufacturer_id='$man_id', store_id=0");
		}
		return $man_id;
	}


	public function RecheckDiscount()
	{
		$this->load->model("module/bitproapi");
		$this->model_module_bitproapi->RecheckDiscount();
		$this->response->redirect($this->url->link('catalog/product', 'token=' . $this->session->data['token'] . $url, 'SSL'));
	}


	function select_proc($proc_name, $param_array=array())
	{
		$response=array();
		$stmt = mssql_init($proc_name,$this->msdb);
		if (count($param_array)>0)
		
		foreach ($param_array as $name => $value)
			{mssql_bind($stmt, $name, $value, SQLVARCHAR);}
		
		$res=mssql_execute($stmt);
		if (mssql_num_rows($res)) 
		{
			while ($row = mssql_fetch_assoc($res)) 
			{
			    $response[]=$row;
			}
		}
		mssql_free_statement($stmt);
		return $response;
	}


}
?>