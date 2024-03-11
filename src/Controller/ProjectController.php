<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\DBAL\Connection;
use Symfony\Component\Finder\Finder;

class ProjectController extends AbstractController
{
    /**
     * @Route("/project", name="app_project")
     */
    public function index(Connection $connection): Response
    {
        $id = $_REQUEST['id'];

        $query = 'SELECT * FROM portfolio WHERE id = ?';
        $result = $connection->executeQuery($query, [$id]);
        $rows = $result->fetchAssociative();

        // Chemin du répertoir d'image
        $directoryPath = $this->getParameter('kernel.project_dir') . '\public\img/' . $rows['imgDir'];
        // Créer une instance de Finder
        $finder = new Finder();
        // Lister les fichiers dans le répertoire spécifié
        $pathImg = $finder->files()->in($directoryPath);
        $listImg = [];
        foreach ($pathImg as $img) {
            $listImg[] = 'img/' . $rows['imgDir'] . $img->getRelativePathname();
        }

        return $this->render('project/project.html.twig', [
            'controller_name' => 'test',
            'project' => $rows,
            'listImg' => $listImg,
        ]);
    }
}
