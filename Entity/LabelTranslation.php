<?php

namespace Teo\Db18nBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Knp\DoctrineBehaviors\Model as ORMBehaviors;

/**
 * @ORM\Entity
 * @ORM\Entity(repositoryClass="Teo\Db18nBundle\Entity\LabelTranslationRepository")
 */
class LabelTranslation
{
    use ORMBehaviors\Translatable\Translation;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    protected $content;

    public function __toString()
    {
        return (string) $this->content;
    }

    public function getContent()
    {
        return $this->content;
    }

    public function setContent($content)
    {
        $this->content = $content;

        return $this;
    }
}