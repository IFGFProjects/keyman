<?php
class ControllerModuleFaq extends Controller {
	private $error = array(); 
	 
	public function index() {   
		$this->language->load('module/faq');

		$data['heading_title'] = $this->language->get('heading_title');
		$data['text_modules'] = $this->language->get('text_modules');
		$data['text_here'] = $this->language->get('text_here');
		$data['text_faq'] = $this->language->get('text_faq');
		$data['text_categories'] = $this->language->get('text_categories');
		$data['text_setting'] = $this->language->get('text_setting');
		$data['text_question'] = $this->language->get('text_question');
		$data['text_answer'] = $this->language->get('text_answer');
		$data['text_category'] = $this->language->get('text_category');
		$data['text_sort'] = $this->language->get('text_sort');
		$data['text_remove'] = $this->language->get('text_remove');
		$data['text_add'] = $this->language->get('text_add');
		$data['text_name'] = $this->language->get('text_name');
		$data['text_show'] = $this->language->get('text_show');
		$data['text_hide'] = $this->language->get('text_hide');
		$data['text_accordion'] = $this->language->get('text_accordion');
		$data['text_collapsed'] = $this->language->get('text_collapsed');
		$data['text_visible'] = $this->language->get('text_visible');
		$data['text_save'] = $this->language->get('text_save');
		$data['text_not_selected'] = $this->language->get('text_not_selected');
		$data['text_title'] = $this->language->get('text_title');
		$data['error_category'] = $this->language->get('error_category');

		$this->document->setTitle($data['heading_title']);
		
		$this->load->model('setting/setting');
				
		$this->document->addStyle('view/stylesheet/faq.css');
        
		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validate()) {
            
            if(!empty($this->request->post['faq_module']['sections'])){
                foreach($this->request->post['faq_module']['sections'] as &$section){
                    if(!isset($section['id']) || !$section['id']){
                        $section['id'] = uniqid();
                    }
                }
            }
            
			$this->model_setting_setting->editSetting('faq', $this->request->post);		
			
			$this->session->data['success'] = $this->language->get('text_success');
			
			$this->response->redirect($this->url->link('module/faq', 'token=' . $this->session->data['token'], 'SSL'));			
		}
		
 		if (isset($this->error['warning'])) {
			$data['error_warning'] = $this->error['warning'];
		} else {
			$data['error_warning'] = '';
		}
		
		if (isset($this->session->data['success'])) {
			$data['success'] = $this->session->data['success'];
		    unset($this->session->data['success']);
		} else {
			$data['success'] = '';
		}
		
		$data['action'] = $this->url->link('module/faq', 'token=' . $this->session->data['token'], 'SSL');
		
		if(version_compare(VERSION, '2.2.0.0', '<') == true) { 
	        $front_url = new Url(HTTP_CATALOG, $this->config->get('config_secure') ? HTTP_CATALOG : HTTPS_CATALOG);
	        $data['front_url'] = $front_url->link('module/faq', '', 'SSL');
	    } else {
	    	 $data['front_url'] = '/index.php?route=module/faq';
	    }
        
		$data['token'] = $this->session->data['token'];
	
		if (isset($this->request->post['faq_module'])) {
			$data['module'] = $this->request->post['faq_module'];
		} elseif ($this->config->get('faq_module')) { 
			$data['module'] = $this->config->get('faq_module');
		}	
        
        if(isset($data['module']['sections']) && !empty($data['module']['sections'])){
            $this->sortData($data['module']['sections'], 'order');
        }
        if(isset($data['module']['items']) && !empty($data['module']['items'])){
            $this->sortData($data['module']['items'], 'order');
        }
		
		
		// Languages
		$this->load->model('localisation/language');
		$data['languages'] = $this->model_localisation_language->getLanguages();
		
		$data['breadcrumbs'] = array();
		
		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_home'),
			'href' => $this->url->link('common/dashboard', 'token=' . $this->session->data['token'], 'SSL')
		);
		
		$data['breadcrumbs'][] = array(
			'text' => $data['text_modules'],
			'href' => $this->url->link('extension/module', 'token=' . $this->session->data['token'], 'SSL')
		);
				
		$data['breadcrumbs'][] = array(
			'text' => $data['heading_title'],
			'href' => $this->url->link('module/faq', 'token=' . $this->session->data['token'], 'SSL')
		);
				
		$data['header'] = $this->load->controller('common/header');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer'] = $this->load->controller('common/footer');
        $data['current_lang_id'] = $this->config->get('config_language_id');
				
		$this->response->setOutput($this->load->view('module/faq.tpl', $data));
	}
	
	protected function validate() {
		if (!$this->user->hasPermission('modify', 'module/faq')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}
        // Languages
		$this->load->model('localisation/language');
        $languages = $this->model_localisation_language->getLanguages();

        $this->language->load('module/faq');
        $data['error_category'] = $this->language->get('error_category');

        
        if(!empty($this->request->post['faq_module']['sections'])){
            foreach($this->request->post['faq_module']['sections'] as $section){
                foreach($languages as $lang){
                    if(trim($section['title'][$lang['language_id']]) == ''){
                        $this->error['warning'] = $data['error_category']; 
                    }
                }
            }
        }
		
		if (!$this->error) {
			return true;
		} else {
			return false;
		}	
	}
    
    function sortData(&$data, $col)
    {
        usort($data, function($a, $b) use ($col){
            if ($a[$col] == $b[$col]) {
                return 0;
            }
            return ($a[$col] < $b[$col]) ? -1 : 1;
        });
    }
}
?>