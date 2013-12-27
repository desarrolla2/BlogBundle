<?php
/**
 * This file is part of the desarrolla2/blog-bundle package.
 *
 * (c) Daniel González <daniel@desarrolla2.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace Desarrolla2\Bundle\BlogBundle\Form\Backend\Handler;

use Desarrolla2\Bundle\BlogBundle\Entity\Banner;

/**
 * BannerHandler
 */
class BannerHandler extends AbstractHandler
{

    /**
     * @param Banner $entity
     *
     * @return bool
     */
    public function process(Banner $entity)
    {
        $this->form->submit($this->request);
        if ($this->form->isValid()) {
            $entityModel = $this->form->getData();

            $entity->setName($entityModel->getName());
            $entity->setContent($entityModel->getContent());
            $entity->setWeight($entityModel->getWeight());
            $entity->setIsPublished($entityModel->getIsPublished());

            $this->em->persist($entity);
            $this->em->flush();

            return true;
        }

        return false;
    }
} 