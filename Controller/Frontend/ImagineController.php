<?php
/**
 * This file is part of the planetubuntu package.
 *
 * (c) Daniel González <daniel@desarrolla2.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace Desarrolla2\Bundle\BlogBundle\Controller\Frontend;

use Liip\ImagineBundle\Controller\ImagineController as Controller;
use Symfony\Component\HttpFoundation\Request;
use FastFeed\Url\Url;

/**
 * ImagineController
 */
class ImagineController extends Controller
{
    /**
     * @param Request $request
     * @param string  $path
     * @param string  $filter
     *
     * @return \Symfony\Component\HttpFoundation\Response
     * @throws
     */
    public function filterAction(Request $request, $path, $filter)
    {
        $path = new Url($path);
        $path->resetParameters();

        try {
            return parent::filterAction($request, $path->toString(), $filter);
        } catch (\Exception $e) {
            throw $this->createNotFoundException('The image does not exist');
        }
    }

} 