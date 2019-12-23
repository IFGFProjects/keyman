<?php
class ControllerProductFastorder extends Controller {

  public function index($data) {
    // Load language
    $this->load->language('product/fastorder');

    // Language data
    $data['text_fastorder_button']                      = $this->language->get('text_fastorder_button');
    $data['text_fastorder_form_header']                 = $this->language->get('text_fastorder_form_header');
    $data['text_fastorder_form_info']                   = $this->language->get('text_fastorder_form_info');
    $data['text_fastorder_name']                        = $this->language->get('text_fastorder_name');
    $data['text_fastorder_phone']                       = $this->language->get('text_fastorder_phone');
    $data['text_fastorder_comment']                     = $this->language->get('text_fastorder_comment');
    $data['text_fastorder_button_submit']               = $this->language->get('text_fastorder_button_submit');
    $data['text_fastorder_button_close']                = $this->language->get('text_fastorder_button_close');
    $data['text_fastorder_success_message']             = $this->language->get('text_fastorder_success_message');
    $data['text_fastorder_button_cancel']               = $this->language->get('text_fastorder_button_cancel');
    $data['text_fastorder_input_name_placeholder']      = $this->language->get('text_fastorder_input_name_placeholder');
    $data['text_fastorder_input_phone_placeholder']     = $this->language->get('text_fastorder_input_phone_placeholder');
    $data['text_fastorder_input_mail_placeholder']      = $this->language->get('text_fastorder_input_mail_placeholder');
    $data['text_fastorder_input_comment_placeholder']   = $this->language->get('text_fastorder_input_comment_placeholder');
    $data['text_fastorder_success_title']               = $this->language->get('text_fastorder_success_title');
    $data['text_fastorder_mail_msg_order']              = $this->language->get('text_fastorder_mail_msg_order');
    $data['text_fastorder_mail_msg_price']              = $this->language->get('text_fastorder_mail_msg_price');
    $data['txt_text_fastorder_form_info_message']       = $this->language->get('txt_text_fastorder_form_info_message');
    $data['txt_none_price']                             = $this->language->get('txt_none_price');

    if(!isset($data['price'])){
      $data['price'] = $data['txt_none_price'];
    }

    // return view data
    if (VERSION >= '2.2.0.0') {
      return $this->load->view('product/fastorder', $data);
    }else{
      return $this->load->view($this->config->get('config_template') . '/template/product/fastorder.tpl', $data);
    }
  }

  public function getForm(){

    $this->load->language('product/fastorder');

    // Language data
    $data['text_fastorder_button']                      = $this->language->get('text_fastorder_button');
    $data['text_fastorder_form_header']                 = $this->language->get('text_fastorder_form_header');
    $data['text_fastorder_form_info']                   = $this->language->get('text_fastorder_form_info');
    $data['text_fastorder_name']                        = $this->language->get('text_fastorder_name');
    $data['text_fastorder_phone']                       = $this->language->get('text_fastorder_phone');
    $data['text_fastorder_comment']                     = $this->language->get('text_fastorder_comment');
    $data['text_fastorder_button_submit']               = $this->language->get('text_fastorder_button_submit');
    $data['text_fastorder_button_close']                = $this->language->get('text_fastorder_button_close');
    $data['text_fastorder_success_message']             = $this->language->get('text_fastorder_success_message');
    $data['text_fastorder_button_cancel']               = $this->language->get('text_fastorder_button_cancel');
    $data['text_fastorder_input_name_placeholder']      = $this->language->get('text_fastorder_input_name_placeholder');
    $data['text_fastorder_input_phone_placeholder']     = $this->language->get('text_fastorder_input_phone_placeholder');
    $data['text_fastorder_input_mail_placeholder']      = $this->language->get('text_fastorder_input_mail_placeholder');
    $data['text_fastorder_input_comment_placeholder']   = $this->language->get('text_fastorder_input_comment_placeholder');
    $data['text_fastorder_success_title']               = $this->language->get('text_fastorder_success_title');
    $data['text_fastorder_mail_msg_order']              = $this->language->get('text_fastorder_mail_msg_order');
    $data['text_fastorder_mail_msg_price']              = $this->language->get('text_fastorder_mail_msg_price');
    $data['txt_text_fastorder_form_info_message']       = $this->language->get('txt_text_fastorder_form_info_message');

    $data['heading_title'] = $this->request->post['heading_title'];
    $data['price'] = $this->request->post['price'];
    $data['product_id'] = $this->request->post['product_id'];

    if (VERSION >= '2.2.0.0') {
      $tpl =  $this->load->view('product/fastorder_form', $data);
    }else{
      $tpl =  $this->load->view($this->config->get('config_template') . '/template/product/fastorder_form.tpl', $data);
    }

    $this->response->setOutput($tpl);
  }

