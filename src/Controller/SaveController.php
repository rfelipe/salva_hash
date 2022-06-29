<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\Persistence\ManagerRegistry;
use App\Entity\SaveHash;

class SaveController extends AbstractController
{

    
    public function __construct(ManagerRegistry $registry)
    {
        $this->Save= $registry;
    }

    #[Route('/save', name: 'app_save')]
    public function index($product)
    {
        $entityManager = $this->Save->getManager();
        $entityManager->persist($product);
        $entityManager->flush();
        return '';
    }

    public function ip()
    {
        $this->server->get('REMOTE_ADDR');
    }
}