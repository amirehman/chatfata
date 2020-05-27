<?php

namespace App\Http\Controllers;

use Illuminate\Support\Str;
use Illuminate\Http\Request;
use \App\Media;
use Image;
use ImageOptimizer;

class MediaController extends Controller
{
    public function storeImages(Request $request, $collection, $rid, $rname)
    {


        // create folder by monts and yeare
        $monthYear = date('FY');
        $folder_by_month = public_path() . '/storage/recipes/' . $monthYear;
        !file_exists($folder_by_month) && mkdir($folder_by_month, 0777);

        // giving random name to image to make it unique
        $imgName = Str::random() . time();
        $image = $request->image;

        $mimeType = $request->image->getClientMimeType();

        $imagePathForDB = 'recipes/' . $monthYear . '/' . $imgName . '.' . $image->getClientOriginalExtension();
        $smallImage = $imgName . '-small.' . $image->getClientOriginalExtension();
        $mediumImage = $imgName . '-medium.' . $image->getClientOriginalExtension();
        $originalImage = $imgName . '.' . $image->getClientOriginalExtension();

        Image::make($image)->resize(96, null, function ($constraint) {
            $constraint->aspectRatio();
        })->save(public_path() . '/storage/recipes/' . $monthYear . '/' . $smallImage);

        Image::make($image)->resize(600, null, function ($constraint) {
            $constraint->aspectRatio();
        })->save(public_path() . '/storage/recipes/' . $monthYear . '/' . $mediumImage);

        Image::make($image)->save(public_path() . '/storage/recipes/' . $monthYear . '/' . $originalImage);


        ImageOptimizer::optimize(public_path() . '/storage/recipes/' . $monthYear . '/' . $smallImage);
        ImageOptimizer::optimize(public_path() . '/storage/recipes/' . $monthYear . '/' . $mediumImage);
        ImageOptimizer::optimize(public_path() . '/storage/recipes/' . $monthYear . '/' . $originalImage);

        // ======== Generating images ==============

        $media = Media::create([
            'user_id' => auth()->user()->id,
            'recipe_id' => $rid,
            'name' => $rname,
            'file' => $imagePathForDB,
            'mime_type' => $mimeType,
            'collection' => $collection
        ]);


        return response()->json([
            "message" => 201,
            "image" => $media,
        ]);
    }

    public function deleteImage($id)
    {

        $media = Media::where("id", $id)->first();
        $image = public_path("storage/$media->file");

        $extension_pos = strrpos($image, '.');
        $small = substr($image, 0, $extension_pos) . '-small' . substr($image, $extension_pos);
        $medium = substr($image, 0, $extension_pos) . '-medium' . substr($image, $extension_pos);


        unlink($small);
        unlink($medium);
        unlink($image);
        $media->delete();
        return response("Image deleted", 201);
    }
}
