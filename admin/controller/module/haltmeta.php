<?php 
class ControllerModuleHAltMeta extends Controller {
	private $error = array();

	function __construct($data) {
	    parent::__construct($data);
//------------------------------------ SETTINGS ----------------------------------
	    // 				ОБЩИЕ НАСТРОЙКИ 
	    $this->main_model="model_haltmeta_haltmeta";
	    $this->main_model_name="haltmeta/haltmeta";
	    $this->controller_name="module/haltmeta";
	    $this->list_tpl='module/haltmeta/list.tpl';
	    $this->form_tpl='module/haltmeta/form.tpl';
	    $this->language_name="module/haltmeta";
	    $this->index_field_name="altmeta_id";
	    $this->limit_default=$this->config->get('config_limit_admin');

	    // 				НАСТРОЙКИ ВЫДАЧИ
	    $this->load->language($this->language_name);
	    $this->listing_fields=array(
	    		"altmeta_id"=>array(
	    			"title"=>$this->language->get('text_ham_altmeta_id_row'),
	    			"in_filter"=>true
	    			),
	    		"link"=>array(
	    			"title"=>$this->language->get('text_ham_link_row'),
	    			"in_filter"=>true
	    			),
	    		"seo_url"=>array(
	    			"title"=>$this->language->get('text_ham_seo_url_row'),
	    			"in_filter"=>true
	    			),
	    		"status"=>array(
	    			"title"=>$this->language->get('text_ham_status_row'),
	    			"in_filter"=>false
	    			)
	    );

	    // 				НАСТРОЙКИ СИНГЛА
	    		// Тут описываем все поля базы и определяем действия с ними
	    $this->form_fields=array(
	    	"altmeta_id"=>array(
	    		"title"=>$this->language->get('text_ham_altmeta_id_row'), 
	    		"type"=>"int", 
	    		"show_on_form"=>false,
	    		"enabled_on_form"=>false,
	    		"required"=>false,
	    		"value"=>"",
	    		"insert"=>false,
	    		"update"=>false
	    	),
	    	"link"=>array(
	    		"title"=>$this->language->get('text_ham_link_row'),
	    		"type"=>"string",
	    		"show_on_form"=>true,
	    		"enabled_on_form"=>true,
	    		"required"=>true,
	    		"value"=>"",
	    		"insert"=>true,
	    		"update"=>true
	    	),
	    	"seo_url"=>array(
	    		"title"=>$this->language->get('text_ham_seo_url_row'),
	    		"type"=>"string",
	    		"show_on_form"=>true,
	    		"enabled_on_form"=>true,
	    		"required"=>false,
	    		"value"=>"",
	    		"insert"=>true,
	    		"update"=>true
	    	),
	    	"meta_title"=>array(
	    		"title"=>$this->language->get('text_ham_meta_title_row'),
	    		"type"=>"string",
	    		"show_on_form"=>true,
	    		"enabled_on_form"=>true,
	    		"required"=>false,
	    		"value"=>"",
	    		"insert"=>true,
	    		"update"=>true
	    	),
	    	"meta_description"=>array(
	    		"title"=>$this->language->get('text_ham_meta_description_row'),
	    		"type"=>"string",
	    		"show_on_form"=>true,
	    		"enabled_on_form"=>true,
	    		"required"=>false,
	    		"value"=>"",
	    		"insert"=>true,
	    		"update"=>true
	    	),
	    	"meta_keywords"=>array(
	    		"title"=>$this->language->get('text_ham_meta_keywords_row'),
	    		"type"=>"string",
	    		"show_on_form"=>true,
	    		"enabled_on_form"=>true,
	    		"required"=>false,
	    		"value"=>"",
	    		"insert"=>true,
	    		"update"=>true
	    	),
	    	"add_tags"=>array(
	    		"title"=>$this->language->get('text_ham_add_tags_row'),
	    		"type"=>"text",
	    		"show_on_form"=>true,
	    		"enabled_on_form"=>true,
	    		"required"=>false,
	    		"value"=>"",
	    		"insert"=>true,
	    		"update"=>true
	    	),
	    	"status"=>array(
	    		"title"=>$this->language->get('text_ham_status_row'),
	    		"type"=>"int",
	    		"show_on_form"=>true,
	    		"enabled_on_form"=>true,
	    		"required"=>false,
	    		"value"=>1,
	    		"insert"=>true,
	    		"update"=>true
	    	),
	    	"date_modified"=>array(
	    		"title"=>$this->language->get('text_ham_date_modified_row'),
	    		"type"=>"date_now",
	    		"show_on_form"=>true,
	    		"enabled_on_form"=>false,
	    		"required"=>false,
	    		"value"=>date(""),
	    		"insert"=>true,
	    		"update"=>true
	    	),
	    	"date_added"=>array(
	    		"title"=>$this->language->get('text_ham_date_added_row'),
	    		"type"=>"date_now",
	    		"show_on_form"=>true,
	    		"enabled_on_form"=>false,
	    		"required"=>false,
	    		"value"=>date(""),
	    		"insert"=>true,
	    		"update"=>false
	    	)
	    );

	    /*
	    	ДОПИЛИТЬ!
	    	- Фильтры костылём пока, вручную вытягивать в GetList функции (FILTERS BLOCK и GET_ENTRIES BLOCK)
			- Статусы костылём пока (привязаны к названию статусов) в GET_ENTRIES BLOCK в цикле подставляются значения
	    */
	}

