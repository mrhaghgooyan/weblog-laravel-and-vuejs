<?php

namespace Tests\Unit;

use PHPUnit\Framework\TestCase;

class CommentTest extends TestCase
{
    /**
     * A basic unit test example.
     *
     * @return void
     */
    public function test_store_comment(){
        $response = $this->post('api/comment',[
            'id'=>150,
            'parent_id'=>50,
            'name'=>'Farid HaghGooyan',
            'comment'=>'This is a Test',
            'created_at'=>'2022-03-03 22:19:46',
            'updated_at'=>null
        ]);
        $response->assertStatus(200);
    }
}
