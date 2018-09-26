<?php

namespace AppBundle\Controller;

use AppBundle\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class DefaultController extends Controller
{
    /**
     * @Route("/", name="homepage")
     */
    public function indexAction(Request $request)
    {
        // replace this example code with whatever you need
        return $this->render('default/index.html.twig', [
            'base_dir' => realpath($this->getParameter('kernel.project_dir')).DIRECTORY_SEPARATOR,
        ]);
    }



    /**
     * @Route("/login", name="login")
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function loginAction(Request $request)
    {
        $authenticationUtils = $this->get('security.authentication_utils');
        // get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();

        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();

        return $this->render('@App/login.html.twig', array(
            'last_username' => $lastUsername,
            'error' => $error,
        ));
    }

    /**
     * @Route("/logout", name="logout")
     * @param Request $request
     */
    public function logoutAction(Request $request)
    {

    }



    /**
     * @Route("/user/page", name="user_page")
     * @param Request $request
     */
    public function userPageAction(Request $request)
    {
        dump($this->getUser());die;
    }


    /**
     * @Route("/register-user", name="register_user")
     * @param Request $request
     */
    public function registerUserAction(Request $request)
    {
        $mobileNumber = $request->query->get("mobileNumber", time());
        $password = $request->query->get("password", "123456");
        $password = password_hash($password, PASSWORD_BCRYPT);
        $user = new User();
        $user->setMobileNumber($mobileNumber)
            ->setMobileCountry("CN")
            ->setPassword($password)
            ->setUsername("CN_".$mobileNumber)
            ->setEmail("CN_".$mobileNumber."@zadmin.test")
        ;
        $em = $this->getDoctrine()->getManager();
        $em->persist($user);
        $em->flush();
        echo "OK";die;
    }



}
