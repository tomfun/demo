<?php
namespace AppBundle\DataFixtures\ORM;

use AppBundle\Entity\Category;
use Brander\Bundle\EAVBundle\DataFixtures\AbstractFixture;
use Brander\Bundle\EAVBundle\Entity\Attribute;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\Yaml\Yaml;

/**
 * Тестовые категории
 */
class LoadCategoryData extends AbstractFixture
{
    /**
     * @return int
     */
    public static function getItemCount() {
        return static::$itemCount;
    }

    protected static $itemCount = 0;

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
     * @return Category[]
     */
    public static function getArray(AbstractFixture $fixture) {
        $res = [];
        foreach(range(0, static::$itemCount - 1) as $i) {
            $res[] = $fixture->getReference('app-category-' . $i);
        }
        return $res;
    }

    /**
     * {@inheritdoc}
     */
    public function loadFixture(ObjectManager $manager)
    {
        $i = static::$itemCount;
        foreach (range(1, 10) as $itemNumber) {
            $category = $this->createCategory($manager);

            $manager->persist($category);
            $this->setReference('app-category-' . $i++, $category);
        }
        static::$itemCount = $i;
        $manager->flush();
    }


    /**
     * @param ObjectManager $manager
     * @return Category
     */
    private function createCategory(ObjectManager $manager)
    {
        $category = new Category();
        $category
            ->setSort($this->faker->randomDigit)
            ->setTitle($this->faker->domainName);

        return $category;
    }

    /**
     * @return array
     */
    private function getData()
    {
        return Yaml::parse(file_get_contents(
                               $this->getContainer()->getParameter('brander_eav.fixtures_directory') . '/attributes.yml'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getOrder()
    {
        return 0;
    }
}
