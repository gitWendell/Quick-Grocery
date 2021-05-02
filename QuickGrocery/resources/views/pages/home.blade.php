@extends('layouts.app')

@include('inc/inner-header-location')

@section('content')
<div class="container">
    <section id="home-location">
        <div class="container">
            <div class="home-title">
                <h3>Location:</h3>
                <span>Lapu-Lapu City</span>
            </div>
            <div class="" style="margin-bottom: 20px;">
                <h2>Filter:</h2>
                <select class="form-select" id="filter-barangay">
                    <option value="">Select Barangay</option>
                    <option value="?filter-barangay=All">All</option>
                    @foreach($allStores as $store)
                        <option value="?filter-barangay={{$store->barangays->id}}">{{$store->barangays->brgyDesc}}</option>
                    @endforeach
                </select>
            </div>

            @include('inc.messages')
            <div class="row">
                @isset($stores)
                    @foreach ($stores as $store)
                        @if($store->status == 'Block')

                        @else
                            <div class="location-content-card">
                                <div class="location-content-store">
                                    <div class="location-content-store-header">
                                        <img src="/storage/store_images/{{$store->store_image}}" width="200px" height="100px">
                                    </div>
                                    <div class="location-content-store-body">
                                        <div class="location-content-card-name">
                                            <h5>{{$store->name}}</h5>
                                        </div>
                                        <p><b>Barangay: {{$store->barangays->brgyDesc}}</b></p>
                                        <div class="location-content-card-description">
                                            <p>{{$store->description}}</p>
                                        </div>
                                    </div>
                                    <div class="location-content-store-footer">
                                        <a href="/shopping/{{$store->id}}">SELECT</a>
                                    </div>
                                </div>
                            </div>
                        @endif
                    @endforeach
                @endisset
            </div>
        </div>
    </section>
    <p align="center" style="font-size: 18px">Wanna feature your store ? <a href="/contact-us" style="text-decoration: none">Contact Us</a></p>
</div>
@endsection

@section('scripts')
    <script>
        window.onload=function() {

            $(document).on('change', '#filter-barangay', function (e) {
                window.location.replace("http://quickgrocery.test:8080"+this.value);
            })
        }
    </script>
@endsection
