@extends('layouts.app')

@include('inc/inner-header-location')

@section('content')
<div class="container carousel-container">
    <section id="carousel">
        <div class="slider">
            <section><img src="{{asset('images/naruto.jpg')}}"></section>
            <section><img src="{{asset('images/background.png')}}"></section>
            <section><img src="{{asset('images/logo.png')}}"></section>
            <section><img src="{{asset('images/background.png')}}"></section>
        </div>
        <div class="slider-controller">
            <span class="arrow left">
                    <i class="material-icons">keyboard_arrow_left</i>
            </span>
            <span class="arrow right">
                    <i class="material-icons">keyboard_arrow_right</i>
            </span>
            <ul>
                <li class="active"></li>
                <li></li>
                <li></li>
                <li></li>
            </ul>
        </div>
    </section>
</div>

<section id="shopping-container">
    <div class="store-name" style="margin:0 15% 20px 15%">
        <h2>Selected Store: <strong style="color: #31cece">
                {{ \App\Store::getStoreName(request()->route('shop_id')) }}
        </strong></h2>
    </div>
    <div style="margin:0 15% 20px 15%">
        <h2>Filter:</h2>
        <select class="form-select" data-id="{{$shop_id}}" id="filter-product">
            <option value="">Select Category</option>
            <option value="?filter-barangay=All">All</option>
            @foreach($all_products as $all_product)
                <option value="?filter-subcat={{$all_product->subcat_id}}">{{$all_product->subcategory->category->name}} / {{$all_product->subcategory->name}}</option>
            @endforeach
        </select>
    </div>
    <div id="shopping-message"></div>
    @include('inc.messages')
    <div class="row shopping-content">
        @isset($products)
            @foreach ($products as $product)
                @isset($_GET['search'])
                    @if($product->store_id != $shop_id)

                    @else
                    <div class="location-content-card">
                    <div class="location-content-store">
                        <div class="location-content-store-header">
                            <img src="/storage/product_images/{{$product->product_image}}" width="200px" height="100px">
                        </div>
                        <div class="location-content-store-body">
                            <div class="location-content-card-name">
                                <h5>
                                    <a href="/product/{{$product->id}}" style="text-decoration: none;color: #31cece;">
                                        {{$product->name }}
                                    </a>
                                </h5>
                            </div>
                            <div class="location-content-card-description">
                                <p>{{ $product->description }}</p>
                                <p>

                                    @isset($_GET['search'])
                                        <strong>Brand:</strong> {{ $product->brand_name}} <br/>
                                        <strong>Attribute</strong>: {{ \App\Product::getAttributeNameById($product->id)}}
                                    @else
                                        <strong>Brand:</strong> {{ $product->brand->name }} <br/>
                                        <strong>Attribute</strong>: {{$product->getAttributeName()->value }}
                                    @endisset
                                    @if(\App\Product::getProductStock($product->id) == 0)
                                        <span style="color: red;width: 100% !important;text-align: center;display: block;"><i><b>Out of Stocks</b></i></span>
                                    @endif
                                </p>
                            </div>
                            <div class="location-content-card-price">
                                <p>P {{ number_format($product->selling_price, 2) }}</p>
                            </div>
                        </div>
                        <div class="row location-content-store-footer" style="margin:0 auto">
                            <form method="post" class="addtocartForm" data-id="{{$product->id}}"
                                  action="{{ route('product.addtocart', ['id' => $product->id]) }}">
                                @csrf
                                <input type="number" class="shopping-input" name="qty"
                                       placeholder="Qty:{{\App\Product::getProductStock($product->id)}}" >
                                <button type="submit" class="shopping-button">
                                    <i class="fa fa-shopping-cart"></i>
                                </button>
                            </form>
                            @if(session()->has('key'))

                            @else
                                <form method="post" action="/compare-product/add/{{$product->id}}" style="margin: 5px auto 0 auto;width: 100%">
                                    @csrf
                                    <button type="submit"
                                            style=" width: 90%"
                                            class="compare-product-button"
                                            data-id="{{$product->id}}">
                                        +Compare
                                    </button>
                                </form>
                            @endif
                        </div>
                    </div>
                </div>
                    @endif
                @else
                    <div class="location-content-card">
                        <div class="location-content-store">
                            <div class="location-content-store-header">
                                <img src="/storage/product_images/{{$product->product_image}}" width="200px" height="100px">
                            </div>
                            <div class="location-content-store-body">
                                <div class="location-content-card-name">
                                    <h5>
                                        <a href="/product/{{$product->id}}" style="text-decoration: none;color: #31cece;">
                                            {{$product->name }}
                                        </a>
                                    </h5>
                                </div>
                                <div class="location-content-card-description">
                                    <p>{{ $product->description }}</p>
                                    <p>
                                        @isset($_GET['search'])
                                            <strong>Brand:</strong> {{ $product->brand_name}} <br/>

                                        @else
                                            <strong>Brand:</strong> {{ $product->brand->name }} <br/>
                                            <strong>Attribute</strong>: {{$product->getAttributeName()->value }}
                                        @endisset
                                    </p>
                                    @if($product->getStocks($product->id) == 0)
                                        <span style="color: red;width: 100% !important;text-align: center;display: block;"><i><b>Out of Stocks</b></i></span>
                                    @endif
                                </div>
                                <div class="location-content-card-price">
                                    <p>P {{ number_format($product->selling_price,2) }}</p>
                                </div>
                            </div>
                            <div class="row location-content-store-footer" style="margin:0 auto">
                                <form method="post" class="addtocartForm" data-id="{{$product->id}}"
                                      action="{{ route('product.addtocart', ['id' => $product->id]) }}">
                                    @csrf
                                    <input type="number" class="shopping-input" name="qty"
                                           placeholder="Qty:{{$product->getStocks($product->id)}}" >
                                    <button type="submit" class="shopping-button">
                                        <i class="fa fa-shopping-cart"></i>
                                    </button>
                                </form>
                                @if(session()->has('key'))

                                @else
                                    <form method="post" action="/compare-product/add/{{$product->id}}" style="margin: 5px auto 0 auto;width: 100%">
                                        @csrf
                                        <button type="submit"
                                                style=" width: 90%"
                                                class="compare-product-button"
                                                data-id="{{$product->id}}">
                                            +Compare
                                        </button>
                                    </form>
                                @endif


                            </div>
                        </div>
                    </div>
                @endisset
            @endforeach
        @endisset
    </div>

