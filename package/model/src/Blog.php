<?php

namespace Nicepay;

use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Request;

class Blog
{
  public static $options = [];

  public function __construct()
  {
    if( !session()->has('LanguageID') ){
          session(['LanguageID' => 'no']);
        }
  }

  public static function index($params = null)
  {
    return "Test Blog Controller";
  }

  public static function getJsonPostDataNew($url, $data)
  {
        $url = 'https://dev.nicepay.co.id/nicepay/direct/v2/'.$url;
        $data = $data;

        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30000,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_POSTFIELDS => json_encode($data),
            CURLOPT_HTTPHEADER => array(
                // Set here requred headers
                "accept: */*",
                "accept-language: en-US,en;q=0.8",
                "content-type: application/json",
            ),
        ));

        $response = curl_exec($curl);
        $err = curl_error($curl);

        curl_close($curl);

        if ($err) {
            return "cURL Error #:" . $err;
        } else {
            return json_decode($response);
        }
  }

}
