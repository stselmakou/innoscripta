<?php

namespace Tests\Feature\Auth;

use App\Models\User;
use Tests\TestCase;
use Illuminate\Support\Facades\Hash;

class LoginTest extends TestCase
{
    public function testLogIn(): void
    {
        User::factory()->create([
            'email' => 'test@test.loc',
            'password' => Hash::make('secret'),
        ]);

        $this->post('api/login', [
            'email' => 'test@test.loc',
            'password' => 'secret',
        ])
            ->assertOk()
            ->assertJsonStructure([
                'token'
            ]);
    }
}
