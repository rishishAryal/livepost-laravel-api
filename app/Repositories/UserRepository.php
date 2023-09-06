<?php

namespace App\Repositories;

use App\Events\Models\User\UserCreated;
use App\Events\Models\User\UserDeleted;
use App\Events\Models\User\UserUpdated;
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
         event(new UserCreated($created));
        return $created;
     });


    }

    public function update($user, array $attributes)
    {
        return DB::transaction(function () use($user,$attributes){
            $updated = $user->update([
                'name' => data_get($attributes,'name',$user->name ),
                'email' => data_get($attributes,'email',$user->email),
                'password' => data_get($attributes,'password',$user->password),

            ]);
            throw_if(!$updated,GeneralJsonException::class,'Failed to Update a post');
                event(new UserUpdated($user));
            return $user;
        });

    }

    public function forceDelete($user)
    {
       return DB::transaction(function () use($user){
            $deleted = $user->forceDelete();
           throw_if(!$deleted,GeneralJsonException::class,'Failed to Delete a post');
            event(new UserDeleted($user));
           return $deleted;
        });
    }
}
