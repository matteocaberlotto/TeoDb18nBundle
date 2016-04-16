<?php

namespace Teo\Db18nBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Knp\DoctrineBehaviors\Model as ORMBehaviors;

use Doctrine\Common\Collections\ArrayCollection;

/**
 * @ORM\Entity
 * @ORM\HasLifecycleCallbacks
 * @ORM\Table(name="label")
 * @ORM\Entity(repositoryClass="Teo\Db18nBundle\Entity\LabelRepository")
 */
class Label
{
    use ORMBehaviors\Translatable\Translatable;

    /**
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    protected $name;

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
}