  public function sender(){
    // Load language
    $this->load->language('product/fastorder');

    $data['text_fastorder_mail_subject']    = $this->language->get('text_fastorder_mail_subject');
    $data['text_fastorder_mail_msg_data']   = $this->language->get('text_fastorder_mail_msg_data');
    $data['text_fastorder_name']            = $this->language->get('text_fastorder_name');
    $data['text_fastorder_phone']           = $this->language->get('text_fastorder_phone');
    $data['text_fastorder_mail']            = $this->language->get('text_fastorder_mail');
    $data['text_fastorder_comment']         = $this->language->get('text_fastorder_comment');
    $data['text_fastorder_mail_msg_order']  = $this->language->get('text_fastorder_mail_msg_order');
    $data['text_fastorder_mail_msg_price']  = $this->language->get('text_fastorder_mail_msg_price');
    $data['text_fastorder_mail_msg_size']  = $this->language->get('text_fastorder_mail_msg_size');
    $data['text_fastorder_mail_msg_model']  = $this->language->get('text_fastorder_mail_msg_model');
    $data['text_fastorder_mail_msg_amount']  = $this->language->get('text_fastorder_mail_msg_amount');
    $data['text_fastorder_mail_msg_address']  = $this->language->get('text_fastorder_mail_msg_address');

    $json = array();

    if (isset($this->request->post['product_id'])){
      $json['product_id'] = $this->request->post['product_id'];
    }
    if (isset($this->request->post['name'])){
      $json['name'] = $this->request->post['name'];
    }
    if (isset($this->request->post['phone'])){
      $json['phone'] = $this->request->post['phone'];
    }
    if (isset($this->request->post['mail'])){
      $json['mail'] = $this->request->post['mail'];
    }
    if (isset($this->request->post['comment'])){
      $json['comment'] = $this->request->post['comment'];
    }
    if (isset($this->request->post['heading_title'])){
      $json['heading_title'] = $this->request->post['heading_title'];
    }
    if (isset($this->request->post['price'])){
      $json['price'] = $this->request->post['price'];
    }
    if (isset($this->request->post['amount'])){
      $json['amount'] = $this->request->post['amount'];
    }
    if (isset($this->request->post['address'])){
      $json['address'] = $this->request->post['address'];
    }
    if (isset($this->request->post['size'])){
      $json['size'] = $this->request->post['size'];
    }
    if (isset($this->request->post['model'])){
      $json['model'] = $this->request->post['model'];
    }

    // Mail adrees 
    $mail_to    = $this->config->get('config_email');

    // Mail adrees from mail were send (get from Opencart settings)
    // If multiple mail set in store admin settings - explode adresses and use the 1th e-mail adress
    $mail_from  = explode(',', $this->config->get('config_email'))[0];

    // Mail subject
    $subject    = $data['text_fastorder_mail_subject'] .' ('.$_SERVER['HTTP_HOST'] . ')';

    $products   = $json['heading_title'];

    $mail_message =
        '<h1>' . $subject . '</h1>'.
        '<p><strog>'.$data['text_fastorder_mail_msg_data'].'</strog></p>'.
        '<table style="list-style: none;">'.
        '<tr><td>' . $data['text_fastorder_name'] . ': </td><td><strong>' .$json['name'].'</strong></td></tr>'.
        '<tr><td>' . $data['text_fastorder_phone'] . ': </td><td><strong>'.$json['phone'].'</strong></td></tr>'.
        '<tr><td>' . $data['text_fastorder_mail'] . ': </td><td><strong>'.$json['mail'].'</strong></td></tr>'.
        '<tr><td>' . $data['text_fastorder_mail_msg_address'] . ': </td><td><strong>'.$json['address'].'</strong></td></tr>'.
        '<tr><td>'. $data['text_fastorder_comment'] . ': </td><td><i>'.$json['comment'].'</i></td></tr>'.
        '</table>'.
        $data['text_fastorder_mail_msg_order'] .': <strong>' . $products . '</strong><br />'.
        $data['text_fastorder_mail_msg_size'] .': <strong>' . $json['size'] . '</strong><br />'.
        $data['text_fastorder_mail_msg_amount'] .': <strong>' . $json['amount'] . '</strong><br />'.
        $data['text_fastorder_mail_msg_model'] .': <strong>' . $json['model'] . '</strong><br />'.
        $data['text_fastorder_mail_msg_price'] . ': <strong>' . $json['price'] . '</strong><br />';

    // Set the mail headers
    $headers = "From: $mail_from" . "\r\n" .
        "Reply-To: $mail_from" . "\r\n" .
        'Content-Type: text/html; charset="utf8"'."\n".
        'X-Mailer: PHP/' . phpversion();

        $mail = new Mail();
        $mail->protocol = $this->config->get('config_mail_protocol');
        $mail->parameter = $this->config->get('config_mail_parameter');
        $mail->smtp_hostname = $this->config->get('config_mail_smtp_hostname');
        $mail->smtp_username = $this->config->get('config_mail_smtp_username');
        $mail->smtp_password = html_entity_decode($this->config->get('config_mail_smtp_password'), ENT_QUOTES, 'UTF-8');
        $mail->smtp_port = $this->config->get('config_mail_smtp_port');
        $mail->smtp_timeout = $this->config->get('config_mail_smtp_timeout');

        $mail->setTo($mail_to);
        $mail->setFrom($this->config->get('config_email'));
        $mail->setSender(html_entity_decode($this->config->get('config_meta_title'), ENT_QUOTES, 'UTF-8'));
        $mail->setSubject(html_entity_decode($subject, ENT_QUOTES, 'UTF-8'));
        $mail->setHtml($mail_message);
        $mail->send();
        unset($mail);

    // Send mail to the shop owner
    // $result = mail($mail_to, $subject, $mail_message, $headers);

    // To customer==================================================================================

    // Send mail to the customer
    // $result = mail($json['mail'], $subject, $mail_message, $headers);

    $mail = new Mail();
    $mail->protocol = $this->config->get('config_mail_protocol');
    $mail->parameter = $this->config->get('config_mail_parameter');
    $mail->smtp_hostname = $this->config->get('config_mail_smtp_hostname');
    $mail->smtp_username = $this->config->get('config_mail_smtp_username');
    $mail->smtp_password = html_entity_decode($this->config->get('config_mail_smtp_password'), ENT_QUOTES, 'UTF-8');
    $mail->smtp_port = $this->config->get('config_mail_smtp_port');
    $mail->smtp_timeout = $this->config->get('config_mail_smtp_timeout');

    $mail->setTo($json['mail']);
    $mail->setFrom($this->config->get('config_email'));
    $mail->setSender(html_entity_decode($this->config->get('config_meta_title'), ENT_QUOTES, 'UTF-8'));
    $mail->setSubject(html_entity_decode($subject, ENT_QUOTES, 'UTF-8'));
    $mail->setHtml($mail_message);
    $mail->send();

    $this->response->addHeader('Content-Type: application/json');
    $this->response->setOutput(json_encode($json));
  }
}