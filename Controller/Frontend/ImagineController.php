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

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Imagine\Exception\RuntimeException;
use Liip\ImagineBundle\Imagine\Cache\CacheManager;
use Liip\ImagineBundle\Imagine\Data\DataManager;
use Liip\ImagineBundle\Imagine\Filter\FilterManager;
use Liip\ImagineBundle\Exception\Binary\Loader\NotLoadableException;
use Liip\ImagineBundle\Imagine\Cache\SignerInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use FastFeed\Url\Url;

/**
 * ImagineController
 */
class ImagineController extends Controller
{
    /**
     * @var DataManager
     */
    protected $dataManager;

    /**
     * @var FilterManager
     */
    protected $filterManager;

    /**
     * @var CacheManager
     */
    protected $cacheManager;

    /**
     * @var SignerInterface
     */
    protected $signer;

    /**
     * @param DataManager   $dataManager
     * @param FilterManager $filterManager
     * @param CacheManager  $cacheManager
     */
    public function __construct(
        DataManager $dataManager,
        FilterManager $filterManager,
        CacheManager $cacheManager
    ) {
        $this->dataManager = $dataManager;
        $this->filterManager = $filterManager;
        $this->cacheManager = $cacheManager;
    }

    /**
     * @param Request $request
     * @param string $path
     * @param string $filter
     *
     * @return \Symfony\Component\HttpFoundation\Response
     * @throws
     */
    public function filterAction(Request $request, $path, $filter)
    {
        $path = new Url($path);
        $path->resetParameters();
        $filename = $this->getFileName($path->toString());

        try {
            try {
                if (!$this->cacheManager->isStored($path, $filter)) {
                    try {
                        $binary = $this->dataManager->find($filter, $path);
                    } catch (NotLoadableException $e) {
                        throw new NotFoundHttpException('Source image could not be found', $e);
                    }

                    $this->cacheManager->store(
                        $this->filterManager->applyFilter($binary, $filter),
                        $filename,
                        $filter
                    );
                }

                return new RedirectResponse($this->cacheManager->resolve($filename, $filter), 301);
            } catch (RuntimeException $e) {
                throw new \RuntimeException(sprintf(
                    'Unable to create image for path "%s" and filter "%s". Message was "%s"',
                    $path,
                    $filter,
                    $e->getMessage()
                ), 0, $e);
            }
        } catch (\Exception $e) {
            throw $e;
            //throw new NotFoundHttpException('The image does not exist');
        }
    }

    /**
     * @param string $path
     *
     * @return string
     */
    private function getFileName($path)
    {
        $explode = explode('.', $path);
        $extension = array_pop($explode);
        $filename = sha1($path) . '.' . $extension;

        return substr($filename, 0, 2) . '/' .
        substr($filename, 2, 2) . '/' .
        substr($filename, 4, 2) . '/' .
        substr($filename, 6);
    }
}
