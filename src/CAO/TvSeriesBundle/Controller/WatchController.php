<?php

namespace CAO\TvSeriesBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;


class WatchController extends Controller
{
    public function indexAction($name)
    {
        return $this->render('', array('name' => $name));
    }
}
