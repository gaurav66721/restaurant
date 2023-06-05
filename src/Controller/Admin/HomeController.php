<?php


namespace App\Controller\Admin;


use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    #[Route('/admin', name: 'admin_home')]
    public function index(EntityManagerInterface $em)
    {
        $dql = 'SELECT (select count(*) from pages) AS pages, (select count(*) from menu) AS menu, (select count(*) from menu_item) AS menu_item, (select count(*) from booking_table) AS booking_table, (select count(*) from booking_order) AS booking_order';
        $data= $em->getConnection()->executeQuery($dql)->fetchAllAssociative();
        return $this->render('admin/home/index.html.twig', [
            'data' => $data[0],
        ]);
    }
}