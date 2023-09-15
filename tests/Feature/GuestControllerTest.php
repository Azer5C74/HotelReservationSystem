<?php

namespace Tests\Feature;

use App\Models\Guest;
use Database\Factories\GuestFactory;
use Tests\TestCase;

class GuestControllerTest extends TestCase
{
    /**
     * @return void
     */
    public function testStore()
    {
        $data = (new GuestFactory())->definition();

        $response = $this->json('POST', '/api/guests', $data);

        $response->assertStatus(201) // Expect a 201 (Created) status code.
            ->assertJson([
                'guest' => $data, // Expect the response to contain the posted data.
            ]);
    }

    /**
     * Test the index endpoint.
     *
     * @return void
     */
    public function testIndex()
    {
        $response = $this->get('/api/guests');

        $response->assertStatus(200);
    }

    /**
     * @return void
     */
    public function testUpdate()
    {
        // Assuming you have a guest with ID 1 in your database.
        $updatedData = [
            'first_name' => 'UpdatedFirstName',
            'last_name' => 'UpdatedLastName',
            'email' => 'updated@example.com',
        ];

        $response = $this->json('PUT', '/api/guests/1', $updatedData);

        $response->assertStatus(200) // Expect a 200 (OK) status code.
            ->assertJson(['guest' => $updatedData]); // Expect the response to match the updated data.
    }

    /**
     * @return void
     */
    public function testDestroy()
    {
        $response = $this->json('DELETE', '/api/guests/1');

        $response->assertStatus(204); // Expect a 204 (No Content) status code.
        $this->assertDatabaseMissing('guests', ['id' => 1]); // Ensure the guest is deleted from the database.
    }
}
