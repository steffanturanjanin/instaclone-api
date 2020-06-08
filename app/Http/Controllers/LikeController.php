<?php

namespace App\Http\Controllers;

use App\Like;
use Illuminate\Http\Request;
use App\Http\Resources\Like as LikeResource;
use App\Photo;

class LikeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function index($id)
    {
        $photo = Photo::find($id);

        return LikeResource::collection($photo->likes);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return LikeResource
     */
    public function store(Request $request)
    {
        $like = Like::where([['photo_id', '=', $request->photo_id], ['user_id', '=', $request->user()->id]])->first();
        if ($like === null) {
            $like = new Like;
            $like->photo_id = $request->photo_id;
            $like->user_id = $request->user()->id;

            $like->save();
            return new LikeResource($like);
        }
        return null;
    }

    /**
     * Display the specified resource.
     *
     * @param Request $request
     * @param $photo_id
     * @return LikeResource
     */
    public function show(Request $request, $photo_id)
    {
        $like = Like::where([['photo_id' , "=", (int)$photo_id], ['user_id', '=', $request->user()->id]])->first();
        if ($like !== null) {
            return new LikeResource($like);
        }

        return response()->json(['data' => false]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  $request
     * @return LikeResource
     */
    public function destroy(Request $request)
    {
        $like = Like::where([['photo_id', '=', $request->photo_id], ['user_id',  '=', $request->user()->id]])->first();

        if ($like !== null) {
            $like->delete();

            return new LikeResource($like);
        }

        return response()->json(['data' => false]);
    }
}
