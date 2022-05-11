<?php

namespace App\Tests\Integration\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class BookingControllerTest extends WebTestCase
{
    private $client;
    private $url;
    public function setUp(): void
    {
        // This calls KernelTestCase::bootKernel(), and creates a
        // "client" that is acting as the browser
        $this->client = static::createClient();
        $this->url = 'http://localhost:8001/spot/booking';
        parent::setUp();
    }

    public function testAddSpot()
    {
        $param = 'user_hash=test@gmail.com&reserve_spot=1';
        $result = $this->client->request('POST', $this->url . '?' . $param);
        self::assertNotNull($result);
    }

    public function testCreateInvalidUserHashSpot(): void
    {
        $param = 'user_hash=testgmail.com&reserve_spot=1';
        $this->client->request('POST', $this->url . '?' . $param);
        $this->assertResponseStatusCodeSame(404);
    }

    public function testCreateWithOutReserveSpot(): void
    {
        $param = 'user_hash=test@gmail.com';
        $this->client->request('POST', $this->url . '?' . $param);
        $this->assertResponseStatusCodeSame(404);
    }


    public function testRequestHasVaildUserData()
    {
        $result = $this->client->request('GET', $this->url . '/user?user_hash=test@gmail.com');
        self::assertNotNull($result);
        $response = $this->client->getResponse();
        $responseData = json_decode($response->getContent(), true);
        self::assertNotNull($responseData['total_bookings']);
    }

    public function testRequestHasInVaildUserData()
    {
        $this->client->request('GET', $this->url . '/user?user_hash=test12@gmail.com');
        $this->assertEquals(301, $this->client->getResponse()->getStatusCode());
    }
}
