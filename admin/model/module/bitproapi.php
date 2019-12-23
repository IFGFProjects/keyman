<?php 
class ModelModuleBitProApi extends Model {

	private $msdb=0;
	private $serverName = "usn.bitpro.by";
	private $port="14338";
	private $connectionInfo = array( "Database"=>"bitpro1040", "UID"=>"bitpro1040", "PWD"=>"jd-afe1979");

	function index() 
	{
		// $this->serverName = "usn.bitpro.by"; //serverName\instanceName
		// $this->port="14338";
		// $this->connectionInfo = array( "Database"=>"bitpro1040", "UID"=>"bitpro1040", "PWD"=>"jd-afe1979");
		$conn=mssql_connect($this->serverName. ':' . $this->port, $this->connectionInfo['UID'], $this->connectionInfo['PWD']);
		if( $conn === false ) 
			{die( print_r( sqlsrv_errors(), true));}
		mssql_select_db($this->connectionInfo['Database'], $conn);
		mssql_query("SET ANSI_NULLS ON");
		mssql_query("SET ANSI_WARNINGS ON");
		$this->msdb=$conn;
	}

	public function GetCustomers($from_id=2180)
	{
		$buf_size=100;
		$max_id=$this->query("select max(idpred) as max_id from Bitpro1040L...predpr");
		$max_id=$max_id[0]['max_id'];


		$result=array();
		for ($i=0; $i < ceil(($max_id-$from_id)/$buf_size) ; $i++) { 
			$cust=$this->query("select
					idpred,
				 	NamePred,
				 	JurAdress,
				 	postAdress,
				 	Mail,
				 	phone,
				 	FioFl,
				 	klbarcode,
				 	DateOfBirth
				 from Bitpro1040L...predpr 
				 where idpred BETWEEN ".($from_id+($i*$buf_size))." and ".($from_id+(($i+1)*$buf_size))."
			 ");

			foreach ($cust as $ckey => $customer) {
				$fname=explode(" ", trim(str_replace("  ", " ", iconv("cp1251", "UTF-8", $customer['NamePred'] ))));
				$lname=isset($fname[1])?$fname[1]:'';
				$fname=isset($fname[0])?$fname[0]:'';
				$birthday=date_create_from_format('M d Y *+',$customer['DateOfBirth']);
				$result[]=array(
					'customer_group_id' =>1,
					'firstname'=>$fname,
					'lastname'=>$lname,
					'email'=>iconv("cp1251", "UTF-8", $customer['Mail']),
					'telephone'=>$customer['phone'],
					'fax' =>'',
					'custom_field'=>array(
						'1'=>$customer['klbarcode'],
						'6'=>$birthday->format("Y-m-d")
					),
					'newsletter'=>1,
					'password'=>$customer['klbarcode'],
					'status'=>1,
					'approved'=>1,
					'add_amount'=>0,
					'safe'=>0,

					// 'address'=>iconv("cp1251", "UTF-8", $customer['JurAdress']),
					// 'post_address'=>iconv("cp1251", "UTF-8", $customer['postAdress']),
					// 'card'=>$customer['klbarcode'],
					// 'birthday'=>$customer['DateOfBirth']
					'bitpro_id'=>$customer['idpred']
				);
			}
			break;
		}
		return $result;
	}

	public function LoadNewCustomers()
	{
		$this->load->model('customer/customer_new');
		$max=$this->db->query("SELECT max(bitpro_id) as max_id FROM " . DB_PREFIX . "customer_new ");
		echo "<h1 style='color:red;'>max :</h1><pre>";print_r($max);echo "</pre><hr>";
		foreach ($this->GetCustomers(intval($max->row['max_id'])+1) as $ckey => $customer_data) {
			$new=$this->model_customer_customer_new->addCustomer($customer_data);
			echo "<h1 style='color:red;'>customer_added :</h1><pre>";print_r($customer_data);echo "</pre><hr>";
		}
	}


		public function AddClient($data)
		{
			$this->query("insert into Bitpro1040L...predpr(UNP,NamePred,JurAdress,postAdress,Mail,phone,osnrs,KontrTipe,Nerez,FioFl,Passport,PredprDiscount,klbarcode,DateOfBirth,Sellflag,codedrdb) 
	  values(0,'".iconv("UTF-8", "cp1251", $data['@fio'])."','".iconv("UTF-8", "cp1251", $data['@AdressPropiski'])."','".iconv("UTF-8", "cp1251", $data['@postAdress'])."','".iconv("UTF-8", "cp1251", $data['@Mail'])."','".iconv("UTF-8", "cp1251", $data['@phone']).
	  	"',0,3,0,'".iconv("UTF-8", "cp1251", $data['@fio'])."','',0,'".iconv("UTF-8", "cp1251", $data['@klbarcode'])."',CAST('".iconv("UTF-8", "cp1251", $data['@Year_of_birth'])."' AS datetime),0,".$data['@siteid'].")");
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
	  						    DateOfBirth=CAST('".iconv("UTF-8", "cp1251", $data['@Year_of_birth'])."' AS datetime),
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
			$this->load->model("module/hbuydiscount");
			$cl_disc=0;
			if ($amount==0)
				{$cl_disc=$this->model_module_hbuydiscount->GetClientDiscount($client_id);}
			$res=$this->query("  Update Bitpro1040L...predpr
			  Set PredprDiscount=CAST('".$cl_disc."' as money),
			      Sellflag=0
			  Where CodeDrDb=".$client_id);
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

	public function GetClientTotal($client_id, $update_flag=false)
	{
		$cache_client=$this->cache->get('GetClientTotal_cache');
		if ( ($update_flag) || (!isset($cache_client[$client_id])) )
		{
			// echo "<h1 style='color:red;'>DATA :</h1><pre>";print_r($this->select_proc("Prodaji_total"));echo "</pre><hr>";
			$res=$this->select_proc("Prodaji_total_ByClient",array("@Siteid"=>$client_id));
			// echo "<h1 style='color:red;'>$client_id :</h1><pre>";print_r($res);echo "</pre><hr>";
			$add_amount=$this->db->query("SELECT add_amount FROM customer WHERE customer_id=$client_id LIMIT 1");		
			// $res=0;
			// echo "<h1 style='color:red;'>res :</h1><pre>";print_r($res);echo "</pre><hr>";
			if (isset($res[0]['total_amnt']))
				{$res= (float)$res[0]['total_amnt']+$add_amount->row['add_amount'];}
			else 
				{$res= $add_amount->row['add_amount'];}
			$cache_client[$client_id]=$res;
			$this->cache->set('GetClientTotal_cache',$cache_client);
		}
		return $cache_client[$client_id];
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
				array_push($rows, $value['product_id']);
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
			if ( ($name=="@Siteid") || ($name=="@siteid") || ($name=="@Year_of_birth"))
				{$type=SQLINT2;$value=(int)$value;}
			mssql_bind($stmt, $name, $value, $type, false, false);
		}

		// echo "<h1 style='color:red;'>DATA :</h1><pre>";print_r(mssql_bind($stmt, $name, $value, $type, false, false));echo "</pre><hr>";
		// echo "<h1 style='color:red;'>stmt :</h1><pre>";print_r($stmt);echo "</pre><hr>";
		$res=mssql_execute($stmt);
		// echo "<h1 style='color:red;'>param_array :</h1><pre>";print_r($param_array);echo "</pre><hr>";
		// echo "<h1 style='color:red;'>$proc_name -".mssql_num_rows($res)." :</h1><pre>";print_r(mssql_fetch_assoc($res));echo "</pre><hr>";
		
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
			mssql_free_result($q);
		}
		return $res;
	}
}	

 ?>