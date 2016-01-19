<?php
namespace AppBundle\DataFixtures\ORM;

use AppBundle\Entity\Product;
use Brander\Bundle\EAVBundle\Entity as EAV;
use Brander\Bundle\EAVBundle\DataFixtures\AbstractFixture;
use Brander\Bundle\EAVBundle\Model\GeoLocation;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\Yaml\Yaml;

/**
 * Тестовые продукты
 */
class LoadProductData extends AbstractFixture
{
    protected static $itemCount = 0;

    protected static $productCount = 5;

    /**
     * @return int
     */
    public static function getItemCount()
    {
        return static::$itemCount;
    }

    private static function getProductCount()
    {
        return self::$productCount * LoadCategoryData::getItemCount() * LoadStoreData::getItemCount();
    }

    /**
     * @var \Faker\Generator
     */
    private $faker;

    /**
     * {@inheritdoc}
     */
    public function initialize(ContainerInterface $container)
    {
        $this->faker = $this->getFaker();
    }

    /**
     * @return bool
     */
    public function isEnabled()
    {
        return true;
    }

    /**
     * @param AbstractFixture $fixture
     * @return Product[]
     */
    public static function getArray(AbstractFixture $fixture)
    {
        $res = [];
        foreach (range(0, static::$itemCount - 1) as $i) {
            $res[] = $fixture->getReference('app-product-' . $i);
        }
        return $res;
    }

    /**
     * {@inheritdoc}
     */
    public function loadFixture(ObjectManager $manager)
    {
        $progressHelper = AbstractFixture::getProgressBar(static::getProductCount());

        $i = static::$itemCount;
        foreach (LoadCategoryData::getArray($this) as $category) {
            foreach (LoadStoreData::getArray($this) as $store) {
                foreach (range(1, self::$productCount) as $itemNumber) {
                    $product = $this->createProduct($manager);

                    $product
                        ->setCategory($category)
                        ->setStore($store);

                    $this->setEavValues($product);

                    $manager->persist($product);
                    $this->setReference('app-product-' . $i++, $product);
                    if ($progressHelper) {
                        $progressHelper->advance();
                    }
                }
            }
        }
        static::$itemCount = $i;
        $manager->flush();
        if ($progressHelper) {
            AbstractFixture::getOutput()->writeln('');
        }
    }


    /**
     * @param ObjectManager $manager
     * @return Product
     */
    private function createProduct(ObjectManager $manager)
    {
        $product = new Product();
        $product
            ->setPrice($this->faker->numberBetween(1, 99) * 10)
            ->setTitle($this->faker->firstNameMale)
            ->setSku($this->faker->citySuffix . (mt_rand(0, 10000000)));

        return $product;
    }

    /**
     * @return array
     */
    private function getData()
    {
        return Yaml::parse(file_get_contents(
            $this->getContainer()->getParameter(
                'brander_eav.fixtures_directory'
            ) . '/attribute_groups.yml'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getOrder()
    {
        return 3;
    }
}
