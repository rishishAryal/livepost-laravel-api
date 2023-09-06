<?php

namespace Tests\Unit;

use App\Models\Post;
use App\Repositories\PostRepository;
use Tests\TestCase;

class PostRepositoryTest extends TestCase
{
    /**
     * A basic unit test example.
     */
    public function test_create(){
        //Define the goal
        //1. test if create() will actually create a record in the DB

        //2. Replicate the env / restriction
        //instance of PostRepository
        $repository = $this->app->make(PostRepository::class);

        //3. Define the source of Truth
        $payload = [
          'title'=>'Test Title',
          'body'=>'Test Body'
        ];
         //4. Compare The result
        $result = $repository->create($payload);

        $this->assertSame($payload['title'],$result->title,'Post created does not have the same title');


    }
    public function test_update(){
        $repository = $this->app->make(PostRepository::class);
        $dummyPost = Post::factory(1)->create()[0];
        $payload = [
            'title'=>'updated title'
        ];
      $updated =   $repository->update($dummyPost,$payload);
        $this->assertSame($payload['title'],$updated->title,'updated post doesnt have the same title');

    }


    public function test_delete(){
        $repository =$this->app->make(PostRepository::class);
        $dummy = Post::factory(1)->create()->first();
        $deleted = $repository->forceDelete($dummy);
        $found = Post::query()->find($dummy->id);
        $this->assertSame(null,$found,'Post is not deleted');

    }

}
