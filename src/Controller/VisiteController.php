<?php

namespace App\Controller;

use App\Form\VisiteType;
use App\Service\WeatherService;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class VisiteController extends AbstractController
{
    #[Route('/visite', name: 'visite')]
    public function index(Request $request, WeatherService $weatherService): Response
    {
        $form = $this->createForm(VisiteType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $city = $form['ville']->getData();
            $weatherData = $weatherService->getWeatherData($city);
            return $this->render('visite/index.html.twig', [
                'visiteForm' => $form->createView(),
                'weatherData' => $weatherData
            ]);
        }
       
        return $this->render('visite/index.html.twig', [
            'visiteForm' => $form->createView()
        ]);
    }
}
