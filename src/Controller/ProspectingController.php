<?php

namespace App\Controller;

use App\Entity\Prospect;
use App\Entity\Prospecting;
use App\Repository\MemberRepository;
use App\Repository\ProspectingRepository;
use App\Repository\ProspectRepository;
use DateTimeImmutable;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ProspectingController extends AbstractController
{
    #[Route('/prospecting', name: 'app_prospecting')]
    public function index(ProspectingRepository $prospectingRepository): Response
    {
        $prospectings=$prospectingRepository->findAll();
        return $this->render('prospecting/index.html.twig', [
            'prospectings' => $prospectings,

        ]);
    }

    #[Route('/prospecting/new', name: 'app_prospecting_new')]
    public function new(ProspectRepository $prospectRepository , MemberRepository $memberRepository): Response
    {
        $prospects=$prospectRepository->findAll();
        $members=$memberRepository->findAll();
        return $this->render('prospecting/add.html.twig', [
            'prospects' =>$prospects,
            'members' =>$members,
        ]);
    }

    #[Route('/prospecting/add', name: 'app_prospecting_add')]
    public function add(Request $request , ProspectingRepository $prospectingRepository , ProspectRepository $prospectRepository, MemberRepository $memberRepository): Response
    {


        $memberId = $request->request->get("member");
        $prospectId = $request->request->get("prospect");
        $member=$memberRepository->find($memberId);
        $prospect=$prospectRepository->find($prospectId);

        $note=$_POST['note'];

        $date=$request->request->get("date");
        $datetime=datetimeimmutable::createFromFormat('Y-m-d',$date);

        $pros= new Prospecting();
        $pros->setNote($note);
        $pros->setDate($datetime);
        $pros->setMemberProspecting($member);
        $pros->setProspect($prospect);


        $prospectingRepository->save($pros , true);


        return $this->redirectToRoute('app_prospecting');
    }

    #[Route('/prospecting/delete/{id}', name: 'app_prospecting_delete')]
    public function delete( ProspectingRepository $prospectingRepository ,  Prospecting $prospecting): Response
    {

        $prospectingRepository->remove($prospecting ,true );

        return $this->redirectToRoute('app_prospecting');
    }

    #[Route('/prospecting/modify/{id}', name: 'app_prospecting_modify')]
    public function modify(Prospecting $prospecting ,  ProspectRepository $prospectRepository , MemberRepository $memberRepository): Response
    {
        $member=$memberRepository->findAll();
        $prospect=$prospectRepository->findAll();

        return $this->render('prospecting/update.html.twig', [
            'prospecting'=> $prospecting,
            'members' => $member,
            'prospects' => $prospect
        ]);
    }

    #[Route('/prospecting/update/{id}', name: 'app_prospecting_update')]
    public function update(Request $request, ProspectRepository $prospectRepository , Prospecting $prospecting, MemberRepository $memberRepository , ProspectingRepository $prospectingRepository): Response
    {
        $prospectId= $request->request->get("prospect");
        $memberId= $request->request->get("member");
        $note= $request->request->get("note");
        $date=$request->request->get("date");
        $datetime=datetimeimmutable::createFromFormat('Y-m-d',$date);

        $prospect=$prospectRepository->find($prospectId);
        $member=$memberRepository->find($memberId);



        $prospecting->setProspect($prospect);
        $prospecting->setMemberProspecting($member);
        $prospecting->setNote($note);
        $prospecting->setDate($datetime);


        $prospectingRepository->save($prospecting ,true );


        return $this->redirectToRoute('app_prospecting');
    }











}