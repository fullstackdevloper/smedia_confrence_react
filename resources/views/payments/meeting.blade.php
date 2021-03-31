@extends('layouts.app')

@section('content')
<style>

</style>
<div class="row">
    <div class="col-md-8">
        <span class="d-flex justify-content-center pt-3">{{'Please enter your card detail to make the payment'}}</span>
        <form action="" method="POST" onsubmit="return createStripeToken(this, event);">
            @csrf
            <input type="hidden" name="token" />
            <div class="form-group">
                <label for="Card Name" class="col-md-3 col-form-label">{{ __('Name') }}</label>
                <div class="col-md-12">
                    <input id="card-name-element" type="text" class="form-control" placeholder="Card Holder Name" name="card_holder_name" autofocus/>
                </div>
            </div>
            <div class="form-group">
                <label for="Card number" class="col-md-3 col-form-label">{{ __('Card number') }}</label>
                <div class="col-md-12">
                    <div id="card-number-element" type="text" class="form-control" name="title" autofocus></div>
                </div>
            </div>
            <div class="form-group row">
                <div class="col-md-8 pr-0">
                    <label for="expiry" class="col-md-3 col-form-label">{{ __('Expiry Date') }}</label>
                    <div class="col-md-12">
                        <div id="card-expiry-element" type="text" class="form-control" name="title" autofocus></div>
                    </div>
                </div>
                <div class="col-md-4 pl-0">
                    <label for="cvc" class="col-md-3 col-form-label">{{ __('CVC') }}</label>
                    <div class="col-md-12">
                        <div id="card-cvc-element" type="text" class="form-control" name="cvc" autofocus></div>
                    </div>
                </div>    
            </div>
            <div class="col-md-12 stripe_error_message d-none">
                <div class="alert alert-danger"></div>
            </div>
            
            <div class="col-md-12 d-flex justify-content-center">
                <button type="submit" class="btn btn-primary">Pay ({{strtoupper(Config::getByKey('stripe_currency'))}} {{Config::getByKey('meeting_price')}})</button>
            </div>
        </form>
    </div>
    <div class="col-md-4 border-left pt-3">
        <h5 class="card-title">{{$meeting->title}}</h5>
        <span class="card-text">{{$meeting->description}}</span>
        <div class="start_time">
            <span>
                <i class="fa fa fa-calendar"></i>
                <span>{{DTime::displayFullDate($meeting->start_time)}}</span>
            </span>
            <span>
                <i class="fa fa-clock-o"></i>
                <span>{{DTime::displayMeetingDuration($meeting)}}</span>
            </span>

        </div>
    </div>
</div>
<script src="https://js.stripe.com/v3/"></script>
<script>
var stripe = Stripe("{{Config::getStripePublicKey()}}");
var elements = stripe.elements();

var style = {
    base: {
        iconColor: '#666EE8',
        color: '#31325F',
        fontWeight: 300,
        fontFamily: 'Helvetica Neue',
        fontSize: '18px',

        '::placeholder': {
            color: '#CFD7E0',
        },
    },
};

var cardNumberElement = elements.create('cardNumber', {
    style: style,
    placeholder: 'Enter Card Number',
});
cardNumberElement.mount('#card-number-element');

var cardExpiryElement = elements.create('cardExpiry', {
    style: style,
    placeholder: 'Card Exp. Date',
});
cardExpiryElement.mount('#card-expiry-element');

var cardCvcElement = elements.create('cardCvc', {
    style: style,
    placeholder: 'CVC',
});
cardCvcElement.mount('#card-cvc-element');

function createStripeToken(element, event) {
    event.preventDefault();
    var options = {

    };
    $('.stripe_error_message').addClass('d-none');
    stripe.createToken(cardNumberElement, options).then(function(result){
        if (result.token) {
            element.querySelector('input[name="token"]').setAttribute('value', result.token.id);
            element.submit();
        }else {
            $('.stripe_error_message').removeClass('d-none');
            $('.stripe_error_message .alert').html(result.error.message);
            console.log(result.error);
        }
    });
}

</script>    
@endsection