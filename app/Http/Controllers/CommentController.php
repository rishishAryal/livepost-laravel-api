<?php

namespace App\Http\Controllers;

use App\Http\Resources\CommentResource;
use App\Models\Comment;
use App\Models\Post;
use App\Models\User;
use App\Repositories\CommentRepository;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class CommentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return AnonymousResourceCollection
     */
    public function index(Request $request): \Illuminate\Http\Resources\Json\AnonymousResourceCollection
    {
        $pageSize = $request->page_size?? 20;
        $comments = Comment::query()->paginate($pageSize);

        return  CommentResource::Collection($comments);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @param CommentRepository $repository
     * @return CommentResource
     */
    public function store(Request $request,CommentRepository $repository): CommentResource
    {

        $created = $repository->create([
            'body'=>$request->body,
            'user_id'=>$request->user_id,
            'post_id'=>$request->post_id
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
    public function update(Request $request, Comment $comment, CommentRepository $repository): JsonResponse | CommentResource
    {
      $comment=$repository->update($comment,[
          'body'=>$request->body
      ]);


        return new CommentResource($comment);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Comment $comment
     * @return JsonResponse
     */
    public function destroy(Comment $comment,CommentRepository $repository): JsonResponse
    {
      $deleted =  $repository->forceDelete($comment);


        return new JsonResponse([
            'data' => 'success',
        ]);
    }
}
