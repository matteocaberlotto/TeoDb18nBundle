<?php

namespace Teo\Db18nBundle\Entity;

class LabelTranslation
{
    protected $translatable;

    protected $content;

    public function setContent($content)
    {
        $this->content = $content;

        return $this;
    }

    public function getContent()
    {
        return $this->content;
    }

    /**
     * Here follows the A2lix bundle trait Translatable
     */
    protected $id;

    /**
     * @var string
     */
    protected $locale;

    public function getId()
    {
        return $this->id;
    }

    public function getTranslatable()
    {
        return $this->translatable;
    }

    public function setTranslatable($translatable)
    {
        $this->translatable = $translatable;
        return $this;
    }

    public function getLocale()
    {
        return $this->locale;
    }

    public function setLocale($locale)
    {
        $this->locale = $locale;
        return $this;
    }
}