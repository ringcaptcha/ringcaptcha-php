<?php

/**
 * Ringcaptcha class
 *
 * Provides simplified interaction with the Ringcaptcha verification REST API.
 *
 * @package Ringcaptcha
 * @author  Cristian Iturri <iturri.cf@gmail.com>
 * @license http://www.gnu.org/licenses/gpl-3.0.html GNU General Public License
 * @link    http://ringcaptcha.com/
 */
class Ringcaptcha
{
    const RC_SERVER     = 'api.ringcaptcha.com';
    const USER_AGENT    = 'ringcaptcha-php/1.0';

    private $version    = '1.0';

    private $isSecure;

    private $appKey;
    private $secretKey;
    private $retryAttempts;

    private $status;
    private $message;

    private $transactionID;
    private $phoneNumber;
    private $geolocation;


    public function __construct($appKey, $secretKey)
    {
        $this->appKey           = $appKey;
        $this->secretKey        = $secretKey;
        $this->retryAttempts    = 0;
        $this->isSecure         = true;
        $this->status           = -1;
    }

    public function isValid($pinCode, $token)
    {
        // @TODO: Check parameters

        $data = array(
            'secret_key' => $this->secretKey,
            'token'      => $token,
            'code'       => $pinCode,
        );

        $this->sanitizeData($data);

        $server   = (($this->isSecure) ? 'https://' : 'http://')
            . self::RC_SERVER;

        $resource = "/{$this->appKey}/verify";

        try {
            $response = $this->ringcaptchaVerifyRESTCall(
                $server,
                $resource,
                $data
            );

            $jsonData = json_decode($response, true);

            if ($jsonData['status'] == 'SUCCESS') {
                $this->status = 1;
            } else {
                $this->status = 0;
            }
        } catch (Exception $e) {
            $this->status = 0;
            $this->message = $e->getMessage();

            return false;
        }

        $this->transactionID = isset($jsonData['id']) ? $jsonData['id'] : false;
        $this->phoneNumber = isset($jsonData['phone']) ? $jsonData['phone'] : false;
        $this->geolocation = isset($jsonData['geolocation']) ? $jsonData['geolocation'] : false;
        $this->message = isset($jsonData['message']) ? $jsonData['message'] : false;

        return ($this->status == 1);

    }

    public function setSecure($secure)
    {
        $this->isSecure = ($secure);
    }

    public function getStatus()
    {
        switch ($this->status) {
            case 1:
                return "SUCCESS";
            case 0:
                return "ERROR";
            default:
                return "UNDEFINED";
        }
    }

    public function getMessage()
    {
        return $this->message;
    }

    public function getId()
    {
        return $this->transactionID;
    }

    public function getPhoneNumber()
    {
        return $this->phoneNumber;
    }

    public function isGeolocated()
    {
        return $this->geolocation;
    }

    private function sanitizeData(&$data)
    {
        foreach ($data as $key => $value) {
            $data[$key] = trim(urlencode($value));
        }
    }

    private function ringcaptchaVerifyRESTCall($server, $resource, $data, $port = 80)
    {
        $query      = http_build_query($data, '', '&');
        $url        = $server . $resource;

        $request    = curl_init($url);

        if ($this->isSecure) {
            curl_setopt($request, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($request, CURLOPT_SSL_VERIFYHOST, 2);
            curl_setopt($request, CURLOPT_PORT, 443);
        } else {
            curl_setopt($request, CURLOPT_PORT, $port);
        }

        curl_setopt($request, CURLOPT_USERAGENT, self::USER_AGENT);
        curl_setopt($request, CURLOPT_POST, true);
        curl_setopt($request, CURLOPT_POSTFIELDS, $query);
        curl_setopt($request, CURLOPT_RETURNTRANSFER, true);

        $response   = curl_exec($request);

        if (!$response) {
            throw new Exception('ERROR_PROCESING_REQUEST');
        }

        return $response;
    }
}