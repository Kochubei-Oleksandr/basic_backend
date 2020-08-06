<?php

namespace Tests\Feature;

class UserTest extends BaseUserTest
{

    /**
     * all user tests by correct token
     * @test
     * @return void
     */
    public function allUserTestsByCorrectToken()
    {
        $this->setUserToken();
        $this->setUserId();

        $this->getUserInfoAfterRegister();
        $this->updateUserInfo();

        $this->deleteUser();
    }

    /**
     * Get user info
     * PARAMS: null
     * @return void
     */
    public function getUserInfoAfterRegister()
    {
        $response = $this->withHeaders([
            'Authorization' => 'Bearer '.$this->userToken,
        ])->getJson('/user');

        $response->assertStatus(200)->assertJsonStructure([
            'id',
            'name',
            'email',
            'usage_policy',
            'created_at',
            'updated_at',
        ]);
    }

    /**
     * update user info when user updated all data
     * PARAMS: $data
     * @return void
     */
    public function updateUserInfo()
    {
        $data = [
            'name' => 'Alex',
            'email' => $this->email,
            'language_id' => 2,
        ];

        $response = $this->withHeaders([
            'Authorization' => 'Bearer '.$this->userToken,
        ])->putJson('/user/'.$this->userId, $data);

        $response->assertStatus(200)->assertJsonFragment($data);
    }
}
