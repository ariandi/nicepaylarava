<?php

namespace Ari\Cc;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Ari\Cc\Blog;

class NicepayVaController extends Controller
{
    public function index()
    {
        return view('cc::list');
    }

    public function regisVA(Request $request)
    {
        $timeStamp = date('YmdHis');

        $paramsVa = new Blog();
        $paramsVa->set('timeStamp', $timeStamp);
        $paramsVa->set('userIP', self::getUserIP());
        $paramsVa->set('description', $request->description);
        $paramsVa->set('payMethod', '02');
        $paramsVa->set('currency', 'IDR');
        $paramsVa->set('amt', $request->amt);
        $paramsVa->set('referenceNo', 'REF'.$timeStamp);
        $paramsVa->set('billingNm', $request->billingNm);
        $paramsVa->set('billingPhone', $request->billingPhone);
        $paramsVa->set('billingEmail', $request->billingEmail);
        $paramsVa->set('billingAddr', $request->billingAddr);
        $paramsVa->set('billingCity', $request->billingCity);
        $paramsVa->set('billingState', $request->billingState);
        $paramsVa->set('billingCountry', $request->billingCountry);
        $paramsVa->set('billingPostCd', $request->billingPostCd);
        $paramsVa->set('userAgent', $request->server('HTTP_USER_AGENT'));
        $paramsVa->set('bankCd', $request->bankCd);

        if( $request->billingAddrShipp == 1 ){
            $paramsVa->set('deliveryNm', $request->billingNm);
            $paramsVa->set('deliveryPhone', $request->billingPhone);
            // $paramsVa->set('deliveryEmail', $request->billingEmail);
            $paramsVa->set('deliveryAddr', $request->billingAddr);
            $paramsVa->set('deliveryCity', $request->billingCity);
            $paramsVa->set('deliveryState', $request->billingState);
            $paramsVa->set('deliveryCountry', $request->billingCountry);
            $paramsVa->set('deliveryPostCd', $request->billingPostCd);
        }else{
            $paramsVa->set('deliveryNm', $request->deliveryNm);
            $paramsVa->set('deliveryPhone', $request->deliveryPhone);
            //  $paramsVa->set('deliveryEmail', $request->deliveryEmail);
            $paramsVa->set('deliveryAddr', $request->deliveryAddr);
            $paramsVa->set('deliveryCity', $request->deliveryCity);
            $paramsVa->set('deliveryState', $request->deliveryState);
            $paramsVa->set('deliveryCountry', $request->deliveryCountry);
            $paramsVa->set('deliveryPostCd', $request->deliveryPostCd);
        }

        $response = $paramsVa->createVa();
        $response = json_decode($response, true);
        // print_r($response);die;
        if($response['resultCd'] == '0000'){
            $response['bankName'] = $this->bank_name( $response['bankCd'] )['bankName'];
            $response['bankAtm'] = $this->bank_name( $response['bankCd'] )['bankAtm'];
            $response['bankMobileBank'] = $this->bank_name( $response['bankCd'] )['bankMobileBank'];
            $response['bankInternetBank'] = $this->bank_name( $response['bankCd'] )['bankInternetBank'];
            return view('cc::response', ['response' => $response]);
        } elseif ( is_array($response) ) {
            return redirect()->route('va-regis-request')
                        ->with('error', 'Error '.$response['resultCd'].' : '.$response['resultMsg']);
        } else{
            return redirect()->route('va-regis-request')
                        ->with('error', 'Unknow Error');
        }
    }

    public function getUserIP() 
    {
       $clientIP = \Request::ip();
       return $clientIP;
    }

    public function bank_name($bankCd)
    {
        $bank_info = [];
        switch ($bankCd) {
            case 'BMRI':
                $bank_info['bankName'] = 'Mandiri';

                $bank_info['bankAtm'] = '<h4>Panduan Bayar</h4>
                        <ul>
                            <li>Input kartu ATM dan PIN Anda</li>
                            <li>Pilih Menu Bayar/Beli</li>
                            <li>Pilih Lainnya</li>
                            <li>Pilih Multi Payment</li>
                            <li>Input 70014 sebagai Kode Institusi</li>
                            <li>Input Virtual Account Number, misal. 70014XXXXXXXXXXX</li>
                            <li>Pilih Benar</li>
                            <li>Pilih Ya</li>
                            <li>Pilih Ya</li>
                            <li>Ambil bukti bayar Anda</li>
                            <li>Selesai</li>
                        </ul>';

                $bank_info['bankMobileBank'] = '<h4>Panduan Bayar</h4>
                        <ul>
                            <li>Login Mobile Banking</li>
                            <li>Pilih Bayar</li>
                            <li>Pilih Multi Payment</li>
                            <li>Input Transferpay sebagai Penyedia Jasa</li>
                            <li>Input Nomor Virtual Account, misal. 70014XXXXXXXXXXX sebagai Kode Bayar</li>
                            <li>Pilih Lanjut</li>
                            <li>Input OTP and PIN</li>
                            <li>Pilih OK</li>
                            <li>Bukti bayar ditampilkan</li>
                            <li>Selesai</li>
                        </ul>';

                $bank_info['bankInternetBank'] = '<h4>Panduan Bayar</h4>
                        <ul>
                            <li>Login Internet Banking</li>
                            <li>Pilih Bayar</li>
                            <li>Pilih Multi Payment</li>
                            <li>Input Transferpay sebagai Penyedia Jasa</li>
                            <li>Input Nomor Virtual Account, misal. 70014XXXXXXXXXXX sebagai Kode Bayar</li>
                            <li>Ceklis IDR</li>
                            <li>Klik Lanjutkan</li>
                            <li>Bukti bayar ditampilkan</li>
                            <li>Selesai</li>
                        </ul>';

                break;
            case 'CENA':
                $bank_info['bankName'] = 'BCA';
                break;
            case 'IBBK':
                $bank_info['bankName'] = 'BBank International Indonesia MaybankCA';
                break;
            case 'BBBA':
                $bank_info['bankName'] = 'Bank Permata';
                break;
            case 'BNIN':
                $bank_info['bankName'] = 'Bank Negara Indonesia 46';
                break;
            case 'HNBN':
                $bank_info['bankName'] = 'Bank KEB Hana Indonesia';
                break;
            case 'BRIN':
                $bank_info['bankName'] = 'Bank Rakyat Indonesia';
                break;
            case 'BNIA':
                $bank_info['bankName'] = 'Bank PT. BANK CIMB NIAGA, TB';
                break;
            case 'BDIN':
                $bank_info['bankName'] = 'Bank PT. BANK DANAMON INDONESIA, TBK';
                break;
        }

        return $bank_info;
    }
}
