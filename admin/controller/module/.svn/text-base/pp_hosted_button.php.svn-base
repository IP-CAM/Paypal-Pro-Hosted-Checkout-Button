<?php
/*
 * @support
 * http://www.opensourcetechnologies.com/contactus.html
 * sales@opensourcetechnologies.com
* */
class ControllerModulePPHostedButton extends Controller {
	private $error = array();
	private $name = '';

	public function index() {

		/* START ERRORS */
		$errors = array(
			'warning',
			'email'
		);
		/* END ERRORS */



		/* START COMMON STUFF */
		$this->name = str_replace('vq2-admin_controller_module_', '', basename(__FILE__, '.php'));

		if (!isset($this->session->data['token'])) { $this->session->data['token'] = 0; }
		$data['token'] = $this->session->data['token'];
		$data = array_merge($data, $this->load->language('module/' . $this->name));

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('setting/setting');

		if (($this->request->server['REQUEST_METHOD'] == 'POST') && ($this->validate($errors))) {
			foreach ($this->request->post as $key => $value) {
				if (is_array($value)) { $this->request->post[$key] = implode(',', $value); }
			}
			$this->load->model('setting/setting');

			$this->model_setting_setting->editSetting($this->name, $this->request->post);

			$this->session->data['success'] = $this->language->get('text_success');

			$this->response->redirect($this->url->link('extension/module', 'token=' . $this->session->data['token'], 'SSL'));
		}

		$data['breadcrumbs'] = array();

   		$data['breadcrumbs'][] = array(
       		'href'      => (((HTTPS_SERVER) ? HTTPS_SERVER : HTTP_SERVER) . 'index.php?token=' . $this->session->data['token'] . '&route=common/home'),
       		'text'      => $this->language->get('text_home'),
      		'separator' => FALSE
   		);

   		$data['breadcrumbs'][] = array(
       		'href'      => (((HTTPS_SERVER) ? HTTPS_SERVER : HTTP_SERVER) . 'index.php?token=' . $this->session->data['token'] . '&route=extension/module'),
       		'text'      => $this->language->get('text_module'),
      		'separator' => ' :: '
   		);

   		$data['breadcrumbs'][] = array(
       		'href'      => (((HTTPS_SERVER) ? HTTPS_SERVER : HTTP_SERVER) . 'index.php?token=' . $this->session->data['token'] . '&route=module/' . $this->name),
       		'text'      => $this->language->get('heading_title'),
      		'separator' => ' :: '
   		);

		$data['action'] = (((HTTPS_SERVER) ? HTTPS_SERVER : HTTP_SERVER) . 'index.php?token=' . $this->session->data['token'] . '&route=module/' . $this->name);

		$data['cancel'] = (((HTTPS_SERVER) ? HTTPS_SERVER : HTTP_SERVER) . 'index.php?token=' . $this->session->data['token'] . '&route=extension/module');

		$this->id       = 'content';
		$this->template = 'module/' . $this->name . '.tpl';

		/* 14x backwards compatibility */
		if (method_exists($this->document, 'addBreadcrumb')) { //1.4.x
			$this->document->breadcrumbs = $data['breadcrumbs'];
			unset($data['breadcrumbs']);
		}//
        foreach ($errors as $error) {
			if (isset($this->error[$error])) {
				$data['error_' . $error] = $this->error[$error];
			} else {
				$data['error_' . $error] = '';
			}
		}
		/* END COMMON STUFF */




		/* START FIELDS */
		$data['extension_class'] = 'module';
		$data['tab_class'] = 'htabs';

		$geo_zones = array();

		$this->load->model('localisation/geo_zone');

		$geo_zones[0] = $this->language->get('text_all_zones');
		foreach ($this->model_localisation_geo_zone->getGeoZones() as $geozone) {
			$geo_zones[$geozone['geo_zone_id']] = $geozone['name'];
		}

		$order_statuses = array();

		$this->load->model('localisation/order_status');

		foreach ($this->model_localisation_order_status->getOrderStatuses() as $order_status) {
			$order_statuses[$order_status['order_status_id']] = $order_status['name'];
		}
		
		$customer_groups = array();

		$this->load->model('sale/customer_group');

		foreach ($this->model_sale_customer_group->getCustomerGroups() as $customer_group) {
			$customer_groups[$customer_group['customer_group_id']] = $customer_group['name'];
		}

		$data['tabs'] = array();

		$data['tabs'][] = array(
			'id'		=> 'tab_general',
			'title'		=> $this->language->get('tab_general')
		);

		$data['fields'] = array();

		$data['fields'][] = array(
			'entry' 		=> $this->language->get('entry_status'),
			'help' 		=> '',
			'type'			=> 'select',
			'name' 			=> $this->name . '_status',
			'value' 		=> (isset($this->request->post[$this->name . '_status'])) ? $this->request->post[$this->name . '_status'] : $this->config->get($this->name . '_status'),
			'required' 		=> false,
			'options'		=> array(
				'0' => $this->language->get('text_disabled'),
				'1' => $this->language->get('text_enabled')
			)
		);

		$data['fields'][] = array(
			'entry' 		=> $this->language->get('entry_email'),
			'help' 		=> '',
			'type'			=> 'text',
			'size'			=> '60',
			'name' 			=> $this->name . '_email',
			'value' 		=> (isset($this->request->post[$this->name . '_email'])) ? $this->request->post[$this->name . '_email'] : $this->config->get($this->name . '_email'),
			'required' 		=> true,
			'error'			=> (isset($this->error['email'])) ? $this->error['email'] : ''
		);

		$data['fields'][] = array(
			'entry' 		=> $this->language->get('entry_transaction'),
			'help' 		=> '',
			'type'			=> 'select',
			'name' 			=> $this->name . '_transaction',
			'value' 		=> (isset($this->request->post[$this->name . '_transaction'])) ? $this->request->post[$this->name . '_transaction'] : $this->config->get($this->name . '_transaction'),
			'required' 		=> false,
			'options'		=> array(
				'0' => $this->language->get('text_authorization'),
				'1' => $this->language->get('text_sale')
			)
		);

		$data['fields'][] = array(
			'entry' 		=> $this->language->get('entry_test'),
			'help' 		=> '',
			'type'			=> 'select',
			'name' 			=> $this->name . '_test',
			'value' 		=> (isset($this->request->post[$this->name . '_test'])) ? $this->request->post[$this->name . '_test'] : $this->config->get($this->name . '_test'),
			'required' 		=> false,
			'options'		=> array(
				'0' => $this->language->get('text_no'),
				'1' => $this->language->get('text_yes')
			)
		);

		$data['fields'][] = array(
			'entry' 		=> $this->language->get('entry_total'),
			'help' 		=> $this->language->get('help_total'),
			'type'			=> 'text',
			'name' 			=> $this->name . '_total',
			'value' 		=> (isset($this->request->post[$this->name . '_total'])) ? $this->request->post[$this->name . '_total'] : $this->config->get($this->name . '_total'),
			'required' 		=> false,
		);

		$data['fields'][] = array(
			'entry' 		=> $this->language->get('entry_debug'),
			'help' 		=> $this->language->get('help_debug'),
			'type'			=> 'select',
			'name' 			=> $this->name . '_debug',
			'value' 		=> (isset($this->request->post[$this->name . '_debug'])) ? $this->request->post[$this->name . '_debug'] : $this->config->get($this->name . '_debug'),
			'required' 		=> false,
			'options'		=> array(
				'0' => $this->language->get('text_disabled'),
				'1' => $this->language->get('text_enabled')
			)
		);
		
		$data['fields'][] = array(
			'entry' 		=> $this->language->get('entry_geo_zone'),
			'help' 		=> '',
			'type'			=> 'select',
			'name' 			=> $this->name . '_geo_zone_id',
			'value' 		=> (isset($this->request->post[$this->name . '_geo_zone_id'])) ? $this->request->post[$this->name . '_geo_zone_id'] : $this->config->get($this->name . '_geo_zone_id'),
			'required' 		=> false,
			'options'		=> $geo_zones
		);

		$data['fields'][] = array(
			'entry' 		=> $this->language->get('entry_order_status'),
			'help' 		=> '',
			'type'			=> 'select',
			'name' 			=> $this->name . '_order_status_id',
			'value' 		=> (isset($this->request->post[$this->name . '_order_status_id'])) ? $this->request->post[$this->name . '_order_status_id'] : $this->config->get($this->name . '_order_status_id'),
			'required' 		=> false,
			'options'		=> $order_statuses
		);
		
		$data['fields'][] = array(
			'entry' 		=> $this->language->get('entry_order_status_pending'),
			'help' 		=> $this->language->get('help_order_status_pending'),
			'type'			=> 'select',
			'name' 			=> $this->name . '_order_status_id_pending',
			'value' 		=> (isset($this->request->post[$this->name . '_order_status_id_pending'])) ? $this->request->post[$this->name . '_order_status_id_pending'] : $this->config->get($this->name . '_order_status_id_pending'),
			'required' 		=> false,
			'options'		=> $order_statuses
		);
		
		$data['fields'][] = array(
			'entry' 		=> $this->language->get('entry_order_status_denied'),
			'help' 		=> $this->language->get('help_order_status_denied'),
			'type'			=> 'select',
			'name' 			=> $this->name . '_order_status_id_denied',
			'value' 		=> (isset($this->request->post[$this->name . '_order_status_id_denied'])) ? $this->request->post[$this->name . '_order_status_id_denied'] : $this->config->get($this->name . '_order_status_id_denied'),
			'required' 		=> false,
			'options'		=> $order_statuses
		);
		
		$data['fields'][] = array(
			'entry' 		=> $this->language->get('entry_order_status_failed'),
			'help' 		=> $this->language->get('help_order_status_failed'),
			'type'			=> 'select',
			'name' 			=> $this->name . '_order_status_id_failed',
			'value' 		=> (isset($this->request->post[$this->name . '_order_status_id_failed'])) ? $this->request->post[$this->name . '_order_status_id_failed'] : $this->config->get($this->name . '_order_status_id_failed'),
			'required' 		=> false,
			'options'		=> $order_statuses
		);
		
		$data['fields'][] = array(
			'entry' 		=> $this->language->get('entry_order_status_refunded'),
			'help' 		=> $this->language->get('help_order_status_refunded'),
			'type'			=> 'select',
			'name' 			=> $this->name . '_order_status_id_refunded',
			'value' 		=> (isset($this->request->post[$this->name . '_order_status_id_refunded'])) ? $this->request->post[$this->name . '_order_status_id_refunded'] : $this->config->get($this->name . '_order_status_id_refunded'),
			'required' 		=> false,
			'options'		=> $order_statuses
		);
		
		$data['fields'][] = array(
			'entry' 		=> $this->language->get('entry_order_status_canceled_reversal'),
			'help' 		=> $this->language->get('help_order_status_canceled_reversal'),
			'type'			=> 'select',
			'name' 			=> $this->name . '_order_status_id_canceled_reversal',
			'value' 		=> (isset($this->request->post[$this->name . '_order_status_id_canceled_reversal'])) ? $this->request->post[$this->name . '_order_status_id_canceled_reversal'] : $this->config->get($this->name . '_order_status_id_canceled_reversal'),
			'required' 		=> false,
			'options'		=> $order_statuses
		);
		
		$data['fields'][] = array(
			'entry' 		=> $this->language->get('entry_order_status_reversed'),
			'help' 		=> $this->language->get('help_order_status_reversed'),
			'type'			=> 'select',
			'name' 			=> $this->name . '_order_status_id_reversed',
			'value' 		=> (isset($this->request->post[$this->name . '_order_status_id_reversed'])) ? $this->request->post[$this->name . '_order_status_id_reversed'] : $this->config->get($this->name . '_order_status_id_reversed'),
			'required' 		=> false,
			'options'		=> $order_statuses
		);
		
		$data['fields'][] = array(
			'entry' 		=> $this->language->get('entry_order_status_unspecified'),
			'help' 		=> '',
			'type'			=> 'select',
			'name' 			=> $this->name . '_order_status_id_unspecified',
			'value' 		=> (isset($this->request->post[$this->name . '_order_status_id_unspecified'])) ? $this->request->post[$this->name . '_order_status_id_unspecified'] : $this->config->get($this->name . '_order_status_id_unspecified'),
			'required' 		=> false,
			'options'		=> $order_statuses
		);

		$data['fields'][] = array(
			'entry'			=> $this->language->get('entry_sort_order'),
			'help' 		=> '',
			'type'			=> 'text',
			'name'			=> $this->name . '_sort_order',
			'value'			=> (isset($this->request->post[$this->name . '_sort_order'])) ? $this->request->post[$this->name . '_sort_order'] : $this->config->get($this->name . '_sort_order'),
			'required'		=> false,
		);
		/* END FIELDS */
		$data['text_edit'] = $this->language->get('text_edit');
		$data['header'] = $this->load->controller('common/header');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer'] = $this->load->controller('common/footer');

		$this->response->setOutput($this->load->view('module/pp_hosted_button.tpl', $data));
	}

	private function validate($errors = array()) {
		if (!$this->user->hasPermission('modify', 'module/' . $this->name)) {
			$this->error['warning'] = $this->language->get('error_permission');
		}

		foreach ($errors as $error) {
			if (isset($this->request->post[$this->name . '_' . $error]) && !$this->request->post[$this->name . '_' . $error]) {
				$this->error[$error] = $this->language->get('error_' . $error);
			}
		}

		if (!$this->error) {
			return TRUE;
		} else {
			return FALSE;
		}
	}
}
?>
