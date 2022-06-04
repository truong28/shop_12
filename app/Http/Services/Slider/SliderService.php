<?php

namespace App\Http\Services\Slider;

use App\Models\Slider;

use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class SliderService
{
    public function insert($request)
    {
        try{
          
            Slider::create($request->input());
            Session::flash('success','A new slider added!');
        }catch (\Exception $err){
            Session::flash('error','A new slider adde false!');
            Log::info($err->getMessage());

            return false;
            
        }
        return true;
    }

    public function get()
    {
        return Slider::orderByDesc('id')->paginate(10);
    }

    public function update($request, $slider)
    {
        try{
            $slider->fill($request->input());
            $slider->save();
            Session::flash('success','Update Compeleted!');
        }catch (\Exception $err)
           
        {
            Session::flash('error','Update false!');
            Log::info($err->getMessage());
            return false;
        }
        return true;
    }

    public function destroy($request)
    {
  
        $slider = Slider::where('id',$request->input('id'))->first();
        if($slider)
        {
            $path = str_replace('storage','public',$slider->thumb);
            Storage::delete($path);
            $slider->delete();
            return true;

        }
        return false;
    }
}
