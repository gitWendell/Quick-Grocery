@extends('layouts.app')

@include('inc/inner-header-location')

@section('content')
<div class="container product-details-container">
    <div class="row">
        <div class="product-image" style="text-align: center">
            <img src="/storage/product_images/{{$product->product_image}}" alt="" style="width: 50%;">
        </div>
        <div class="product-details">
            <h1>{{$product->name}}</h1>
            <h3>P {{number_format($product->selling_price, 2)}}</h3>
            <form method="post" action="{{ route('product.addtocart', ['id' => $product->id]) }}">
                @csrf
                <input type="text" class="shopping-input" name="qty" placeholder="Qty: {{$product->getStocks($product->id)}}" >
                <button type="submit" class="shopping-button">
                    <i class="fa fa-shopping-cart"></i>
                </button>
            </form>
            <div class="product-description">
                <h3>Product Description</h3>
                <p>{{$product->description}}</p>
            </div>
            <div class="row">
                <div class="product-brand">
                    <h3>Product Brand</h3>
                    <p>{{$product->brand->name}}</p>

                    <h3>Attribute</h3>
                    <p><strong>{{$attr_values->first()->attribute->name}}</strong>: {{$attr_values->first()->value}}</p>
                </div>
                <div class="product-category">
                    <h3>Product Category</h3>
                    <p>{{$product->subcategory->category->name}} / {{$product->subcategory->name}}</p>
                </div>
            </div>
        </div>
    </div>
    <div class="product-reviews">
        <h3 class="tab">Reviews</h3>
        <div class="content">
            <h1>Reviews</h1>
            @foreach($product->rating as $rating)
                <div class="reviews-section">
                    <div class="row review-section" style="margin: 0">
                        <div class="user-image">
                            <img src="{{asset('/images/no_image.png')}}" alt="" width="100%" height="70px">
                        </div>
                        <div class="user-reviews">
                            <div>
                                <span>{{$rating->user->name}}</span>
                                @for($i=0; $i<5; $i++)
                                    @if($i < $rating->rating)
                                        <i class="fa fa-star star-check"></i>
                                    @else
                                        <i class="fa fa-star"></i>
                                    @endif
                                @endfor

                            </div>
                            <div>
                                <p>{{$rating->comment}}</p>
                                <strong style="float: right;">{{$rating->created_at->diffForHumans()}}</strong>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>

    <div class="related-products">
        <h2>Related Products</h2>
        <div class="row related-products-content" style="margin: 20px 0">
            @if(sizeof($relatedProducts) > 0)
                @foreach($relatedProducts as $relatedProduct)
                    <div class="location-content-card">
                        <div class="location-content-store">
                            <div class="location-content-store-header">
                                <img src="/storage/product_images/{{$relatedProduct->product_image}}" width="200px" height="100px">
                            </div>
                            <div class="location-content-store-body">
                                <div class="location-content-card-name">
                                    <h5>
                                        <a href="/product/{{$relatedProduct->id}}" style="text-decoration: none;color: #31cece;">
                                            {{$relatedProduct->name }}
                                        </a>
                                    </h5>
                                </div>
                                <div class="location-content-card-description">
                                    <p>{{ $relatedProduct->description }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            @endif
        </div>
    </div>
</div>
@endsection
