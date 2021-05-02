@section('inner-header')

<section id="inner-header-location">
    <div class="container">
        <div class="content">
            <div class="row">
                <div class="inner-header-title">
                    <img src="{{asset('images/logo.png')}}" alt="">
                </div>
                <div class="inner-header-location">
                    <form action="{{$_SERVER['REQUEST_URI']}}" method="GET">
                        <input type="text" name="search" class="inner-header-location-input"
                               @isset($_GET['search'])
                                    value="{{$_GET['search']}}"
                               @endisset
                               placeholder="@if(Request::segment(1) == 'shopping')Search for Product, Brand or Category @else Search @endif">

                        <button type="submit" class="inner-header-location-button">
                            <i class="fa fa-search" aria-hidden="true"></i> SEARCH </button>
                    </form>
                </div>
                <div class="inner-header-cart">
                    <input type="checkbox" id="openCart">
                    <label for="openCart" class="open-cart"><i class="fa fa-shopping-cart" aria-hidden="true"></i>
                        @if (Auth::id())
                            <span id="totalqty" class="totalqty">{{ Auth::user()->cart->sum('qty') }}</span> My Cart
                        @else
                            My Cart
                        @endif

                    </label>

                    {{-- Cart Modal --}}
                    @include('inc.cart')
                </div>

            </div>
        </div>
    </div>
</section>
<section id="outer-header-navbar">
    <div class="container">
        <ul>
            <li><a href="/">Home</a></li>
            <li><a href="#">About Us</a></li>
            <li><a href="/contact-us">Contact Us</a></li>
        </ul>
    </div>
</section>

@endsection
