<?php

namespace App\Services;

use Iyzipay\Model\Address;
use Iyzipay\Model\BasketItem;
use Iyzipay\Model\BasketItemType;
use Iyzipay\Model\Buyer;
use Iyzipay\Model\CheckoutFormInitialize;
use Iyzipay\Model\Currency;
use Iyzipay\Model\Locale;
use Iyzipay\Model\PaymentGroup;
use Iyzipay\Model\Subscription\SubscriptionInitialize;
use Iyzipay\Options;
use Iyzipay\Request\CreateCheckoutFormInitializeRequest;
use Iyzipay\Request\CreateSubscriptionInitializeRequest;
use Iyzipay\Request\RetrieveCheckoutFormRequest;
use Illuminate\Support\Facades\Log;

class IyzicoService
{
    protected $options;

    public function __construct()
    {
        $this->options = new Options();
        $this->options->setApiKey(config('iyzico.api_key'));
        $this->options->setSecretKey(config('iyzico.secret_key'));
        $this->options->setBaseUrl(config('iyzico.base_url'));
    }

    /**
     * Ödeme formu başlatır
     *
     * @param array $params Form parametreleri
     * @return mixed
     */
    public function initializeCheckoutForm(array $params)
    {
        try {
            $request = new CreateCheckoutFormInitializeRequest();
            $request->setLocale($params['locale'] ?? Locale::TR);
            $request->setConversationId($params['conversation_id']);
            $request->setPrice($params['price']);
            $request->setPaidPrice($params['paid_price']);
            $request->setCurrency($params['currency'] ?? Currency::TL);
            $request->setBasketId($params['basket_id']);
            $request->setPaymentGroup($params['payment_group'] ?? PaymentGroup::PRODUCT);
            $request->setCallbackUrl($params['callback_url']);
            $request->setEnabledInstallments($params['enabled_installments'] ?? [1, 2, 3, 6, 9]);

            $buyer = new Buyer();
            $buyer->setId($params['buyer']['id']);
            $buyer->setName($params['buyer']['name']);
            $buyer->setSurname($params['buyer']['surname']);
            $buyer->setGsmNumber($params['buyer']['gsm_number']);
            $buyer->setEmail($params['buyer']['email']);
            $buyer->setIdentityNumber($params['buyer']['identity_number']);
            $buyer->setRegistrationAddress($params['buyer']['address']);
            $buyer->setIp($params['buyer']['ip']);
            $buyer->setCity($params['buyer']['city']);
            $buyer->setCountry($params['buyer']['country']);
            $request->setBuyer($buyer);

            $shippingAddress = new Address();
            $shippingAddress->setContactName($params['shipping_address']['contact_name']);
            $shippingAddress->setCity($params['shipping_address']['city']);
            $shippingAddress->setCountry($params['shipping_address']['country']);
            $shippingAddress->setAddress($params['shipping_address']['address']);
            $request->setShippingAddress($shippingAddress);

            $billingAddress = new Address();
            $billingAddress->setContactName($params['billing_address']['contact_name']);
            $billingAddress->setCity($params['billing_address']['city']);
            $billingAddress->setCountry($params['billing_address']['country']);
            $billingAddress->setAddress($params['billing_address']['address']);
            $request->setBillingAddress($billingAddress);

            $basketItems = [];
            foreach ($params['basket_items'] as $item) {
                $basketItem = new BasketItem();
                $basketItem->setId($item['id']);
                $basketItem->setName($item['name']);
                $basketItem->setCategory1($item['category1']);
                $basketItem->setItemType($item['item_type'] ?? BasketItemType::VIRTUAL);
                $basketItem->setPrice($item['price']);
                $basketItems[] = $basketItem;
            }
            $request->setBasketItems($basketItems);

            return CheckoutFormInitialize::create($request, $this->options);
        } catch (\Exception $e) {
            Log::error('İyzico checkout form initialization error: ' . $e->getMessage());
            return ['error' => $e->getMessage()];
        }
    }

    /**
     * Ödeme formu sonucunu alır
     *
     * @param string $token Form token
     * @return mixed
     */
    public function retrieveCheckoutForm(string $token)
    {
        try {
            $request = new RetrieveCheckoutFormRequest();
            $request->setLocale(Locale::TR);
            $request->setToken($token);

            return \Iyzipay\Model\CheckoutForm::retrieve($request, $this->options);
        } catch (\Exception $e) {
            Log::error('İyzico retrieve checkout form error: ' . $e->getMessage());
            return ['error' => $e->getMessage()];
        }
    }

    /**
     * Abonelik başlatır
     * 
     * @param array $params Abonelik parametreleri
     * @return mixed
     */
    public function initializeSubscription(array $params)
    {
        try {
            $request = new CreateSubscriptionInitializeRequest();
            $request->setLocale($params['locale'] ?? Locale::TR);
            $request->setConversationId($params['conversation_id']);
            $request->setPricingPlanReferenceCode($params['pricing_plan_reference_code']);
            $request->setSubscriptionInitialStatus($params['initial_status'] ?? 'ACTIVE');
            $request->setCallbackUrl($params['callback_url']);
            
            $buyer = new Buyer();
            $buyer->setId($params['buyer']['id']);
            $buyer->setName($params['buyer']['name']);
            $buyer->setSurname($params['buyer']['surname']);
            $buyer->setGsmNumber($params['buyer']['gsm_number']);
            $buyer->setEmail($params['buyer']['email']);
            $buyer->setIdentityNumber($params['buyer']['identity_number']);
            $buyer->setRegistrationAddress($params['buyer']['address']);
            $buyer->setIp($params['buyer']['ip']);
            $buyer->setCity($params['buyer']['city']);
            $buyer->setCountry($params['buyer']['country']);
            $request->setBuyer($buyer);
            
            $billingAddress = new Address();
            $billingAddress->setContactName($params['billing_address']['contact_name']);
            $billingAddress->setCity($params['billing_address']['city']);
            $billingAddress->setCountry($params['billing_address']['country']);
            $billingAddress->setAddress($params['billing_address']['address']);
            $request->setBillingAddress($billingAddress);
            
            return SubscriptionInitialize::create($request, $this->options);
        } catch (\Exception $e) {
            Log::error('İyzico subscription initialization error: ' . $e->getMessage());
            return ['error' => $e->getMessage()];
        }
    }
} 