<?php


namespace App\Controller;


use App\Entity\Services;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class TestController extends AbstractController
{
    #[Route('/test', name: 'test')]
   public function test(EntityManagerInterface $em)
    {
        $service=$em->getRepository(Services::class)->findAll();
        dd($service[1]->getGalleryImages()->toArray());
    }
}