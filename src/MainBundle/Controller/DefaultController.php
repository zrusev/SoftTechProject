<?php

namespace MainBundle\Controller;

use MainBundle\Entity\Chapter;
use MainBundle\Entity\Role;
use MainBundle\Entity\User;
use MainBundle\Form\UserType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class DefaultController extends Controller
{
    /**
     * @Route("/", name="homepage")
     * @Method({"GET", "POST"})
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function indexAction(Request $request)
    {
        $user = new User();
        $form = $this->createForm(UserType::class, $user);

        $form->handleRequest($request);
        if ($form->isSubmitted()) {

            $validator = $this->get('validator');
            $errors = $validator->validate($user);
            if (count($errors) > 0) {
                return $this->render('chapter/validation.html.twig', array(
                    'errors' => $errors,
                ));
            }

            $password = $this->get('security.password_encoder')
                ->encodePassword($user, $user->getPassword());
            $user->setPassword($password);

            $role = $this->getDoctrine()->getRepository(Role::class)->findOneBy(['name' => 'ROLE_USER']);
            $user->addRole($role);

            $em = $this->getDoctrine()->getManager();
            $em->persist($user);
            $em->flush();

            return $this->redirectToRoute('security_login');

    }

        $chapters = $this->getDoctrine()->getRepository(Chapter::class)->findAllOrdered();
        // replace this example code with whatever you need
        return $this->render('default/index.html.twig', ['chapters' => $chapters]);
    }

    /**
     * @Security("is_granted('IS_AUTHENTICATED_FULLY')")
     * @Route("/profile", name="user_profile")
     */
    public function profileAction()
    {
        $user = $this->getUser();
        $chapters = $this->getDoctrine()->getRepository(Chapter::class)->findCurrentUser($user->getID());
        return $this->render("user/profile.html.twig", array('user' => $user, 'chapters' => $chapters));
    }


    /**
     *
     * @Route("/library", name="library")
     */
    public function libraryAction()
    {
        $chapters = $this->getDoctrine()->getRepository(Chapter::class)->findAllBooks();
        return $this->render(":default:library.html.twig",  ['chapters' => $chapters]);
    }
}
