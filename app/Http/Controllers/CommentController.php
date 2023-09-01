<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        $comments = Comment::query()->get();

        return new JsonResponse([
            'data' => $comments,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function store(Request $request): JsonResponse
    {
        $created = Comment::query()->create([
            'title' => $request->title,
            'body' => $request->body,
        ]);

        return new JsonResponse([
            'data' => $created,
        ]);

    }

    /**
     * Display the specified resource.
     *
     * @param Comment $comment
     * @return JsonResponse
     */
    public function show(Comment $comment): JsonResponse
    {
        return new JsonResponse([
            'data' => $comment,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param Comment $comment
     * @return JsonResponse
     */
    public function update(Request $request, Comment $comment): JsonResponse
    {
        $updated = $comment->update([
            'title' => $request->title ?? $comment->title,
            'body' => $request->body ?? $comment->body,
        ]);

        if(!$updated){
            return new JsonResponse([
                'error' => 'Failed to update resource.'
            ]);
        }

        return new JsonResponse([
            'data' => $comment
        ]);
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
