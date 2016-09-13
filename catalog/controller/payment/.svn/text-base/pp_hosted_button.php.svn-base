<?php
class ControllerPaymentPPHostedButton extends Controller {
	public function addOrder()
	{
		$order_data = array();
		$order_data['totals'] = array();
		$total = 0;
		$taxes = $this->cart->getTaxes();

		$this->load->model('extension/extension');

		$sort_order = array();

		$results = $this->model_extension_extension->getExtensions('total');

		foreach ($results as $key => $value) {
			$sort_order[$key] = $this->config->get($value['code'] . '_sort_order');
		}

		array_multisort($sort_order, SORT_ASC, $results);

		foreach ($results as $result) {
			if ($this->config->get($result['code'] . '_status')) {
				$this->load->model('total/' . $result['code']);

				$this->{'model_total_' . $result['code']}->getTotal($order_data['totals'], $total, $taxes);
			}
		}

		$sort_order = array();

		foreach ($order_data['totals'] as $key => $value) {
			$sort_order[$key] = $value['sort_order'];
		}

		array_multisort($sort_order, SORT_ASC, $order_data['totals']);

		$this->load->language('checkout/checkout');

		$order_data['invoice_prefix'] = $this->config->get('config_invoice_prefix');
		$order_data['store_id'] = $this->config->get('config_store_id');
		$order_data['store_name'] = $this->config->get('config_name');

		if ($order_data['store_id']) {
			$order_data['store_url'] = $this->config->get('config_url');
		} else {
			$order_data['store_url'] = HTTP_SERVER;
		}

		$this->load->model('account/customer');

		if ($this->customer->isLogged()) {
			$this->load->model('account/customer');

			$customer_info = $this->model_account_customer->getCustomer($this->customer->getId());

			$order_data['customer_id'] = $this->customer->getId();
			$order_data['customer_group_id'] = $customer_info['customer_group_id'];
			$order_data['firstname'] = $customer_info['firstname'];
			$order_data['lastname'] = $customer_info['lastname'];
			$order_data['email'] = $customer_info['email'];
			$order_data['telephone'] = $customer_info['telephone'];
			$order_data['fax'] = $customer_info['fax'];
			$order_data['custom_field'] = unserialize($customer_info['custom_field']);
		} 
		else
		{
			$order_data['customer_id'] = 0;
			$order_data['customer_group_id'] =0;
			$order_data['firstname'] = '';
			$order_data['lastname'] = '';
			$order_data['email'] = '';
			$order_data['telephone'] ='';
			$order_data['fax'] = '';
			$order_data['custom_field'] = '';
		}
		
		$order_data['payment_firstname'] = '';
		$order_data['payment_lastname'] = '';
		$order_data['payment_company'] = '';
		$order_data['payment_address_1'] = '';
		$order_data['payment_address_2'] = '';
		$order_data['payment_city'] = '';
		$order_data['payment_postcode'] = '';
		$order_data['payment_zone'] = '';
		$order_data['payment_zone_id'] = '';
		$order_data['payment_country'] ='';
		$order_data['payment_country_id'] = '';
		$order_data['payment_address_format'] ='';
		$order_data['payment_custom_field'] =  array();
		

		$order_data['payment_method'] = 'Paypal Hosted Button';
		$order_data['payment_code'] = 'paypal_hosted_button';
		
		$order_data['shipping_firstname'] = '';
		$order_data['shipping_lastname'] = '';
		$order_data['shipping_company'] = '';
		$order_data['shipping_address_1'] = '';
		$order_data['shipping_address_2'] = '';
		$order_data['shipping_city'] = '';
		$order_data['shipping_postcode'] = '';
		$order_data['shipping_zone'] = '';
		$order_data['shipping_zone_id'] = '';
		$order_data['shipping_country'] ='';
		$order_data['shipping_country_id'] = '';
		$order_data['shipping_address_format'] = '';
		$order_data['shipping_custom_field'] = array();
		$order_data['shipping_method'] = '';
		$order_data['shipping_code'] = '';
		

		$order_data['products'] = array();

		foreach ($this->cart->getProducts() as $product) {
			$option_data = array();

			foreach ($product['option'] as $option) {
				$option_data[] = array(
					'product_option_id'       => $option['product_option_id'],
					'product_option_value_id' => $option['product_option_value_id'],
					'option_id'               => $option['option_id'],
					'option_value_id'         => $option['option_value_id'],
					'name'                    => $option['name'],
					'value'                   => $option['value'],
					'type'                    => $option['type']
				);
			}

			$order_data['products'][] = array(
				'product_id' => $product['product_id'],
				'name'       => $product['name'],
				'model'      => $product['model'],
				'option'     => $option_data,
				'download'   => $product['download'],
				'quantity'   => $product['quantity'],
				'subtract'   => $product['subtract'],
				'price'      => $product['price'],
				'total'      => $product['total'],
				'tax'        => $this->tax->getTax($product['price'], $product['tax_class_id']),
				'reward'     => $product['reward']
			);
		}

		// Gift Voucher
		$order_data['vouchers'] = array();

		if (!empty($this->session->data['vouchers'])) {
			foreach ($this->session->data['vouchers'] as $voucher) {
				$order_data['vouchers'][] = array(
					'description'      => $voucher['description'],
					'code'             => substr(md5(mt_rand()), 0, 10),
					'to_name'          => $voucher['to_name'],
					'to_email'         => $voucher['to_email'],
					'from_name'        => $voucher['from_name'],
					'from_email'       => $voucher['from_email'],
					'voucher_theme_id' => $voucher['voucher_theme_id'],
					'message'          => $voucher['message'],
					'amount'           => $voucher['amount']
				);
			}
		}
		if(isset($this->session->data['comment']))
		$order_data['comment'] = $this->session->data['comment'];
		else $order_data['comment']='';
		$order_data['total'] = $total;

		if (isset($this->request->cookie['tracking'])) {
			$order_data['tracking'] = $this->request->cookie['tracking'];

			$subtotal = $this->cart->getSubTotal();

			// Affiliate
			$this->load->model('affiliate/affiliate');

			$affiliate_info = $this->model_affiliate_affiliate->getAffiliateByCode($this->request->cookie['tracking']);

			if ($affiliate_info) {
				$order_data['affiliate_id'] = $affiliate_info['affiliate_id'];
				$order_data['commission'] = ($subtotal / 100) * $affiliate_info['commission'];
			} else {
				$order_data['affiliate_id'] = 0;
				$order_data['commission'] = 0;
			}

			// Marketing
			$this->load->model('checkout/marketing');

			$marketing_info = $this->model_checkout_marketing->getMarketingByCode($this->request->cookie['tracking']);

			if ($marketing_info) {
				$order_data['marketing_id'] = $marketing_info['marketing_id'];
			} else {
				$order_data['marketing_id'] = 0;
			}
		} else {
			$order_data['affiliate_id'] = 0;
			$order_data['commission'] = 0;
			$order_data['marketing_id'] = 0;
			$order_data['tracking'] = '';
		}

		$order_data['language_id'] = $this->config->get('config_language_id');
		$order_data['currency_id'] = $this->currency->getId();
		$order_data['currency_code'] = $this->currency->getCode();
		$order_data['currency_value'] = $this->currency->getValue($this->currency->getCode());
		$order_data['ip'] = $this->request->server['REMOTE_ADDR'];

		if (!empty($this->request->server['HTTP_X_FORWARDED_FOR'])) {
			$order_data['forwarded_ip'] = $this->request->server['HTTP_X_FORWARDED_FOR'];
		} elseif (!empty($this->request->server['HTTP_CLIENT_IP'])) {
			$order_data['forwarded_ip'] = $this->request->server['HTTP_CLIENT_IP'];
		} else {
			$order_data['forwarded_ip'] = '';
		}

		if (isset($this->request->server['HTTP_USER_AGENT'])) {
			$order_data['user_agent'] = $this->request->server['HTTP_USER_AGENT'];
		} else {
			$order_data['user_agent'] = '';
		}

		if (isset($this->request->server['HTTP_ACCEPT_LANGUAGE'])) {
			$order_data['accept_language'] = $this->request->server['HTTP_ACCEPT_LANGUAGE'];
		} else {
			$order_data['accept_language'] = '';
		}

		$this->load->model('checkout/order');
		if($this->cart->getProducts())
		{
			$this->session->data['order_id'] = $this->model_checkout_order->addOrder($order_data);
			$order_id=$this->session->data['order_id'];
		}
		$this->session->data['guest']['firstname']= '';
		$this->session->data['guest']['lastname']= '';
		$this->session->data['order_id']=$order_id;
		echo $order_id;
	}
   	public function callback() {
		if (isset($this->request->post['custom'])) {
			$order_id = $this->request->post['custom'];
		} else {
			$order_id = 0;
		}
		$this->load->model('checkout/order');

		$order_info = $this->model_checkout_order->getOrder($order_id);

		if ($order_info) {
			$order_data=array();
			if (isset($this->request->post['payment_status'])) {
				
				$order_status_id = $this->config->get('config_order_status_id');

				switch($this->request->post['payment_status']) {
					case 'Canceled_Reversal':
						$order_status_id = $this->config->get('pp_hosted_button_order_status_id_canceled_reversal');
						break;
					case 'Completed':
						$receiver_match = (strtolower($this->request->post['receiver_email']) == strtolower($this->config->get('pp_hosted_button_email')));

						$total_paid_match = ((float)$this->request->post['mc_gross'] == $this->currency->format($order_info['total'], $order_info['currency_code'], $order_info['currency_value'], false));

						if ($receiver_match && $total_paid_match) {
							$order_status_id = $this->config->get('pp_hosted_button_order_status_id');
						}
						
						break;
					case 'Denied':
						$order_status_id = $this->config->get('pp_hosted_button_order_status_id_denied');
						break;
					case 'Expired':
						$order_status_id = $this->config->get('pp_hosted_button_order_status_id_expired');
						break;
					case 'Failed':
						$order_status_id = $this->config->get('pp_hosted_button_order_status_id_failed');
						break;
					case 'Pending':
						$order_status_id = $this->config->get('pp_hosted_button_order_status_id_pending');
						break;
					case 'Refunded':
						$order_status_id = $this->config->get('pp_hosted_button_order_status_id_refunded');
						break;
					case 'Reversed':
						$order_status_id = $this->config->get('pp_hosted_button_order_status_id_reversed');
						break;
					case 'Voided':
						$order_status_id = $this->config->get('pp_hosted_button_order_status_id_unspecified');
						break;
				}
			
				$this->load->model('account/customer');

				$customer_info = $this->model_account_customer->getCustomerByEmail($this->request->post['payer_email']);
				if($customer_info)
				{
				
					$order_data['customer_id'] = $customer_info['customer_id'];
					$order_data['customer_group_id'] = $customer_info['customer_group_id'];
					$order_data['firstname'] = $customer_info['firstname'];
					$order_data['lastname'] = $customer_info['lastname'];
					$order_data['email'] = $customer_info['email'];
					$order_data['telephone'] = $customer_info['telephone'];
					$order_data['fax'] = $customer_info['fax'];
					$order_data['custom_field'] = unserialize($customer_info['custom_field']);
				}
				else
				{
					$order_data['customer_id'] = 0;
					$order_data['customer_group_id'] =0;
					$order_data['firstname'] = $this->request->post['first_name'];
					$order_data['lastname'] = $this->request->post['last_name'];
					$order_data['email'] = $this->request->post['payer_email'];
					$order_data['telephone'] ='';
					$order_data['fax'] = '';
					$order_data['custom_field'] = '';
				}
				$order_data['payment_firstname'] = $this->request->post['first_name'];
				$order_data['payment_lastname'] = $this->request->post['last_name'];
				$order_data['payment_address_1'] = $this->request->post['address_street'];
				$order_data['payment_city'] = $this->request->post['address_city'];
				$order_data['payment_postcode'] = $this->request->post['address_zip'];
				$order_data['payment_zone'] = $this->request->post['address_state'];
				$order_data['payment_country'] =$this->request->post['address_country'];
			
				$order_data['shipping_firstname'] = $this->request->post['first_name'];
				$order_data['shipping_lastname'] = $this->request->post['last_name'];
				$order_data['shipping_address_1'] = $this->request->post['address_street'];
				$order_data['shipping_city'] = $this->request->post['address_city'];
				$order_data['shipping_postcode'] = $this->request->post['address_zip'];
				$order_data['shipping_zone'] = $this->request->post['address_state'];;
				$order_data['shipping_country'] =$this->request->post['address_country'];
				
			}

			$this->load->model('payment/pp_hosted_button');
			$this->model_payment_pp_hosted_button->editOrder($order_id,$order_data);
			$this->load->model('checkout/order');	
			$this->model_checkout_order->addOrderHistory($order_id, $order_status_id);

		} 

	}		
}
?>
