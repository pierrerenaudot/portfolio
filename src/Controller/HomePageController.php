<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\DBAL\Connection;

class HomePageController extends AbstractController
{
    /**
     * @Route("/home/page", name="app_home_page")
     */
    public function index(): Response
    {
        return $this->render('homepage.html.twig', [
            "page" => "test",
        ]);
    }

    /**
     * Section affichage portfolio
     */
    public function section_portfolio(Connection $connection): Response
    {
        // Exécuter une requête de sélection brute
        $query = 'SELECT * FROM portfolio';
        $result = $connection->executeQuery($query);

        // Traiter les résultats de la requête
        $rows = $result->fetchAllAssociative();


        // Effectuer la requête pour récupérer tous les enregistrements
        $portfolios = $rows;
        return $this->render('section/portfolioSection.html.twig', [
            'data' => $portfolios
        ]);
    }

    /**
     * Section veille informatique
     */
    public function section_veille(): Response
    {
        return $this->render('section/veilleSection.html.twig', []);
    }

    /**
     * Section Contact Me
     */
    public function section_contact(): Response
    {
        return $this->render('section/contactSection.html.twig', []);
    }

}
