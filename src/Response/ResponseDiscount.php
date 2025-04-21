<?php declare(strict_types=1);

namespace App\Response;

class ResponseDiscount implements \JsonSerializable
{
	public function __construct(
		protected float $discount = 0.0,
		protected string $discount_type = 'MONEY',
		protected string $title = 'Скидка по акции'
	) {}

	public function getDiscount(): float
	{
		return $this->discount;
	}

	public function getDiscountType(): string
	{
		return $this->discount_type;
	}

	public function getTitle(): string
	{
		return $this->title;
	}

	public function jsonSerialize(): mixed
	{
		return [
			'discount' => $this->discount,
			'discount_type' => $this->discount_type,
			'title' => $this->title
		];
	}
}
