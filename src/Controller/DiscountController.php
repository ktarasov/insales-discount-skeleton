<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Attribute\Route;

final class DiscountController extends AbstractController
{
    #[Route('/discount', name: 'app_discount', methods: 'POST')]
    public function index(): JsonResponse
    {
        $discountTitle = $this->getParameter('app.discount_title');
        $discountType = $this->getParameter('app.discount_type');

        return $this->json([
            'message' => 'Welcome to your new controller!',
            'path' => 'src/Controller/DiscountController.php',
            'discount' => $discountTitle,
            'type' => $discountType,
        ]);
    }

    #[Route('/test-discount', name: 'app_discount_test', methods: 'POST')]
    public function test(): JsonResponse
    {
        return $this->json([
            'message' => 'Welcome to test discount!',
            'path' => 'src/Controller/DiscountController.php',
        ]);
    }
}