	public function validate()
	{
		if (!$this->user->hasPermission('modify', 'catalog/product')) 
			{$this->error['warning'] = $this->language->get('error_permission');}

		if ((utf8_strlen($this->request->post['link']) < 3) || (utf8_strlen($this->request->post['link']) > 250)) 
			{$this->error['link'] = $this->language->get('error_link');}

		if ($this->error && !isset($this->error['warning'])) 
			{$this->error['warning'] = $this->language->get('error_warning');}
		
		return !$this->error;
	}

	public function index() {
		$data=$this->load->language($this->language_name);
		$this->document->setTitle($this->language->get('heading_title'));
		$this->GetList($data);
	}

	public function add()
	{
		$data=$this->load->language($this->language_name);
		$this->document->setTitle($this->language->get('heading_title'));
		$this->load->model($this->main_model_name);

		$url=$this->{$this->main_model}->GetUrlWithout();
		
		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validate())
		{
			$add_data=$this->form_fields;
			foreach ($this->request->post as $field_id => $value)
			{
				if (isset($add_data[$field_id]))
					{$add_data[$field_id]['value']=$value;}
			}
			$this->{$this->main_model}->insertEntry($add_data);
			$this->response->redirect($this->url->link($this->controller_name, 'token=' . $this->session->data['token'].$url, 'SSL'));
		}

		$data['entry']=$this->form_fields;

		$data['action'] = $this->url->link($this->controller_name.'/add', 'token=' . $this->session->data['token'].$url, 'SSL');

