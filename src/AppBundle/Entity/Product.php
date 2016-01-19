<?php

namespace AppBundle\Entity;

use Brander\Bundle\EAVBundle\Entity\AttributeSet;
use Brander\Bundle\EAVBundle\Model\ExtensibleEntityInterface;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Brander\Bundle\EAVBundle\Entity as EAV;

/**
 * Product
 *
 * @ORM\Table(name="product")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\ProductRepository")
 */
class Product implements ExtensibleEntityInterface
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
     * @ORM\Column(name="price", type="decimal", precision=10, scale=2)
     */
    private $price;

    /**
     * @var string
     *
     * @ORM\Column(name="sku", type="string", length=50, unique=true)
     */
    private $sku;

    /**
     * @var string
     *
     * @ORM\Column(name="title", type="string", length=50)
     */
    private $title;

    /**
     * @var Category
     *
     * @ORM\ManyToOne(targetEntity="Category")
     */
    private $category;

    /**
     * @var Store
     *
     * @ORM\ManyToOne(targetEntity="Store")
     */
    private $store;

    /**
     * @ORM\ManyToMany(targetEntity="\Brander\Bundle\EAVBundle\Entity\Value", cascade={"all"})
     * @ORM\JoinTable(name="product_attribute_values",
     *      joinColumns={
     *          @ORM\JoinColumn(name="advert_id", referencedColumnName="id", onDelete="CASCADE")
     *      },
     *      inverseJoinColumns={
     *          @ORM\JoinColumn(name="value_id", referencedColumnName="id", onDelete="CASCADE")
     *      }
     * )
     * *Serializer\Type("array<Brander\Bundle\EAVBundle\Entity\Value>")
     * @var EAV\Value[]|Collection
     * *Serializer\Groups({"=((g('view') || g('list'))&& read) || g('create') || g('admin')"})
     */
    protected $values;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->setValues(new ArrayCollection());
    }

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
     * Set price
     *
     * @param string $price
     *
     * @return Product
     */
    public function setPrice($price)
    {
        $this->price = $price;

        return $this;
    }

    /**
     * Get price
     *
     * @return string
     */
    public function getPrice()
    {
        return $this->price;
    }

    /**
     * Set sku
     *
     * @param string $sku
     *
     * @return Product
     */
    public function setSku($sku)
    {
        $this->sku = $sku;

        return $this;
    }

    /**
     * Get sku
     *
     * @return string
     */
    public function getSku()
    {
        return $this->sku;
    }

    /**
     * Set title
     *
     * @param string $title
     *
     * @return Product
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
     * @return Category
     */
    public function getCategory()
    {
        return $this->category;
    }

    /**
     * @param Category $category
     * @return $this
     */
    public function setCategory($category)
    {
        $this->category = $category;
        return $this;
    }

    /**
     * @return Store
     */
    public function getStore()
    {
        return $this->store;
    }

    /**
     * @param Store $store
     * @return $this
     */
    public function setStore($store)
    {
        $this->store = $store;
        return $this;
    }

    /**
     * @return EAV\Value[]|Collection
     */
    public function getValues()
    {
        return $this->values;
    }

    /**
     * @param EAV\Value[]|Collection $values
     */
    public function setValues($values)
    {
        $this->values = $values;
    }

    /**
     * @return AttributeSet
     */
    public function getAttributeSet()
    {
        $cat = $this->getCategory();
        if (!$cat) {
            return null;
        }
        return $cat->getProductSet();
    }
}

