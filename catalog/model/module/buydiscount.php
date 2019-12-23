<?php 
class ModelModuleBuyDiscount extends Model {

public function GetDiscountPercent($amount)
{
	if ($amount==0)
		{return 0;}

	$res=$this->db->query("SELECT discount_percent FROM buydiscount WHERE status=1 AND from_value<=".(float)$amount." AND to_value>".(float)$amount);
	if (isset($res->row['discount_percent']))
		{return (float)$res->row['discount_percent'];}
	else
	{
		//-----  check if amount = maximal discount -----
		$max_to=$this->db->query("SELECT discount_percent FROM buydiscount WHERE status=1 AND from_value=".(float)$amount." AND to_value=".(float)$amount);

		if ($max_to->num_rows!=0)
			{return $max_to->row['discount_percent'];}
		else 
			{return 0;}
	}
}

public function DiscountByPrice($amount,$price)
{
	return (float)$price-(float)$price*($this->GetDiscountPercent($amount)/100);
}


public function GetDiscounts()
{
	$res=$this->db->query("SELECT * FROM buydiscount");
	return $res->rows;
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
	if ((int)$coupon_id<1&&!isset($this->session->data['customer_id']))
		return 0;
	if ((int)$coupon_id<1)
		{return $this->GetClientDiscount($this->session->data['customer_id']);}
	global $loader, $registry;
	$loader->model('module/bitproapi');
	$model = $registry->get('model_module_bitproapi');
	$cl_total = $model->GetDiscountByCoupon($coupon_id);
	return $this->GetDiscountPercent($cl_total);
}

}
 ?>