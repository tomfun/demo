<?php
namespace AppBundle\DataFixtures\ORM;

use AppBundle\Entity\Store;
use Brander\Bundle\EAVBundle\DataFixtures\AbstractFixture;
use Brander\Bundle\EAVBundle\Entity\Attribute;
use Brander\Bundle\EAVBundle\Entity\AttributeGroup;
use Brander\Bundle\EAVBundle\Entity\AttributeSelect;
use Brander\Bundle\EAVBundle\Entity\AttributeSelectOption;
use Brander\Bundle\EAVBundle\Service\Holder;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\Yaml\Yaml;

/**
 * Тестовые магазины
 */
class LoadStoreData extends AbstractFixture
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
     * @return Store[]
     */
    public static function getArray(AbstractFixture $fixture) {
        $res = [];
        foreach(range(0, static::$itemCount - 1) as $i) {
            $res[] = $fixture->getReference('app-store-' . $i);
        }
        return $res;
    }

    /**
     * {@inheritdoc}
     */
    public function loadFixture(ObjectManager $manager)
    {
        $progressHelper = AbstractFixture::getProgressBar(2.6 * LoadCategoryData::getItemCount());

        $i = static::$itemCount;
        foreach (LoadCategoryData::getArray($this) as $category) {
            foreach (range(1, mt_rand(1, 4)) as $itemNumber) {
                $store = $this->createStore($manager);
                $store->setCategory($category);
                $this->setEavValues($store);

                $manager->persist($store);
                $this->setReference('app-store-' . $i++, $store);
                if ($progressHelper) {
                    $progressHelper->advance();
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
     * @return Store
     */
    private function createStore(ObjectManager $manager)
    {
        $store = new Store();
        $store
            ->setGrace($this->faker->numberBetween(-10, 10))
            ->setTitle($this->faker->firstNameFemale)
            ->setDescription($this->faker->address);

        return $store;
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
        return 2;
    }
}
