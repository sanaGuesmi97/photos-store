<?php

namespace App\Http\Controllers\Review;

use App\Http\Controllers\Controller;
use App\Models\Review;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;


class ReviewController extends Controller
{
    public function addReview(Request $request)
    {
        try {
            if (!Auth::check()) {
                $message = "Login to rate this image";
                return response()->json(['message' => $message], 401);
            }

            $reviewCount = Review::where(['user_id' => Auth::user()->id, 'image_id' => $request->imageId])->count();

            if ($reviewCount > 0) {
                $message = "Your rating already exists for this product";
                return response()->json(['message' => $message], 400);
            }

            $newReview = new Review;
            $newReview->user_id = Auth::user()->id;
            $newReview->image_id = $request->imageId;
            $newReview->comment = $request->comment;
            $newReview->rating = $request->rating;
            $newReview->status = 0;
            $newReview->save();

            $message = "Thanks for rating this product! It will be shown once approved.";
            return response()->json(['message' => $message], 200);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
}
