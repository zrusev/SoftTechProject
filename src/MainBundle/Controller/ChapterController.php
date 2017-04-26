<?php

namespace MainBundle\Controller;

use MainBundle\Entity\Chapter;
use MainBundle\Form\ChapterType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class ChapterController extends Controller
{
    /**
     * @param Request $request
     *
     * @Route("chapter/create", name="chapter_create")
     * @Security("is_granted('IS_AUTHENTICATED_FULLY')")
     *
     * @return Response
     */
    public function createChapter(Request $request)
    {
        $chapter = new Chapter();
        $form = $this->createForm(ChapterType::class, $chapter);

        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid())
        {
            $chapter->setAuthor($this->getUser());
            $em = $this->getDoctrine()->getManager();
            $em->persist($chapter);
            $em->flush();

            return $this->redirectToRoute('user_profile');
        }

        return $this->render('chapter/create.html.twig',
            array('form' => $form->createView()));

    }
}
