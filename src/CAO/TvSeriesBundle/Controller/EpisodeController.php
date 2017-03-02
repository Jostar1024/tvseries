<?php

namespace CAO\TvSeriesBundle\Controller;

use CAO\TvSeriesBundle\Entity\Episode;
use CAO\TvSeriesBundle\Entity\UserEpisode;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;use Symfony\Component\HttpFoundation\Request;
use Doctrine\ORM\Tools\Pagination\Paginator;

/**
 * Episode controller.
 *
 * @Route("/episode")
 */
class EpisodeController extends Controller
{
    /**
     * Lists all episode entities.
     * @Route("/", name="admin_episode_index")
     * @Route("/{page}", name="episode_with_paginator", requirements={"page": "\d+"})
     * @Method("GET")
     */
    public function indexAction($page=1)
    {
        $em = $this->getDoctrine()->getManager();

//        $episodes = $em->getRepository('CAOTvSeriesBundle:Episode')->findAll();

        $limit = 5;
        $offset = ($page-1) * $limit;
        $dql ="SELECT e FROM CAOTvSeriesBundle:Episode e ORDER BY e.name ASC";
        $query = $em->createQuery($dql)
            ->setFirstResult($offset)
            ->setMaxResults($limit)
        ;

        $paginator = new Paginator($query);
        return $this->render('CAOTvSeriesBundle:episode:index.html.twig', array(
//            'episodes' => $episodes,
            'totalPages' => (int) ceil($paginator->count() / $limit),
            'currentPage' => $page,
            'paginator' => $paginator,
        ));
    }

    /**
     * Creates a new episode entity.
     *
     * @Route("/new", name="admin_episode_new")
     * @Method({"GET", "POST"})
     * @Security("has_role('ROLE_ADMIN')")
     */
    public function newAction(Request $request)
    {
        $episode = new Episode();
        $form = $this->createForm('CAO\TvSeriesBundle\Form\EpisodeType', $episode);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // deal with the image.
            $image = $episode->getImage();

            if ($image != NULL)
            {
                $imageName = md5(uniqid()).'.'.$image->guessExtension();
                $image->move(
                    $this->getParameter('image_directory'),
                    $imageName
                );
                $episode->setImage($imageName);
            }

            $em = $this->getDoctrine()->getManager();
            $em->persist($episode);
            $em->flush($episode);

            return $this->redirectToRoute('admin_episode_show', array('id' => $episode->getId()));
        }

        return $this->render('CAOTvSeriesBundle:episode:new.html.twig', array(
            'episode' => $episode,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a episode entity.
     *
     * @Route("/{id}", name="admin_episode_show")
     * @Method("GET")
     */
    public function showAction(Episode $episode)
    {
        $deleteForm = $this->createDeleteForm($episode);
        $userEpisode = array();
        if ($this->get('security.authorization_checker')->isGranted('IS_AUTHENTICATED_FULLY'))
        {
            $userEpisode = $this->getDoctrine()
                ->getManager()
                ->getRepository("CAOTvSeriesBundle:UserEpisode")
                ->findBy(array(
                    'user' => $this->get('security.token_storage')->getToken()->getUser(),
                    'episode' => $episode
                ))
            ;
        }
        return $this->render('CAOTvSeriesBundle:episode:show.html.twig', array(
            'episode' => $episode,
            'userEpisode' => $userEpisode,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing episode entity.
     *
     * @Route("/{id}/edit", name="admin_episode_edit")
     * @Method({"GET", "POST"})
     * @Security("has_role('ROLE_ADMIN')")
     */
    public function editAction(Request $request, Episode $episode)
    {
        $deleteForm = $this->createDeleteForm($episode);
        $editForm = $this->createForm('CAO\TvSeriesBundle\Form\EpisodeType', $episode);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('admin_episode_edit', array('id' => $episode->getId()));
        }

        return $this->render('@CAOTvSeries/episode/edit.html.twig', array(
            'episode' => $episode,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a episode entity.
     *
     * @Route("/{id}", name="admin_episode_delete")
     * @Method("DELETE")
     * @Security("has_role('ROLE_ADMIN')")
     */
    public function deleteAction(Request $request, Episode $episode)
    {
        $form = $this->createDeleteForm($episode);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($episode);
            $em->flush($episode);
        }

        return $this->redirectToRoute('admin_episode_index');
    }

    /**
     * Creates a form to delete a episode entity.
     *
     * @param Episode $episode The episode entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Episode $episode)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('admin_episode_delete', array('id' => $episode->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }

    /**
     * @param $name
     * @return \Symfony\Component\HttpFoundation\Response
     * @Route("/watch/{id}", name="user_watch_episode")
     */
    public function watchAction(Episode $episode)
    {
        $user = $this->get('security.token_storage')->getToken()->getUser();
        $em = $this->getDoctrine()->getManager();
        $userEpisodeTable = $em->getRepository('CAOTvSeriesBundle:UserEpisode');
        $episodeArr = $userEpisodeTable
                        ->findBy(array(
                            'user' => $user,
                            'episode' => $episode
                        ))
        ;

        $userEpisode = new UserEpisode();
        $userEpisode->setUser($user);
        $userEpisode->setEpisode($episode);
        $userEpisode->setCurrent($episode->getEpisodeNumber());
        $userEpisode->setWatechedAt(new \DateTime('now'));

        // if null add new
        if (empty($episodeArr))
        {
            $em->persist($userEpisode);
        }
        else // if not update this term with new data
        {
            $em->merge($userEpisode);
        }
        $em->flush();
        return $this->redirectToRoute("admin_episode_index");
//
//        $form = $this->createForm('CAO\TvSeriesBundle\Form\UserEpisodeType', $userEpisode);
//
//        if ($form->isSubmitted() && $form->isValid())
//        {
//
//        }
//        return $this->render('', array(
//            'user' => $user,
//            'episode' => $episode
//        ));


    }
}
