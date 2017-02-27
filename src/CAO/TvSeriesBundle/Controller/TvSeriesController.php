<?php

namespace CAO\TvSeriesBundle\Controller;

use CAO\TvSeriesBundle\Entity\TvSeries;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;use Symfony\Component\HttpFoundation\Request;

/**
 * Tvseries controller.
 *
 * @Route("tvseries")
 */
class TvSeriesController extends Controller
{
    /**
     * Lists all tvSeries entities.
     *
     * @Route("/", name="tvseries_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $tvSeries = $em->getRepository('CAOTvSeriesBundle:TvSeries')->findAll();

        return $this->render('CAOTvSeriesBundle:tvseries:index.html.twig', array(
            'tvSeries' => $tvSeries,
        ));
    }

    /**
     * Creates a new tvSeries entity.
     *
     * @Route("/new", name="admin_tvseries_new")
     * @Method({"GET", "POST"})
     * @Security("has_role('ROLE_ADMIN')")
     */
    public function newAction(Request $request)
    {

        $tvSeries = new Tvseries();
        $form = $this->createForm('CAO\TvSeriesBundle\Form\TvSeriesType', $tvSeries);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // deal with the image.
            $image = $tvSeries->getImage();
            if ($image != NULL)
            {
                $imageName = md5(uniqid()).'.'.$image->guessExtension();
                $image->move(
                    $this->getParameter('image_directory'),
                    $imageName
                );
                $tvSeries->setImage($imageName);
            }

            $em = $this->getDoctrine()->getManager();
            $em->persist($tvSeries);
            $em->flush($tvSeries);

            return $this->redirectToRoute('admin_tvseries_show', array('id' => $tvSeries->getId()));
        }

        return $this->render('CAOTvSeriesBundle:tvseries:new.html.twig', array(
            'tvSeries' => $tvSeries,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a tvSeries entity.
     *
     * @Route("/{id}", name="admin_tvseries_show")
     * @Method("GET")
     */
    public function showAction(TvSeries $tvSeries)
    {
        $deleteForm = $this->createDeleteForm($tvSeries);

        return $this->render('CAOTvSeriesBundle:tvseries:show.html.twig', array(
            'tvSeries' => $tvSeries,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing tvSeries entity.
     *
     * @Route("/{id}/edit", name="admin_tvseries_edit")
     * @Method({"GET", "POST"})
     * @Security("has_role('ROLE_ADMIN')")
     */
    public function editAction(Request $request, TvSeries $tvSeries)
    {
        $deleteForm = $this->createDeleteForm($tvSeries);
        $editForm = $this->createForm('CAO\TvSeriesBundle\Form\TvSeriesType', $tvSeries);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('admin_tvseries_edit', array('id' => $tvSeries->getId()));
        }

        return $this->render('CAOTvSeriesBundle:tvseries:edit.html.twig', array(
            'tvSeries' => $tvSeries,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a tvSeries entity.
     *
     * @Route("/{id}", name="admin_tvseries_delete")
     * @Method("DELETE")
     * @Security("has_role('ROLE_ADMIN')")
     */
    public function deleteAction(Request $request, TvSeries $tvSeries)
    {
        $form = $this->createDeleteForm($tvSeries);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($tvSeries);
            $em->flush($tvSeries);
        }

        return $this->redirectToRoute('admin_tvseries_index');
    }

    /**
     * Creates a form to delete a tvSeries entity.
     *
     * @param TvSeries $tvSeries The tvSeries entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(TvSeries $tvSeries)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('admin_tvseries_delete', array('id' => $tvSeries->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
