<?php

namespace CAO\TvSeriesBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
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
        return $this->render('@CAOTvSeries/Admin/index.html.twig');
    }


}
