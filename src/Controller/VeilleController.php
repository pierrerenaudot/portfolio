<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\DBAL\Connection;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

class VeilleController extends AbstractController
{
    private $USERNAME = "pierre";
    private $PASSWORD = "pass";

    /**
     * @Route("/veille", name="app_veille")
     */
    public function index(SessionInterface $session): Response
    {
        if ($session->get('isConnected') != null && $session->get('isConnected') == true) {
            return $this->render('veille/index.html.twig', [
                'controller_name' => 'VeilleController',
            ]);
        } else {
            return $this->redirectToRoute('pageConnexion');
        }
    }

    /**
     * @Route("/enregistrer-veille", name="enregistrer_veille", methods={"POST"})
     */
    public function enregistrerVeille(Request $request, Connection $connection): Response
    {
        // Récupérer les données du formulaire
        $nom = $request->request->get('nom');
        $url = $request->request->get('url');
        $tag = $request->request->get('tag');
        $dateAjout = $request->request->get('date_ajout');
        $dateMaj = $request->request->get('date_maj');
        $commentaire = $request->request->get('commentaire');

        // Préparer la requête SQL
        $sql = "INSERT INTO veille (nom, url, tag, date_ajout, date_maj, commentaire) VALUES (?, ?, ?, ?, ?, ?)";
        $stmt = $connection->prepare($sql);

        // Exécuter la requête SQL
        $stmt->execute([$nom, $url, $tag, $dateAjout, $dateMaj, $commentaire]);

        // Rediriger ou retourner une réponse appropriée
        return new Response('Veille enregistrée avec succès!');
    }

    public function pageConnexion(SessionInterface $session): Response
    {
        if ($session->get('isConnected') != null && $session->get('isConnected') == true) {
            return $this->redirectToRoute('veille');
        } else {
            return $this->render('veille/connexion.html.twig');
        }
    }
    
    public function connexion(Request $request, SessionInterface $session): Response
    {
        $username = $request->request->get('username');
        $password = $request->request->get('password');

        if ($username == $this->USERNAME && $password == $this->PASSWORD) {
            $session->set('isConnected', true);
            return $this->redirectToRoute('veille');
        } else {
            return $this->redirectToRoute('pageConnexion');
        }
    }
}
