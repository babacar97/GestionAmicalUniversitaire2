<?php

namespace App\Service;

use App\Entity\Campaign;
use App\Entity\Contribution;
use GuzzleHttp\Client;
use Symfony\Component\HttpFoundation\Response;

class PaydunyaService {

    private $masterKey;
    private $publicKey;
    private $privateKey;
    private $token;
    private $mode;
    private $name;
    private $tagLine;
    private $phoneNumber;
    private $postalAddress;
    private $webSiteUrl;
    private $logoUrl;
    private $urlCallBack;
    private $returnUrlStore;
    private $cancelUrlStore;
    private $returnUrlInvoice;
    private $cancelUrlInvoice;
    private $initDeboursement;
    private $submitDeboursement;
    private $checkDeboursement;

    public function __construct(
        string $masterKey, 
        string $publicKey, 
        string $privateKey, 
        string $token,
        string $mode,
        string $name,
        string $tagLine,
        string $phoneNumber,
        string $postalAddress,
        string $webSiteUrl,
        string $logoUrl,
        string $urlCallBack,
        string $cancelUrlInvoice,
        string $returnUrlInvoice,
        string $cancelUrlStore,
        string $returnUrlStore,
        string $initDeboursement,
        string $submitDeboursement,
        string $checkDeboursement)
    {
        $this->masterKey = $masterKey;
        $this->publicKey = $publicKey;
        $this->privateKey = $privateKey;
        $this->token = $token;
        $this->mode = $mode;
        $this->name = $name ;
        $this->tagLine = $tagLine;
        $this->phoneNumber = $phoneNumber;
        $this->postalAddress = $postalAddress;
        $this->webSiteUrl = $webSiteUrl;
        $this->logoUrl = $logoUrl;
        $this->urlCallBack = $urlCallBack;
        $this->cancelUrlInvoice = $cancelUrlInvoice;
        $this->returnUrlInvoice = $returnUrlInvoice;
        $this->cancelUrlStore = $cancelUrlStore;
        $this->returnUrlStore = $returnUrlStore;
        $this->initDeboursement = $initDeboursement;
        $this->submitDeboursement = $submitDeboursement;
        $this->checkDeboursement = $checkDeboursement;
        $this->setup();
        $this->store();
    }


    public function setup(){
        \Paydunya\Setup::setMasterKey($this->getMasterKey());
        \Paydunya\Setup::setPublicKey($this->getPublicKey());
        \Paydunya\Setup::setPrivateKey($this->getPrivateKey());
        \Paydunya\Setup::setToken($this->getToken());
        \Paydunya\Setup::setMode($this->getMode());
    }

    public function store(){
        //Configuration des informations de votre service/entreprise
        \Paydunya\Checkout\Store::setName($this->getName()); // Seul le nom est requis
        \Paydunya\Checkout\Store::setTagline($this->getTagLine());
        \Paydunya\Checkout\Store::setPhoneNumber($this->getPhoneNumber());
        \Paydunya\Checkout\Store::setPostalAddress($this->getPostalAddress());
        \Paydunya\Checkout\Store::setWebsiteUrl($this->getWebSiteUrl());
        \Paydunya\Checkout\Store::setLogoUrl($this->getLogoUrl());
        \Paydunya\Checkout\Store::setCallbackUrl($this->getUrlCallBack());
        \Paydunya\Checkout\Store::setReturnUrl($this->getReturnUrlStore());
        \Paydunya\Checkout\Store::setCancelUrl($this->getCancelUrlStore());
    }

    public function payment(Campaign $campaign, Contribution $contribution){
        $invoice = new \Paydunya\Checkout\CheckoutInvoice();
        $amount = $contribution->getAmount();
        $invoice->addItem($campaign->getTitle(), 1, $amount, $amount);
        $invoice->setTotalAmount($amount);
        $invoice->setDescription("Cagnotte pour ".$campaign->getBeneficiary());
        $invoice->addCustomData("idCampaign", $campaign->getId());
        $invoice->addCustomData("name", $contribution->getName());
        $invoice->addCustomData("firstname", $contribution->getFirstname());
        $invoice->addCustomData("profession", $contribution->getProfession());
        $invoice->addCustomData("tel", $contribution->getTel());
        $invoice->addCustomData("isAnonymous", $contribution->getIsAnonymous());
        $invoice->addCustomData("amount", $amount);
        $invoice->setCancelUrl($this->getCancelUrlInvoice());
        $invoice->setReturnUrl($this->getReturnUrlInvoice());
        $invoice->addChannels(['card', 'wizall-senegal','expresso-sn', 'orange-money-senegal','free-money-senegal','wave-senegal']);
        if($invoice->create()) {
            return [
                "status" => Response::HTTP_OK,
                "url" => $invoice->getInvoiceUrl()
            ];
        }else{
            return [
                "status" => Response::HTTP_BAD_REQUEST,
                "message" => $invoice->response_text
            ];
        }
    }

