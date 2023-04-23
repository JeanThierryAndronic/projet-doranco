<?php

namespace App\DataFixtures;

use App\Entity\Categories;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\String\Slugger\SluggerInterface;

class CategoriesFixtures extends Fixture
{
    private $counter = 1;

    public function __construct(private SluggerInterface $slugger){}

    public function load(ObjectManager $manager): void
    {
        $parent = $this->createCategory('Meubles', null, $manager);
        
        $this->createCategory('Salon', $parent, $manager);
        $this->createCategory('Salle a manger', $parent, $manager);
        $this->createCategory('Chambre', $parent, $manager);

        $parent = $this->createCategory('Mobilier design', null, $manager);

        $this->createCategory('Canapes', $parent, $manager);
        $this->createCategory('Tables et chaises', $parent, $manager);
        $this->createCategory('Literie', $parent, $manager);
                
        $manager->flush();
    }

    public function createCategory(string $name, Categories $parent = null, ObjectManager $manager)
    {
        $category = new Categories();
        $category->setName($name);
        $category->setSlug($this->slugger->slug($category->getName())->lower());
        $category->setParent($parent);
        $manager->persist($category);

        $this->addReference('cat-'.$this->counter, $category);
        $this->counter++;

        return $category;
    }
}