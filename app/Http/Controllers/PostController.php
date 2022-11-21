<?php

namespace App\Http\Controllers;

use App\Http\Requests\PostStoreRequest;
use App\Models\Post;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Symfony\Component\HttpFoundation\Response;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
       
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(PostStoreRequest $request)
    {
        $inputs = $request->validated();
        if(!empty($inputs['image'])) {
            $inputs['image']->store('images', 'public');
            $inputs['image'] = $inputs['image']->hashName();
        }

        $post = auth()->user()->posts()->create($inputs);

        if(!empty($inputs['image'])) {
            $post['image'] = asset('storage/images/'.$post['image']);
        }
    
        return response()->json(['the post has been created', $post], Response::HTTP_CREATED);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $post = Post::all()->where('id', $id)->first();
        
        File::delete(public_path('storage/images/'.$post->image));
        
        $post = Post::where('id', $id)->delete();
        
        return response()->json('', Response::HTTP_NO_CONTENT);   
    }
}
