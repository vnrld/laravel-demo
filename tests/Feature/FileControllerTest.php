<?php

declare(strict_types=1);

namespace Tests\Feature;

use Faker\Factory;
use Faker\Generator;
use Px\Framework\Http\Responder\Response;
use Tests\TestCase;

class FileControllerTest extends TestCase
{
    private Generator $faker;

    public function setUp(): void
    {
        parent::setUp(); // TODO: Change the autogenerated stub
        $this->faker = Factory::create();
    }

    public function testCreateFileWithWrongApiCredentials(): void
    {
        $response = $this->postJson('fs/file/create', $this->dataProvider('test'));

        $response->assertStatus(Response::HTTP_FORBIDDEN);
        $response->assertJsonFragment(['success' => false]);
    }

    public function testCreateFileWithApiCredentials(): void
    {
        $response = $this->postJson('fs/file/create', $this->dataProvider());

        $response->assertStatus(Response::HTTP_OK);
        $response->assertJsonFragment(['success' => true, 'is_created' => true]);
    }

    private function dataProvider(string $login = 'demo'): array
    {
        return [
            'client_id' => $login,
            'client_secret' => $login,
            'disk' => 'demo-local',
            'file_name' => 'test.' . date('Y-m-d-H-i-s') . '.txt',
            'save_path' => 'phpunit',
            'contents' => $this->faker->sentences(10, true)
        ];
    }
}
