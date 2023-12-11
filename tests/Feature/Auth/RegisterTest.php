<?php

namespace Tests\Feature\Auth;

use App\Models\User;
use Tests\TestCase;
use Illuminate\Support\Facades\Hash;

class RegisterTest extends TestCase
{
    public function testRegister(): void
    {

        $this->post('api/register', [
            'name' => 'test',
            'email' => 'test1@test.loc',
            'password' => Hash::make('secret'),
        ])
            ->assertOk()
            ->assertJsonStructure([
                'token'
            ]);
    }
}
