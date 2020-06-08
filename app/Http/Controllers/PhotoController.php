<?php

namespace App\Http\Controllers;

use App\Photo;
use App\Http\Resources\Photo as PhotoResource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;


class PhotoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function index()
    {
        return PhotoResource::collection(Photo::all());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'photo' => 'required|:jpeg,jpg,png'
        ]);

        $name = Storage::disk('local')->put('/', $request->photo);

        $photo = new Photo;
        $photo->name = $name;
        $photo->description = $request->description;
        $photo->user_id = $request->user()->id;

        $photo->save();


        return response()->json(['message' => 'Photo successfully uploaded', 'uploaded_photo' => new PhotoResource($photo)]);
    }
}
