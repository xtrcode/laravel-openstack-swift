<?php

namespace Xtrcode\Filesystem;

use Nimbusoft\Flysystem\OpenStack\SwiftAdapter as BaseAdapter;
use OpenStack\ObjectStore\v1\Models\Container;

class SwiftAdapter extends BaseAdapter
{
    /**
     * Optional base URL to use for this adapter.
     *
     * @var string
     */
    protected $url;

    /**
     * Constructor
     *
     * @param  Container  $container
     * @param  string  $prefix
     */
    public function __construct(Container $container, $prefix = null, $url = null)
    {
        parent::__construct($container, $prefix);
        $this->url = rtrim($url, '/');
    }

    /**
     * Get the URL for the file at the given path.
     *
     * @param  string  $path
     * @return string
     */
    public function getUrl($path)
    {
        if ($this->url) {
            return "{$this->url}/{$path}";
        }

        return $this->container->getObject($path)->getPublicUri();
    }
}
