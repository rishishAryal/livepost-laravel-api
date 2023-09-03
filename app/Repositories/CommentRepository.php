<?php

namespace App\Repositories;

use App\Models\Comment;
use App\Models\Post;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class CommentRepository extends BaseRepository
{

    public function create(array $attributes)
    {
        return DB::transaction(function () use ($attributes){
        return Comment::query()->create([

                'body' => data_get($attributes,'body'),
                'user_id'=>data_get($attributes,'user_id'),
                'post_id'=>data_get($attributes,'post_id')
            ]);

        });
    }

    public function update($comment, array $attributes)
    {
       return DB::transaction(function () use ($comment,$attributes){
           $updated = $comment->update([

               'body' => data_get($attributes,'body')
           ]);
           if (!$updated){
               throw new \Exception('Failed to update post');
           }
           return $comment;
       });
    }

    public function forceDelete($comment)
    {
        return DB::transaction(function () use($comment){
            $deleted = $comment->forceDelete();

            if (!$deleted){
                throw  new \Exception('Cant delete the comment');
            }
            return $deleted;
        });
    }
}
