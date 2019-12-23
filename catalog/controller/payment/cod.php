<?php
class ControllerPaymentCod extends Controller {
	public function index() {
		$data['button_confirm'] = $this->language->get('button_confirm');

		$data['text_loading'] = $this->language->get('text_loading');

		$data['continue'] = $this->url->link('checkout/success');

		if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/payment/cod.tpl')) {
			return $this->load->view($this->config->get('config_template') . '/template/payment/cod.tpl', $data);
		} else {
			return $this->load->view('default/template/payment/cod.tpl', $data);
		}
	}

	public function confirm() {
		// echo "<h1 style='color:red;'>this->session->data :</h1><pre>";print_r($this->session->data);echo "</pre><hr>";
		if ($this->session->data['payment_method']['code'] == 'cod') {
			$this->load->model('checkout/order');
			// die($this->session->data['order_id']);
			$this->model_checkout_order->addOrderHistory($this->session->data['order_id'], $this->config->get('cod_order_status_id'));
		}
	}
}
