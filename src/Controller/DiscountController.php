<?php

namespace App\Controller;

use App\Handler\DiscountHandler;
use App\Response\ResponseDiscount;
use App\Response\ResponseError;
use Fig\Http\Message\StatusCodeInterface;
use Psr\Log\LoggerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;

/**
 * Контроллер внешней скидки InSales.
 *
 * @author Константин Тарасов <kvt@peredelka-saitov.ru>
 * @copyright (C) 2025 Переделка-сайтов.РФ
 * @license GNU General Public License version 2 see LICENSE.md
 */
final class DiscountController extends AbstractController
{
    /**
     * Обработчик запроса внешней скидки
     *
     * @param \Symfony\Component\HttpFoundation\Request $request
     * @param \App\Handler\DiscountHandler $handler
     * @param \Psr\Log\LoggerInterface $logger
     *
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     */
    #[Route('/discount', name: 'app_discount', methods: 'POST')]
    public function discount(
        Request $request,
        DiscountHandler $handler,
        LoggerInterface $logger
    ): JsonResponse {
        $order = json_decode($request->getContent());

        // Проверяем, что запрос корректный и содержит данные в формате JSON
        if (json_last_error() !== JSON_ERROR_NONE) {
            $error = json_last_error_msg();
            return $this->json(
                new ResponseError($error),
                StatusCodeInterface::STATUS_BAD_REQUEST
            );
        }

        // Проверяем, что запрос содержит данные заказа
        if (empty($order) || empty($order->order_lines)) {
            return $this->json(
                new ResponseError('Неправильный запрос'),
                StatusCodeInterface::STATUS_BAD_REQUEST
            );
        }

        // Сохраняем запрос в логе
        $logger->info('Discount Request body', [$order]);

        // Обрабатываем запрос и формируем ответ
        $isDiscountRound = $this->getParameter('app.discount_round');
        $responseBody = new ResponseDiscount(
            $handler($order, $isDiscountRound),
            $this->getParameter('app.discount_type'),
            $this->getParameter('app.discount_title')
        );

        // Сохраняем ответ в логе
        $logger->info('Discount Response body', [$responseBody]);
        return $this->json($responseBody);
    }

    /**
     * Обработчик тестового запроса внешней скидки
     *
     * Запрос к этому URL помогает проверить данные пришедшие во внешнюю скидку из InSales.
     * Запрос сохраняется в лог.
     *
     * @param \Symfony\Component\HttpFoundation\Request $request
     * @param \Psr\Log\LoggerInterface $logger
     *
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     */
    #[Route('/test-discount', name: 'app_discount_test', methods: 'POST')]
    public function test(Request $request, LoggerInterface $logger): JsonResponse
    {
        $logger->info('test-discount request body', [
            json_decode($request->getContent()),
        ]);

        return $this->json(new ResponseDiscount(
            0,
            $this->getParameter('app.discount_type'),
            'ТЕСТ: ' . $this->getParameter('app.discount_title')
        ));
    }
}
