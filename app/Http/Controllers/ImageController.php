<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Image;

class ImageController extends Controller
{
    public function uploadImage(Request $request){
      $request->validate(['image'=>'required|image|mimes:jpg,png,jpeg,gif,svg|max:2048']);
      $path_image = $request->file('image')->store('image','public');
      $data = Image::create(['image' => $path_image,]);
      return $data;
    }
}
