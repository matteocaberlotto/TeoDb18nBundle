<?php

namespace Teo\Db18nBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction($name)
    {
        return $this->render('TeoDb18nBundle:Default:index.html.twig', array('name' => $name));
    }
}
