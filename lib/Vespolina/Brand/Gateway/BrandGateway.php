<?php

/**
 * (c) 2013 - ∞ Vespolina Project http://www.vespolina-project.org
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace Vespolina\Brand\Gateway;

use Vespolina\Entity\Brand\BrandInterface;
use Vespolina\Exception\InvalidInterfaceException;
use Vespolina\Specification\IdSpecification;
use Vespolina\Specification\SpecificationInterface;
use Vespolina\Specification\SpecificationWalker;

abstract class BrandGateway implements BrandGatewayInterface
{
    protected $brandClass;
    protected $gatewayName;
    protected $specificationWalker;

    /**
     * @param string $managedClass
     */
    public function __construct($brandClass, $gatewayName)
    {
        if (!class_exists($brandClass) || !in_array('Vespolina\Entity\Brand\BrandInterface', class_implements($brandClass))) {
            throw new InvalidInterfaceException('Please have your brand class implement Vespolina\Entity\Brand\BrandInterface');
        }
        $this->brandClass = $brandClass;
        $this->gatewayName = $gatewayName;
    }

    public function createBrand()
    {
        return new $this->brandClass;
    }

    public function matchBrandById($id, $type = null)
    {
        return $this->executeSpecification(new IdSpecification($id, $type), true);
    }

    public function findAll(SpecificationInterface $specification)
    {
        return $this->executeSpecification($specification);
    }

    public function findOne(SpecificationInterface $specification)
    {
        return $this->executeSpecification($specification, true);
    }

    protected function getSpecificationWalker()
    {
        if (null == $this->specificationWalker) {
            $visitor = $this->getVisitor();
            $this->specificationWalker = new SpecificationWalker(array($visitor));
        }

        return $this->specificationWalker;
    }

}