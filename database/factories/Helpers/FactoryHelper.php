<?php

namespace Database\Factories\Helpers;

use App\Models\Post;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class FactoryHelper
{
    /**
     * This function will get a random model id from the database
     * @param string  |  HasFactory $model
     * @return int
     */
    public static function getRandomModelId(string $model){
    $count = $model::query()->count();

    if($count===0){
        return $model::factory()->create();
    }
    else {
        return rand(1,$count);
    }
}
}
