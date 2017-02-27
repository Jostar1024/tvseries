<?php

namespace CAO\TvSeriesBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

class DefaultController extends Controller
{
    /**
     * @Route("/CAO")
     */
    public function indexAction()
    {
        return $this->render('CAOTvSeriesBundle:Default:index.html.twig');
    }


}
