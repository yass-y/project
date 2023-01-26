<?php

namespace App\Controller;

use App\Entity\Member;
use App\Repository\MemberRepository;
use DateTimeImmutable;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MemberController extends AbstractController
{
    #[Route('/member', name: 'app_member')]
    public function index(MemberRepository $memberRepository): Response
    {

        $members = $memberRepository->findAll();
        return $this->render('members/index.html.twig', [
            'members' => $members,

        ]);
    }

    #[Route('/member/new', name: 'app_member_new')]
    public function new(): Response
    {
        return $this->render('members/add.html.twig');
    }

    #[Route('/member/add', name: 'app_member_add')]
    public function add(Request $request ,  MemberRepository $memberRepository): Response
    {
        $name = $request->request->get("fullname");
        $department =$request->request->get("department");
        $email=$request->request->get("email");

        $date=$request->request->get("birthday");
        $datetime=datetimeimmutable::createFromFormat('Y-m-d',$date);

        $member = new Member();
        $member->setFullname($name);
        $member->setDepartment($department);
        $member->setEmail($email);
        $member->setBirthday($datetime);

        $memberRepository->save($member , true);

        return $this->redirectToRoute('app_member');
    }

    #[Route('/member/delete/{id}', name: 'app_member_delete')]
    public function delete(MemberRepository $memberRepository ,  Member $member): Response
    {

        $memberRepository->remove($member ,true );

        return $this->redirectToRoute('app_member');
    }

    #[Route('/member/modify/{id}', name: 'app_member_modify')]
    public function modify(Member $member ): Response
    {

        return $this->render('members/update.html.twig', [
            'member' => $member,
        ]);
    }

    #[Route('/member/update/{id}', name: 'app_member_update')]
    public function update(Request $request,  Member $member , MemberRepository $memberRepository): Response
    {
        $name = $request->request->get("fullname");
        $department = $request->request->get("department");
        $email=$request->request->get("email");

        $date=$request->request->get("birthday");
        $datetime=datetimeimmutable::createFromFormat('Y-m-d',$date);

        $member->setFullname($name);
        $member->setBirthday($datetime);
        $member->setDepartment($department);
        $member->setEmail($email);
        $memberRepository->save($member ,true );


        return $this->redirectToRoute('app_member');
    }









}