<?php

namespace App\Http\Controllers;

use App\Cart;
use App\Notification;
use App\OrderMaster;
use App\Product;
use App\ReusableCartlist;
use App\Reward;
use App\Services\HomeServices;
use App\Services\PagesServices;
use App\Store;
use App\City;
use App\BillingAddress;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use MongoDB\Driver\Session;
use PDF;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('/customer/dashboard');
    }

    public function order()
    {
        if (isset($_GET['status']) && $_GET['status'] != 'All') {
            $status = $_GET['status'];

            $orders = OrderMaster::where('user_id', Auth::id())
                        ->orderBy('id', 'DESC')
                        ->where('status', '=', $status)->get();
        } else {
            $orders = OrderMaster::orderBy('id', 'DESC')->where('user_id', Auth::id())->get();
        }

        return view('/customer/order')
                ->with('total', $total = 0)
                ->with('orders', $orders);
    }

    public function addresses()
    {
        $locations = City::all();
        $billingaddresses = BillingAddress::all();

        return view('/customer/addresses')
                ->with('locations', $locations)
                ->with('billingaddresses', $billingaddresses);
    }

    public function accountdetails()
    {
        return view('/customer/accountdetails');
    }

    public function applyCoupon(Request $request) {

        $coupon = Reward::where('code', $request->coupon)->first();
        $subtotal = Cart::subtotal();

        if(!$coupon || $coupon->status == 'Used') {
            return redirect()->back()->with('error', 'Invalid Coupon');
        }

        session()->put('coupon', [
            'id' => $coupon->id,
            'code' => $coupon->code,
            'discount' => $coupon->discount
        ]);

        return redirect()->back()->with('success', 'Coupon Applied');
    }

    public function removeCoupon() {
        session()->forget('coupon');
        return redirect()->back()->with('success', 'Coupon Removed');
    }

    public function reusablecartlist() {
        $reusable_carts = ReusableCartlist::where('user_id', Auth::id())->get();

        return view('/customer/reusablecart')
                    ->with('total', $total = 0)
                    ->with('stores', $stores = Store::all())
                    ->with('reusable_carts', $reusable_carts);
    }

    public function expensesList(HomeServices $homeServices) {
        $orders = OrderMaster::where('user_id', Auth::id())
                    ->limit(3)
                    ->orderBy('created_at','DESC')
                    ->get();

        return view('/customer/expenses')
                    ->with('orders', $orders)
                    ->with('total', $total = 0)
                    ->with('expenses_chart', $homeServices->expensesChart());
    }

    public function review($id)
    {
        $orderDetails = OrderMaster::where("id", $id)->first()->OrderDetails;

        return view('/customer/order-review')
                ->with('orderDetails', $orderDetails);
    }

    public function generateExpensesPDF() {

        $orders = OrderMaster::where('user_id', Auth::id())
            ->orderBy('created_at','DESC')
            ->get();

        // share data to view
        view()->share(['orders' => $orders, 'total' => $total=0]);
        $pdf = PDF::loadView('PDF.customer.ExpensesPDF', $orders);

        // download PDF file with download method
        return $pdf->stream('pdf_file.pdf');

    }

    public function compareProduct($id) {
        $product = Product::where('id', $id)->first();

        session()->push('key', $product);

        return redirect()->back();
    }

    public function clearCompare() {
        session()->forget('key');

        return redirect()->back();
    }

    public function notificationUpdate(PagesServices $pagesServices) {

        Auth::user()->role == 'customer'
            ? $id = Auth::id()
            : $id = $pagesServices->storeByRole()->id;

        $notification_to = Notification::where('user_id', $id)->get();

        foreach ($notification_to as $notify) {

            Notification::where('id', $notify->id)->update(['status' => 1]);
        }

    }

    public function storeDashboard(HomeServices $homeServices) {

        return view('/storeadmin/dashboard')
                ->with('totalOrderToday', $homeServices->totalOrderToday())
                ->with('totalStaff', $homeServices->totalStaff())
                ->with('totalRevenue', Store::getTotalOrder())
                ->with('totalActiveSupply', Store::getActiveRequestSupply())
                ->with('totalProfit', Store::getTotalProfit())
                ->with('totalOrder', $homeServices->totalOrders())
                ->with('product_trend', $homeServices->productTrend());
    }

    public function VerificationPage() {
        return view('pages.verification_page');
    }

}
