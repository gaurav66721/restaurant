<?php


namespace App\Controller\Admin;


use App\Entity\Menu;
use App\Form\MenuFormType;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MenuController extends AbstractController
{
    #[Route('/admin/menu', name: 'admin_menu')]
    public function index(Request $request,PaginatorInterface $paginator,EntityManagerInterface $em): Response
    {
        $dql = "SELECT m FROM App\Entity\Menu m ORDER BY m.id DESC";
        $pages = $em->createQuery($dql);
        $pagination = $paginator->paginate(
            $pages,
            $request->query->getInt('page',1),
            5
        );
        return $this->render('admin/menu/index.html.twig',compact('pagination'));
    }
    //create function to add menu
    #[Route('/admin/menu/add', name: 'admin_menu_add')]
    public function add(Request $request,EntityManagerInterface $em): RedirectResponse|Response
    {
        //add menu form from MenuFormType
        $menu = new Menu();
        $form=$this->createForm(MenuFormType::class,$menu);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            //save form data to database
            $em->persist($menu);
            $em->flush();
            //set flash message
            $this->addFlash('success','Menu Added');
            //redirect to menu list
            return $this->redirectToRoute('admin_menu');
        }
        return $this->render('admin/menu/add.html.twig',['form'=>$form->createView()]);
    }
    //create function to edit menu
    #[Route('/admin/menu/edit/{id}', name: 'admin_menu_edit')]
    public function edit(Request $request,EntityManagerInterface $em,$id): RedirectResponse|Response
    {
        //get menu by id
        $menu = $em->getRepository(Menu::class)->find($id);
        //add menu form from MenuFormType
        $form=$this->createForm(MenuFormType::class,$menu);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            //save form data to database
            $em->persist($menu);
            $em->flush();
            //set flash message
            $this->addFlash('success','Menu Updated');
            //redirect to menu list
            return $this->redirectToRoute('admin_menu');
        }
        return $this->render('admin/menu/edit.html.twig',['form'=>$form->createView()]);
    }
    //create function to delete menu
    #[Route('/admin/menu/delete/{id}', name: 'admin_menu_delete')]
    public function delete(Menu $menu,EntityManagerInterface $em): RedirectResponse
    {
        //get menu by id
        //remove menu
        $em->remove($menu);
        $em->flush();
        //set flash message
        $this->addFlash('success','Menu Deleted');
        //redirect to menu list
        return $this->redirectToRoute('admin_menu');
    }
}