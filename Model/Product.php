<?php
/**
 * (c) Vespolina Project http://www.vespolina-project.org
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace Vespolina\ProductBundle\Model;

use Doctrine\Common\Collections\ArrayCollection;

use Vespolina\ProductBundle\Model\Feature\FeatureInterface;
use Vespolina\ProductBundle\Model\Identifier\IdentifierInterface;
use Vespolina\ProductBundle\Model\Identifier\ProductIdentifierSetInterface;
use Vespolina\ProductBundle\Model\Option\OptionInterface;
use Vespolina\ProductBundle\Model\Option\OptionGroupInterface;

/**
 * @author Richard D Shank <develop@zestic.com>
 * @author Daniel Kucharski <daniel@xerias.be>
 */
abstract class Product implements ProductInterface
{
    const PHYSICAL      = 1;
    const UNIQUE        = 2;
    const DOWNLOAD      = 4;
    const TIME          = 8;
    const SERVICE       = 16;

    protected $createdAt;
    protected $description;
    protected $features;
    protected $primaryIdentifierSet;
    protected $name;
    protected $options;
    protected $type;
    protected $updateAt;

    /**
     * @inheritdoc
     */
    public function setDescription($description)
    {
        $this->description = $description;
    }

    /**
     * @inheritdoc
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @inheritdoc
     */
    public function addFeature(FeatureInterface $feature)
    {
        $type = strtolower($feature->getType());
        $searchTerm = strtolower($feature->getSearchTerm());
        $this->features[$type][$searchTerm] = $feature;
    }

    /**
     * @inheritdoc
     */
    public function setFeatures($features)
    {
        $this->features = $features;
    }

    /**
     * @inheritdoc
     */
    public function getFeatures()
    {
        return $this->features;
    }

    /**
     * @inheritdoc
     */
    public function setPrimaryIdentifierSet($identifiersSet)
    {
        $this->primaryIdentifierSet = $identifiersSet;
    }

    /**
     * @inheritdoc
     */
    public function getPrimaryIdentifierSet()
    {
        return $this->primaryIdentifierSet;
    }

    /**
     * @inheritdoc
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * @inheritdoc
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @inheritdoc
     */
    public function setOptionGroups($optionGroups)
    {
        foreach ($optionGroups as $optionGroup) {
            $this->addOptionGroup($optionGroup);
        }
    }

    /**
     * @inheritdoc
     */
    public function addOptionGroup(OptionGroupInterface $optionGroup)
    {
        $this->options[$optionGroup->getName()] = $optionGroup;
    }

    /**
     * @inheritdoc
     */
    public function removeOptionGroup($name)
    {
        unset($this->options[$name]);
    }

    /**
     * @inheritdoc
     */
    public function clearOptions()
    {
       $this->options = null;
    }

    /**
     * @inheritdoc
     */
    public function getOptions()
    {
        return $this->options;
    }

    /**
     * @inheritdoc
     */
    public function setType($type)
    {
        $this->type = $type;
    }

    /**
     * @inheritdoc
     */
    public function getType()
    {
        return $this->type;
    }

    /*
     * @inheritdoc
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /*
     * @inheritdoc
     */
    public function getUpdatedAt()
    {
        return $this->updatedAt;
    }

    public function incrementCreatedAt()
    {
        if (null === $this->createdAt) {
            $this->createdAt = new \DateTime();
        }
        $this->updatedAt = new \DateTime();
    }

    public function incrementUpdatedAt()
    {
        $this->updatedAt = new \DateTime();
    }
}