</section>
<script src="{{asset('js/pages/store-carousel.js')}}"></script>
@if(Auth::id())
<script>
window.addEventListener("load", function () {

    $(document).on('submit', '.addtocartForm', function (e) {
        var id = this.dataset.id;
        e.preventDefault();

        var formData = new FormData(this);

        $.ajax({
            url: "/addtocart/"+id,
            method: "POST",
            data:formData,
            cache:false,
            contentType: false,
            processData: false,
            dataType: "json",
            success:function(data){

                $("#refresh-whole").load(location.href + " #refresh-whole");
                $(".message-error").remove();
                $(".message-success").remove();

                if(data['failed'] === 1) {
                    swal("Oops something went wrong", data['message'], "error");
                } else {
                    swal("Product added to cart", "", "success");
                }


            }, error:function (err) {

                if (err.status == 422) {
                    console.log(err.responseJSON);
                    $(".message-error").remove();
                    $(".message-success").remove();

                    $.each(err.responseJSON.errors, function (i, error) {
                        swal("Oops something went wrong", error[0], "error");
                    });
                }
                document.location.hash = "#shopping-message";
            }
        });
    })
})
</script>
@endif
<script>
    window.onload=function() {

        $(document).on('change', '#filter-product', function (e) {
            let id = this.dataset.id;

            window.location.replace("http://quickgrocery.test:8080/shopping/"+id+this.value);
        })
    }
</script>
@endsection
