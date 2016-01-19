<?php

namespace AppBundle\Entity;

use Brander\Bundle\EAVBundle\Entity as EAV;
use Brander\Bundle\EAVBundle\Entity\AttributeSet;
use Brander\Bundle\EAVBundle\Model\ExtensibleEntityInterface;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * Store
 *
 * @ORM\Table(name="store")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\StoreRepository")
 */
class Store implements ExtensibleEntityInterface
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
     * @ORM\Column(name="title", type="string", length=127)
     */
    private $title;

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="string", length=255, nullable=true)
     */
    private $description;

    /**
     * @var int
     *
     * @ORM\Column(name="grace", type="integer")
     */
    private $grace;

    /**
     * @var Category
     *
     * @ORM\ManyToOne(targetEntity="Category")
     */
    private $category;

    /**
     * @ORM\ManyToMany(targetEntity="\Brander\Bundle\EAVBundle\Entity\Value", cascade={"all"})
     * @ORM\JoinTable(name="store_attribute_values",
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
     * Set title
     *
     * @param string $title
     *
     * @return Store
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
     * Set description
     *
     * @param string $description
     *
     * @return Store
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get description
     *
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Set grace
     *
     * @param int $grace
     *
     * @return Store
     */
    public function setGrace($grace)
    {
        $this->grace = $grace;

        return $this;
    }

    /**
     * Get grace
     *
     * @return int
     */
    public function getGrace()
    {
        return $this->grace;
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

