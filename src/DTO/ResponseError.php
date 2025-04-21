<?php

namespace App\DTO;

use Fig\Http\Message\StatusCodeInterface;

class ResponseError implements \JsonSerializable
{
	protected array $errors = [];
	protected int $resultCode = StatusCodeInterface::STATUS_OK;

	/**
	 * Конcтруктор объект ответа с ошибкой
	 * @param string|null $error_msg - сообщение об ошибке/массив строк с ошибками
	 */
	public function __construct(?string $error_msg = null, $resultCode = StatusCodeInterface::STATUS_OK)
	{
		$this->resultCode = $resultCode;
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

	public function getResultCode(): int
	{
		return $this->resultCode;
	}

	public function jsonSerialize(): mixed
	{
		return ['errors' => $this->errors];
	}
}