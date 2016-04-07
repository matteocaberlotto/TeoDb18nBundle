<?php

namespace Teo\Db18nBundle\Twig;

class Db18nExtension extends \Twig_Extension
{
    protected $translator;

    public function __construct($translator)
    {
        $this->translator = $translator;
    }

    public function getFilters()
    {
        return array(
            new \Twig_SimpleFilter('trans_db', array($this, 'transFromDb')),
        );
    }

    public function transFromDb($string)
    {
        return $this->translator->trans($string);
    }

    public function getName()
    {
        return 'db18n_extension';
    }
}