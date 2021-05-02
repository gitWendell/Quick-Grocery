<?php

namespace App\Http\Controllers;

use App\AttributeValue;
use App\Barangay;
use App\Charts\AccountChart;
use App\OrderMaster;
use App\RequestSupply;
use App\Reward;
use App\Services\PagesServices;
use App\StoreSetting;
use App\Supplier;
use Illuminate\Http\Request;
use App\Brand;
use App\Category;
use App\Attribute;
use App\Staff;
use App\User;
use App\Store;
use App\Product;
use App\BillingAddress;
use Auth;
use Illuminate\Support\Facades\DB;
use Session;
use PDF;

class PagesController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth', ['except' =>  ['shopping', 'index', 'productDetails']]);
        $this->brands = Brand::all();
        $this->categories = Category::all();
        $this->attributes = Attribute::all();
        $this->staffs = Staff::all();
        $this->users = User::all();
        $this->stores = Store::all();
        $this->products = Product::all();
        $this->billings = BillingAddress::all();
    }

    // Customer
    // Home Page
    public function index(PagesServices $pagesServices)
    {
        $barangays = Barangay::all();
        $allStores = Store::where('status', '!=', 'Block')->get();

        if (isset($_GET['search'])) {
            $search = $_GET['search'];

            $this->stores = Store::where('name', 'like','%'.$search.'%')
                            ->orWhere('description', 'like', '%'.$search.'%')
                            ->get();
        }

        if (isset($_GET['filter-barangay'])) {
            $search = $_GET['filter-barangay'];

            if ($search == 'All') {
                $this->stores = Store::all();
            } else {
                $this->stores = Store::where('barangay', $search)
                    ->get();
            }

        }

        if(!auth()) {
            return view('pages.home')->with('stores', $this->stores);
        }

        return view('pages.home')
            ->with('cartitems', $pagesServices->getCartOfUserInDesc())
            ->with('subtotal', $pagesServices->cartSubtotal())
            ->with('storeTotal', $storeTotal = 0)
            ->with('dupes', $dupes=0)
            ->with('subtotalbystore', $subtotalbystore=0)
            ->with('allStores', $allStores)
            ->with('stores', $this->stores);
    }

    public function singleOrderView($id) {
        $order_master = OrderMaster::where('id', $id)->first();
        return view('storeadmin.orderdetails')->with('order_master', $order_master);
    }

    // Shopping Page
    public function shopping($shop_id, PagesServices $pagesServices)
    {
        $products = Product::where('store_id', $shop_id)->get();
        $allProducts = Product::where('store_id', $shop_id)->get();

        if (isset($_GET['search'])) {

            $search = $_GET['search'];

            $products = DB::table('stores')
                ->join('products', 'products.store_id', '=', 'stores.id')
                ->join('brands', 'brands.id', '=', 'products.brand_id')
                ->join('sub_categories', 'sub_categories.id', '=', 'products.subcat_id')
                ->join('categories', 'categories.id', '=', 'sub_categories.category_id')
                ->where('products.name', 'like', '%'.$search.'%')
                ->orWhere('products.description', 'like', '%'.$search.'%' )
                ->orWhere('brands.name', 'like', '%'.$search.'%' )
                ->orWhere('categories.name', 'like', '%'.$search.'%' )
                ->orWhere('sub_categories.name', 'like', '%'.$search.'%' )
                ->select('products.id', 'products.product_image', 'products.name',
                        'products.description', 'products.price', 'stores.id AS store_id', 'brands.name AS brand_name',
                        'stores.name AS store_name')
                ->get();
        }

        if(isset($_GET['filter-subcat'])) {
            $products = Product::where('store_id', $shop_id)->where('subcat_id', $_GET['filter-subcat'])->get();
        }

        if(!Auth::id()){
            return view('pages.shopping')
                ->with('shop_id', $shop_id)
                ->with('all_products', $allProducts)
                ->with('products', $products);
        }

        return view('pages.shopping')
            ->with('cartitems', $pagesServices->getCartOfUserInDesc())
            ->with('subtotal', $pagesServices->cartSubtotal())
            ->with('dupes', $dupes=0)
            ->with('shop_id', $shop_id)
            ->with('all_products', $allProducts)
            ->with('products', $products);
    }

    // Product Details Page
    public function productDetails($id, PagesServices $pagesServices)
    {
        $product = Product::where('id', $id)->first();
        $attr_id = str_replace("\"","",$product->attr_values);
        $attr_values = AttributeValue::where('id', $attr_id)->get();


        $relatedProducts = Product::whereHas('subcategory', function ($query) use($product){
                $query->where('name', $product->subcategory->name);
        })->whereNotIn('name', [$product->name])->get();

        if(!auth()) {
            return view('pages.product')
                ->with('relatedProducts', $relatedProducts)
                ->with('product', $product)
                ->with('attr_values', $attr_values);
        }

        return view('pages.product')
            ->with('cartitems', $pagesServices->getCartOfUserInDesc())
            ->with('subtotal', $pagesServices->cartSubtotal())
            ->with('dupes', $dupes=0)
            ->with('subtotalbystore', $subtotalbystore=0)
            ->with('relatedProducts', $relatedProducts)
            ->with('product', $product)
            ->with('attr_values', $attr_values);

    }

    // Checkout Page
    public function checkout(PagesServices $pagesServices)
    {
        if(!Auth::id()){ return view('pages.checkout'); }

        $userBillings = BillingAddress::where('user_id', Auth::id())->get();

        return view('pages.checkout')
                ->with('cartitems', $pagesServices->getCartOfUserInDesc())
                ->with('dupes', $dupes=0)
                ->with('billings', $userBillings)
                ->with('subtotal', $pagesServices->cartSubtotal());
    }

    public function setShippingFee(Request $request, PagesServices $pagesServices)
    {
        $location = [
            'Agus'   =>	[10.290110,	123.979420],
            'Babag'	 =>	[10.279980,	123.960007],
            'Bankal' =>	[10.303450,	123.970680],
            'Baring' =>	[10.285810,	124.062320],
            'Basak'	 =>	[10.292350,	123.965580],
            'Calawisan'	=>	[10.278290,	123.934440],
            'Canjulao'	=>	[10.289800,	123.938500],
            'Caw-oy'	=>	[10.275060,	124.066150],
            'Cawhagan'	=>	[10.316780,	123.965060],
            'Caubian'	=>	[10.316780,	123.965060],
            'Gun-ob'	=>	[10.298610,	123.952171],
            'Ibo'		=>	[10.324530,	123.982030],
            'Looc'		=>	[10.300750,	123.940130],
            'Mactan'	=>	[10.306230,	124.007060],
            'Maribago'	=>	[10.295810,	124.000480],
            'Marigondon'=>	[10.281820,	123.974180],
            'Pajac'		=>	[10.303330,	123.987580],
            'Pajo'		=>	[10.314030,	123.960140],
            'Pangan-an'	=>	[10.222390,	124.037160],
            'Poblacion'	=>	[10.3121,	123.9506],
            'Punta Engaño'	=>	[10.314760,	124.030140],
            'Pusok'		=>	[10.320150,	123.971330],
            'Sabang'	=>	[10.253060,	124.052730],
            'Santa Rosa'=>	[10.263690,	124.046660],
            'Subabasbas'=>	[10.265240,	123.977310],
            'Talima'	=>	[10.275220,	124.057800],
            'Tingo'		=>	[10.283010,	124.068490],
            'Tungasan'	=>	[10.266740,	124.057990],
            'San Vicente'=>	[10.257290,	124.032380]
        ];

        $store = Store::where('id', $request['store_id'])->first();
        $customer = BillingAddress::where('id', $request['billing'])->first();

        $storeCoordinates = $location[$store->barangays->brgyDesc];
        $customerCoordinates = $location[$customer->barangay->brgyDesc];
        $distance = $pagesServices->calculateDistance($storeCoordinates[0], $storeCoordinates[1],
                        $customerCoordinates[0], $customerCoordinates[1]);
        $distance = round($distance,2);
        if($distance > 3) {
            $get = $distance - 2;
            $fee = $get * 10;
        } else {
            $fee = 0;
        }
        session()->put('shipping', [
            'amount' => $fee,
            'distance' => $distance
        ]);

        return $distance;
    }

    public function unsetShippingFee()
    {
        session()->forget('shipping');
    }
    // Store
    // Account Management
    public function accountMgt(PagesServices $pagesServices) {

        return view('storeadmin.account');
    }


    // Store Management
    public function storeMgt(PagesServices $pagesServices) {
        $pagesServices->getRequestStock() == "" ? $request_stocks = []: $request_stocks = $pagesServices->getRequestStock();

        return view('storeadmin.settings')
                ->with('settings',  $pagesServices->storeByRole()->storesettings)
                ->with('request_stocks',  $request_stocks)
                ->with('store',  $pagesServices->storeByRole());
    }

    // Inventory Management
    public function inventoryMgtStore(PagesServices $pagesServices) {

        return view('storeadmin.inventory')
                ->with('store',  $pagesServices->storeByRole())
                ->with('brands', $this->brands);
    }

    public function inventoryMgtBrand() {
        return view('storeadmin.inventory-list.brand')
                ->with('brands', $this->brands);
    }

    public function inventoryMgtCategory() {
        return view('storeadmin.inventory-list.category')
                ->with('categories', $this->categories);
    }

    public function inventoryMgtAttribute() {
        return view('storeadmin.inventory-list.attribute')
                ->with('attributes', $this->attributes);
    }

    public function inventoryMgtaddproduct(PagesServices $pagesServices) {
        $suppliers = Supplier::where('store_id', $pagesServices->storeByRole()->id)->get();

        return view('storeadmin.inventory-list.addproduct')
                ->with('attributes', $this->attributes)
                ->with('suppliers', $suppliers)
                ->with('categories', $this->categories)
                ->with('brands', $this->brands);
    }

    // Staff Management
    public function staffMgt(PagesServices $pagesServices) {

        return view('storeadmin.staff')
                ->with('stores', $this->stores)
                ->with('staffs', $pagesServices->getStaffByStoreId())
                ->with('users', $this->users);
    }

    public function staffMgtAddStaff() {
        return view('storeadmin.staff-list.addstaff');
    }

    //  Order Management
    public function orderMgtShow(PagesServices $pagesServices) {

        if (isset($_GET['status']) && $_GET['status'] != 'All') {
            $status = $_GET['status'];

            $orders = OrderMaster::orderBy('id', 'DESC')->where('store_id', $pagesServices->storeByRole()->id)
                ->where('status', '=', $status)->get();
        } else {
            $orders = OrderMaster::orderBy('id', 'DESC')->where('store_id', $pagesServices->storeByRole()->id)->get();
        }

        return view('storeadmin.order')
                ->with('total', $total=0)
                ->with('orders', $orders);
    }

    public function orderMgtShowCancel(PagesServices $pagesServices) {

        if (isset($_GET['status']) && $_GET['status'] != 'All') {
            $status = $_GET['status'];

            $orders = OrderMaster::orderBy('id', 'DESC')->where('store_id', $pagesServices->storeByRole()->id)
                ->where('status', '=', $status)->get();
        } else {
            $orders = OrderMaster::orderBy('id', 'DESC')->where('store_id', $pagesServices->storeByRole()->id)->get();
        }

        return view('storeadmin.cancelorder')
            ->with('total', $total=0)
            ->with('orders', $orders);
    }

    //  Supplier Management
    public function supplierMgtShow(PagesServices $pagesServices) {

        $suppliers = Supplier::where('store_id', $pagesServices->storeByRole()->id)->get();

        return view('storeadmin.supplier')
                ->with('suppliers', $suppliers);
    }

    public function requestSupplyMgt(PagesServices $pagesServices) {
        $requests = RequestSupply::where('store_id',$pagesServices->storeByRole()->id)->get();

        return view('storeadmin.requestsupply')
                ->with('requests', $requests);
    }

    // SUPPLIER
    // Request Supply List
    public function supplyMgtShow() {
        $supplier_to_store = Supplier::where('user_id', Auth::id())->first()->store_id;
        $store_setting = StoreSetting::where('store_id', $supplier_to_store)->first();

        return view('supplier.supply')
                ->with('request_stocks', $store_setting->request_stock);
    }

    // System Admin Dashboard
    public function SystemAdminDashboard(PagesServices $pagesServices) {
        $storeTotal = count(Store::all());
        $usersTotal = count(User::all());
        $rewardTotal = count(Reward::all());

        return view('/systemadmin/dashboard')
                ->with('storeTotal', $storeTotal)
                ->with('usersTotal', $usersTotal)
                ->with('rewardTotal', $rewardTotal)
                ->with('store_chart', $pagesServices->storeChart())
                ->with('account_chart', $pagesServices->accountChart())
                ->with('activeAndBlockUser', $pagesServices->activeAndBlockUser())
                ->with('most_used_store', $pagesServices->mostUsedStoreChart());
    }

    // Generate PDF
    public function generateOrderPDF(PagesServices $pagesServices) {

        $orders = OrderMaster::where('store_id', $pagesServices->storeByRole()->id)->get();

        // share data to view
        view()->share(['orders' => $orders, 'total' => $total=0]);
        $pdf = PDF::loadView('PDF.store.OrderPDF', $orders);

        // download PDF file with download method
        return $pdf->stream('pdf_file.pdf');
    }

    public function generatePDF($id) {
        $order_master = OrderMaster::where('id', $id)->first();

        // share data to view
        view()->share(['order_master' => $order_master]);
        $pdf = PDF::loadView('PDF.store.GenerateInvoice', $order_master);

        // download PDF file with download method
        return $pdf->stream('pdf_file.pdf');
    }



