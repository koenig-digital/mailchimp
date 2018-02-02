<?php

namespace Kof\Mailchimp\Finisher;

use In2code\Powermail\Domain\Model\Mail;
use In2code\Powermail\Finisher\AbstractFinisher;


/**
 * Class DoSomethingFinisher
 *
 * @package Vendor\Ext\Finisher
 */
class MailchimpFinisher extends AbstractFinisher
{

    /**
     * @var Mail
     */
    protected $mail;

    /**
     * @var array
     */
    protected $configuration;

    /**
     * @var array
     */
    protected $settings;

    /**
     * Will be called always at first
     *
     * @return void
     */
    public function initializeFinisher()
    {
    }

    /**
     * Will be called before myFinisher()
     *
     * @return void
     */
    public function initializeMyFinisher()
    {
    }

    /**
     * MyFinisher
     *
     * @return void
     */
    public function myFinisher()
    {
        //Email aus Formular
        $email = $this->getMail()->getAnswersByFieldMarker()['e_mail']->getValue();


    //Mailchimp Settings
    $apiKey = '###';
    $listId = '###';
    $server = 'us2.';

    //Mailchimp API Funktion
    $auth = base64_encode('user:' . $apiKey);
    $data = array(
        'apikey' => $apiKey,
        'email_address' => $email,
        'status' => 'pending',
    );

    $json_data = json_encode($data);
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, 'https://' . $server . 'api.mailchimp.com/3.0/lists/' . $listId . '/members/');
    curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json',
        'Authorization: Basic ' . $auth));
    curl_setopt($ch, CURLOPT_USERAGENT, 'PHP-MCAPI/2.0');
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_TIMEOUT, 10);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $json_data);
    $result = curl_exec($ch);

}

     

  
  return true;
  
    }
}