<?php
/*
 * @support
 * http://www.opensourcetechnologies.com/contactus.html
 * sales@opensourcetechnologies.com
* */
class ModelPaymentPPHostedButton extends Model {
  	public function getMethod($address, $total = false) {

		$name = basename(__FILE__, '.php');

		$this->load->language('payment/' . $name);

		if ($this->config->get($name . '_status')) {

			if ($total === false) { $total = $this->cart->getTotal(); }

			if ($this->config->get($name . '_total') > $total) { return array(); }

			$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "zone_to_geo_zone WHERE geo_zone_id = '" . (int)$this->config->get($name . '_geo_zone_id') . "' AND country_id = '" . (int)$address['country_id'] . "' AND (zone_id = '" . (int)$address['zone_id'] . "' OR zone_id = '0')");

			if (!$this->config->get($name . '_geo_zone_id')) {
        		$status = TRUE;
			} elseif ($query->num_rows) {
			  	$status = TRUE;
			} else {
				$status = FALSE;
			}
		} else {
			$status = FALSE;
		}

		$method_data = array();

		$fees = 0;

		if ($this->config->get($name . '_fees')) {
			if (!$this->config->get($name . '_fees_type')) {
				$fees = $this->config->get($name . '_fees');
			} elseif ($this->config->get($name . '_fees_type')) {
				$fees = ($this->config->get($name . '_fees') / 100) * $this->cart->getSubTotal();
			}
		}

		$feestxt = '';
		if ($fees) {
			$feestxt = "(".$this->currency->format($fees, false, false, true).")";
		}

		//Check that current Customer Group ID is allowed
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "setting WHERE `key` LIKE '" . $name . "_customer_group_%'");
		if ($query->num_rows) {
			$allowed = array();
			foreach($query->rows as $group) {
				$key = explode('_', $group['key']);
				$allowed[] = end($key);
			}
			if (!in_array($this->customer->getCustomerGroupId(), $allowed)) {
				$status = FALSE;
			}
		}

		if ($status) {
      		$method_data = array(
        		'id'	    => $name,
			'code'	    => 'pp_hosted',
        		'title'     => ($this->language->get('text_title') . $feestxt),
                        'terms'     => '',
			'sort_order'=> $this->config->get($name . '_sort_order'),
			'fees' 	    => number_format((float)$fees, 2, '.', '')
      		);
    	}

    	return $method_data;
  	}
  	public function editOrder($order_id, $data) 
  	{
		$this->event->trigger('pre.order.edit', $data);

		$this->db->query("UPDATE `" . DB_PREFIX . "order` SET customer_id = '" . (int)$data['customer_id'] . "', customer_group_id = '" . (int)$data['customer_group_id'] . "', firstname = '" . $this->db->escape($data['firstname']) . "', lastname = '" . $this->db->escape($data['lastname']) . "', email = '" . $this->db->escape($data['email']) . "', telephone = '" . $this->db->escape($data['telephone']) . "', fax = '" . $this->db->escape($data['fax']) . "', payment_firstname = '" . $this->db->escape($data['payment_firstname']) . "', payment_lastname = '" . $this->db->escape($data['payment_lastname']) . "', payment_address_1 = '" . $this->db->escape($data['payment_address_1']) . "', payment_city = '" . $this->db->escape($data['payment_city']) . "', payment_postcode = '" . $this->db->escape($data['payment_postcode']) . "', payment_country = '" . $this->db->escape($data['payment_country']) . "', payment_zone = '" . $this->db->escape($data['payment_zone']) . "', shipping_firstname = '" . $this->db->escape($data['shipping_firstname']) . "', shipping_lastname = '" . $this->db->escape($data['shipping_lastname']) . "', shipping_address_1 = '" . $this->db->escape($data['shipping_address_1']) . "', shipping_city = '" . $this->db->escape($data['shipping_city']) . "', shipping_postcode = '" . $this->db->escape($data['shipping_postcode']) . "', shipping_country = '" . $this->db->escape($data['shipping_country']) . "', shipping_zone = '" . $this->db->escape($data['shipping_zone']) . "', date_modified = NOW() WHERE order_id = '" . (int)$order_id . "'");
		
		$this->event->trigger('post.order.edit', $order_id);
	}
	
}
?>
