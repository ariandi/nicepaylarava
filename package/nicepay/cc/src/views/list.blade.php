@extends('cc::app')
@section('content')
    <style type="text/css">
        .checkbox-Custom{
            width: 30%;
            display: inline;
            position: relative;
            top: 10px;
        }
    </style>
    @if(isset($task))
        <h3>Edit : </h3>
        {!! Form::model($task, ['route' => ['task.update', $task->id], 'method' => 'patch']) !!}
        @method('PUT')
    @else
        <h3>Input Data : </h3>
            
            @if ($message = Session::get('error'))
                <div class="alert alert-danger">
                    {{ $message }}
                </div>
            @endif

        <form action="{{ route('va-regis-response') }}" method="post">
            @csrf
    @endif
        <div style="border-top: 1px solid #ccc;">
            <div class="row" style="padding-top: 25px;">
                
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Amount </label>
                        <input type="text" name="amt" value="{{ old('amt') }}" class="form-control" />
                    </div>
                    <div class="form-group">
                        <label>Billing Name </label>
                        <input type="text" name="billingNm" value="{{ old('billingNm') }}" class="form-control" />
                    </div>
                    <div class="form-group">
                        <label>Billing Phone </label>
                        <input type="text" name="billingPhone" value="{{ old('billingPhone') }}" class="form-control" />
                    </div>
                    <div class="form-group">
                        <label>Billing Email </label>
                        <input type="email" name="billingEmail" value="{{ old('billingEmail') }}" class="form-control" />
                    </div>
                    <div class="form-group">
                        <label>Billing Address </label>
                        <input type="text" name="billingAddr" value="{{ old('billingAddr') }}" class="form-control" />
                    </div>

                    <div class="form-group">
                        <label>Bank </label>
                        <select name="bankCd" value="{{ old('bankCd') }}" class="form-control">
                            <option value=""> ===Pilih Salah Satu=== </option>
                            <option value="BMRI" >Mandiri</option>
                            <option value="BDIN" >DANAMON</option>
                            <option value="BNIA" >CIMB</option>
                            <option value="BNIN" >BNI</option>
                            <option value="IBBK" >MAYBANK</option>
                            <option value="BBBA" >PERMATA</option>
                            <option value="BRIN" >BRI</option>
                            <option value="CENA" >BCA</option>
                            <option value="HNBN" >HANA</option>
                        </select>
                    </div>

                    
                </div>


                <div class="col-md-6">
                    <div class="form-group">
                        <label>Billing City </label>
                        <input type="text" name="billingCity" value="{{ old('billingCity') }}" class="form-control" />
                    </div>
                    <div class="form-group">
                        <label>Billing State </label>
                        <input type="text" name="billingState" value="{{ old('billingState') }}" class="form-control" />
                    </div>
                    <div class="form-group">
                        <label>Billing Post Code </label>
                        <input type="text" name="billingPostCd" value="{{ old('billingPostCd') }}" class="form-control" />
                    </div>
                    <div class="form-group">
                        <label>Billing Country </label>
                        <input type="text" name="billingCountry" value="{{ old('billingCountry')?old('billingCountry'):'Indonesia' }}" class="form-control" />
                    </div>
                    <div class="form-group">
                        <label>Description </label>
                        <input type="text" name="description" value="{{ old('description') }}" class="form-control" />
                    </div>
                    <div class="form-group">
                        <label>Shipping same as billing ? </label>
                        <input type="checkbox" name="billingAddrShipp" value="1" class="form-control checkbox-Custom" checked />
                    </div>
                </div>

            </div>
            <hr />
            <div style="clear: both;"></div>
            <div class="row shipping-Address">

                <div class="col-md-6">
                    <div class="form-group">
                        <label>Delivery Name </label>
                        <input type="text" name="deliveryNm" value="{{ old('deliveryNm') }}" class="form-control" />
                    </div>
                    <div class="form-group">
                        <label>Delivery Phone </label>
                        <input type="text" name="deliveryPhone" value="{{ old('deliveryPhone') }}" class="form-control" />
                    </div>
                    <div class="form-group">
                        <label>Delivery Address </label>
                        <input type="text" name="deliveryAddr" value="{{ old('deliveryAddr') }}" class="form-control" />
                    </div>
                    <div class="form-group">
                        <label>Delivery City </label>
                        <input type="text" name="deliveryCity" value="{{ old('deliveryCity') }}" class="form-control" />
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="form-group">
                        <label>Delivery State </label>
                        <input type="text" name="deliveryState" value="{{ old('deliveryState') }}" class="form-control" />
                    </div>
                    <div class="form-group">
                        <label>Delivery Pos Code </label>
                        <input type="text" name="deliveryPostCd" value="{{ old('deliveryPostCd') }}" class="form-control" />
                    </div>
                    <div class="form-group">
                        <label>Delivery Country </label>
                        <input type="text" name="deliveryCountry" value="{{ old('deliveryCountry') }}" class="form-control" />
                    </div>
                </div>
            </div>

            <div class="text-right">
                <button type="submit" class="btn btn-success">Submit</button>
            </div>
        </div>
    </form>
    <hr>
@endsection

@section('jquery')
<script type="text/javascript">
    $(document).ready(function(){
        $('.shipping-Address').hide();
        $(".checkbox-Custom").change(function() {
            if(this.checked) {
                $('.shipping-Address').hide();
            }else{
                $('.shipping-Address').show();
            }
        });
    });
</script>
@endsection