// NO NEED TO REFACTOR AREAS ------------------------------------------------------------------------------------------------------
    // Fetch Data
    // Get Subcategory of Category
    public function subcategoryFetch(Request $request) {

        if($request->input('category_id') > 0){

            $id = $request->input('category_id');

            $cat = Category::find($id);

            $output = '<label for="subcategory">Sub Category</label><select class="form-select" name="subcat_id" id="subcategory">';

            foreach ($cat->subcategory as $subcat){
                $output .= '<option value="'.$subcat->id.'">'.$subcat->name.'</option>';
            }

            $output .= '</select>';

            echo $output;
        }
    }

    // Get Attribute Values of Category
    public function attributevalues(Request $request) {

        if($request->input('attribute_id') > 0){

            $id = $request->input('attribute_id');
            $attributes = Attribute::find($id);

            $output = '<label for="attributevalue">Attribute Values</label><select class="form-select" name="attr_values" id="attributevalue">';
            $output .= '<option name="" value="" >Select</option>';

            foreach ($attributes->attributevalues as $attributevalue){
                $value = "".$attributevalue->id;
                $output .= '<option name="" value="'.$value.'">'.$attributevalue->value.'</option>';
            }
            $output .= '</select>';

            echo $output;

        } else {
            $output = '<label for="attributevalue">Attribute Values</label>
                       <select class="form-select" name="attr_values" id="attributevalue">
                            <option name="attributevalue[]" value="0">No Value</option>
            ';

            echo $output;
        }
    }
}
