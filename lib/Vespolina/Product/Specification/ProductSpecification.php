<?php

namespace Vespolina\Product\Specification;
use Vespolina\Entity\Taxonomy\TaxonomyNode;
use Vespolina\Entity\Taxonomy\TaxonomyNodeInterface;
use Vespolina\Product\Specification\ProductSpecificationInterface;
use Vespolina\Entity\Product\ProductInterface;

class ProductSpecification extends BaseSpecification implements ProductSpecificationInterface
{

    public function isSatisfiedBy(ProductInterface $product)
    {
        foreach ($this->operands as $specification) {
            if (!$specification->isSatisfiedBy($product)) {

                return false;
            }
        }

        return true;
    }

    public function attributeEquals($name, $value)
    {

        return $this;
    }
    public function attributeContains($name, $value)
    {

        return $this;
    }

    public function equals($name, $value)
    {
        $this->addOperand(new FilterSpecification($name, $value));

        return $this;
    }

    public function getOperands()
    {
        return $this->operands;
    }

    public function withPriceRange($name, $fromValue, $toValue)
    {
        $this->addOperand(new PriceSpecification($name, $fromValue, $toValue));

        return $this;
    }

    public function withTaxonomyNode(TaxonomyNodeInterface $node)
    {
        return $this;
    }
}
