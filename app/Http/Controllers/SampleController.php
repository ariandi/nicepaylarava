<?php
namespace App\Http\Controllers;

use Ari\Cc\Blog;

class SampleController extends Controller {

  public function index()
  {
    $data = [
      "timeStamp" => "20180123100505",
      "iMid" => "IONPAYTEST",
      "payMethod" => "02",
      "currency" => "IDR",
      "amt" => "10000",
      "referenceNo" => "ORD12345",
      "goodsNm" => "Test Transaction Nicepay",
      "billingNm" => "Customer Name",
      "billingPhone" => "12345678",
      "billingEmail" => "email@merchant.com",
      "billingAddr" => "Jalan Bukit Berbunga 22",
      "billingCity" => "Jakarta",
      "billingState" => "DKI Jakarta",
      "billingPostCd" => "12345",
      "billingCountry" => "Indonesia",
      "deliveryNm" => "email@merchant.com",
      "deliveryPhone" => "12345678",
      "deliveryAddr" => "Jalan Bukit Berbunga 22",
      "deliveryCity" => "Jakarta",
      "deliveryState" => "DKI Jakarta",
      "deliveryPostCd" => "12345",
      "deliveryCountry" => "Indonesia",
      "description" => "Transaction Description",
      "dbProcessUrl" => "http => //ptsv2.com/t/0ftrz-1519971382/post",
      "merchantToken" => "f9d30f6c972e2b5718751bd087b178534673a91bbac845f8a24e60e8e4abbbc5",
      "reqDomain" => "merchant.com",
      "reqServerIP" => "127.0.0.1",
      "userIP" => "127.0.0.1",
      "userSessionID" => "697D6922C961070967D3BA1BA5699C2C",
      "userAgent" => "Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML,like Gecko) Chrome/60.0.3112.101 Safari/537.36",
      "userLanguage" => "ko-KR,en-US;q=0.8,ko;q=0.6,en;q=0.4",
      "cartData" => "{}",
      "bankCd" => "BMRI",
      "vacctValidDt" => "",
      "vacctValidTm" => "",
      "merFixAcctId" => ""
    ];

    $req = Blog::getJsonPostDataNew('registration', $data);

    $ip = Blog::getClientIps();
    return print_r($ip);

    return json_decode($req, true);
  }

}
