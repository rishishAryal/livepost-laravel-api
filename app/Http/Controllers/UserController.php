<?php

namespace App\Http\Controllers;

use App\Events\Models\User\UserCreated;
use App\Http\Resources\UserResource;
use App\Models\User;
use App\Repositories\UserRepository;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return AnonymousResourceCollection
     */
    public function index(Request $request): \Illuminate\Http\Resources\Json\AnonymousResourceCollection
    {
        event(new UserCreated( User::factory( )->make()));
        $pageSize = $request->page_size?? 20;
        $users = User::query()->paginate($pageSize);

        return UserResource::collection($users);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @param UserRepository $repository
     * @return UserResource
     */
    public function store(Request $request,UserRepository $repository): UserResource
    {
    $created= $repository->create([
        'name'=>$request->name,
        'email'=>$request->email,
        'password'=>$request->password
    ]);

        return new UserResource($created);
    }

    /**
     * Display the specified resource.
     *
     * @param User $user
     * @return UserResource
     */
    public function show(User $user): UserResource
    {
        return new UserResource($user);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param User $user
     * @param UserRepository $repository
     * @return JsonResponse|UserResource
     */
    public function update(Request $request, User $user,UserRepository $repository): JsonResponse | UserResource
    {

        $user =$repository->update($user,[
            'name'=> $request->name ?? $user->name,
            'email'=>$request->email ?? $user->email,
            'password'=>$request->password ?? $user->password

        ]);


        return new UserResource($user);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param User $user
     * @param UserRepository $repository
     * @return JsonResponse
     */
    public function destroy(User $user, UserRepository $repository): JsonResponse
    {
       $deleted=$repository->forceDelete($user);

        return new JsonResponse([
            'data' => 'success',
        ]);
    }
}
