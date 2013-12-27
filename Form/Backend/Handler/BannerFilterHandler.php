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

use Symfony\Component\Form\Form;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\ORM\QueryBuilder;

/**
 * BannerFilterHandler
 */
class BannerFilterHandler extends AbstractFilterHandler
{
    /**
     *
     * @return boolean
     */
    public function process()
    {
        $this->form->submit($this->request);
        if ($this->form->isValid()) {
            $formData = $this->form->getData();
            if ($name = (string)$formData->name) {
                $this->qb->andWhere($this->qb->expr()->like('t.name', ':name'))
                    ->setParameter('name', '%' . $name . '%');
            }

            return true;
        }

        return false;
    }
} 