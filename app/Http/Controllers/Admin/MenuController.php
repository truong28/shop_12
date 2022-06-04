<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Menu\CreateFormRquest;
use Illuminate\Http\Request;
use App\Http\Services\Menu\MenuService;

class MenuController extends Controller
{
    protected $menuService;

    public function __construct(MenuService $menuService)
    {
        $this->menuService = $menuService;
    }

    public function create()
    {
        return view('admin.menu.add', [
            'title' => 'Menu',
            'menus' => $this->menuService->getParent()
          
        ]);
    }
    //add category
    public function store(CreateFormRquest $request)
    {
         $result = $this->menuService->create($request);

         return redirect()->back();
          
        
    }

    public function index()
    {
         return view('admin.menu.list',[
             'title' => 'Category list',
             'menus' => $this->menuService->getAll()
         ]);
          
        
    }

    public function destroy(Request $request)
    {
        $result = $this->menuService->destroy($request); 
        if($result){
            return response()->json([
                'error'=> false,
                'message'=>'delete success'
            ]);
        }
        return response()->json([
            'error'=> true,
          
        ]);
        
    }
}
