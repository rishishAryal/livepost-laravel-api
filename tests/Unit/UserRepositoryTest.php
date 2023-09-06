<?php

namespace Tests\Unit;

use App\Exceptions\GeneralJsonException;
use App\Models\User;
use App\Repositories\UserRepository;
use Tests\TestCase;

class UserRepositoryTest extends TestCase
{
    /**
     * A basic unit test example.
     */
    public function test_create(){
        $repository = $this->app->make(UserRepository::class);
        $payload = [
            'name'=>"Rishish Aryal",
            'email'=>'risharyal5@gmail.com',
            'password'=>'12345678'
        ];
        $result =$repository->create($payload);
        $this->assertSame($payload['name'],$result->name,'Created User doesnot have same name');

    }
    public function test_update(){
    $repository = $this->app->make(UserRepository::class);
    $dummyUser = User::factory(1)->create()[0];
    $payload = [
        'name'=>'Rish'
    ];
    $updated = $repository->update($dummyUser,$payload);
    $this->assertSame($payload['name'],$updated->name,'Updated name is not same');
    }

    public function test_delete_will_throw_exception_when_delete_user_that_doesnt_exist()
    {
        // env
        $repository = $this->app->make(UserRepository::class);
        $dummy = User::factory(1)->make()->first();

        $this->expectException(GeneralJsonException::class);
        $deleted = $repository->forceDelete($dummy);
    }
    public function test_delete(){
        $repository = $this->app->make(UserRepository::class);
        $dummyUser = User::factory(1)->create()[0];
        $deleted = $repository->forceDelete($dummyUser);
        $found = User::query()->find($dummyUser->id);
        $this->assertSame(null,$found,'User is not deleted');


    }
}
