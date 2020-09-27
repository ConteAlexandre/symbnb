<?php

namespace App\DataFixtures;

use App\Entity\Ad;
use App\Entity\Booking;
use App\Entity\Image;
use App\Entity\Role;
use App\Entity\Users;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class AppFixtures extends Fixture
{
    private $passwordEncoder;

    public function __construct(UserPasswordEncoderInterface $passwordEncoder)
    {
        $this->passwordEncoder = $passwordEncoder;
    }

    public function load(ObjectManager $manager)
    {
        $faker = Factory::create('en_US');

        $adminRole = new Role();
        $adminRole->setTitle('ROLE_ADMIN');
        $manager->persist($adminRole);

        $adminUser = new Users();
        $adminUser->setFirstName('Michel')
            ->setLastName('Michel')
            ->setEmail('michel@example.com')
            ->setPassword($this->passwordEncoder->encodePassword($adminUser, 'michel'))
            ->setPicture('https://avatar.io/twitter/LiiorC')
            ->setIntroduction($faker->sentence())
            ->setDescription('<p>' . join('</p><p>', $faker->paragraphs(3)) . '</p>')
            ->addUserRole($adminRole)
            ->setSalt(rtrim(str_replace('+', '.', base64_encode(random_bytes(32))), '='));
        $manager->persist($adminUser);

        // Manage Users
        $users = [];
        $genders = ['male', 'female'];

        for ($i = 1; $i <= 10; $i++) {
            $user = new Users();

            $gender = $faker->randomElement($genders);

            $picture = "https://randomuser.me/api/portraits/";
            $pictureId = $faker->numberBetween(1, 99) . '.jpg';

            $picture .= ($gender == 'male' ? 'men/' : 'women/') . $pictureId;

            $password = $this->passwordEncoder->encodePassword($user, 'password');

            $user->setFirstName($faker->firstName)
                ->setLastName($faker->lastName)
                ->setEmail($faker->email)
                ->setIntroduction($faker->sentence())
                ->setDescription('<p>' . join('</p><p>', $faker->paragraphs(3)) . '</p>')
                ->setPassword($password)
                ->setPicture($picture)
                ->setSalt(rtrim(str_replace('+', '.', base64_encode(random_bytes(32))), '='));

            $manager->persist($user);
            $users[] = $user;
        }

        // Manage Announcements
        for ($i = 1; $i < 30; $i++) {
            $ad = new Ad();

            $title = $faker->sentence();
            $coverImage = $faker->imageUrl(1000, 350, 'city');
            $introduction = $faker->paragraph(2);
            $content = '<p>' . join('</p><p>', $faker->paragraphs(5)) . '</p>';

            $user = $users[mt_rand(0, count($users) - 1)];

            $ad->setTitle($title)
                ->setCoverImage($coverImage)
                ->setIntroduction($introduction)
                ->setContent($content)
                ->setPrice(mt_rand(40, 200))
                ->setRooms(mt_rand(3, 8))
                ->setAuthor($user);

            for ($j = 1; $j <= mt_rand(2, 5); $j++) {
                $image = new Image();

                $image->setUrl($faker->imageUrl())
                    ->setCaption($faker->sentence())
                    ->setAd($ad);

                $manager->persist($image);
            }

            // Manage Booking
            for ($j = 1; $j <= mt_rand(0, 10); $j++) {
                $booking = new Booking();

                $startDate = $faker->dateTimeBetween('-3 months');
                $duration = mt_rand(3, 10);
                $endDate = (clone $startDate)->modify("+$duration days");
                $amount = $ad->getPrice() * $duration;
                $comment = $faker->paragraph();

                $booker = $users[mt_rand(0, count($users) - 1)];

                $booking
                    ->setBooker($booker)
                    ->setAd($ad)
                    ->setStartDate($startDate)
                    ->setEndDate($endDate)
                    ->setAmount($amount)
                    ->setComment($comment);
                $manager->persist($booking);
            }

            $manager->persist($ad);
        }
        $manager->flush();
    }
}
