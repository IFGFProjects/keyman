<?php 
class ModelModuleBitProApi extends Model {

	private $msdb=0;
	private $serverName = "usn.bitpro.by";
	private $port="14338";
	private $connectionInfo = array( "Database"=>"bitpro1040", "UID"=>"bitpro1040", "PWD"=>"jd-afe1979");

	function index() 
	{
		$conn=mssql_connect($this->serverName. ':' . $this->port, $this->connectionInfo['UID'], $this->connectionInfo['PWD']);
		if( $conn === false ) 
			{die( print_r( sqlsrv_errors(), true));}
		mssql_select_db($this->connectionInfo['Database'], $conn);
		mssql_query("SET ANSI_NULLS ON");
		mssql_query("SET ANSI_WARNINGS ON");
		$this->msdb=$conn;
	}


	public function AddClient($data)
	{
		$this->query("insert into Bitpro1040L...predpr(UNP,NamePred,JurAdress,postAdress,Mail,phone,osnrs,KontrTipe,Nerez,FioFl,Passport,PredprDiscount,klbarcode,Year_of_birth,Sellflag,codedrdb) 
  values(0,'".iconv("UTF-8", "cp1251", $data['@fio'])."','".iconv("UTF-8", "cp1251", $data['@AdressPropiski'])."','".iconv("UTF-8", "cp1251", $data['@postAdress'])."','".iconv("UTF-8", "cp1251", $data['@Mail'])."','".iconv("UTF-8", "cp1251", $data['@phone'])."',0,3,0,'".iconv("UTF-8", "cp1251", $data['@fio'])."','',0,'".iconv("UTF-8", "cp1251", $data['@klbarcode'])."',".$data['@Year_of_birth'].",0,".$data['@siteid'].")");
		$this->SetDiscount($data['@siteid']);
	}

	public function EditClient($data)
	{
		$this->query("Update Bitpro1040L...predpr
  						Set NamePred='".iconv("UTF-8", "cp1251", $data['@fio'])."',
  							JurAdress='".iconv("UTF-8", "cp1251", $data['@AdressPropiski'])."',
  						    postAdress='".iconv("UTF-8", "cp1251", $data['@postAdress'])."',
  						    Mail='".iconv("UTF-8", "cp1251", $data['@Mail'])."',
  						    phone='".iconv("UTF-8", "cp1251", $data['@phone'])."',
  						    FioFl='".iconv("UTF-8", "cp1251", $data['@fio'])."',
  						    klbarcode='".iconv("UTF-8", "cp1251", $data['@klbarcode'])."',
  						    Year_of_birth=".iconv("UTF-8", "cp1251", $data['@Year_of_birth']).",
  						    Sellflag=0
  						Where Codedrdb=".iconv("UTF-8", "cp1251", $data['@siteid'])
  		);
  		$this->SetDiscount($data['@siteid']);
	}

	public function RecheckDiscount()
	{
		$clients=$this->select_proc("Clients_toRecheck_discount");
		foreach ($clients as $ckey => $client) 
			{$this->SetDiscount($client['siteid'],$client['total_amnt']);}
	}


	public function SetDiscount($client_id, $amount=0)
	{
		$this->load->model("module/buydiscount");
		$cl_disc=0;
		if ($amount==0)
			{$cl_disc=$this->model_module_buydiscount->GetClientDiscount($client_id);}

		$res=$this->select_proc("Client_set_discount",array("@siteid"=>$client_id, "@PredprDiscount"=>$cl_disc));
		return $res;
	}

	public function GetDiscountByCoupon($coupon_id)
	{
		$cl_id=$this->GetClientByCoupon($coupon_id);
		return $this->GetClientTotal($cl_id);
	}


	public function GetClientByCoupon($coupon_id)
	{
		$res=$this->select_proc("Clients");
		$client_id=0;
		foreach ($res as $key => $value)
		{
			if ($value['klbarcode']==$coupon_id)
				{$client_id=$value['siteid'];}
		}
		return $client_id;
	}

	public function GetClientTotal($client_id)
	{
		$cust=$this->db->query("SELECT add_amount, custom_field FROM customer WHERE customer_id=$client_id");		
		$add_amount=0;
		$card="";
		if ($cust->num_rows>0)
		{
			$card=json_decode($cust->row['custom_field'],true);
			if(isset($card[1])){
				$card=$card[1];	
			}
			$add_amount=$cust->row['add_amount'];
		}


		$res=$this->select_proc("Prodaji_total_ByClient",array("@Siteid"=>$client_id));
		$total=0;
		if (isset($res[0]['total_amnt']))
			{$total=(float)$res[0]['total_amnt'];}
		
		return $total+$add_amount;
	}


	public function GetProductHistory($client_id)
	{
		$products=$this->select_proc("Prodaji_ByClient",array("@Siteid"=>$client_id));
		$res=array();
		if (count($products)>0)
		{

			$prods_query="SELECT product_id FROM product_option_value WHERE map_id IN (";
			foreach ($products as $key => $value)
				{$prods_query.=" '".$value['idproduct']."',";}
			$prods_query=trim($prods_query,",")." ) GROUP BY product_id";
			unset($products);
			$products=$this->db->query($prods_query);
			foreach ($products->rows as $key => $value) {
				array_push($res, $value['product_id']);
			}
		}
		return $res;
	}

	function select_proc($proc_name, $param_array=array())
	{
		if ($this->msdb==0)
			{$this->index();}
		$response=array();
		$stmt = mssql_init($proc_name,$this->msdb);
		if (count($param_array)>0)
		
		foreach ($param_array as $name => $value)
		{
			$type=SQLVARCHAR;
			// if ($name=="@PredprDiscount")
			// 	{$type=SQLMONEY;}
			if ( ($name=="@siteid") || ($name=="@Year_of_birth"))
				{$type=SQLINT1;}
			mssql_bind($stmt, $name, $value, $type, false, false);
		}
		
		$res=mssql_execute($stmt);
		if (is_resource($res))
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

	function query($qu_str)
	{
		$conn=mssql_connect($this->serverName. ':' . $this->port, $this->connectionInfo['UID'], $this->connectionInfo['PWD']);
		if( $conn === false ) 
			{die( print_r( sqlsrv_errors(), true));}
		mssql_select_db($this->connectionInfo['Database'], $conn);
		mssql_query("SET ANSI_NULLS ON");
		mssql_query("SET ANSI_WARNINGS ON");

		$res=array();
		$q=mssql_query($qu_str);
		if (is_resource($q)) 
		{
			while ($row = mssql_fetch_assoc($q)) 
				{$res[]=$row;}
		}

		mssql_free_result($q);
		return $res;
	}

}	

 ?>