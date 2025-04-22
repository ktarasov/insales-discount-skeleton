<?php

namespace App\Handler;

use Psr\Log\LoggerInterface;

/**
 * Обработчик внешней скидки InSales, который рассчитывает размер скидки.
 *
 * @author Константин Тарасов <kvt@peredelka-saitov.ru>
 * @copyright (C) 2025 Переделка-сайтов.РФ
 * @license GNU General Public License version 2 see LICENSE.md
 */
class DiscountHandler
{
	public function __construct(
		protected LoggerInterface $logger
	) {}

	/**
	 * Метод, который рассчитывает размер скидки, в зависимости от условий бизнес логики.
	 *
	 * @param object $data данные, полученные из InSales
	 * @param bool $isRound параметр, определяющий нужно ли округлять скидку до целого числа
	 *
	 * @return float сумма скидки
	 */
	public function __invoke(object $data, bool $isRound = false): float
	{
		if (empty($data->order_lines)) {
			return $isRound ? 0 : 0.0;
		}

		$discountSumList = [];
		foreach ($data->order_lines as $line) {
			if ($line->sale_price == 0) {
				continue;
			}
			$discountSumList[] = $line->sale_price;
		}

		$discountSum = min($discountSumList);
		if ($isRound) {
			$discountSum = round($discountSum);
		}

		return $discountSum;
	}
}