<?php
/**
 * This file is part of the planetubuntu package.
 *
 * (c) Daniel González <daniel@desarrolla2.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace Desarrolla2\Bundle\BlogBundle\Manager;

/**
 * SanitizerManager
 */
class SanitizerManager
{
    /**
     * @param null $cacheDirectory
     *
     * @throws \InvalidArgumentException
     */
    public function __construct($cacheDirectory = null)
    {
        if (!$cacheDirectory) {
            $cacheDirectory = realpath(sys_get_temp_dir());
        }

        if (!is_writable($cacheDirectory)) {
            throw new \InvalidArgumentException($cacheDirectory . ' is not writable');
        }
        // require to configure some CONSTANST
        new \HTMLPurifier_Bootstrap();
        $config = \HTMLPurifier_Config::createDefault();
        $config->set('Cache.SerializerPath', $cacheDirectory);
        $this->purifier = new \HTMLPurifier($config);
    }

    public function doClean($string)
    {
        return $this->purifier->purify($string);
    }
} 