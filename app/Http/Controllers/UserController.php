<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Resources\User as UserResource;
use App\User;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return UserResource
     */
    public function index($id)
    {
        return new UserResource(User::find($id));
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function follow(Request $request)
    {
        $user = User::find($request->user_id);
        $request->user()->followings()->attach($request->user_id);

        return response()->json(new UserResource($user));
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function getFollows(Request $request)
    {
        return response()->json(UserResource::collection($request->user()->follows));
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function getFollowings(Request $request)
    {
        return response()->json(UserResource::collection($request->user()->followings));
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function deleteFollowings(Request $request)
    {
        $user = User::find($request->user_id);
        $request->user()->followings()->detach($request->user_id);

        return response()->json(new UserResource($user));
    }
}
