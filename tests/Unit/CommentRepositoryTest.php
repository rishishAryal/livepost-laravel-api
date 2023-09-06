<?php

namespace Tests\Unit;

use App\Exceptions\GeneralJsonException;
use App\Models\Comment;
use App\Repositories\CommentRepository;
use Tests\TestCase;


class CommentRepositoryTest extends TestCase
{
    /**
     * A basic unit test example.
     */
    public function test_create(){
        $repository = $this->app->make(CommentRepository::class);

        $payload = [
            'body'=>"Test Comment Body",
             'user_id'=>1,
             'post_id'=> 3
        ];

        $result =$repository->create($payload);

        $this->assertSame($payload['body'],$result->body,'Create Comment body is not same');


    }
    public function test_update(){
        $repository = $this->app->make(CommentRepository::class);
        $payload = [
            'body'=>"Test Comment Body"
        ];
        $dummyComment = Comment::factory(1)->create()[0];
        $updated =   $repository->update($dummyComment,$payload);
        $this->assertSame($payload['body'],$updated->body,'Update Comment body is not same');
    }
    public function test_delete_will_throw_exception_when_delete_comment_that_doesnt_exist()
    {
        // env
        $repository = $this->app->make(CommentRepository::class);
        $dummy = Comment::factory(1)->make()->first();

        $this->expectException(GeneralJsonException::class);
        $deleted = $repository->forceDelete($dummy);
    }

    public function test_delete(){
        $repository = $this->app->make(CommentRepository::class);
        $dummyComment = Comment::factory(1)->create()[0];
        $deleted = $repository->forceDelete($dummyComment);
        $found = Comment::query()->find($dummyComment->id);
        $this->assertSame(null,$found,'Comment is not deleted');
    }
}
