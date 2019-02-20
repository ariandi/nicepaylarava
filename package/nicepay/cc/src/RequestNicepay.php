<?php

namespace Ari\Cc;

use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Request;
use Ari\Cc\ConfigVA;

class RequestNicepay
{
    public $_sock = 0;
    public $_apiUrl;
    public $_configNicepay;
    public $_port = 443;
    public $_status;
    public $_headers = "";
    public $_body = "";
    public $_request;
    public $_errorcode;
    public $_errormsg;
    public $_log;
    public $_timeout;

    public function __construct()
    {
        $this->_configNicepay = new ConfigVA;
    }

    public function operation($type) 
    {

        if ($type == "requestVA") {
            $this->_apiUrl = $this->_configNicepay->_reqVaUrl;
        } else if ($type == "creditCard") {
            $this->apiUrl = NICEPAY_REQ_CC_URL;
        } else if ($type == "checkPaymentStatus") {
            $this->apiUrl = NICEPAY_ORDER_STATUS_URL;
        } else if ($type == "cancelVA") {
            $this->apiUrl = NICEPAY_CANCEL_VA_URL;
        }

    }

  public function getJsonPostDataNew($data)
  {
        // $url = 'https://dev.nicepay.co.id/nicepay/direct/v2/'.$url;
        $data = $data;
        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => $this->_apiUrl,
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
            return $response;
        }
  }

  // Set POST parameter name and its value
  public function set($name, $value) {
      $this->requestData[$name] = $value;
  }

  // Retrieve POST parameter value
  public function get($name = null)
  {
      if (isset($this->requestData[$name])) {
        return $this->requestData[$name];
      }

      return "";
  }

  public function merchantToken() {
      return hash('sha256',   $this->get('timeStamp').
                              $this->get('iMid').
                              $this->get('referenceNo').
                              $this->get('amt').
                              $this->get('merchantKey')
      );
  }

  public function createVa()
  {
    $configVa = new ConfigVA;

    // Populate data
    $this->set('iMid', $configVa->_merchanId);
    $this->set('merchantKey', $configVa->_merchanKey);
    $this->set('merchantToken', $this->merchantToken());
    $this->set('dbProcessUrl', $configVa->_dbProcessUrl);
    $this->set('goodsNm', $this->get('description'));
    if ($this->get('cartData')  == "") {
        $this->set('cartData', '{}');
    }

    $this->set('reqDomain', 'http://merchant-doman');
    $this->set('reqServerIP', '127.0.0.1');
    $this->set('userIP', '127.0.0.1');
    $this->set('userSessionID', '1411aADAQZSFSDZ2323232');
    $this->set('userLanguage', 'id-ID');

    // Check Parameter
    $this->checkParam('iMid', '01');
    $this->checkParam('payMethod', '02');
    $this->checkParam('currency', '03');
    $this->checkParam('amt', '02');
    // $this->checkParam('instmntMon', '05');
    $this->checkParam('referenceNo', '06');
    $this->checkParam('goodsNm', '07');
    $this->checkParam('billingNm', '08');
    $this->checkParam('billingPhone', '09');
    $this->checkParam('billingEmail', '10');
    $this->checkParam('billingAddr', '11');
    $this->checkParam('billingCity', '12');
    $this->checkParam('billingState', '13');
    $this->checkParam('billingCountry', '14');
    $this->checkParam('deliveryNm', '15');
    $this->checkParam('deliveryPhone', '16');
    $this->checkParam('deliveryAddr', '17');
    $this->checkParam('deliveryCity', '18');
    $this->checkParam('deliveryState', '19');
    $this->checkParam('deliveryPostCd', '20');
    $this->checkParam('deliveryCountry', '21');
    // $this->checkParam('callBackUrl', '22');
    $this->checkParam('dbProcessUrl', '23');
    // $this->checkParam('vat', '24');
    // $this->checkParam('fee', '25');
    // $this->checkParam('notaxAmt', '26');
    $this->checkParam('description', '27');
    $this->checkParam('merchantToken', '28');
    $this->checkParam('bankCd', '29');

    // Send Request
    // $this->request->operation('requestVA');
    // $this->request->openSocket();
    // $this->resultData = $this->request->apiRequest($this->requestData);
    // unset($this->requestData);
    // return $this->resultData;
    return $this->get('userAgent');
  }

  public function checkParam($requestData, $errorNo)
  {
      if (null == $this->get($requestData))
      {
          // echo $requestData;die;
          die($this->getError($errorNo));
      }
  }


  public function getError($id)
    {
        $error = array(

            // That always Unknown Error :)
            '00' =>   array(
                'errorCode'    => '00000',
                'errorMsg' => 'Unknown error. Contact it.support@ionpay.net.'
            ),
            // General Mandatory parameters
            '01' =>   array(
                'error'    => '10001',
                'errorMsg' => '(iMid) is not set. Please set (iMid).'
            ),
            '02' =>   array(
                'error'    => '10002',
                'errorMsg' => '(payMethod) is not set. Please set (payMethod).'
            ),
            '03' =>   array(
                'error'    => '10003',
                'errorMsg' => '(currency) is not set. Please set (currency).'
            ),
            '04' =>   array(
                'error'    => '10004',
                'errorMsg' => '(amt) is not set. Please set (amt).'
            ),
            '05' =>   array(
                'error'    => '10005',
                'errorMsg' => '(instmntMon) is not set. Please set (instmntMon).'
            ),
            '06' =>   array(
                'error'    => '10006',
                'errorMsg' => '(referenceNo) is not set. Please set (referenceNo).'
            ),
            '07' =>   array(
                'error'    => '10007',
                'errorMsg' => '(goodsNm) is not set. Please set (goodsNm).'
            ),
            '08' =>   array(
                'error'    => '10008',
                'errorMsg' => '(billingNm) is not set. Please set (billingNm).'
            ),
            '09' =>   array(
                'error'    => '10009',
                'errorMsg' => '(billingPhone) is not set. Please set (billingPhone).'
            ),
            '10' =>   array(
                'error'    => '10010',
                'errorMsg' => '(billingEmail) is not set. Please set (billingEmail).'
            ),
            '11' =>   array(
                'error'    => '10011',
                'errorMsg' => '(billingAddr) is not set. Please set (billingAddr).'
            ),
            '12' =>   array(
                'error'    => '10012',
                'errorMsg' => '(billingCity) is not set. Please set (billingCity).'
            ),
            '13' =>   array(
                'error'    => '10013',
                'errorMsg' => '(billingState) is not set. Please set (billingState).'
            ),
            '14' =>   array(
                'error'    => '10014',
                'errorMsg' => '(billingCountry) is not set. Please set (billingCountry).'
            ),
            '15' =>   array(
                'error'    => '10015',
                'errorMsg' => '(deliveryNm) is not set. Please set (deliveryNm).'
            ),
            '16' =>   array(
                'error'    => '10016',
                'errorMsg' => '(deliveryPhone) is not set. Please set (deliveryPhone).'
            ),
            '17' =>   array(
                'error'    => '10017',
                'errorMsg' => '(deliveryAddr) is not set. Please set (deliveryAddr).'
            ),
            '18' =>   array(
                'error'    => '10018',
                'errorMsg' => '(deliveryCity) is not set. Please set (deliveryCity).'
            ),
            '19' =>   array(
                'error'    => '10019',
                'errorMsg' => '(deliveryState) is not set. Please set (deliveryState).'
            ),
            '20' =>   array(
                'error'    => '10020',
                'errorMsg' => '(deliveryPostCd) is not set. Please set (deliveryPostCd).'
            ),
            '21' =>   array(
                'error'    => '10021',
                'errorMsg' => '(deliveryCountry) is not set. Please set (deliveryCountry).'
            ),
            '22' =>   array(
                'error'    => '10022',
                'errorMsg' => '(callBackUrl) is not set. Please set (callBackUrl).'
            ), 
            '23' =>   array(
                'error'    => '10023',
                'errorMsg' => '(dbProcessUrl) is not set. Please set (dbProcessUrl).'
            ),
            '24' =>   array(
                'error'    => '10024',
                'errorMsg' => '(vat) is not set. Please set (vat).'
            ),
            '25' =>   array(
                'error'    => '10025',
                'errorMsg' => '(fee) is not set. Please set (fee).'
            ),
            '26' =>   array(
                'error'    => '10026',
                'errorMsg' => '(notaxAmt) is not set. Please set (notaxAmt).'
            ),
            '27' =>   array(
                'error'    => '10027',
                'errorMsg' => '(description) is not set. Please set (description).'
            ),
            '28' =>   array(
                'error'    => '10028',
                'errorMsg' => '(merchantToken) is not set. Please set (merchantToken).'
            ),
            '29' =>   array(
                'error'    => '10029',
                'errorMsg' => '(bankCd) is not set. Please set (bankCd).'
            ),

            // Mandatory parameters to Check Order Status
            '30' =>   array(
                'error'    => '10030',
                'errorMsg' => '(tXid) is not set. Please set (tXid).'
            ),
            // Add by Ariandi
            '31' =>   array(
                'error'    => '10031',
                'errorMsg' => '(customerId) is not set. Please set (customerId).'
            ),
            '32' =>   array(
                'error'    => '10032',
                'errorMsg' => '(customerNm) is not set. Please set (customerNm).'
            ),

        );
        return (json_encode($error[$id]));
    }

}
