<?php


namespace App\Controller\Admin;


use App\Entity\Pages;
use App\Form\PageFormType;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\String\Slugger\SluggerInterface;

class PageController extends AbstractController
{
   // display page list with Page Entity
    #[Route(['/admin/page/list','/admin/page/'], name: 'admin_page_list')]
    public function index(EntityManagerInterface $em,PaginatorInterface $paginator,Request $request): Response
    {
        //get all pages
        $dql = "SELECT p FROM App\Entity\Pages p ORDER BY p.id DESC";
        $pages = $em->createQuery($dql);
        //create pagination
          $pagination = $paginator->paginate(
                $pages,
                $request->query->getInt('page',1),
                5
          );

         return $this->render('admin/page/index.html.twig',compact('pagination'));
    }
    //create function to add page
    #[Route('/admin/page/add', name: 'admin_page_add')]
    public function add(EntityManagerInterface $em,Request $request,SluggerInterface $slugger): RedirectResponse|Response
    {
      $page = new Pages();
      $form= $this->createForm(PageFormType::class,$page);

      $form->handleRequest($request);
      if($form->isSubmitted() && $form->isValid()) {
          // handle file upload
           $page_images =  $form->get('Image')->getData();
           if($page_images){
               $originalFilename = pathinfo($page_images->getClientOriginalName(), PATHINFO_FILENAME);
               // this is needed to safely include the file name as part of the URL
               $safeFilename = $slugger->slug($originalFilename);
               $newFilename = $safeFilename.'-'.uniqid().'.'.$page_images->guessExtension();

               // Move the file to the directory where brochures are stored
               try {
                   $page_images->move(
                       $this->getParameter('pages_directory'),
                       $newFilename
                   );
               } catch (FileException $e) {
               }

               $page->setFeaturedImage($newFilename);
           }
          $page->setSlug($slugger->slug(strtolower($page->getTitle())));
          $em->persist($page);
          $em->flush();
          $this->addFlash('success', 'Page Added Successfully');
          return $this->redirectToRoute('admin_page_list');
      }

        return $this->render('admin/page/add.html.twig',['form'=>$form->createView()]);
    }
    //create function to edit page
    #[Route('/admin/page/edit/{id}', name: 'admin_page_edit')]
    function edit(EntityManagerInterface $em,Request $request,SluggerInterface $slugger,$id): RedirectResponse|Response
    {
       //handle edit operation
        $page = $em->getRepository(Pages::class)->find($id);
        $form= $this->createForm(PageFormType::class,$page);

        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()) {
            // handle file upload
            $page_images =  $form->get('Image')->getData();
            if($page_images){
                $originalFilename = pathinfo($page_images->getClientOriginalName(), PATHINFO_FILENAME);
                // this is needed to safely include the file name as part of the URL
                $safeFilename = $slugger->slug($originalFilename);
                $newFilename = $safeFilename.'-'.uniqid().'.'.$page_images->guessExtension();

                // Move the file to the directory where brochures are stored
                try {
                    $page_images->move(
                        $this->getParameter('pages_directory'),
                        $newFilename
                    );
                } catch (FileException $e) {
                }

                $page->setFeaturedImage($newFilename);
            }
            if ($form->get("slug")->getData() == null)
                $page->setSlug($slugger->slug(strtolower($page->getTitle())));
            else
                $page->setSlug($form->get("slug")->getData());
            $em->persist($page);
            $em->flush();
            $this->addFlash('success', 'Page Updated Successfully');
            return $this->redirectToRoute('admin_page_list');
        }

        return $this->render('admin/page/edit.html.twig',['form'=>$form->createView(),'page'=>$page]);
    }
    //create function to delete page
    #[Route('/admin/page/delete/{id}', name: 'admin_page_delete')]
    function delete(EntityManagerInterface $em,$id): RedirectResponse
    {
        //handle delete operation
        $page = $em->getRepository(Pages::class)->find($id);
        $em->remove($page);
        $em->flush();
        $this->addFlash('success', 'Page Deleted Successfully');
        return $this->redirectToRoute('admin_page_list');
    }
    //create function to view page
    #[Route('/admin/page/view/{id}', name: 'admin_page_show')]
    function view(EntityManagerInterface $em,$id): Response
    {
        //handle view operation
        $page = $em->getRepository(Pages::class)->find($id);
        return $this->render('admin/page/view.html.twig',['page'=>$page]);
    }

}