    public function checkInvoice($token){
        //A insérer dans le fichier du code source qui doit effectuer l'action
        $invoice = new \Paydunya\Checkout\CheckoutInvoice();
        if ($invoice->confirm($token)) {
            return [
                "status" => $invoice->getStatus(),
                "name" => $invoice->getCustomerInfo('name'),
                "email" => $invoice->getCustomerInfo('email'),
                "phone" => $invoice->getCustomerInfo('phone'),
                "urlPdf" => $invoice->getReceiptUrl(),

                // Récupérer n'importe laquelle des données personnalisées que
                // vous avez eu à rajouter précédemment à la facture.
                // Merci de vous assurer à utiliser les mêmes clés que celles utilisées
                // lors de la configuration.
                "contribution"=>[
                    "idCampaign" => $invoice->getCustomData("idCampaign"),
                    "name" => $invoice->getCustomData("name"),
                    "firstname" => $invoice->getCustomData("firstname"),
                    "profession" => $invoice->getCustomData("profession"),
                    "tel" => $invoice->getCustomData("tel"),
                    "isAnonymous" => $invoice->getCustomData("isAnonymous"),
                    "amount" => $invoice->getCustomData("amount"),

                    // Vous pouvez aussi récupérer le montant total spécifié précédemment
                    "totalAmount" => $invoice->getTotalAmount()
                ]
            ];

        }else{

            return [
                "status" => $invoice->getStatus(),
                "message" => $invoice->response_text,
                "code" => $invoice->response_code
            ];
        }
    }

    public function initDeboursement($content){
    //' { "account_alias" : "771111111", "amount" : 4500, "withdraw_mode" : "orange-money-senegal" }
        return $this->deboursement($content,$this->getInitDeboursement());
    }

    public function submitDeboursement($content){

    //' {"disburse_invoice": "hwTHAS0WvTmTaYT2zDoO ", " disburse_id ": "456678900309" }'
        return $this->deboursement($content,$this->getSubmitDeboursement());
    }

    public function checkDeboursement($content){

        //' {"disburse_invoice": "hwTHAS0WvTmTaYT2zDoO"}'
        return  $this->deboursement($content,$this->getCheckDeboursement());

    }

    public function deboursement($content,$url){

        //' {"disburse_invoice": "hwTHAS0WvTmTaYT2zDoO"}'
        $client = new Client();

        $response = $client->request('POST', $url, [
            'headers' => [
                'Content-Type' => 'application/json',
                'PAYDUNYA-MASTER-KEY'=> $this->getMasterKey(),
                'PAYDUNYA-PRIVATE-KEY'=> $this->getPrivateKey(),
                'PAYDUNYA-TOKEN'=>$this->getToken()
            ],
            'body' => $content
        ]);

        return $response;
    }

    /**
     * Get the value of masterKey
     */ 
    public function getMasterKey()
    {
        return $this->masterKey;

    }

    /**
     * Set the value of masterKey
     *
     * @return  self
     */ 
    public function setMasterKey($masterKey)
    {
        $this->masterKey = $masterKey;

        return $this;
    }

    /**
     * Get the value of publicKey
     */ 
    public function getPublicKey()
    {
        return $this->publicKey;
    }

    /**
     * Set the value of publicKey
     *
     * @return  self
     */ 
    public function setPublicKey($publicKey)
    {
        $this->publicKey = $publicKey;

        return $this;
    }

    /**
     * Get the value of privateKey
     */ 
    public function getPrivateKey()
    {
        return $this->privateKey;
    }

    /**
     * Set the value of privateKey
     *
     * @return  self
     */ 
    public function setPrivateKey($privateKey)
    {
        $this->privateKey = $privateKey;

        return $this;
    }

    /**
     * Get the value of token
     */ 
    public function getToken()
    {
        return $this->token;
    }

