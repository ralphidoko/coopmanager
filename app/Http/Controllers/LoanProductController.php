<?php

namespace App\Http\Controllers;

use App\Application;
use App\LoanProduct;
use Illuminate\Http\Request;

class LoanProductController extends Controller
{
    public function renderProductForm(Request $request)
    {
        $products = LoanProduct::all();
        return view('dashboard.admin.products.manageProduct',compact('products'));
    }

   public function createProduct(Request $request)
   {
       $createOrUpdateProduct = ($request->productID == '') ?
                      LoanProduct::create([
                       'item_name' => $request->productName,
                       'item_price' => $request->productPrice,
                       'item_description' => $request->productDescription
                      ]):
                       LoanProduct::where('id',$request->productID)->update([
                           'item_name' => $request->productName,
                           'item_price' => $request->productPrice,
                           'item_description' => $request->productDescription
                       ]);
      if($createOrUpdateProduct){
          \App\Helpers\LogActivity::logUserActivity(' User Created or Updated Loan Product');
          $data = ['success' => true, 'message'=> 'Action successfully completed!.'];
          return response()->json($data);
      }else{
          $data = ['warning' => true, 'message'=> 'Action failed, try again.'];
          return response()->json($data);
      }
   }

   public function destroyProduct(Request $request)
   {
       $deleteProduct = LoanProduct::find($request->productID)->delete();
       \App\Helpers\LogActivity::logUserActivity(' User Deleted Loan Product');
       if($deleteProduct){
           $data = ['warning' => true, 'message'=> 'Product successfully deleted.'];
           return response()->json($data);
       }

   }

}