		$this->GetForm($data);
	}

	public function edit()
	{
		$data=$this->load->language($this->language_name);
		$this->document->setTitle($this->language->get('heading_title'));
		$this->load->model($this->main_model_name);

		$url=$this->{$this->main_model}->GetUrlWithout();

		if (!isset($this->request->get[$this->index_field_name]))
			{$this->response->redirect($this->url->link($this->controller_name.'/add', 'token=' . $this->session->data['token'].$url, 'SSL'));}

		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validate())
		{
			$update_data=$this->form_fields;
			foreach ($this->request->post as $field_id => $value)
			{
				if (isset($update_data[$field_id]))
					{$update_data[$field_id]['value']=$value;}
			}
			$this->{$this->main_model}->updateEntry($this->request->get[$this->index_field_name],$update_data);
			$this->response->redirect($this->url->link($this->controller_name, 'token=' . $this->session->data['token'].$url, 'SSL'));
		}

		$result= $this->{$this->main_model}->getEntry($this->request->get[$this->index_field_name],$this->form_fields);
		foreach ($result as $field_id => $entry)
		{
			if (isset($this->request->post[$field_id]))
				{$result[$field_id]['value']=$this->request->post[$field_id];}
		}

		$data['entry']=$result;

		$data['action'] = $this->url->link($this->controller_name.'/edit', 'token=' . $this->session->data['token'].$url."&".$this->index_field_name."=".$this->request->get[$this->index_field_name], 'SSL');

		$this->GetForm($data);
	}

	public function delete()
	{
		$this->load->model($this->main_model_name);
		$url=$this->{$this->main_model}->GetUrlWithout();

		if (!isset($this->request->get[$this->index_field_name]))
			{$this->response->redirect($this->url->link($this->controller_name, 'token=' . $this->session->data['token'].$url, 'SSL'));}

		$this->{$this->main_model}->deleteEntry($this->request->get[$this->index_field_name]);
		$this->response->redirect($this->url->link($this->controller_name, 'token=' . $this->session->data['token'].$url, 'SSL'));
	}

	public function GetList($data)
	{
		$this->load->model($this->main_model_name);
		if (isset($this->error['warning'])) {
			$data['error_warning'] = $this->error['warning'];
		} else {
			$data['error_warning'] = '';
		}

		if (!isset($data['success'])) 
			{$data['success'] = '';}

		//----- [SORTS BLOCK
		if (isset($this->request->get['sort']))
			{$sort = $this->request->get['sort'];}
		else {$sort = 'date_modified';}

		if (isset($this->request->get['order']))
			{$order = $this->request->get['order'];}
		else {$order = 'ASC';}

		if ($order=="ASC")
			{$not_order="DESC";}
		else {$not_order="ASC";}

		if (isset($this->request->get['page']))
			{$page = $this->request->get['page'];}
		else {$page = 1;}

		if (isset($this->request->get['limit']))
			{$limit = $this->request->get['limit'];}
		else {$limit = $this->limit_default;}
		//----- ]

		//----- [FILTERS BLOCK
		if (isset($this->request->get['filter_altmeta_id'])) {
			$filter_altmeta_id = $this->request->get['filter_altmeta_id'];
		} else {
			$filter_altmeta_id = null;
		}

		if (isset($this->request->get['filter_link'])) {
			$filter_link = $this->request->get['filter_link'];
		} else {
			$filter_link = null;
		}
		$data['filter_href']="index.php?route=".$this->request->get['route']."&token=".$this->session->data['token'].$this->{$this->main_model}->GetUrlWithout(array("any_filters"=>''));
		//----- ]

		//----- [GET_ENTRIES BLOCK
		$filter_data = array(
			"filter_altmeta_id" => $filter_altmeta_id,
			"filter_link" 		=> $filter_link,
			'sort'            => $sort,
			'order'           => $order,
			'start'           => ($page - 1) * $limit,
			'limit'           => $limit
		);

		$entries=$this->{$this->main_model}->getEntries($filter_data);
		$url=$this->{$this->main_model}->GetUrlWithout();
		foreach ($entries as $key => $var)
		{
			$var['status']=$data['statuses'][$var['status']];
			$var['edit']=$this->url->link($this->controller_name.'/edit',"token=".$this->session->data['token']."&".$this->index_field_name."=".$var[$this->index_field_name].$url,"SSL");
			$var['delete']=$this->url->link($this->controller_name.'/delete',"token=".$this->session->data['token']."&".$this->index_field_name."=".$var[$this->index_field_name].$url,"SSL");
			$data['entries'][]=$var;
		}
		//----- ]	

		//----- [LIST_FIELDS BLOCK
		$url=$this->{$this->main_model}->GetUrlWithout(array('sort'=>'','order'=>''));

		foreach ($this->listing_fields as $field_id => $var)
		{
			$var["sort_href"]=$this->url->link($this->controller_name, 'token=' . $this->session->data['token'].$url."&sort=$field_id&order=".($sort==$field_id? $not_order : $order) , 'SSL');
			$var["selected"]=$sort==$field_id?true:false;
			if ( ($var['in_filter']) )
			{
				$f_val_name="filter_".$field_id;
				if (isset($$f_val_name))
					{$var['filter_value']=$$f_val_name;}
				else
					{$var['filter_value']="";}
			}
			$data['table_fields'][$field_id]=$var;
		}
		$data['sort_order']=strtolower($order);
		//----- ]

		//----- [CRUMBS_LINKS BLOCK
		$data['add_link']=$this->url->link($this->controller_name.'/add', 'token=' . $this->session->data['token'].$url, 'SSL');

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_home'),
			'href' => $this->url->link('common/dashboard', 'token=' . $this->session->data['token'], 'SSL')
		);
		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_module'),
			'href' => $this->url->link('extension/module', 'token=' . $this->session->data['token'], 'SSL')
		);
		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('heading_title'),
			'href' => $this->url->link($this->controller_name, 'token=' . $this->session->data['token'], 'SSL')
		);
		$data['action'] = $this->url->link($this->controller_name, 'token=' . $this->session->data['token'], 'SSL');
		$data['cancel'] = $this->url->link('extension/module', 'token=' . $this->session->data['token'], 'SSL');
		//----- ]	

		//-----[PAGINATION BLOCK
		$total_entries=$this->{$this->main_model}->getTotalEntries($filter_data);
		$url=$this->{$this->main_model}->GetUrlWithout();

		$pagination = new Pagination();
		$pagination->total = $total_entries;
		$pagination->page = $page;
		$pagination->limit = $limit;
		$pagination->url = $this->url->link($this->controller_name, 'token=' . $this->session->data['token'] . $url . '&page={page}', 'SSL');

		$data['pagination'] = $pagination->render();

		$data['results'] = sprintf($this->language->get('text_pagination'), ($total_entries) ? (($page - 1) * $limit) + 1 : 0, ((($page - 1) * $limit) > ($total_entries - $limit)) ? $total_entries : ((($page - 1) * $limit) + $limit), $total_entries, ceil($total_entries / $limit));
		//----- ]	

		//----- [LAYOUT BLOCK
		$data['header'] = $this->load->controller('common/header');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer'] = $this->load->controller('common/footer');

		$this->response->setOutput($this->load->view($this->list_tpl, $data));
		//----- ]
	}

	public function GetForm($data)
	{
		if (isset($this->error)) {
			$data['errors'] = $this->error;
		}

		if (!isset($data['success'])) 
			{$data['success'] = '';}

		$url=$this->{$this->main_model}->GetUrlWithout();

		//----- [CRUMBS_LINKS BLOCK
		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_home'),
			'href' => $this->url->link('common/dashboard', 'token=' . $this->session->data['token'], 'SSL')
		);
		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_module'),
			'href' => $this->url->link('extension/module', 'token=' . $this->session->data['token'], 'SSL')
		);
		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('heading_title'),
			'href' => $this->url->link($this->controller_name, 'token=' . $this->session->data['token'], 'SSL')
		);
		$data['cancel'] = $this->url->link('extension/module', 'token=' . $this->session->data['token'].$url, 'SSL');
		//----- ]

		//----- [LAYOUT BLOCK
		$data['header'] = $this->load->controller('common/header');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer'] = $this->load->controller('common/footer');

		$this->response->setOutput($this->load->view($this->form_tpl, $data));
		//----- ]
	}
}
 ?>