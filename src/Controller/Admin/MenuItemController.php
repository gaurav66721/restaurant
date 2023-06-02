<?php


namespace App\Controller\Admin;


use App\Entity\MenuItem;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Form\MenuItemFormType;

class MenuItemController extends AbstractController
{
   //create a list function to show menu items
    #[Route('/admin/menu-item/', name: 'admin_menu_item')]
    public function index(Request $request,EntityManagerInterface $em,PaginatorInterface $paginator): Response
    {
        //get all menu items from MenuItem entity
        $dql = "SELECT m FROM App\Entity\MenuItem m ORDER BY m.id DESC";
        $pages = $em->createQuery($dql);
        //paginate menu items
        $pagination = $paginator->paginate(
            $pages,
            $request->query->getInt('page',1),
            5
        );
        return $this->render('admin/menu_item/index.html.twig',compact('pagination'));
    }
    //create function to add menu item
    #[Route('/admin/menu-item/add', name: 'admin_menu_item_add')]
    public function add(Request $request,EntityManagerInterface $em): Response
    {
        //create form to add menu item using MenuItemFormType
        $menuItem = new MenuItem();
        $form = $this->createForm(MenuItemFormType::class,$menuItem);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            //save form data to database
            $em->persist($menuItem);
            $em->flush();
            //set flash message
            $this->addFlash('success','Menu Item Added');
            //redirect to menu item list
            return $this->redirectToRoute('admin_menu_item');
        }

        return $this->render('admin/menu_item/add.html.twig',['form'=>$form->createView()]);
    }
    //create function to edit menu item
    #[Route('/admin/menu-item/edit/{id}', name: 'admin_menu_item_edit')]
    public function edit(MenuItem $menuItem,Request $request,EntityManagerInterface $em): Response
    {
        //create form to edit menu item using MenuItemFormType
        $form = $this->createForm(MenuItemFormType::class,$menuItem);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            //save form data to database
            $em->persist($menuItem);
            $em->flush();
            //set flash message
            $this->addFlash('success','Menu Item Updated');
            //redirect to menu item list
            return $this->redirectToRoute('admin_menu_item');
        }
        return $this->render('admin/menu_item/edit.html.twig',['form'=>$form->createView()]);
    }
    //create function to delete menu item
    #[Route('/admin/menu-item/delete/{id}', name: 'admin_menu_item_delete')]
    public function delete(MenuItem $menuItem,EntityManagerInterface $em): RedirectResponse
    {
        //delete menu item
        $em->remove($menuItem);
        $em->flush();
        //set flash message
        $this->addFlash('success','Menu Item Deleted');
        //redirect to menu item list
        return $this->redirectToRoute('admin_menu_item');
    }
}