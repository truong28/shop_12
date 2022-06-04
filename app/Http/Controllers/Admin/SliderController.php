<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Services\Slider\SliderService;
use App\Models\Slider;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Log;

class SliderController extends Controller
{
    protected $slider;

    public function __construct(SliderService $slider)
    {
        $this->slider = $slider;
    }

    public function create()
    {
        return view('admin/slider/add',[
            'title' => 'New Slider'
        ]);
    }
    // add a new slider and validation for fields
    public function store(Request $request)
    {
        $this->validate($request,[
            'name' => 'required|min:3',
            'thumb' => 'required', 
            'url' => 'required'
        ]);
  
        $this->slider->insert($request);

        return redirect()->back();
    }

    public function index()
    {
        return view('admin.slider.list',[
            'title' => 'List Of Sliders',
            'sliders' => $this->slider->get()
        ]);

    }

    //edit slider
    public function edit( Slider $slider)
    {
        return view('admin.slider.edit',[
            'title' => 'Edit Of Sliders',
            'slider' => $slider
        ]);
    }

    public function update(Request $request, Slider $slider)
    {
       $this->validate($request,[
        'name' => 'required|min:3',
        'thumb' => 'required', 
        'url' => 'required'
       ]);

       $result = $this->slider->update($request, $slider);
       if($result){
           return redirect('admin/sliders/list');
       }
       return redirect()->back();
    }

    public function destroy(Request $request)
    {
        $result = $this->slider->destroy($request);

        try{
            if($result)
            {
                return response()->json([
                    'error'=> false,
                    'message' => 'Delete conpeled!'
                ]);
            }
        }catch (\Exception $err){
            return response()->json([
                'error'=> true
            ]);
        }
    }
}
