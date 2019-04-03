@extends('layouts.app')

@section('content')

    <script src="https://secure.mlstatic.com/sdk/javascript/v1/mercadopago.js"></script>

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Dashboard</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                        <form onsubmit="doPay()" action="/pay" method="post" id="pay" name="pay" >
                                {{ csrf_field()  }}
                                <ul>
                                    <li>
                                        <label for="email">Email</label>
                                        <input id="email" name="email" value="test_user_19653727@testuser.com" type="email" placeholder="your email"/>
                                    </li>
                                    <li>
                                        <label for="cardNumber">Credit card number:</label>
                                        <input type="text" id="cardNumber" data-checkout="cardNumber" value="4235 6477 2802 5682" onselectstart="return false" onpaste="return false" onCopy="return false" onCut="return false" onDrag="return false" onDrop="return false" autocomplete=off />
                                    </li>
                                    <li>
                                        <label for="securityCode">Security code:</label>
                                        <input type="text" id="securityCode" data-checkout="securityCode" value="439" onselectstart="return false" onpaste="return false" onCopy="return false" onCut="return false" onDrag="return false" onDrop="return false" autocomplete=off />
                                    </li>
                                    <li>
                                        <label for="cardExpirationMonth">Expiration month:</label>
                                        <input type="text" id="cardExpirationMonth" data-checkout="cardExpirationMonth" value="07" onselectstart="return false" onpaste="return false" onCopy="return false" onCut="return false" onDrag="return false" onDrop="return false" autocomplete=off />
                                    </li>
                                    <li>
                                        <label for="cardExpirationYear">Expiration year:</label>
                                        <input type="text" id="cardExpirationYear" data-checkout="cardExpirationYear" value="2020" onselectstart="return false" onpaste="return false" onCopy="return false" onCut="return false" onDrag="return false" onDrop="return false" autocomplete=off />
                                    </li>
                                    <li>
                                        <label for="cardholderName">Card holder name:</label>
                                        <input type="text" id="cardholderName" data-checkout="cardholderName" value="APRO" />
                                    </li>
                                    <li>
                                        <label for="docType">Document type:</label>
                                        <select id="docType" data-checkout="docType" name="docType">
                                            <option selected value="CPF">CPF</option>
                                        </select>
                                    </li>
                                    <li>
                                        <label for="docNumber">Document number:</label>
                                        <input type="text" id="docNumber" data-checkout="docNumber" value="04934716181" />
                                    </li>
                                </ul>
                                <input type="hidden" name="paymentMethodId" id="paymentMethodId" value=""/>
                        </form>
                        <button onclick="doPay()">Pay!</button>
                </div>
            </div>
        </div>
    </div>
</div>

    <script>
        window.onload = function(){
            var doSubmit = false;
            Mercadopago.setPublishableKey("TEST-a91e3cd6-89ae-4de6-a589-76243003dc93");
        }


        function setPaymentMethodInfo(status, response) {
            paymentMethod = document.getElementById('paymentMethodId');
            paymentMethod.value = response[0].id;
            console.log(response[0])
        };

        function doPay(){
            var bin = '49844 23';
            Mercadopago.getIdentificationTypes();

            Mercadopago.getPaymentMethod({
                "bin": bin
            }, setPaymentMethodInfo);

            var doSubmit = false;
            if(!doSubmit){
                var form = document.getElementById('pay');
                Mercadopago.createToken(form, sdkResponseHandler); // The function "sdkResponseHandler" is defined below
                return false;
            }
        };

        function sdkResponseHandler(status, response) {
            if (status != 200 && status != 201) {
                console.log(response);
                alert("verify filled data");
            }else{
                var form = document.querySelector('#pay');
                var card = document.createElement('input');
                card.setAttribute('name', 'token');
                card.setAttribute('type', 'hidden');
                card.setAttribute('value', response.id);
                form.appendChild(card);
                form.submit();
            }
        };

    </script>
@endsection
