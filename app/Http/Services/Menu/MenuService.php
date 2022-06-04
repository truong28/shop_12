<?php

namespace App\Http\Services\Menu;

use App\Models\Menu;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;

class MenuService
{
    //get parent category
    public function getParent(){
        return Menu::where('parent_id',0)->get();
    }

    //get all category
    public function getAll(){
        return Menu::orderByDesc('id')->paginate(10);
    }
    // create new category
    public function create(Request $request){
        try{
            Menu::create([
                'name' => (string) $request->input('name'),
                'parent_id' => (int) $request->input('parent_id'),
                'description' => (string) $request->input('description'),
                'content' => (string) $request->input('content'),
                'active' => (string) $request->input('active'),
                'slug'  => Str::slug($request->input('name'), '-')
            ]);

            Session::flash('success','Created!');
        } catch (\Exception $err) {
            Session::flash('error', $err->getMessage());
            return false;
        }
        return true;
    }

    public function destroy(Request $request){
        $id = (int) $request->input('id');
        $menu = Menu::where('id', $id )->first();
        if($menu){
            return Menu::where('id', $id)->orWhere('parent_id',$id)->delete();
        }
        return false;
    }
   
}