<?php

namespace App\Http\Controllers;

use App\Like;
use App\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $post=Post::join("users","users.id","=","posts.user_id")
        ->select("posts.*","users.name as creator_user")
        ->get();
        $post->load("getResponses");
        $post->map(function($value){
            $value["likes"]=Like::where("post_id",$value->id)->count();

            $value["isLike"]=Like::
                wherePostId($value->id)
                ->whereUserId(Auth::user()->id)->count()==0?false:true;

           return $value;
        });
        return $post;
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
    public function store(Request $request)
    {
        // use Illuminate\Support\Facades\Validator;
        $validators=Validator::make($request->all(),
        [
            'title' => 'required|max:100',
            'content' => 'required',
            //'user_id'=>'required',
        ]);
        if($validators->fails())
            return response()->json($validators->messages(),200);

       $post=array(
           "title"=>$request->title,
           "content"=>$request->get("content"),
           "user_id"=>1
       );
        $post=Post::create($post);
        return $post;
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function show(Post $post)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function edit(Post $post)
    {
        //

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Post $post)
    {
        //
        $validators=Validator::make($request->all(),
            [
                'title' => 'required|max:100',
                'content' => 'required',
                //'user_id'=>'required',
            ]);
        if($validators->fails())
            return response()->json($validators->messages(),200);
        $post->update($request->all());
        return $post;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function destroy(Post $post)
    {
        //
            $post->delete();
            return response()->json(["message" => "Eliminado correctamente"], 200);
    }
}
