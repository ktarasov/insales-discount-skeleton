<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class IndexController extends AbstractController
{
    #[Route('/', name: 'app_index')]
    public function __invoke(): Response
    {
        return $this->render('index.html.twig', [
            'page_title' => 'Внешняя скидка InSales',
        ]);
    }
}
