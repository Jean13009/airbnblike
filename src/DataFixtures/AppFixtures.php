<?php

namespace App\DataFixtures;

use App\Entity\Ad;
use Faker\Factory;
use App\Entity\Role;
use App\Entity\User;
use App\Entity\Image;
use App\Entity\Booking;
use App\Entity\Comment;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class AppFixtures extends Fixture
{
    private $encoder;
    
    public function __construct(UserPasswordEncoderInterface $encoder) {
        $this->encoder = $encoder;
    }
    
    public function load(ObjectManager $manager)
    {
        $faker = Factory::create('FR-fr');
        // Roles
        $adminRole = new Role();
        $adminRole->setTitle('ROLE_ADMIN');
        $manager->persist($adminRole);
        
        $adminUser = new User();
        $adminUser->setFirstName('Jean')
        ->setLastName('Jacques')
        ->setEmail('jo@jo.com')
        ->setHash($this->encoder->encodePassword($adminUser, 'password'))
        ->setPicture('http://image.noelshack.com/fichiers/2019/02/3/1547035743-telechargement.png')
        ->setIntroduction($faker->sentence())
        ->setDescription($faker->text( 200))
        ->addUserRole($adminRole);
        
        $manager->persist($adminUser);
        
        //Users
        $users = [];
        $genres = ['male', 'female'];
        
        for($i = 1; $i <= 10;$i++) {
            $user = new User();
            
            $genre = $faker->randomElement($genres);
            
            $picture = 'https://randomuser.me/api/portraits/';
            $pictureId = $faker->numberBetween(1, 99) . '.jpg';
            
            $picture .= ($genre == 'male' ? 'men/' : 'women/') . $pictureId;
            
            $hash = $this->encoder->encodePassword($user, 'password');
            
            $user->setFirstname($faker->firstname($genre))
            ->setLastName($faker->lastname)
            ->setEmail($faker->email)
            ->setIntroduction($faker->sentence())
            ->setDescription($faker->text( 200))
            ->setHash($hash)
            ->setPicture($picture);
            $manager->persist($user);
            $users[] = $user;
        }
        //Annonces
        for($i = 1; $i <= 30;$i++) {
            $ad = new Ad();
            
            $title = $faker->sentence();
            $coverImage = $faker->imageUrl(1000, 350);
            $introduction = $faker->paragraph(2);
            $content = '<p>' . join('</p><p>', $faker->paragraphs(5)) . '</p>';
            
            $user = $users[mt_rand(0, count($users) - 1)];
            
            $ad->setTitle($title)
            ->setCoverImage($coverImage)
            ->setIntroduction($introduction)
            ->setContent($content)
            ->setPrice(mt_rand(40, 200))
            ->setRooms(mt_rand(1, 5))
            ->setAuthor($user);
            
            for($j = 1; $j <= mt_rand(2, 5); $j++) {
                $image = new Image();
                
                $image->setUrl($faker->imageUrl())
                ->setCaption($faker->sentence())
                ->setAd($ad);
                $manager->persist($image);
                
            }
            
            // Ajout de réservations
            for($j = 1; $j <= mt_rand(0, 10); $j++) {
                $booking = new Booking();
                
                $createdAt = $faker->dateTimeBetween('-6 months');
                $startDate = $faker->dateTimeBetween('-3 months');
                
                $duration = mt_rand(3, 10);
                
                $endDate = (clone $startDate)->modify("+$duration days");
                $amount = $ad->getPrice() * $duration;
                $booker = $users[mt_rand(0, count($users) - 1)];
                
                $comment = $faker->paragraph();
                
                $booking->setBooker($booker)
                ->setAd($ad)
                ->setStartDate($startDate)
                ->setEndDate($endDate)
                ->setCreatedAt($createdAt)
                ->setAmount($amount)
                ->setComment($comment);
                
                $manager->persist($booking);

                // Gestion des commentaires
                if(mt_rand(0, 1)) {
                    $comment = new Comment();
                    $comment->setContent($faker->paragraph())
                    ->setRating(mt_rand(1, 5))
                    ->setAuthor($booker)
                    ->setAd($ad);
                    
                    $manager->persist($comment);
                }
            }
            
            $manager->persist($ad);
        }
        $manager->flush();
    }
}
