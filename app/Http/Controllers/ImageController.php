<?php

namespace App\Http\Controllers;

use App\Models\Image;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class ImageController extends Controller
{
  public function uploadImage(Request $request)
  {
    try {
      $request->validate(
        [
          'image' => ['required', 'mimes:png,jpeg,gif,jpg,svg', 'max:2048']
        ]
      );
      //
      $path_image = $request->file('image')->store('image', 'public');
      //
      $image = Image::create(['image' => $path_image]);
      //
      return response()->json($image, Response::HTTP_CREATED);
    } catch (\Exception $ex) {
      //
      return response()->json($ex->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
    }
  }
}
