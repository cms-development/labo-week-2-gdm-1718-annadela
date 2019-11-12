<?php

namespace App\Controller;

use App\Entity\Camp;
use App\Entity\Reaction;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class PageController extends AbstractController
{
    /**
     * @Route("/", name="home", methods={"GET"})
     */
    public function index()
    {
        $manager = $this->getDoctrine()->getManager();
        $repository = $manager->getRepository(Camp::class);
        $camp = $repository->findAll();
        $spotlight = $repository->findOneBy(
            ['spotlight' => true]
        );
        return $this->render('page/index.html.twig', [
            'controller_name' => 'PageController',
            'camps'=> $camp,
            'spotlight' => $spotlight
        ]);
    }

    /**
     * @Route("/detail/{id}", name="detailcamp")
     * @param $id
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function campdetail($id, Request $request)
    {
        //haal het juiste kap op
        $manager = $this->getDoctrine()->getManager();
        $campId =$manager->getRepository(Camp::class)->find($id);

        //haal alle reacties op
        $reactions = $manager->getRepository(Reaction::class)->findBy(['camp_id' => $id]);

        //leeg Reactie maken
        $reaction = new Reaction();

        //form maken
        $form = $this->createFormBuilder($reaction)
            ->add('name', HiddenType::class, [
                'data' => 'Anna De Langhe'
            ])
            ->add('reaction', TextType::class, [
                'attr' =>[
                    'placeholder' => 'Enter your reaction',
                ]

            ])
            ->add('camp_id', HiddenType::class, [
                'data' => $id
            ])
            ->add('save', SubmitType::class,[
                'attr' => [
                    'class' =>"btn btn-info"
                ]

            ])
            ->getForm();

        //nakijken van request
        $form->handleRequest($request);

        //nakijken of form gesubmit is en gevalideerd is
        if($form->isSubmitted() && $form->isValid()) {
            $reaction = $form->getData();

            //entitymanager
            $em = $this->getDoctrine()->getManager();
            $em->persist($reaction);
            $em->flush();
        }

        //render formulier
        return $this->render('page/detail.html.twig',[
            'controller_name' => 'PageController',
            'camp'=> $campId,
            'reaction_form' => $form->createView(),
            'reactions'=> $reactions
        ]);






        }
}
