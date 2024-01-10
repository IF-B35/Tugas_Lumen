<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Auth;

class PostsController extends Controller
{
    public function index(Request $request)
    {
        if(Gate::denies('read-post')){
            return response()->json([
                'success' => false,
                'status' => 403,
                'message' => 'You are Unauthorized'
            ],403);
        }

        if(Auth::user()->role === 'admin'){
            $posts = Post::OrderBy("id","DESC")->paginate(2)->toArray();
        }else{
            $posts = Post::Where(['user_id' => Auth::user()->id])->OrderBy("id","DESC")->paginate(2)->toArray();
        }
        
        $response = [
            "total_count" => $posts["total"],
            "limit" => $posts["per_page"],
            "pagination" => [
                "next_page" => $posts["next_page_url"],
                "current_page" => $posts["current_page"]
            ],
            "data" => $posts["data"],
        ];

        return response()->json($response, 200);
    }

    public function store(Request $request)
    {
        $input = $request->all();
        $validationRules = [
            'title' => 'required|min:5',
            'content' => 'required|min:10',
            'status' => 'required|in: draft,published',
            'user_id' => 'required|numeric',
        ];

        $validator = Validator::make($input, $validationRules);

        if($validator->fails()){
            return response()->json($validator->errors(), 400);
        }

        $post = Post::create($input);
        return response()->json($post,200);
    }

    public function show(Request $request,$id)
    {

        $post = Post::find($id);

        if (!$post){
            abort(404);
        }
        return response()->json($post,200);
    }

    public function update(Request $request, $id)
    {
        $input =$request->all();

        $post = Post::find($id);

        if (!$post){
            abort(404);
        }

        if(Gate::denies('update-post', $post)){
            return response()->json([
                'success' => false,
                'status' => 403,
                'message' => 'You are Unauthorized'
            ],403);
        }

        $validationRules=[
            'title' => 'required|min:5',
            'content' => 'required|min:10',
            'status' => 'required|in:draft,published',
        ];

        $validator = Validator::make($input, $validationRules);

        if($validator->fails()){
            return response()->json($validator->errors(),400);
        }
        
        $post->fill($input);
        $post->save();

        return response()->json($post,200);
    }

    public function destroy(Request $request, $id)
    {
        $post = Post::find($id);

        if(!$post){
            abort(404);
        }

        $post->delete();
        $message = ['message' => 'Deleted successfully','post_id' => $id];

        return response()->json($message,200);
    }
    
}