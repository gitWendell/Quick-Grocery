@if(session()->has('key'))
    <div class="compare-product">
        <h3>Compare product:</h3>
            <div id="reload-compare" style="width: 80%; height:50px; overflow: auto;">
                @foreach(session()->get('key') as $product)
                    <img src="/storage/product_images/{{$product->product_image}}" width="200px" height="50px" style="display: inline-block">
                @endforeach
            </div>
        <div style="float: right;margin: -20px 20px 0 0;">
            <button style="width: fit-content" id="toggleModal-viewproduct">View</button>
            <form method="get" action="/compare-product/clear" style="margin: 0; display: inline;">
                @csrf
                <button style="width: fit-content" id="clearCompare">Clear</button>
            </form>

        </div>
    </div>
@endif

