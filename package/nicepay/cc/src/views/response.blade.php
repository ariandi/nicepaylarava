@extends('cc::app')
@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <h1>Success</h1>
                <table class="table table-bordered">
                    <tr>
                        <td>Nomor Virtual Account</td>
                        <td>{{ $response['vacctNo'] }}</td>
                    </tr>

                    <tr>
                        <td>Nama Bank</td>
                        <td>{{ $response['bankName'] }}</td>
                    </tr>

                    <tr>
                        <td>Nominal</td>
                        <td>Rp {{ number_format($response['amt'], 2) }}</td>
                    </tr>

                    <tr>
                        <td>Nama Penerima</td>
                        <td>{{ $response['billingNm'] }}</td>
                    </tr>

                    <tr>
                        <td>Nomor Order</td>
                        <td>{{ $response['referenceNo'] }}</td>
                    </tr>

                    <tr>
                        <td>Masa Berlaku</td>
                        <td>{{ isset($response['payValidDt']) ? $response['payValidDt'] : '-'  }} {{ $response['payValidTm'] }}</td>
                    </tr>
                    
                </table>
                
                <br />

                <h2>Close Amount Transfer Melalui TRANSFERPAY</h2>

                <div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">

                  <div class="panel panel-primary">
                    <div class="panel-heading" role="tab" id="headingOne">
                      <h4 class="panel-title">
                        <a role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                          ATM
                        </a>
                      </h4>
                    </div>
                    <div id="collapseOne" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="headingOne">
                      <div class="panel-body">
                        {!! $response['bankAtm'] !!}
                      </div>
                    </div>
                  </div>

                  <div class="panel panel-primary">
                    <div class="panel-heading" role="tab" id="headingTwo">
                      <h4 class="panel-title">
                        <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                          Mobile Banking
                        </a>
                      </h4>
                    </div>
                    <div id="collapseTwo" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingTwo">
                      <div class="panel-body">
                        {!! $response['bankMobileBank'] !!}
                      </div>
                    </div>
                  </div>

                  <div class="panel panel-primary">
                    <div class="panel-heading" role="tab" id="headingThree">
                      <h4 class="panel-title">
                        <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                          Internet Banking
                        </a>
                      </h4>
                    </div>
                    <div id="collapseThree" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingThree">
                      <div class="panel-body">
                        {!! $response['bankInternetBank'] !!}
                      </div>
                    </div>
                  </div>

                </div>
            </div>
        </div>
    </div>
@endsection
