<?php

namespace App\Http\Controllers;

use Illuminate\Support\Str;
use Illuminate\Http\Request;
use \App\Recipe;
use \App\Media;
use \App\CountryRecipe;
use Image;
use ImageOptimizer;

class RecipeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $data = $request->validate([
            'title' => 'required|string',
            'meals' => 'required',
            'country' => 'required',
            'difficulty' => 'required|string',
            'prep_time' => 'required|integer',
            'image' => 'required',
        ]);


        // ======= Generating Slug ============
        $title = $request->title;
        $ts = Str::of($title)->slug('-');
        $recipes = Recipe::where('slug', '=', $ts)->pluck('slug');

        if ($recipes->count() == 0) {
            $slug = $ts;
        } else {
            $count = Recipe::whereRaw("slug RLIKE '^{$ts}(-[0-9]+)?$'")->count();
            $slug = $count ? "{$ts}-{$count}" : $ts;
        }
        // ======== Generating Slug ==============


        // ======== Generating images ==============

        // create folder by monts and yeare
        $monthYear = date('FY');
        $folder_by_month = public_path() . '/storage/recipes/' . $monthYear;
        !file_exists($folder_by_month) && mkdir($folder_by_month, 0777);

        // giving random name to image to make it unique
        $thumbName = Str::random() . time();
        $thumbnail = $request->image;

        $imagePathForDB = 'recipes/' . $monthYear . '/' . $thumbName . '.' . explode('/', explode(':', substr($thumbnail, 0, strpos($thumbnail, ';')))[1])[1];

        $smallImage = $thumbName . '-small' . '.' . explode('/', explode(':', substr($thumbnail, 0, strpos($thumbnail, ';')))[1])[1];
        $mediumImage = $thumbName . '-medium' . '.' . explode('/', explode(':', substr($thumbnail, 0, strpos($thumbnail, ';')))[1])[1];
        $originalImage = $thumbName . '.' . explode('/', explode(':', substr($thumbnail, 0, strpos($thumbnail, ';')))[1])[1];


        Image::make($thumbnail)->resize(96, null, function ($constraint) {
            $constraint->aspectRatio();
        })->save(public_path() . '/storage/recipes/' . $monthYear . '/' . $smallImage);

        Image::make($thumbnail)->resize(200, null, function ($constraint) {
            $constraint->aspectRatio();
        })->save(public_path() . '/storage/recipes/' . $monthYear . '/' . $mediumImage);

        Image::make($thumbnail)->save(public_path() . '/storage/recipes/' . $monthYear . '/' . $originalImage);


        ImageOptimizer::optimize(public_path() . '/storage/recipes/' . $monthYear . '/' . $smallImage);
        ImageOptimizer::optimize(public_path() . '/storage/recipes/' . $monthYear . '/' . $mediumImage);
        ImageOptimizer::optimize(public_path() . '/storage/recipes/' . $monthYear . '/' . $originalImage);

        // ======== Generating images ==============

        $recipe = Recipe::create([
            'user_id' => auth()->user()->id,
            'title' => $request->title,
            'slug' => $slug,
            'body' => $request->detail,
            'difficulty' => $request->difficulty,
            'prep_time' => $request->prep_time,
            'serves' => $request->serves,
            'video' => $request->video,
            'image' => $imagePathForDB,
        ]);

        $recipe->meals()->sync($request->meals);

        CountryRecipe::create([
            'recipe_id' => $recipe->id,
            'country_id' => $request->country,
            'state_id' => $request->state,
        ]);

        return response($recipe->slug, 201);
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
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Recipe $recipe)
    {
        $data = $request->validate([
            'title' => 'required|string',
            'meals' => 'required',
            'difficulty' => 'required|string',
            'prep_time' => 'required|integer'
        ]);

        $oldImage = $recipe->image;
        $newImage = $request->image;
        if ($oldImage != $newImage) {

            //deleting old images
            // $image = public_path("storage/$oldImage");
            // $extension_pos = strrpos($image, '.');
            // $small = substr($image, 0, $extension_pos) . '-small' . substr($image, $extension_pos);
            // $medium = substr($image, 0, $extension_pos) . '-medium' . substr($image, $extension_pos);
            // unlink($small);
            // unlink($medium);
            // unlink($image);

            //making new thumbnail resizing compressing
            // ======== Generating images ==============

            // create folder by monts and yeare
            $monthYear = date('FY');
            $folder_by_month = public_path() . '/storage/recipes/' . $monthYear;
            !file_exists($folder_by_month) && mkdir($folder_by_month, 0777);

            // giving random name to image to make it unique
            $thumbName = Str::random() . time();
            $thumbnail = $request->image;

            $imagePathForDB = 'recipes/' . $monthYear . '/' . $thumbName . '.' . explode('/', explode(':', substr($thumbnail, 0, strpos($thumbnail, ';')))[1])[1];

            $smallImage = $thumbName . '-small' . '.' . explode('/', explode(':', substr($thumbnail, 0, strpos($thumbnail, ';')))[1])[1];
            $mediumImage = $thumbName . '-medium' . '.' . explode('/', explode(':', substr($thumbnail, 0, strpos($thumbnail, ';')))[1])[1];
            $originalImage = $thumbName . '.' . explode('/', explode(':', substr($thumbnail, 0, strpos($thumbnail, ';')))[1])[1];


            Image::make($thumbnail)->resize(96, null, function ($constraint) {
                $constraint->aspectRatio();
            })->save(public_path() . '/storage/recipes/' . $monthYear . '/' . $smallImage);

            Image::make($thumbnail)->resize(200, null, function ($constraint) {
                $constraint->aspectRatio();
            })->save(public_path() . '/storage/recipes/' . $monthYear . '/' . $mediumImage);

            Image::make($thumbnail)->save(public_path() . '/storage/recipes/' . $monthYear . '/' . $originalImage);


            ImageOptimizer::optimize(public_path() . '/storage/recipes/' . $monthYear . '/' . $smallImage);
            ImageOptimizer::optimize(public_path() . '/storage/recipes/' . $monthYear . '/' . $mediumImage);
            ImageOptimizer::optimize(public_path() . '/storage/recipes/' . $monthYear . '/' . $originalImage);

            $recipe->image = $imagePathForDB;
        }

        $recipe->title = $request->title;
        $recipe->body = $request->detail;
        $recipe->prep_time = $request->prep_time;
        $recipe->video = $request->video;
        $recipe->serves = $request->serves;
        $recipe->ingredient_note = $request->note;

        $recipe->difficulty = $request->difficulty;

        $recipe->meals()->sync($request->meals);

        $recipe->save();

        $country = CountryRecipe::findorFail($recipe->cuisine->id);
        if(!is_array($request->country)) {
            $country->country_id = $request->country;
            $country->state_id = $request->state;
            $country->save();
        }


        return response($recipe->slug, 201);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

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
            "image" => json_encode($media),
        ]);
    }


    public function changeStatus(Request $request, Recipe $recipe)
    {
        $recipe->status = $request->status;
        $recipe->save();
        return response("Status changed", 201);
    }
}
