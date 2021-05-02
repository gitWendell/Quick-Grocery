@section('inner-header')

<section id="inner-header">
    <div class="container">
        <h1 class="inner-header-title">
            @php
                echo $innerHeader;
            @endphp
        </h1>
        <p>
        @php
            echo $innerHeaderPara;
        @endphp
        </p>
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

