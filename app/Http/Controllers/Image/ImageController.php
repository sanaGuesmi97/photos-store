<?php

namespace App\Http\Controllers\Image;

use App\Http\Controllers\Controller;
use App\Http\Requests\Image\StoreImageRequest;
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
        try{ $image = Image::with('user', 'categories')->get();
            return ImageResource::collection($image);}
            catch (\Exception $e) {
            return $e->getMessage();
        }
       
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
    public function store(StoreImageRequest $request)
    {
        try {
            $image = new Image();
            $image->title = $request->title;
            $image->description = $request->description;
            $image->price = $request->price;
            $image->category = $request->category;
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
    public function update(Request $request, $id)
    {
        //
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
}
