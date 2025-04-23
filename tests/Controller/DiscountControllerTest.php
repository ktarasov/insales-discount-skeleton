<?php

namespace App\Tests\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

final class DiscountControllerTest extends WebTestCase
{
    public function testDiscount(): void
    {
        $client = static::createClient();
        $client->request(
            Request::METHOD_POST,
            '/discount',
            content: json_encode([
                'order_lines' => [
                    [
                        "sale_price" => 100.00,
                        "id" => 1
                    ],
                    [
                        "sale_price" => 10.00,
                        "id" => 2
                    ]
                ]
            ])
        );

        self::assertResponseIsSuccessful();
    }

    public function testInvalidRequestDiscount(): void
    {
        $client = static::createClient();
        $client->request(
            Request::METHOD_POST,
            '/discount',
        );

        self::assertResponseStatusCodeSame(Response::HTTP_BAD_REQUEST);
    }

    public function testInvalidOrderObject(): void
    {
        $client = static::createClient();
        $client->request(
            Request::METHOD_POST,
            '/discount',
            content: '[]'
        );

        self::assertResponseStatusCodeSame(Response::HTTP_BAD_REQUEST);
    }
}
