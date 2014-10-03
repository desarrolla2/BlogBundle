<?php
/**
 * This file is part of the planetubuntu package.
 *
 * (c) Daniel González <daniel@desarrolla2.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Desarrolla2\Bundle\BlogBundle\Imagine\Data\Loader;

use Imagine\Image\ImagineInterface;
use Liip\ImagineBundle\Binary\Loader\LoaderInterface;

/**
 * StreamLoader
 */
class StreamLoader implements LoaderInterface
{

    /**
     * @var ImagineInterface
     */
    protected $imagine;

    /**
     * @var string|bool
     */
    protected $defaultImage;

    /**
     * Constructor.
     *
     * @param ImagineInterface $imagine
     * @param string|bool      $defaultImage
     */
    public function __construct(ImagineInterface $imagine, $defaultImage = false)
    {
        $this->imagine = $imagine;
        $this->defaultImage = $defaultImage;
    }

    /**
     * @param mixed $path
     *
     * @return \Imagine\Image\ImageInterface
     */
    public function find($path)
    {
        try {
            return $this->imagine->load(
                $this->getContent($path)
            );
        } catch (\  Exception $e) {
            return $this->imagine->load(
                $this->getContent($this->defaultImage)
            );
        }
    }

    /**
     * @param $url
     *
     * @return mixed
     */
    function getContent($url)
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        $data = curl_exec($ch);
        curl_close($ch);

        return $data;
    }
}