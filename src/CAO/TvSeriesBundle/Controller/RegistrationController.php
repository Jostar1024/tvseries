<?php

namespace CAO\TvSeriesBundle\Controller;

use CAO\TvSeriesBundle\Entity\User;
use CAO\TvSeriesBundle\Form\UserType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class RegistrationController extends Controller
{
    /**
     * @Route("/register", name="Registration")
     */
    public function registrationAction(Request $request)
    {
        $user = new User();
        $form = $this->createForm(UserType::class, $user);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid())
        {
            $password = $this->get('security.password_encoder')
                ->encodePassword($user, $user->getPlainPassword());
            $user->setPassword($password);

            $em = $this->getDoctrine()->getManager();
            $em->persist($user);
            $em->flush();

            return $this->redirectToRoute('registration_success');
        }
        return $this->render(
            '@CAOTvSeries/Registration/register.html.twig',
            array('form' => $form->createView())
        );
    }

    /**
     * @Route("/success", name="registration_success")
     */
    public function successAction()
    {
        return $this->render('@CAOTvSeries/Registration/success.html.twig');
    }

    /**
     * @Route("/logout", name="user_logout")
     */
    public function logoutAction()
    {
        //clear the token, cancel session and redirect
        $this->get('security.context')->setToken(null);
        $this->get('request')->getSession()->invalidate();
        return $this->redirectToRoute("tvseries_index");
    }
}
