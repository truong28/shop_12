<?php

namespace App\Http\Controllers\Admin;

use App\Http\Services\Product\ProductAdminService;
use App\Http\Controllers\Controller;
use App\Http\Requests\Product\ProductRequest;
use App\Models\Menu;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{

    protected $productService;
    public function __construct(ProductAdminService $productService)
    {
        $this->productService = $productService;
      
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.product.list',[
            'title' => 'Product List',
            'products' => $this->productService->getProduct()
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.product.add',[
            'title' => 'Create a new product!',
            'menus' => $this->productService->getMenu()
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ProductRequest $request)
    {
        $this->productService->insert($request);
        return redirect()->back();
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Product $product)
    {
        
        return view('admin.product.edit',[
            'title' => 'Edit product',
            'product' => $product,
            'menus' => $this->productService->getMenu()
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(ProductRequest $request, Product $product)
    {
        $result = $this->productService->update($request, $product);
        if($result)
        {
            return redirect('admin/products/list');
        }
        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $result = $this->productService->destroy($request);

        try{
            if($result)
            {
                return response()->json([
                    'error' => false,
                    'message' => 'delete completed!'
                ]);
            }
        }catch (\Exception $err){
            return response()->json([
                'error' => true,
            ]);
        }
      
    }
    
}
