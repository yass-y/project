<?php

namespace App\Controller;

use App\Entity\Prospect;
use App\Repository\ProspectRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ProspectController extends AbstractController
{
    #[Route('/', name: 'app_prospect')]
    public function index(ProspectRepository $prospectRepository): Response
    {
        $prospects = $prospectRepository->findAll();
        return $this->render('prospect/index.html.twig', [
            'prospects' => $prospects,

        ]);
    }

    #[Route('/prospect/new', name: 'app_prospect_new')]
    public function new(): Response
    {
        return $this->render('prospect/add.html.twig');
    }

    #[Route('/prospect/add', name: 'app_prospect_add')]
    public function add(Request $request ,ProspectRepository $prospectRepository): Response
    {
        $name = $request->request->get("name");
        $email =$request->request->get("email");
        $phone=$request->request->get("phone");
        $adress=$request->request->get("adress");
        $description=$request->request->get("phone");


        $prospect = new Prospect();
        $prospect->setName($name);
        $prospect->setEmail($email);
        $prospect->setPhone($phone);
        $prospect->setAdress($adress);
        $prospect->setDescription($description);


        $prospectRepository->save($prospect, true);

        return $this->redirectToRoute('app_prospect');
    }

    #[Route('/prospect/delete/{id}', name: 'app_prospect_delete')]
    public function delete( ProspectRepository $prospectRepository ,  Prospect $prospect): Response
    {


        $prospectRepository->remove($prospect ,true );


        return $this->redirectToRoute('app_prospect');
    }

    #[Route('/prospect/modify/{id}', name: 'app_prospect_modify')]
    public function modify(Prospect $prospect ): Response
    {

        return $this->render('prospect/update.html.twig', [
            'prospect' => $prospect,
        ]);
    }

    #[Route('/prospect/update/{id}', name: 'app_prospect_update')]
    public function update(Request $request,  Prospect $prospect , ProspectRepository $prospectRepository): Response
    {
        $name = $request->request->get("name");
        $email =$request->request->get("email");
        $phone=$request->request->get("phone");
        $adress=$request->request->get("adress");
        $description=$request->request->get("description");



        $prospect->setName($name);
        $prospect->setEmail($email);
        $prospect->setPhone($phone);
        $prospect->setAdress($adress);
        $prospect->setDescription($description);


        $prospectRepository->save($prospect, true);


        return $this->redirectToRoute('app_prospect');
    }



}