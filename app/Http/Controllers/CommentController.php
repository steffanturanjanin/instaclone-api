<?php

namespace App\Http\Controllers;

use App\Comment;
use App\Photo;
use App\Http\Resources\Comment as CommentResource;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function index($id)
    {
        $photo = Photo::find($id);
        return CommentResource::collection($photo->comments);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return CommentResource
     */
    public function store(Request $request)
    {

        $comment = new Comment;
        $comment->photo_id = $request->photo_id;
        $comment->user_id = $request->user()->id;
        $comment->content = $request->comment_content;
        $comment->likes = 0;

        $comment->save();

        return new CommentResource($comment);
     }
}
