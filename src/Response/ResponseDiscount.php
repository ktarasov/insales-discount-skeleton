<?php declare(strict_types=1);

namespace App\Response;

/**
 * Класс структуры ответа для внешней скидки.
 *
 * @author Константин Тарасов <kvt@peredelka-saitov.ru>
 * @copyright (C) 2025 Переделка-сайтов.РФ
 * @license GNU General Public License version 2 see LICENSE.md
 */
class ResponseDiscount implements \JsonSerializable
{
	public function __construct(
		protected float $discount = 0.0, // Сумма скидки
		protected string $discount_type = 'MONEY', // Тип скидки: PERCENT, MONEY
		protected string $title = 'Скидка по акции' // Заголовок для скидки
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
