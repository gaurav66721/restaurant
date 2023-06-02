<?php


namespace App\Controller\Admin;


use App\Entity\BookingTable;
use App\Form\BookingTableFormType;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class BookingTableController extends AbstractController
{
    #[Route('/admin/booking-table', name: 'admin_booking_table')]
    public function index(Request $request,EntityManagerInterface $em,PaginatorInterface $paginator): Response
    {
         $dql = "SELECT m FROM App\Entity\BookingTable m ORDER BY m.id DESC";
        $pages = $em->createQuery($dql);
        $pagination = $paginator->paginate(
            $pages,
            $request->query->getInt('page',1),
            5
        );
        return $this->render('admin/booking_table/index.html.twig',compact('pagination'));
    }
    //create code for add booking table
    #[Route('/admin/booking-table/add', name: 'admin_booking_table_add')]
    public function add(Request $request,EntityManagerInterface $em): Response
    {
        $bookingTable = new BookingTable();
        $form=$this->createForm(BookingTableFormType::class,$bookingTable);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            //save form data to database
            $em->persist($bookingTable);
            $em->flush();
            //set flash message
            $this->addFlash('success','Booking Table Added');
            //redirect to menu list
            return $this->redirectToRoute('admin_booking_table');
        }
        return $this->render('admin/booking_table/add.html.twig',['form'=>$form->createView()]);
    }
    //create code for edit booking table
    #[Route('/admin/booking-table/edit/{id}', name: 'admin_booking_table_edit')]
    public function edit(BookingTable $bookingTable,EntityManagerInterface $em,Request $request): Response
    {
        $form=$this->createForm(BookingTableFormType::class,$bookingTable);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            //save form data to database
            $em->persist($bookingTable);
            $em->flush();
            //set flash message
            $this->addFlash('success','Booking Table Updated');
            //redirect to menu list
            return $this->redirectToRoute('admin_booking_table');
        }

        return $this->render('admin/booking_table/edit.html.twig',['form'=>$form->createView()]);
    }
    //create code for delete booking table
    #[Route('/admin/booking-table/delete/{id}', name: 'admin_booking_table_delete')]
    public function delete(BookingTable $bookingTable,EntityManagerInterface $em):RedirectResponse
    {
        //delete booking table
        $em->remove($bookingTable);
        $em->flush();
        //set flash message
        $this->addFlash('success','Booking Table Deleted');
        //redirect to menu list
        return $this->redirectToRoute('admin_booking_table');

    }


}