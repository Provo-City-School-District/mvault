<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

use App\Models\User;
use Mockery;
use Str;
use Socialite;

class LoginTest extends TestCase
{
    public function test_google_redirect()
    {
        $response = $this->get('/google/redirect');
        $response->assertStatus(302);
        $this->assertStringContainsString('accounts.google.com', $response->getTargetUrl());
    }
/*
    public function test_socialite()
    {
        $abstractUser = Mockery::mock('Laravel\Socialite\Two\User');         
        $abstractUser->shouldReceive('getId') 
            ->andReturn(1234567890)
            ->shouldReceive('email')
            ->andReturn(Str::random(10).'@provo.edu')
            ->shouldReceive('name')
            ->andReturn('Peter Brown');

        $provider = Mockery::mock('Laravel\Socialite\Contracts\Provider');
        $provider->shouldReceive('user')->andReturn($abstractUser);

        Socialite::shouldReceive('driver')->with('google')->andReturn($provider);

        $this->get(route("google.callback"))
            ->assertStatus(302)
            ->assertRedirectToRoute(route('profile'));
    }
*/
}
