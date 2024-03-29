<?php  
class ControllerModuleFaq extends Controller {
	public function index() {
		$lang_id = $this->config->get('config_language_id');
		$setting = $this->config->get('faq_module');
        
        if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/css/faq.css')) {
            $this->document->addStyle('catalog/view/theme/' . $this->config->get('config_template') . '/css/faq.css');
        }
        
        $data['settings'] = $setting['settings'];
		$data['sections'] = array();
        $data['heading_title'] = $setting['settings']['title'];
        $this->document->setTitle($data['heading_title']);
        
		if(is_array($setting['sections'])) {
			$this->sortData($setting['sections'], 'order');
            foreach($setting['sections'] as $section){
                $data['sections'][$section['id']]['title'] = $section['title'][$lang_id];
                $data['sections'][$section['id']]['hidden'] = isset($section['hidden']) && $section['hidden'] == 1 ? true : false; ;
                if(!empty($setting['items'])){
                    $this->sortData($setting['items'], 'order');
                    $i = 0;
                    foreach($setting['items'] as $item){
                        if(!isset($item['section_id'])) continue;
                        if($item['section_id'] == $section['id']){
                            $data['sections'][$section['id']]['items'][$i]['question'] = html_entity_decode($item['question'][$lang_id], ENT_QUOTES, 'UTF-8');
                            $data['sections'][$section['id']]['items'][$i]['answer'] = html_entity_decode($item['answer'][$lang_id], ENT_QUOTES, 'UTF-8');
                            $i++;
                        }
                    }
                }
            }
		}
        
		$data['breadcrumbs'] = array();

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_home'),
			'href' => $this->url->link('common/home')
		);

		$data['breadcrumbs'][] = array(
			'text' => $data['heading_title'],
			'href' => $this->url->link('module/faq', '', 'SSL')
		);
        
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['column_right'] = $this->load->controller('common/column_right');
		$data['content_top'] = $this->load->controller('common/content_top');
		$data['content_bottom'] = $this->load->controller('common/content_bottom');
		$data['footer'] = $this->load->controller('common/footer');
		$data['header'] = $this->load->controller('common/header');
        
        if(version_compare(VERSION, '2.2.0.0', '<') == true) { 
    		if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/module/faq.tpl')) {
                $this->response->setOutput($this->load->view($this->config->get('config_template') . '/template/module/faq.tpl', $data));
    		} else {
    			$this->response->setOutput($this->load->view('default/template/module/faq.tpl', $data));
    		}
        } else {
             $this->response->setOutput($this->load->view('module/faq', $data));
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