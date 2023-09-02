<?php

namespace App\Http\Controllers;

use App\Http\Resources\CommentResource;
use App\Models\Comment;
use App\Models\Post;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function index(): \Illuminate\Http\Resources\Json\AnonymousResourceCollection
    {
        $comments = Comment::query()->get();

        return  CommentResource::Collection($comments);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return CommentResource
     */
    public function store(Request $request): CommentResource
    {

        $created = Comment::query()->create([

            'body' => $request->body,
            'user_id'=>User::all()->random()->id,
            'post_id'=>Post::all()->random()->id
        ]);

        return new CommentResource($created);
    }

    /**
     * Display the specified resource.
     *
     * @param Comment $comment
     * @return CommentResource
     */
    public function show(Comment $comment): CommentResource
    {
        return new CommentResource($comment);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param Comment $comment
     * @return JsonResponse
     */
    public function update(Request $request, Comment $comment): JsonResponse | CommentResource
    {
        $updated = $comment->update([

            'body' => $request->body ?? $comment->body,
        ]);

        if(!$updated){
            return new JsonResponse([
                'error' => 'Failed to update resource.'
            ]);
        }

        return new CommentResource($updated);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Comment $comment
     * @return JsonResponse
     */
    public function destroy(Comment $comment): JsonResponse
    {
        $deleted = $comment->forceDelete();

        if(!$deleted){
            return new JsonResponse([
                'error' => 'Failed to delete resource.'
            ]);
        }
        return new JsonResponse([
            'data' => 'success',
        ]);
    }
}
