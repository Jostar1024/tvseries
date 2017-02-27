<?php

namespace CAO\TvSeriesBundle\Controller;

use CAO\TvSeriesBundle\Entity\TvSeries;
use CAO\TvSeriesBundle\Form\TvSeriesType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
//use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
/**
 * Class AdminController
 * @package CAO\TvSeriesBundle\Controller
 *
 * @Route("/admin")
 */
class AdminController extends Controller
{
    /**
     * @Route("/")
     */
    public function adminAction()
    {
        return new Response('<html><body>Admin page!</body></html>');
    }

    /**
     * @Route("/tvseries/add")
     *
     */
    public function addTvSeriesAction(Request $request)
    {

        $tvseries = new TvSeries();
        $form = $this->createForm(TvSeriesType::class, $tvseries);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid())
        {
            // deal with the image.
            $image = $tvseries->getImage();

            $imageName = md5(uniqid()).'.'.$image->guessExtension();

            $image->move(
                $this->getParameter('image_directory'),
                $imageName
            );

            $tvseries->setImage($imageName);

            // persist the tvseries
            $manager = $this->getDoctrine()->getManager();
            $manager->persist($tvseries);
            $manager->flush();

            return $this->redirect('add_success');
        }

        return $this->render(
            '@CAOTvSeries/Admin/add_tvseries.html.twig',
            array('form' => $form->createView())
        );
    }


    /**
     * @Route("/tvseries/add_success", name="add_success");
     *
     */
    public function addTvSeriesSuccessAction()
    {
        return $this->render(
            '@CAOTvSeries/Admin/add_tvseries_success.html.twig'
        );
    }
}
