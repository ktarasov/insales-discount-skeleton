<?php

namespace App\Controller;

use App\DTO\ResponseDiscount;
use App\DTO\ResponseError;
use Fig\Http\Message\StatusCodeInterface;
use Psr\Log\LoggerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;

final class DiscountController extends AbstractController
{
    #[Route('/discount', name: 'app_discount', methods: 'POST')]
    public function discount(Request $request, LoggerInterface $logger): JsonResponse
    {
        $order = json_decode($request->getContent());
        if (json_last_error() !== JSON_ERROR_NONE) {
            $this->json(new ResponseError(
                'Некорректный запрос',
                StatusCodeInterface::STATUS_BAD_REQUEST
            ));
        }

        $logger->info('Discount Request body', [ $order ]);

        return $this->json(new ResponseDiscount(
            0,
            $this->getParameter('app.discount_type'),
            $this->getParameter('app.discount_title')
        ));
    }

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
