<?php

namespace Teo\Db18nBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

use Gedmo\Mapping\Annotation as Gedmo;

use Gedmo\Translatable\Translatable;
use Sonata\TranslationBundle\Traits\Gedmo\PersonalTranslatable;

use Doctrine\Common\Collections\ArrayCollection;
use AppBundle\Entity\LabelTranslation;

/**
 * @ORM\Entity
 * @ORM\HasLifecycleCallbacks
 * @ORM\Table(name="label")
 * @ORM\Entity(repositoryClass="Teo\Db18nBundle\Entity\LabelRepository")
 * @Gedmo\TranslationEntity(class="AppBundle\Entity\LabelTranslation")
 */
class Label
{
    use PersonalTranslatable;

    /**
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @Gedmo\Translatable
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    protected $name;

    /**
     * @ORM\OneToMany(
     *   targetEntity="LabelTranslation",
     *   mappedBy="object",
     *   cascade={"persist", "remove"}
     * )
     */
    protected $translations;

    public function __construct()
    {
        $this->translations = new ArrayCollection();
    }

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