<?php
namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Image;
use Validator;
use Illuminate\Http\Request;

class ImageUploadController extends Controller
{
    public function upload(Request $request)
    {
 
       $validator = Validator::make($request->all(),[ 
              'image' => 'required|mimes:doc,docx,pdf,txt,csv,jpg|max:2048',
        ]);   
 
        if($validator->fails()) {          
            
            return response()->json(['error'=>$validator->errors()], 401);                        
         }  
 
  
        if ($image = $request->image('image')) {
            $path = $image->store('public/images');
            $name = $image->getClientOriginalName();
 
            //store your image into directory and db
            $save = new Image();
            $save->name = $image;
            $save->store_path= $path;
            $save->save();
              
            return response()->json([
                "success" => true,
                "message" => "image successfully uploaded",
                "image" => $image
            ]);
  
        }
 
  
    }
}
