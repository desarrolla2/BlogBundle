<?php
/**
 * This file is part of the planetubuntu project.
 *
 * Copyright (c)
 *
 * This source file is subject to the MIT license that is bundled
 * with this package in the file LICENSE.
 */

namespace Desarrolla2\Bundle\BlogBundle\Tests\DataFixtures;

use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Desarrolla2\Bundle\BlogBundle\Entity\Post;
use Desarrolla2\Bundle\BlogBundle\Model\PostStatus;
use Symfony\Component\Validator\Constraints\DateTime;


/**
 * Class LoadPosts
 *
 * @author Daniel González <daniel.gonzalez@freelancemadrid.es>
 */

class LoadPosts implements FixtureInterface
{
    /**
     * @var \Faker\Generator
     */
    protected $faker;

    public function __construct()
    {
        $this->faker = \Faker\Factory::create();
    }

    /**
     * {@inheritDoc}
     */
    public function load(ObjectManager $manager)
    {
        $post = $this->createPost();

        $manager->persist($post);
        $manager->flush();
    }

    protected function createPost()
    {
        $date = new \DateTime();
        $post = new Post();
        $name = $this->faker->name;
        $post->setName($name);
        $post->setSlug(md5($name));
        $post->setIntro($this->faker->text);
        $post->setContent($this->faker->text);
        $post->setStatus(PostStatus::PUBLISHED);
        $post->setCreatedAt($date);
        $post->setUpdatedAt($date);

        return $post;
    }
}