@extends('layouts.app')

@php
    $innerHeader = 'Thank You!';
    $innerHeaderPara = 'Order Details';
@endphp
@include('inc/inner-header')

@section('content')
<div class="container">
    <section class="finished-checkout">
        <div class="finished-checkout-header" style="text-align: center">
            <h1 style="padding: 50px">Thank you. Your order <br/>will be process soon.</h1>
        </div>
        <div class="location-content-store-footer" style="text-align: center;margin: 20px 0">
            <a href="/"><i class="fa fa-shopping-cart"></i> Shop Again</a>
        </div>
    </section>
</div>
@endsection
