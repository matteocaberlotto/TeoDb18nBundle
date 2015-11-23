<?php

namespace Teo\Db18nBundle\Helper;

class Translation
{
    protected $container, $default_locale;

    public function __construct($container, $default_locale)
    {
        $this->container = $container;
        $this->default_locale = $default_locale;
    }

    public function trans($string)
    {
        $candidate = $this->container->get('doctrine')->getRepository('Teo\Db18nBundle\Entity\Label')
            ->findTranslation($string, $this->getLocale(), $this->getDefaultLocale());

        if ($candidate) {
            return $candidate;
        }

        return $string;
    }

    protected function getLocale()
    {
        $locale = $this->container->get('session')->get('_locale');
        if (empty($locale)) {
            return $this->default_locale;
        }
        return $locale;
    }

    public function getDefaultLocale()
    {
        return $this->default_locale;
    }
}