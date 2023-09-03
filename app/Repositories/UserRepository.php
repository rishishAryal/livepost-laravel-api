<?php

namespace App\Repositories;

use App\Exceptions\GeneralJsonException;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class UserRepository extends BaseRepository
{

    public function create(array $attributes)
    {
     return DB::transaction(function () use($attributes) {
         $created = User::query()->create([
             'name' => data_get($attributes,'name','noName'),
             'email' => data_get($attributes,'email',),
             'password' => data_get($attributes,'password','12345678'),
             'email_verified_at'=>now()
         ]);
         throw_if(!$created,GeneralJsonException::class,'Failed to Create a User');

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
            throw_if(!$updated,GeneralJsonException::class,'Failed to Update a post');

            return $user;
        });

    }

    public function forceDelete($user)
    {
       return DB::transaction(function () use($user){
            $deleted = $user->forceDelete();
           throw_if(!$deleted,GeneralJsonException::class,'Failed to Delete a post');

           return $deleted;
        });
    }
}
