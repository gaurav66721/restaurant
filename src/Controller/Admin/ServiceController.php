<?php


namespace App\Controller\Admin;


use App\Entity\Gallery;
use App\Entity\Services;
use App\Form\ServiceFormType;
use App\Services\FileUploader;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\String\Slugger\SluggerInterface;

class ServiceController extends AbstractController
{
    #[Route('/admin/service', name: 'admin_service')]
    public function index(EntityManagerInterface $em,Request $request,PaginatorInterface $paginator)
    {
        $dql = "SELECT s FROM App\Entity\Services s ORDER BY s.id DESC";
        $pages = $em->createQuery($dql);
        $pagination = $paginator->paginate(
            $pages,
            $request->query->getInt('page',1),
            5
        );
        return $this->render('admin/service/index.html.twig', [
            'controller_name' => 'ServiceController',
            'pagination'=>$pagination
        ]);
    }
    //create function to add service
    #[Route('/admin/service/add', name: 'admin_service_add')]
    #[Route('/admin/service/edit/{id}', name: 'admin_service_edit')]
    public function add(EntityManagerInterface $em,Request $request,FileUploader $uploader,SluggerInterface $slugger,?Services $services=null): RedirectResponse|Response
    {

        $service = ($services != null) ? $services : new Services();
        $form = $this->createForm(ServiceFormType::class,$service);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $service_images =  $form->get('image')->getData();
            if ($form->get("slug")->getData()==""){
                $service->setSlug(strtolower($slugger->slug($service->getTitle())));
            }
            if($service_images != null){
                $uploader->setTargetDirectory($this->getParameter('service_directory'));
                $image_name = $uploader->upload($service_images);
                $service->setFeaturedImage($image_name);
            }
            //handle gallery multiple images
            $gallerys = $form->get('gallery');
            $uploader->setTargetDirectory($this->getParameter('service_directory'));

            foreach ($gallerys as $form_gallery){
                $gallery = new Gallery();
                $gallery_image = $form_gallery->get("myimages")->getData();
                $gallery->setImage($uploader->upload($gallery_image));

                $gallery->setCreatedAt(new \DateTime());

                $gallery->setService($service);
                $em->persist($gallery);

            }
            $em->persist($service);
            $em->flush();
            $this->addFlash('success','Service Added Successfully');
            return $this->redirectToRoute('admin_service');
        }
        return $this->render('admin/service/add.html.twig', [
            'controller_name' => 'ServiceController',
            'form'=>$form->createView()
        ]);
    }
    // create function to delete service
    #[Route('/admin/service/delete/{id}', name: 'admin_service_delete')]
    public function delete(Services $services,EntityManagerInterface $em): RedirectResponse
    {
        $em->remove($services);
        $em->flush();
        $this->addFlash('success','Service Deleted Successfully');
        return $this->redirectToRoute('admin_service');
    }

}