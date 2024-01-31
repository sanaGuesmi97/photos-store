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
    public function store(Request $request)

    {
        try {
            $image = new Image();
            $image->title = $request->title;
            $image->description = $request->description;
            $image->price = $request->price;
            $image->user_id = $request->userId;
            $image->category_id = $request->categoryId;
            if ($request->has('image')) {
                $file = $request->file('image');
                $fileName = time() . '.' . $request->image->extension();
                $path = 'uploads/images/';

                $publicPath = public_path($path);
                if (!is_dir($publicPath)) {
                    mkdir($publicPath, 0755, true);
                }
                $file->move($publicPath, $fileName);
                $image->image = $publicPath . $fileName;
            }
            $image->save();
            return $image;
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
            return $image;
        } catch (\Exception $e) {
            return $e->getMessage();
        }
        ;
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
            $image = Image::find($id);
    
            if (!$image) {
                return response()->json(['message' => 'Image not found'], 404);
            }
    
            if ($request->has('title')) {
                $image->title = $request->title;
            }
            if ($request->has('description')) {
                $image->description = $request->description;
            }
            if ($request->has('price')) {
                $image->price = $request->price;
            }
            if ($request->has('userId')) {
                $image->user_id = $request->userId;
            }
            if ($request->has('categoryId')) {
                $image->category_id = $request->categoryId;
            }
            
            if ($request->has('image')) {
              
                $file = $request->file('image');
                $fileName = time() . '.' . $request->image->extension();
                $path = 'uploads/images/';
    
                $publicPath = public_path($path);
                $file->move($publicPath, $fileName);
    
                // Update image file path in the database
                $image->image = $path . $fileName;
            }
    
            $image->save();
    
            return response()->json(['message' => 'Image updated successfully']);
    
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
        $image=Image::find($id);
        $image->delete();
        return'deleted';
    }
    public function restore($id)
    {
        $image=Image::withTrashed()->find($id);
        $image->restore();
        return'restored one';
    }
}
