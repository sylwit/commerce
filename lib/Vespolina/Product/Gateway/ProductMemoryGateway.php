<?php

namespace Vespolina\Product\Gateway;

use Molino\MolinoInterface;
use Molino\SelectQueryInterface;
use Vespolina\Entity\Product\ProductInterface;
use Vespolina\Exception\InvalidInterfaceException;
use Vespolina\Product\Specification\SpecificationInterface;

class ProductMemoryGateway extends ProductGateway
{
    protected $products;

    /**
     * @param string $managedClass
     */
    public function __construct($productClass)
    {
        parent::__construct($productClass, 'Memory');

        $this->products = array();
    }

    protected function executeSpecification(SpecificationInterface $specification, $matchOne = false)
    {
        $results = array();

        foreach ($this->products as $product)
        {
            if (!$specification->isSatisfiedBy($product)) {
               continue;
            }

            if ($matchOne) return $product;

            $result[] = $product;
        }

        return $results;
    }

    /**
     * Delete a Product that has been persisted and optionally flush that link.
     * Systems that allow for a delayed flush can use the $andFlush parameter, other
     * systems would disregard the flag. The success of the process is returned.
     *
     * @param \Vespolina\Entity\ProductInterface $product
     *
     * @param boolean $andFlush
     */
    function deleteProduct(ProductInterface $product, $andFlush = false)
    {
        // TODO: Implement deleteProduct() method.
    }

    /**
     * Flush any changes to the database
     */
    function flush()
    {
        // TODO: Implement flush() method.
    }

    /**
     * Persist a Product that has been created and optionally flush that link.
     * Systems that allow for a delayed flush can use the $andFlush parameter, other
     * systems would disregard the flag. The success of the process is returned.
     *
     * @param Vespolina\Entity\ProductInterface $product
     *
     * @param boolean $andFlush
     */
    function persistProduct(ProductInterface $product, $andFlush = false)
    {
        // TODO: Implement persistProduct() method.
    }

    /**
     * Update a Product that has been persisted and optionally flush that link.
     * Systems that allow for a delayed flush can use the $andFlush parameter, other
     * systems would disregard the flag. The success of the process is returned.
     *
     * @param Vespolina\Entity\ProductInterface $product
     *
     * @param boolean $andFlush
     */
    function updateProduct(ProductInterface $product, $andFlush = false)
    {
        $key = $product->getName(); //Hackish

        $this->products[$key] = $product;
    }


}
