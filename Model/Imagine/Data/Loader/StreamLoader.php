<?php
/**
 * This file is part of the planetubuntu package.
 *
 * (c) Daniel González <daniel@desarrolla2.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

use Imagine\Image\ImagineInterface;
use Liip\ImagineBundle\Imagine\Data\Loader\LoaderInterface;

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
     * Constructor.
     *
     * @param ImagineInterface $imagine
     */
    public function __construct(ImagineInterface $imagine)
    {
        $this->imagine = $imagine;
    }

    /**
     * @param mixed $path
     *
     * @return \Imagine\Image\ImageInterface
     */
    public function find($path)
    {
        $path = str_replace('http://', '', $path);

        return $this->imagine->load($this->getContent($path));
    }

    /**
     * @param $url
     *
     * @return mixed
     */
    function getContent($url)
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_URL, $url);
        $data = curl_exec($ch);
        curl_close($ch);

        return $data;
    }
}