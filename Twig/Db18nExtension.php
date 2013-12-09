<?php

namespace Teo\Db18nBundle\Twig;

class Db18nExtension extends \Twig_Extension
{
    protected $em;
    protected $session;
    protected $default_locale;

    public function __construct($em, $session, $default_locale)
    {
        $this->em = $em;
        $this->session = $session;
        $this->default_locale = $default_locale;
    }

    public function getFilters()
    {
        return array(
            new \Twig_SimpleFilter('trans_db', array($this, 'transFromDb')),
        );
    }

    public function transFromDb($string)
    {
        $candidate = $this->em->getRepository('Teo\Db18nBundle\Entity\Label')
            ->findTranslation($string, $this->getLocale(), $this->getDefaultLocale());

        if ($candidate) {
            return $candidate;
        }

        return $string;
    }

    protected function getLocale()
    {
        $locale = $this->session->get('_locale');
        if (empty($locale)) {
            return 'en';
        }
        return $locale;
    }

    public function getDefaultLocale()
    {
        return $this->default_locale;
    }

    public function getName()
    {
        return 'db18n_extension';
    }
}