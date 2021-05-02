<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
// Displaying Product Details
Route::get('/product/{id}', 'PagesController@productDetails');

Auth::routes(['verify' => true]);

Route::post('/login/custom',[
    'uses' => 'LoginController@login',
    'as'   => 'login.custom'
]);

Route::get('/verify/account', 'HomeController@VerificationPage');
Route::get('/verify-account/{id}', 'Customer\AccountController@verify');
Route::get('/logout', '\App\Http\Controllers\Auth\LoginController@logout')->name('logout');
Route::get('/', 'PagesController@index')->name('home');


Route::get('/contact-us', 'ContactUsController@view');
Route::post('/contact-us/sendEmail', 'ContactUsController@send');


// Displaying Products
Route::get('/shopping/{shop_id}', 'PagesController@shopping');

// Notification
Route::get('/notification/update', 'HomeController@notificationUpdate');

// Account Role Routes
Route::group(['middleware' => 'auth'], function(){

//    System admin
    Route::group(['middleware' => 'systemadmin'], function(){

        Route::get('/systemadmin/dashboard', 'PagesController@SystemAdminDashboard')->name('SystemadminDashboard');

        // SystemAdmin Store Management Routes
        Route::get('/systemadmin/storemanagement', 'SystemAdmin\StoreController@showStoreInformation');
        Route::post('/systemadmin/storemanagement', ['uses'=> 'SystemAdmin\StoreController@storeStoreInformation']);
        Route::post('/systemadmin/storemanagement/{id}', ['uses'=> 'SystemAdmin\StoreController@updateStoreInformation']);

        // Account Management
        // Display
        Route::get('/systemadmin/accountmanagement', ['uses'=> 'SystemAdmin\AccountController@show']);
        // Update
        Route::post('/systemadmin/accountmanagement/{id}', ['uses'=> 'SystemAdmin\AccountController@update']);

        // Rewards
        Route::get('/systemadmin/reward', ['uses'=> 'SystemAdmin\RewardController@show']);

        // Reward Create
        Route::post('/systemadmin/reward/create', ['uses'=> 'SystemAdmin\RewardController@create']);

        // Reward Delete
        Route::get('/systemadmin/reward/delete/{id}', ['uses'=> 'SystemAdmin\RewardController@delete']);


        // Generate Reports

        //Account PDF
        Route::get('/system-admin/account/pdf', ['uses'=> 'SystemAdmin\AccountController@generatePDF']);
        //Store PDF
        Route::get('/system-admin/store/pdf', ['uses'=> 'SystemAdmin\StoreController@generatePDF']);
        //Reward PDF
        Route::get('/system-admin/reward/pdf', ['uses'=> 'SystemAdmin\RewardController@generatePDF']);
    });

    // Customers Routes
    Route::group(['middleware' => 'customer'], function(){

        // Customer Dashboard Routes
        Route::get('/customer/dashboard', 'HomeController@index')->name('CustomerDashboard');
        Route::get('/customer/order', 'HomeController@order');

        Route::get('/customer/addresses', 'HomeController@addresses');
        Route::post('/customer/addresses', ['uses'=> 'Customer\BillingAddressController@create']);
        Route::get('/cusotmer/billing/delete/{id}', ['uses'=> 'Customer\BillingAddressController@delete']);

        Route::get('/customer/accountdetails', 'HomeController@accountdetails');
        Route::post('/customer/accountdetails/{id}', ['uses'=> 'Customer\AccountController@update']);


        // Coupon
        Route::post('/applyCouponCode', ['uses'=> 'HomeController@applyCoupon']);
        Route::get('/removeCouponCode', ['uses'=> 'HomeController@removeCoupon']);

        // Adding Product to cart
        Route::post('/addtocart/{id}', [
            'uses' => 'Customer\CartController@getAddToCart',
            'as'   => 'product.addtocart'
        ]);

        // Cart -> Reusable Cart
        Route::get('/cart/savetoreusablecart', ['uses' => 'Customer\ReusableCartController@create']);

        // Cart Reduce
        Route::post('/cart/reduce/{id}', ['uses' => 'Customer\CartController@reduceCartProductQty']);

        // Cart Increase
        Route::post('/cart/increase/{id}', ['uses' => 'Customer\CartController@increaseCartProductQty']);

        // Cart Change
        Route::post('/cart/change/{id}', ['uses' => 'Customer\CartController@changeCartProductQty']);

        // Compare Product Add
        Route::post('/compare-product/add/{id}', ['uses' => 'HomeController@compareProduct']);
        Route::get('/compare-product/clear', ['uses' => 'HomeController@clearCompare']);

        // Process Checkout
        Route::get('/checkout', 'PagesController@checkout');
        Route::post('/checkout/shipping', 'PagesController@setShippingFee');
        Route::get('/checkout/pickup', 'PagesController@unsetShippingFee');
        Route::post('/checkout/{id}', ['uses' => 'Customer\OrderMasterController@create']);

        // Order Details
        Route::get('/order/{id}', ['uses' => 'Customer\OrderDetailsController@afterCheckout']);
        // Order Details
        Route::get('/customer/view/{id}', ['uses' => 'Customer\OrderDetailsController@view']);

        // Order Update
        Route::post('/customer/order/update/{id}', ['uses' => 'Customer\OrderMasterController@update']);

        // Order Review
        Route::get('/customer/review/{id}', 'HomeController@review');
        Route::post('/customer/review/post/{id}', 'Customer\ProductRatingController@create');

        // Reusable Cart List
        Route::get('/customer/reusablecart', 'HomeController@reusablecartlist');

        //Reusable Cart -> Cart
        Route::get('/reusable/addtocart/{id}', ['uses' => 'Customer\ReusableCartController@addToCart']);

        //Delete Reusable Cart
        Route::get('/reusable/delete/{id}', ['uses' => 'Customer\ReusableCartController@delete']);

        //Reusable Cart List Load to Reusable Modal Update
        Route::get('/reusablecart/load/{id}', ['uses' => 'Customer\ReusableCartController@loadReusableCartList']);

        //Reusable Cart Modal Load Product By Store Id
        Route::get('/reusable/product/load/{id}', ['uses' => 'Customer\ReusableCartController@loadProduct']);

        //Add Product to Reusable Cart List
        Route::get('/reusable/product/add/{id}', ['uses' => 'Customer\ReusableCartController@addProductToReusableList']);

        //Change Reusable Cart List
        Route::get('/reusable/product/product-change/{id}', ['uses' => 'Customer\ReusableCartController@changeProductQty']);

        // Expenses Route
        Route::get('/customer/expenses', 'HomeController@expensesList');

        //Expenses PDF
        Route::get('/customer/expenses/pdf', ['uses'=> 'HomeController@generateExpensesPDF']);
    });

//    Store Routes
    Route::group(['middleware' => ['storeadmin', 'staff']], function(){

        Route::get('/storeadmin/dashboard', 'HomeController@storeDashboard')->name('StoreDashboard');

        // Store Admin Routes
        Route::get('/storeadmin/inventorymanagement', 'PagesController@inventoryMgtStore');
        Route::get('/storeadmin/staffmanagement', 'PagesController@staffMgt');

        //STORE SETTINGS ROUTES
        // Account Management
        Route::get('/storeadmin/accountmanagement', 'PagesController@accountMgt');

        Route::post('/storeadmin/accountmanagement/update/{id}', 'StoreAdmin\AccountManagement@update');
        // Store Management
        Route::get('/storeadmin/storemanagement', 'PagesController@storeMgt');

        // Store Create
        Route::post('/storeadmin/storemanagement/create/{id}', ['uses'=> 'StoreAdmin\StoreSettingController@create']);

        // INVENTORY MANAGEMENT ROUTES
        // Inventory
        Route::post('/storeadmin/inventorymanagement/update/{id}', ['uses'=> 'StoreAdmin\ProductController@update']);

        // Brand
        Route::post('/storeadmin/inventorymanagement/brand', ['uses'=> 'StoreAdmin\BrandController@create']);
        Route::get('/storeadmin/inventorymanagement/brand/delete/{id}', ['uses'=> 'StoreAdmin\BrandController@delete']);
        Route::get('/storeadmin/inventorymanagement/brand', 'PagesController@inventoryMgtbrand');

        // Category
        Route::get('/storeadmin/inventorymanagement/category', 'PagesController@inventoryMgtCategory');
        Route::get('/storeadmin/inventorymanagement/category/delete/{id}', ['uses'=> 'StoreAdmin\CategoryController@delete']);
        Route::post('/storeadmin/inventorymanagement/category', ['uses'=> 'StoreAdmin\CategoryController@create']);

        // Sub Category
        Route::post('/storeadmin/inventorymanagement/category/{id}', ['uses'=> 'StoreAdmin\SubCategoryController@create']);
        Route::get('/storeadmin/inventorymanagement/subcategory/delete/{id}', ['uses'=> 'StoreAdmin\SubCategoryController@delete']);

        // Attribute
        Route::get('/storeadmin/inventorymanagement/attribute', 'PagesController@inventoryMgtattribute');
        Route::get('/storeadmin/inventorymanagement/attribute/delete/{id}', 'StoreAdmin\AttributeController@delete');
        Route::post('/storeadmin/inventorymanagement/attribute', ['uses'=> 'StoreAdmin\AttributeController@create']);

        // Attribute Value
        Route::post('/storeadmin/inventorymanagement/attribute/{id}', ['uses'=> 'StoreAdmin\AttributeValueController@create']);
        Route::get('/storeadmin/inventorymanagement/subattribute/delete/{id}', ['uses'=> 'StoreAdmin\AttributeValueController@delete']);

        // Add Product Item
        Route::get('/storeadmin/inventorymanagement/addproduct', 'PagesController@inventoryMgtaddproduct');

        Route::post('/storeadmin/inventorymanagement/addproduct', ['uses'=> 'StoreAdmin\ProductController@create']);
        Route::post('/storeadmin/inventorymanagement/addproduct/subcategory', 'PagesController@subcategoryFetch');
        Route::post('/storeadmin/inventorymanagement/addproduct/attribute', 'PagesController@attributevalues');

        // STAFF MANAGEMENT ROUTES
        // Add Staff
        Route::get('/storeadmin/staffmanagement/addstaff', 'PagesController@staffMgtAddStaff');
        Route::get('/storeadmin/staffmanagement/delete/{id}', 'StoreAdmin\StaffController@delete');
        Route::post('/storeadmin/staffmanagement/addstaff', ['uses'=> 'StoreAdmin\StaffController@create']);


        // Manage Staff
        Route::post('/storeadmin/staffmanagement/{id}', ['uses'=> 'StoreAdmin\StaffController@update']);

        // ORDER MANAGEMENT ROUTES

        // Order List
        Route::get('/storeadmin/ordermanagement', 'PagesController@orderMgtShow');
        Route::get('/storeadmin/ordermanagement/canceledorder', 'PagesController@orderMgtShowCancel');

        // Order Detail
        Route::get('/storeadmin/ordermanagement/view/{id}', 'PagesController@singleOrderView');
        Route::get('/storeadmin/ordermanagement/view/report/{id}', 'PagesController@generatePDF');

        // Order PDF
        Route::get('/store-admin/order/pdf', 'PagesController@generateOrderPDF');

        // Update Order
        Route::post('/storeadmin/ordermanagement/update/{id}', ['uses'=> 'StoreAdmin\OrderMasterController@update']);

        // SUPPLIER MANAGEMENT ROUTES
        // Supplier List
        Route::get('/storeadmin/supplier', 'PagesController@supplierMgtShow');

        // Supplier Create
        Route::post('/storeadmin/supplier/create', ['uses'=> 'StoreAdmin\SupplierController@create']);

        // Supplier Update
        Route::post('/storeadmin/supplier/update/{id}', ['uses'=> 'StoreAdmin\SupplierController@update']);

        // Supplier Delete
        Route::get('/storeadmin/supplier/delete/{id}', ['uses'=> 'StoreAdmin\SupplierController@delete']);

        // Request Supply
        Route::get('/storeadmin/supply', 'PagesController@requestSupplyMgt');
        Route::post('/storeadmin/supply/update/{id}', 'RequestSupplyController@update');

        // Generate PDF
        // Inventory
        Route::get('/store-admin/account/pdf', 'StoreAdmin\ProductController@generatePDF');
    });

//  Supplier Routes
    Route::group(['middleware' => 'supplier'], function(){

        Route::get('/supplier/dashsystem-admin/account/pdfboard', function () {
            return view('/supplier/dashboard');
        })->name('SupplierDashboard');

        // Request Supply List
        Route::get('/supplier/supplymanagement', 'PagesController@supplyMgtShow');

        // Request Supply Update
        Route::post('/supplier/supplymanagement/update/{id}', ['uses'=> 'Supplier\RequestStockController@update']);

    });

});







