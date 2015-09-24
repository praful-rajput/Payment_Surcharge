<?php

/**
 * Created by PhpStorm.
 * User: praful.rajput
 * Date: 9/23/2015
 * Time: 3:53 PM
 */
class Bdt_PaymentCharge_Model_Observer extends Mage_Core_Model_Abstract
{
    public function addScreenToPayPal($observer)
    {
        $paypal_cart = $observer->getEvent()->getPaypalCart();
        if ($paypal_cart && $paypal_cart->getSalesEntity()) {
            $amount = $paypal_cart->getSalesEntity()->getPaymentCharge();
            if ($amount) {
                $paypal_cart->addItem(Mage::helper('paymentcharge')->__('Payment Charges'), 1, $amount, 'pchrgs');
            }
        }
        return $this;
    }
}