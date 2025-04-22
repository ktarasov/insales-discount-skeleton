<?php

namespace App\Response;

/**
 * Объект ответа с ошибкой.
 *
 * @author Константин Тарасов <kvt@peredelka-saitov.ru>
 * @copyright (C) 2025 Переделка-сайтов.РФ
 * @license GNU General Public License version 2 see LICENSE.md
 */
class ResponseError implements \JsonSerializable
{
	protected array $errors = []; // Список ошибок

	/**
	 * Конcтруктор объект ответа с ошибкой
	 * @param string|null $error_msg - сообщение об ошибке/массив строк с ошибками
	 */
	public function __construct(?string $error_msg = null)
	{
		if ($error_msg) {
			$this->addError($error_msg);
		}
	}

	/**
	 * Добавление сообщения об ошибке, к уже имеющимся
	 *
	 * @param string|array $error_msg
	 *
	 * @return void
	 */
	public function addError($error_msg): void
	{
		if (is_array($error_msg)) {
			$this->errors = array_merge($this->errors, $error_msg);
		} elseif (is_string($error_msg)) {
			$this->errors[] = $error_msg;
		}
	}

	public function getErrors(): array
	{
		return $this->errors;
	}

	public function jsonSerialize(): mixed
	{
		return ['errors' => $this->errors];
	}
}