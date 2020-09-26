<?php

namespace App\DataFixtures;

use App\Entity\Ad;
use Cocur\Slugify\Slugify;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $faker = Factory::create('en_US');
        $slugify = new Slugify();

        for ($i = 1; $i < 30; $i++) {
            $ad = new Ad();

            $title = $faker->sentence();
            $slug = $slugify->slugify($title);
            $coverImage = $faker->imageUrl(1000, 350);
            $introduction = $faker->paragraph(2);
            $content = '<p>'.join('</p><p>', $faker->paragraphs(5)). '</p>';

            $ad->setTitle($title)
                ->setSlug($slug)
                ->setCoverImage($coverImage)
                ->setIntroduction($introduction)
                ->setContent($content)
                ->setPrice(mt_rand(40, 200))
                ->setRooms(mt_rand(3, 8))
            ;

            $manager->persist($ad);
        }
        $manager->flush();
    }
}
