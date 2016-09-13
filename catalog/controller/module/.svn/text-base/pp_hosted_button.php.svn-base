<?php
/*
 * @support
 * http://www.opensourcetechnologies.com/contactus.html
 * sales@opensourcetechnologies.com
* */
class ControllerModulePPHostedButton extends Controller {
	public function index() {
		$status = true;

		if ((!$this->cart->hasProducts() && empty($this->session->data['vouchers'])) || (!$this->cart->hasStock() && !$this->config->get('config_stock_checkout')) || (!$this->customer->isLogged() && ($this->cart->hasRecurringProducts() || $this->cart->hasDownload()))) {
			$status = false;
		}

		if ($status) {
			/*Paypal hosted Button*/
			if (preg_match('/Mobile|Android|BlackBerry|iPhone|Windows Phone/', $this->request->server['HTTP_USER_AGENT'])) {
				$data['mobile'] = true;
			} else {
				$data['mobile'] = false;
			}
			$this->language->load('payment/pp_hosted_button');

			$data['text_testmode'] = $this->language->get('text_testmode');
			$data['button_confirm'] = $this->language->get('button_confirm');
			$data['testmode'] = $this->config->get('pp_hosted_button_test');

			if (!$this->config->get('pp_hosted_button_test')) {
                    $data['action'] = 'https://securepayments.paypal.com/acquiringweb?cmd=_hosted-payment';
			} else {
                    $data['action'] = 'https://securepayments.sandbox.paypal.com/acquiringweb?cmd=_hosted-payment';
			}

			$data['fields']['business'] = $this->config->get('pp_hosted_button_email');
			$data['fields']['subtotal'] = html_entity_decode($this->cart->getTotal(), ENT_QUOTES, 'UTF-8');
			$data['fields']['return'] = $this->url->link('checkout/success');
			$data['fields']['notify_url'] = $this->url->link('payment/pp_hosted_button/callback', '', 'SSL');
			$data['fields']['cancel_return'] = $this->url->link('checkout/cart', '', 'SSL');
			if (!$this->config->get('pp_hosted_button_transaction')) {
				$data['fields']['paymentaction'] = 'authorization';
			} else {
				$data['fields']['paymentaction'] = 'sale';
			}
		/* End of paypal hosted */

			if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/module/pp_hosted_button.tpl')) {
				return $this->load->view($this->config->get('config_template') . '/template/module/pp_hosted_button.tpl', $data);
			} else {
				return $this->load->view('default/template/module/pp_hosted_button.tpl', $data);
			}
		}
	}
}
