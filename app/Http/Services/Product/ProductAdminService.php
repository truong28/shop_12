<?php

namespace App\Http\Services\Product;

use App\Models\Product;
use App\Models\Menu;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class ProductAdminService
{
    public function getMenu()
    {
        return Menu::where('active', 1)->get();
    }

    // check price and price_sale
    public function isValuePrice($request)
    {
       
        if(( $request->input('price') == 0 || $request->input('price_sale') == 0 ) )
        {
            Session::flash('error','Fields price and price_sale not empty!');
            return false;
        }else{

            if( ( $request->input('price_sale') >= $request->input('price')) )
            {
                Session::flash('error','Price_sale must lesser than price!');
                return false;
            }
        }

        return true;

    }

    public function insert($request)
    {
        
        $isValuePrice = $this->isValuePrice($request);
        if($isValuePrice == false){ return false;}

        try{
            $request->except('_token');
            Product::create($request->all());
            Session::flash('success','Create Completed!');
        } catch ( \Exception $err)
        {
            Session::flash('error','Create false!');
            Log::info($err->getMessage());
            return false;
        }
        return true;
       
    }
    //get product list
    public function getProduct()
    {
        return Product::with('menu')->orderByDesc('id')->paginate(10);
    }

   /*  public function getProductById($id)
    {
        return Product::where('id',$id)->first();
    } */

    //Update product

    public function update($request, $product)
    {
        $isValuePrice = $this->isValuePrice($request);
  
        if($isValuePrice == false){ return false;}

        try{
            $request->except('_token');
            $product->fill($request->input());
            $product->save();
            Session::flash('success','Update Completed!');
        } catch ( \Exception $err)
        {
            Session::flash('error','Update false!');
            Log::info($err->getMessage());
            return false;
        }
        return true;
    }

    //delete product
    public function destroy($request)
    {
        $product = Product::where('id',$request->input('id'))->first();

        if($product)
        {
            $path = str_replace('storage','public',$product->thumb);
            Storage::delete($path);
            $product->delete();
            return true;
        }
        return false;

    }


}
