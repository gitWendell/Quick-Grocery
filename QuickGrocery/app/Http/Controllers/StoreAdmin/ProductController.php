<?php

namespace App\Http\Controllers\StoreAdmin;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreAdmin\Product\ProductCreate;
use App\ProductBatch;
use App\Services\PagesServices;
use App\Services\StoreAdmin\ProductServices;
use Dompdf\FrameReflower\Page;
use Illuminate\Http\Request;
use App\Product;
use App\User;
use Auth;
use PDF;

class ProductController extends Controller
{
    //

    public function create(ProductCreate $request, ProductServices $productServices) {
        $validated = $request->validated();
        // Create Product Information
        $product = Product::create($productServices->create($request));

        $createBatch['stocks'] = $validated['stock'];
        $createBatch['product_id'] = $product->id;
        $createBatch['expiration_date'] = $validated['expiration_date'];
        $createBatch['status'] = 'Active';

        ProductBatch::create($createBatch);

        return redirect('/storeadmin/inventorymanagement/addproduct')->with('success', 'Product Information Added.');
    }

    // Update Product Information ----- will be change or be deleted further ----
    public function update(Request $request, $id) {

        $this->validate($request, [
            'name' => ['required'],
            'product_description' => ['required'],
            'original_price' => ['required'],
            'selling_price' => ['required'],
        ]);

         //  Staff Information
         $product = Product::find($id);
         $product->name = $request->input('name');
         $product->description = $request->input('product_description');
         $product->price = $request->input('original_price');
         $product->selling_price = $request->input('selling_price');
         $product->save();

         return redirect('/storeadmin/inventorymanagement')->with('success', 'Update Information Updated.');
    }

    public function generatePDF(PagesServices $pagesServices) {

        $store = $pagesServices->storeByRole();

        // share data to view
        view()->share('store', $store);
        $pdf = PDF::loadView('PDF.store.InventoryPDF', $store);


        return $pdf->stream('pdf_file.pdf');
    }

}
