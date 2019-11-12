<?php

namespace App\Controller;

use App\Entity\Camp;
use App\Entity\Reaction;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class CampController extends AbstractController
{
    /**
     * @Route("/camp", name="camp")
     */
    public function index()
    {
        return $this->render('camp/index.html.twig', [
            'controller_name' => 'CampController',
        ]);
    }

    /**
     * @Route("/camp/add", name="TaskCreate")
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function addCamp(Request $request) {
        //leeg Camp maken
        $camp = new Camp();

        //formulier maken
        $form = $this->createFormBuilder($camp)
            ->add('title', TextType::class, [
                'label' => 'Give your camp a name'
            ])
            ->add('quote', TextType::class, [
                'label' => 'Give your camp a quote'
            ])
            ->add('date', DateTimeType::class, [
                'label' => 'Give your camp a start date'
            ])
            ->add('image', TextType::class, [
                'label' => 'Give your camp a image (the URL)'
            ])
            ->add('description', TextareaType::class, [
                'label'=> 'Give a description about your camp'
            ])
            ->add('spotlight', CheckboxType::class, [
                'label' => 'Do you want the spotlight?'
            ])
            ->add('save', SubmitType::class)
            ->getForm();

        //nakijken van request
        $form->handleRequest($request);

        //nakijken of form gesubmit is en gevalideerd is
        if($form->isSubmitted() && $form->isValid()) {
            $camp = $form->getData();

            //entitymanager
            $em = $this->getDoctrine()->getManager();
            $em->persist($camp);
            $em->flush();
        }

        // render formulier
        return $this->render('camp/add.html.twig', [
            'form' => $form->createView()
        ]);
    }
}
