<?php

class Bdt_PaymentCharge_Helper_Data extends Mage_Core_Helper_Abstract
{
	/**
	 * Get payment charge
	 * @param string $code
	 * @param Mage_Sales_Model_Quote $quote
	 * @return float
	 */
	public function getPaymentCharge($code, $quote=null)
	{
        //paypal_standard
		if (is_null($quote)) {
			$quote = Mage::getSingleton('checkout/session')->getQuote();
		}
		$amount = 0;
		$address = $quote->isVirtual() ? $quote->getBillingAddress() : $quote->getShippingAddress();
		
		if (preg_match("/paypal_standard/i", strval($code))) {

			$chargeType = Mage::getStoreConfig('payment/settings_payments_standart/charge_type');
        	$chargeValue = Mage::getStoreConfig('payment/settings_payments_standart/charge_value');

		}
		else {
			$chargeType = Mage::getStoreConfig('payment/'.strval($code).'/charge_type');
        	 $chargeValue = Mage::getStoreConfig('payment/'.strval($code).'/charge_value');

		}
        if ($chargeValue ) {
            $amount = array();
        	if ($chargeType=="percentage") {

                $subTotal = $address->getSubtotal();
                $amount['amount'] = $subTotal * floatval($chargeValue) / 100;

                $baseSubTotal = $address->getBaseSubtotal();
                $amount['base_amount'] = $baseSubTotal * floatval($chargeValue) / 100;

        	}
        	else {
                 $baseCurrency = Mage::app()->getStore()->getBaseCurrencyCode();
                 $currentCurrency = Mage::app()->getStore()->getCurrentCurrencyCode();

                $amount['amount'] = floatval(Mage::helper('directory')->currencyConvert($chargeValue, $baseCurrency, $currentCurrency));

                $amount['base_amount'] = floatval($chargeValue);
        	}            	
        }
        return $amount;
	}
}
