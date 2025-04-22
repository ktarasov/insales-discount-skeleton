<?php

namespace App\Tests\Handler;

use App\Handler\DiscountHandler;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class DiscountHandlerTest extends KernelTestCase
{
    private object $order;
    private DiscountHandler $handler;

    protected function setUp(): void
    {
        $this->order = (object)[
            'order_lines' => [
                (object)[
                    'sale_price' => 100.00,
                    'id' => 1
                ],
                (object)[
                    'sale_price' => 0.00,
                    'id' => 2
                ],
                (object)[
                    'sale_price' => 10.40,
                    'id' => 3
                ]
            ]
        ];

        self::bootKernel();
        $this->handler = self::getContainer()->get(DiscountHandler::class);
    }

    public function testDiscount(): void
    {
        $discount = ($this->handler)($this->order);
        $this->assertSame(10.40, $discount);
    }

    public function testDiscountRounded(): void
    {
        $discount = ($this->handler)($this->order, true);
        $this->assertSame(10.00, $discount);
    }

    public function testDiscountEmptyOrder(): void
    {
        $discount = ($this->handler)((object)[]);
        $this->assertSame(0.0, $discount);
    }

    public function testDiscountEmptyOrderLines(): void
    {
        $discount = ($this->handler)((object)[
            'order_lines' => []
        ]);

        $this->assertSame(0.0, $discount);
    }

}
