<?php

namespace Tests\Feature;

use App\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class DonorTest extends TestCase
{
    use DatabaseMigrations;

    public function setUp():void
    {
        parent::setUp();
        $this->withoutExceptionHandling();
    }
    public function test_Can_Register_User()
    {
       $data=[
           'name'=>'John Mark',
           'email'=>'jhn@yahoo.com',
           'blood_group'=>'B',
           'phone'=>'0723444555',
           'lat'=>-1.2680573,
           'lng'=>36.80115,
           'available'=>1
       ];


       $this->post('api/register/donor', $data)
            ->assertStatus(200)
            ->assertJson(['success'=>true]);
    }
    public function test_can_donate_blood()
    {
        factory(User::class)->create(['available'=>0]);
        $data =['lat'=>-1.2680573,'lng'=>36.80115,'user_id'=>1];
        //$this->withoutExceptionHandling();
        $this->post('api/donate/blood',$data)
             ->assertStatus(200);
        $this->assertDatabaseHas('users',['available'=>1,'id'=>1]);
    }
    public function test_can_get_nearby_donors()
    {
      factory(User::class)->create(['lat'=>-1.2680573,'lng'=>36.80115]);
      factory(User::class)->create(['lat'=>-1.2680573,'lng'=>36.80115]);
      factory(User::class)->create(['lat'=>-0.6938822,'lng'=>36.3995825]);
      //$this->withoutExceptionHandling();
      $data =['lat'=>-1.2680573,'lng'=>36.80115,'user_id'=>1];
      $this->post('api/get/donors',$data)
           ->assertStatus(200)
           ->assertJson(['success'=>true]);
    }
    public function test_can_mark_user_as_deregister()
    {
        factory(User::class)->create(['lat'=>-1.2680573,'lng'=>36.80115]);
        $data =['user_id'=>1];
        //$this->withoutExceptionHandling();
        $this->post('api/unavailable/donor', $data)
             ->assertStatus(200);
        $this->assertDatabaseHas('users',['available'=>0,'id'=>1]);
    }
}
