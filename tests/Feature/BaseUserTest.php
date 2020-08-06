<?php

namespace Tests\Feature;

use App\Models\MakeOrder\DishesInOrder;
use App\Models\MakeOrder\FoodDeliveryOrder;
use App\Models\User;
use Tests\TestCase;

class BaseUserTest extends TestCase
{
    protected string $userToken = '';
    protected ?int $userId = null;
    protected string $email = 'test333@test.test';
    protected string $password = '88888888';

    /**
     * User registration
     */
    public function registration()
    {
        return $this->postJson('/register', [
            'email' => $this->email,
            'password' => $this->password,
            'password_confirmation' => $this->password,
            'usage_policy' => true,
        ]);
    }

    /**
     * set User token
     * @return void
     */
    public function setUserToken() {
        $responseData = $this->registration()->json();
        if (array_key_exists('token', $responseData)) {
            $this->userToken = $responseData['token'];
        }
    }

    /**
     * set User id
     * PARAMS: null
     * @return void
     */
    public function setUserId() {
        $responseData = $this->withHeaders([
            'Authorization' => 'Bearer '.$this->userToken,
        ])->getJson('/user')->json();
        if (array_key_exists('id', $responseData)) {
            $this->userId = $responseData['id'];
        }
    }

    /**
     * delete user
     * PARAMS: null
     * @test
     */
    public function deleteUser()
    {
        $user = User::where('email', $this->email)->first();
        if ($user) {
            $user->delete();
        }

        return $this->assertDatabaseMissing('users', [
            'email' => $this->email,
        ]);
    }
}
