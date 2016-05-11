<?php
/**
 * Created by PhpStorm.
 * User: Nadheesh
 * Date: 4/14/2016
 * Time: 11:37 AM
 */

namespace BDBundle\Controller\security;


use BDBundle\Document\security\RegisteredUser;
use BDBundle\Document\security\User;
use BDBundle\Form\security\Model\Registration;
use BDBundle\Form\security\Model\ResetPassword;
use BDBundle\Form\security\Type\ResetPasswordType;
use BDBundle\Form\security\Type\RegistrationType;
use BDBundle\Form\security\Type\UserType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class UserController extends Controller
{

    /**
     * @Route("/admin")
     */
    public function adminAction()
    {
        return new Response('<html><body>Admin page!</body></html>');
    }



//    /**
//     * @Route("/create", name="create")
//     */
//    public function createAction()
//    {
//        $user = new User();
//        $user->setUserName('admin');
//
//
//        $plainPassword = 'admin';
//        $encoder = $this->get('security.password_encoder');
//        $encoded = $encoder->encodePassword($user, $plainPassword);
//
//        $user->setPassword($encoded);
//        $user->setFirstName('Admin');
//        $user->setLastName('Jihan');
//        $user->setEmail('jnj@gmail.com');
//
//        $user->setCreated();
//
//        $dm = $this->get('doctrine_mongodb')->getManager();
//        $dm->persist($user);
//        $dm->flush();
//
//        return new Response('Created product id '.$user->getUserName());
//    }



    /**
     * @Route("/register", name="register")
     */
    public function registerAction(Request $request)
    {
        // build the form
        $form = $this->createForm(RegistrationType::class,  new Registration());

        //handle the submit (will only happen on POST)
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $user = $form->getData()->getUser();

            //Encode the password (you could also do this via Doctrine listener)
            $password = $this->get('security.password_encoder')
                ->encodePassword($user, $user->getPlainPassword());
            $user->setPassword($password);

            $user->setCreated();

//            save the User!
            $em = $this->get('doctrine_mongodb')->getManager();
            $em->persist($user);
            $em->flush();


            return $this->redirectToRoute('profile');

        }

        return $this->render(
            'BDBundle:registration:userRegister.html.twig',
            array('form' => $form->createView())
        );
    }



    /**
     * @Route("/profile", name="profile")
     */
    public function userProfileAction(Request $request)
    {
        $error = $request->query->get('error');
        $success = $request->query->get('success');
        if ($this->get('security.authorization_checker')->isGranted('IS_AUTHENTICATED_FULLY')) {

            // build the form
            $user = $this->get('security.token_storage')->getToken()->getUser();


            $id = $user->getId();
            $dm = $this->get('doctrine_mongodb')->getManager();
            $user_db = $dm->getRepository('BDBundle:security\RegisteredUser')
                ->find($id);


            if (!$user_db) {
                return $this->redirectToRoute('login');
            }


            $companynames = array();
            $companies =$user_db->getCompanies();
            if ($companies !=null && sizeof($companies)> 0){
                foreach($companies as $c_id){
                    $dm = $this->get('doctrine_mongodb')->getManager();
                    $company = $dm->getRepository('BDBundle:company\Company')
                        ->find($c_id);


                    if (!$company){
                        continue;
                    }

                    $companyArry = array();
                    $companyArry['id'] = $c_id;
                    $companyArry['name'] = $company->getCompanyName();
                    $companynames[] =  $companyArry;
                }
            }

            $resetPassword = new ResetPassword();
            $resetPassword->setUser($user);
            // build the form
            $form = $this->createForm(ResetPasswordType::class, $resetPassword);

            //handle the submit (will only happen on POST)
            $form->handleRequest($request);
            if ($form->isSubmitted() && $form->isValid()) {
                $user = $form->getData()->getUser();

                //Encode the password (you could also do this via Doctrine listener)
                $password = $this->get('security.password_encoder')
                    ->encodePassword($user, $user->getPlainPassword());
                $user->setPassword($password);

                $dm->flush();

                return $this->redirectToRoute('profile');
                // build the form

            }
            return $this->render('BDBundle:profile:userProfile.html.twig', array('success'=>$success, 'error'=>$error,'companies'=>$companynames, 'user' => $user, 'form' => $form->createView()));

        }

        return $this->redirectToRoute('login');

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

        return $this->render(
            'BDBundle:security:login.html.twig',
            array(
                // last username entered by the user
                'last_username' => $lastUsername,
                'error' => $error,
            )
        );
    }


    /**
     * @Route("/login_check", name="login_check")
     */
    public function loginCheckAction()
    {
        // this controller will not be executed,
        // as the route is handled by the Security system
    }

}