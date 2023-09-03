<?php

namespace App\Repositories;

use App\Exceptions\GeneralJsonException;
use App\Models\Post;
use Illuminate\Support\Facades\DB;

class PostRepository extends BaseRepository
{
    public function create(array $attributes)
    {
        return DB::transaction(function () use ($attributes) {

            $created = Post::query()->create([
                'title' => data_get($attributes, 'title', 'Untitled'),
                'body' => data_get($attributes, 'body'),
            ]);
//            if (!$created){
//                throw  new GeneralJsonException('Failed to Create a post');
//            }
            throw_if(!$created,GeneralJsonException::class,'Failed to Create a post');
            if($userIds = data_get($attributes, 'user_ids')){

                $created->users()->sync($userIds);
            }
            return $created;
        });
    }

public function update( $post, array $attributes){
       return DB::transaction(function () use($post, $attributes){
       $updated = $post->update([
            'title' => data_get($attributes,'title','untitled'),
            'body' => data_get($attributes,'body',[]),
        ]);

           throw_if(!$updated,GeneralJsonException::class,'Failed to Update a post');

           if($userIds = data_get($attributes,'user_ids')){
              $post->users()->sync($userIds);
        }
             return $post;
        });

}
public function forceDelete( $post )
{
    return DB::transaction(function () use ($post){
        $deleted = $post->forceDelete();
        throw_if(!$deleted,GeneralJsonException::class,'Failed to Delete a post');

        return $deleted;
    });

}
}
