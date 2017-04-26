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
        if($form->isSubmitted())
        {

            $validator = $this->get('validator');
            $errors = $validator->validate($chapter);
            if (count($errors) > 0) {
                return $this->render('chapter/validation.html.twig', array(
                    'errors' => $errors,
                ));
            }

            $chapter->setAuthor($this->getUser());
            $em = $this->getDoctrine()->getManager();
            $em->persist($chapter);
            $em->flush();

            return $this->redirectToRoute('user_profile');
        }

        return $this->render('chapter/create.html.twig',
            array('form' => $form->createView()));

    }

    /**
     * @param int $id
     *
     * @Route("/chapter/{id}", name="chapter_view")
     *
     * @return Response
     */
    public function viewChapter($id)
    {
        $chapter = $this->getDoctrine()->getRepository(Chapter::class)->find($id);

        return $this->render('chapter/chapter.html.twig',
            array('chapter' => $chapter));

    }
}
