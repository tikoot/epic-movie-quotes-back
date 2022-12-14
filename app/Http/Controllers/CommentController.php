<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\Movie;
use App\Models\Quote;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    public function store(Comment $comment, Request $request, $id)
    {
        $comment->create([
            'body' => $request->body,
            'user_id' => $request->user_id,
            'quote_id' => $id
        ]);
        return response()->json('Comment created Successfully');
    }
}
