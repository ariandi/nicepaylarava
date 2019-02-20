<?php

namespace Ari\Cc;

use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Request;

class ConfigVA
{
  public  $_merchanId, $_merchanKey, $_dbProcessUrl, $_timeoutConnect,
          $_timeoutRead, $_reqVaUrl, $_inqVaUrl,
          $_cancelVaUrl, $_readTimeoutError;

  public function __construct()
  {
    $this->_dbProcessUrl = 'http://localhost/laratest/public/nicepay/dbProcessUrl';
    $this->_timeoutConnect = 15;
    $this->_timeoutRead = 25;
    $this->_reqVaUrl = 'https://dev.nicepay.co.id/nicepay/direct/v2/registration';
    $this->_inqVaUrl = 'https://dev.nicepay.co.id/nicepay/direct/v2/inquiry';
    $this->_cancelVaUrl = 'https://dev.nicepay.co.id/nicepay/direct/v2/cancel';
    $this->__readTimeoutError = 10200;

    $this->_merchanId = env("MERCHANT_ID", "IONPAYTEST");
    $this->_merchanKey = env("MERCHANT_KEY", "33F49GnCMS1mFYlGXisbUDzVf2ATWCl9k3R++d5hDd3Frmuos/XLx8XhXpe+LDYAbpGKZYSwtlyyLOtS/8aD7A==");
  }

  public static function index($params = null)
  {
    return "Test Blog Controller";
  }
}
