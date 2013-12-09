<?php

namespace Teo\Db18nBundle\Entity;

class Label
{
    protected $id;

    protected $name;

    /**
     * @var \Doctrine\Common\Collections\ArrayCollection
     */
    protected $translations;

    public function __toString()
    {
        return !empty($this->name) ? (string) $this->name : 'empty';
    }

    public function getName()
    {
        return $this->name;
    }

    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    public function getId()
    {
        return $this->id;
    }

    /**
     * Here follows the A2lix bundle trait Translatable
     */

    public static function getTranslationEntityClass()
    {
        return __CLASS__ . 'Translation';
    }

    public function getTranslations()
    {
        return $this->translations = $this->translations ? : new \Doctrine\Common\Collections\ArrayCollection();
    }

    public function setTranslations(\Doctrine\Common\Collections\ArrayCollection $translations)
    {
        $this->translations = $translations;
        return $this;
    }

    public function addTranslation($translation)
    {
        $this->getTranslations()->set($translation->getLocale(), $translation);
        $translation->setTranslatable($this);
        return $this;
    }

    public function removeTranslation($translation)
    {
        $this->getTranslations()->removeElement($translation);
    }

    public function getCurrentTranslation()
    {
        $t = $this->getTranslationForLocale($this->current_locale);
        if (!$t && $this->getTranslations()->count()) {
            return $this->getTranslations()->first();
        }
        return $t;
    }

    public function getTranslationForLocale($locale, $default)
    {
        foreach ($this->getTranslations() as $translation) {
            if ($translation->getLocale() == $locale) {
                $current = $translation;
            }

            if ($translation->getLocale() == $default) {
                $default_t = $translation;
            }
        }

        if (!empty($current)) {
            return $current;
        }

        if (!empty($default_t)) {
            return $default_t;
        }

        return null;
    }

    public function __call($method, $args)
    {
        return ($translation = $this->getCurrentTranslation()) ?
                call_user_func(array(
                    $translation,
                    'get' . ucfirst($method)
                )) : '';
    }
}