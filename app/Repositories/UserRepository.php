<?php

namespace App\Repositories;

use App\Models\User;
use Illuminate\Support\Facades\DB;

class UserRepository extends BaseRepository
{

    public function create(array $attributes)
    {
     return DB::transaction(function () use($attributes) {
         return User::query()->create([
             'name' => data_get($attributes,'name','noName'),
             'email' => data_get($attributes,'email',),
             'password' => data_get($attributes,'password','12345678'),
             'email_verified_at'=>now()
         ]);
     });


    }

    public function update($user, array $attributes)
    {
        return DB::transaction(function () use($user,$attributes){
            $updated = $user->update([
                'name' => data_get($attributes,'name' ),
                'email' => data_get($attributes,'email'),
                'password' => data_get($attributes,'password'),

            ]);
            if (!$updated){
                throw new \Exception('Failed to update post');
            }
            return $user;
        });

    }

    public function forceDelete($user)
    {
       return DB::transaction(function () use($user){
            $deleted = $user->forceDelete();
            if(!$deleted){
                throw  new \Exception('Cannot delete post');
            }
            return $deleted;
        });
    }
}
