<?php

namespace AppBundle\Entity;

use Brander\Bundle\EAVBundle\Entity as EAV;
use Doctrine\ORM\Mapping as ORM;

/**
 * Category
 *
 * @ORM\Table(name="category")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\CategoryRepository")
 */
class Category
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="title", type="string", length=80)
     */
    private $title;

    /**
     * @var int
     *
     * @ORM\Column(name="sort", type="integer", nullable=true)
     */
    private $sort;

    /**
     * @var EAV\AttributeSet
     * @ORM\ManyToOne(targetEntity="Brander\Bundle\EAVBundle\Entity\AttributeSet")
     * @ORM\JoinColumn(name="product_attribute_set", referencedColumnName="id", onDelete="CASCADE")
     * *Serializer\Expose()
     */
    protected $productSet;

    /**
     * @var EAV\AttributeSet
     * @ORM\ManyToOne(targetEntity="Brander\Bundle\EAVBundle\Entity\AttributeSet")
     * @ORM\JoinColumn(name="store_attribute_set", referencedColumnName="id", onDelete="CASCADE")
     * *Serializer\Expose()
     */
    protected $storeSet;

    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set title
     *
     * @param string $title
     *
     * @return Category
     */
    public function setTitle($title)
    {
        $this->title = $title;

        return $this;
    }

    /**
     * Get title
     *
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Set sort
     *
     * @param int $sort
     *
     * @return Category
     */
    public function setSort($sort)
    {
        $this->sort = $sort;

        return $this;
    }

    /**
     * Get sort
     *
     * @return int
     */
    public function getSort()
    {
        return $this->sort;
    }

    /**
     * @return EAV\AttributeSet
     */
    public function getProductSet()
    {
        return $this->productSet;
    }

    /**
     * @param EAV\AttributeSet $productSet
     * @return $this
     */
    public function setProductSet($productSet)
    {
        $this->productSet = $productSet;
        return $this;
    }

    /**
     * @return EAV\AttributeSet
     */
    public function getStoreSet()
    {
        return $this->storeSet;
    }

    /**
     * @param EAV\AttributeSet $storeSet
     */
    public function setStoreSet($storeSet)
    {
        $this->storeSet = $storeSet;
    }

}

