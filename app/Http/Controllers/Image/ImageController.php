<?php

namespace App\Http\Controllers\Image;

use App\Http\Controllers\Controller;
use App\Http\Requests\Image\StoreImageRequest;
use App\Http\Requests\Image\UpdateImageRequest;
use App\Http\Resources\Image\ImageResource;
use Illuminate\Http\Request;
use App\Models\Image;

class ImageController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try {
            $image = Image::with('user', 'categories')->get();
            return ImageResource::collection($image);
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    // public function store(Request $request)

    public function store(Request $request)
    {
        try {
            $maxIncrement = Image::max('increment');
            $i = $maxIncrement + 1;
            $images = $request->file('images');
            $imagePaths = [];
            foreach ($images as $file) {
                if ($file->isValid()) {
                    $fileName = time() . '_' . $file->getClientOriginalName();
                    $path = 'uploads/images/';
                    $publicPath = public_path($path);

                    if (!is_dir($publicPath)) {
                        mkdir($publicPath, 0755, true);
                    }
                    $file->move($publicPath, $fileName);
                    $imagePaths[] = $path . $fileName;
                }
            }
            foreach ($imagePaths as $imagePath) {
                $image = new Image();
                $image->title = $request->title;
                $image->description = $request->description;
                $image->price = $request->price;
                $image->user_id = $request->userId;
                $image->category_id = $request->categoryId;
                $image->image = $imagePath;
                $image->increment = $i;
                $image->save();
            }
            // return $image;
            return response()->json(['message' => 'Images uploaded successfully']);
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        try {
            $image = Image::findOrFail($id);
            return new ImageResource($image);
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }
    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateImageRequest $request, $id)
    {
        try {
            if (!$request->filled('images')) {
                return response()->json(['message' => 'No images to update'], 400);
            }
            $existingImage = Image::find($id);

            if (!$existingImage) {
                return response()->json(['message' => 'Image not found'], 404);
            }
            $currentIncrement = $existingImage->increment;

            $imagesToUpdate = $request->file('images');

            foreach ($imagesToUpdate as $file) {

                $image = Image::find($id);

                if (!$image) {
                    return response()->json(['message' => 'Image not found'], 404);
                }
                if ($file->isValid()) {
                    $fileName = time() . '_' . $file->getClientOriginalName();
                    $path = 'uploads/images/';
                    $publicPath = public_path($path);

                    if (!is_dir($publicPath)) {
                        mkdir($publicPath, 0755, true);
                    }

                    $file->move($publicPath, $fileName);

                    $image->image = $path . $fileName;

                    if ($request->filled('title')) {
                        $image->title = $request->title;
                    }
                    if ($request->filled('description')) {
                        $image->description = $request->description;
                    }
                    if ($request->filled('price')) {
                        $image->price = $request->price;
                    }
                    if ($request->filled('userId')) {
                        $image->user_id = $request->userId;
                    }
                    if ($request->filled('categoryId')) {
                        $image->category_id = $request->categoryId;
                    }

                    // Utiliser l'incrément actuel pour la mise à jour
                    $image->increment = $currentIncrement;

                    $image->save();
                }
            }

            return response()->json(['message' => 'Images updated successfully']);

        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $image = Image::find($id);
        $image->delete();
        return 'deleted';
    }
    public function restore($id)
    {
        $image = Image::withTrashed()->find($id);
        $image->restore();
        return 'restored one';
    }
}
