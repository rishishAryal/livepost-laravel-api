<?php

namespace App\Http\Controllers;


use App\Http\Resources\PostResource;
use App\Models\Post;

use App\Repositories\PostRepository;
use Illuminate\Http\JsonResponse;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): \Illuminate\Http\Resources\Json\AnonymousResourceCollection
    {
        $pageSize = $request->page_size?? 20;
        $posts = Post::query()->paginate($pageSize);

        return PostResource::collection($posts);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, PostRepository $repository): PostResource
    {

        $created = $repository->create([
            'title'=>$request->title,
            'body'=>$request->body,
            'user_ids'=>$request->user_ids

        ]);

        return new PostResource($created);
    }

    /**
     * Display the specified resource.
     */
    public function show(Post $post): PostResource
    {
        return new PostResource($post);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Post $post , PostRepository $repository): PostResource|JsonResponse
    {
//        $post->update($request->only(['title', 'body']));

        $post = $repository->update($post,[
           'title'=>$request->title ?? $post->title,
           'body'=>$request->body ?? $post->body,

        ]);


        return new PostResource($post);

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Post $post, PostRepository $repository): JsonResponse
    {
        $deleted = $repository->forceDelete($post);


        return new JsonResponse([
            'data' => 'success'
        ]);
    }
}