    /**
     * Set the value of token
     *
     * @return  self
     */ 
    public function setToken($token)
    {
        $this->token = $token;

        return $this;
    }

    /**
     * Get the value of mode
     */ 
    public function getMode()
    {
        return $this->mode;
    }

    /**
     * Set the value of mode
     *
     * @return  self
     */ 
    public function setMode($mode)
    {
        $this->mode = $mode;

        return $this;
    }

    /**
     * Get the value of name
     */ 
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set the value of name
     *
     * @return  self
     */ 
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get the value of tagLine
     */ 
    public function getTagLine()
    {
        return $this->tagLine;
    }

    /**
     * Set the value of tagLine
     *
     * @return  self
     */ 
    public function setTagLine($tagLine)
    {
        $this->tagLine = $tagLine;

        return $this;
    }

    /**
     * Get the value of phoneNumber
     */ 
    public function getPhoneNumber()
    {
        return $this->phoneNumber;
    }

    /**
     * Set the value of phoneNumber
     *
     * @return  self
     */ 
    public function setPhoneNumber($phoneNumber)
    {
        $this->phoneNumber = $phoneNumber;

        return $this;
    }

    /**
     * Get the value of postalAddress
     */ 
    public function getPostalAddress()
    {
        return $this->postalAddress;
    }

    /**
     * Set the value of postalAddress
     *
     * @return  self
     */ 
    public function setPostalAddress($postalAddress)
    {
        $this->postalAddress = $postalAddress;

        return $this;
    }

    /**
     * Get the value of webSiteUrl
     */ 
    public function getWebSiteUrl()
    {
        return $this->webSiteUrl;
    }

    /**
     * Set the value of webSiteUrl
     *
     * @return  self
     */ 
    public function setWebSiteUrl($webSiteUrl)
    {
        $this->webSiteUrl = $webSiteUrl;

        return $this;
    }

    /**
     * Get the value of logoUrl
     */ 
    public function getLogoUrl()
    {
        return $this->logoUrl;
    }

    /**
     * Set the value of logoUrl
     *
     * @return  self
     */ 
    public function setLogoUrl($logoUrl)
    {
        $this->logoUrl = $logoUrl;

        return $this;
    }

    public function getUrlCallBack(){

        return $this->urlCallBack;
    }

    public function setUrlCallBack($urlCallBack){

        $this->urlCallBack = $urlCallBack;

        return $this;
    }

    public function getReturnUrlStore(){

        return $this->returnUrlStore;
    }

    public function setReturnUrlStore($returnUrlStore){

        $this->returnUrlStore = $returnUrlStore;

        return $this;
    }

    public function getCancelUrlStore(){

        return $this->cancelUrlStore;
    }

    public function setCancelUrlStore($cancelUrlStore){

        $this->cancelUrlStore = $cancelUrlStore;

        return $this;
    }

    public function getReturnUrlInvoice(){

        return $this->returnUrlInvoice;
    }

    public function setReturnUrlInvoice($returnUrlInvoice){

        $this->returnUrlInvoice = $returnUrlInvoice;

        return $this;
    }

    public function getCancelUrlInvoice(){

        return $this->cancelUrlInvoice;
    }

    public function setCancelUrlInvoice($cancelUrlInvoice){

        $this->cancelUrlInvoice = $cancelUrlInvoice;

        return $this;
    }

    /**
     * Get the value of initDeboursement
     */ 
    public function getInitDeboursement()
    {
        return $this->initDeboursement;
    }

    /**
     * Set the value of initDeboursement
     *
     * @return  self
     */ 
    public function setInitDeboursement($initDeboursement)
    {
        $this->initDeboursement = $initDeboursement;

        return $this;
    }

    /**
     * Get the value of submitDeboursement
     */ 
    public function getSubmitDeboursement()
    {
        return $this->submitDeboursement;
    }

    /**
     * Set the value of submitDeboursement
     *
     * @return  self
     */ 
    public function setSubmitDeboursement($submitDeboursement)
    {
        $this->submitDeboursement = $submitDeboursement;

        return $this;
    }

    /**
     * Get the value of checkDeboursement
     */ 
    public function getCheckDeboursement()
    {
        return $this->checkDeboursement;
    }

    /**
     * Set the value of checkDeboursement
     *
     * @return  self
     */ 
    public function setCheckDeboursement($checkDeboursement)
    {
        $this->checkDeboursement = $checkDeboursement;

        return $this;
    }
}