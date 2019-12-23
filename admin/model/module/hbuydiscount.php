<?php
class ModelModuleHbuyDiscount extends Model {


public function GetDiscounts()
{
	$res=$this->db->query("SELECT * FROM buydiscount");
	return $res->rows;
}

public function UpdateDiscounts($discounts)
{
	foreach ($discounts as $disc_id => $value)
	{
		$sql="UPDATE buydiscount SET ".
			"from_value='".$value['from_value']."',".
			"to_value='".$value['to_value']."',".
			"discount_percent='".str_replace(",", ".", $value['discount_percent'])."',".
			"status='".$value['status']."' ".
		" WHERE discount_id=$disc_id";
		$this->db->query($sql);		
	}
	return true;
}

public function GetDiscountPercent($amount)
{
	if ($amount==0)
		{return 0;}

	$res=$this->db->query("SELECT discount_percent FROM buydiscount WHERE status=1 AND from_value<".(float)$amount." AND to_value>".(float)$amount);
	// echo "<h1 style='color:red;'>$amount :</h1><pre>";print_r($res);echo "</pre><hr>";
	if (isset($res->row['discount_percent']))
		{return (float)$res->row['discount_percent'];}
	else
	{
		// $max_to=$this->db->query("SELECT d1.to_value, d1.discount_percent as max_to FROM buydiscount as d1
		//							WHERE d1.status=1 AND to_value=( SELECT MAX(to_value) FROM buydiscount as d2 WHERE d2.`status`=1 )");
		$max_to=$this->db->query("SELECT * FROM buydiscount WHERE status=1 ORDER BY from_value DESC LIMIT 1");
		if ( ($amount>=$max_to->row['to_value']) && (isset($max_to->row['discount_percent'])) )
			{return $max_to->row['discount_percent'];}
		else 
			{return 0;}
	}
}

public function DiscountByPrice($amount,$price)
{
	return (float)$price-(float)$price*($this->GetDiscountPercent($amount)/100);
}


public function GetClientDiscount($client_id)
{
	global $loader, $registry;
	$loader->model('module/bitproapi');
	$model = $registry->get('model_module_bitproapi');
	$cl_total = $model->GetClientTotal($client_id);
	return $this->GetDiscountPercent($cl_total);
}



public function GetCouponDiscount($coupon_id)
{
	global $loader, $registry;
	$loader->model('module/bitproapi');
	$model = $registry->get('model_module_bitproapi');
	$cl_total = $model->GetDiscountByCoupon($coupon_id);
	return $this->GetDiscountPercent($cl_total);
}


}
