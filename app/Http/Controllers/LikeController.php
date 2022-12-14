<?php

namespace App\Http\Controllers;

use App\Models\Like;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class LikeController extends Controller
{
    public function storeLike(Request $request): JsonResponse
    {
        $likeCheck = Like::where(['user_id' => $request->user_id, 'quote_id'=> $request->id])->first();
        if ($likeCheck) {
            $likeCheck = Like::where(['user_id' => $request->user_id, 'quote_id'=> $request->id])->delete();
        } else {
            $like = new Like();
            $like->user_id = $request->user_id;
            $like->quote_id = $request->id;
            $like->save();
        }

        return response()->json('success', 200);
    }
}
