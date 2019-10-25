<?php

namespace Xtrcode\Filesystem;

use GuzzleHttp\Client;
use GuzzleHttp\HandlerStack;
use Illuminate\Support\Arr;
use Illuminate\Support\ServiceProvider;
use League\Flysystem\Config;
use League\Flysystem\Filesystem;
use OpenStack\Common\Transport\Utils as TransportUtils;
use OpenStack\Identity\v2\Service;
use OpenStack\OpenStack;

class SwiftServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application events.
     *
     * @return void
     */
    public function boot()
    {
        $this->app['filesystem']->extend('swift', function ($app, $config) {
            $options = $this->getOsOptions($config);
            $container = (new OpenStack($options))
                ->objectStoreV1()
                ->getContainer($config['container']);

            $prefix = Arr::get($config, 'prefix', null);
            $url = Arr::get($config, 'url', null);
            $adapter = new SwiftAdapter($container, $prefix, $url);

            return new Filesystem($adapter, $this->getFlyConfig($config));
        });
    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Get the OpenStack options.
     *
     * @param  array  $config
     *
     * @return array
     */
    protected function getOsOptions($config)
    {
        $authUrl = $config['authUrl'];
        $httpClient = new Client([
            'base_uri' => TransportUtils::normalizeUrl($authUrl),
            'handler'  => HandlerStack::create(),
        ]);
        $options = [
            'authUrl'          => $authUrl,
            'region'           => $config['region'],
            'username'         => $config['user'],
            'password'         => $config['password'],
            'tenantName'       => $config['tenantName'],
            'identityService'  => Service::factory($httpClient),
            'debugLog'         => Arr::get($config, 'debugLog', false),
            'logger'           => Arr::get($config, 'logger', null),
            'messageFormatter' => Arr::get($config, 'messageFormatter', null),
            'requestOptions'   => Arr::get($config, 'requestOptions', []),
        ];

        if (array_key_exists('projectId', $config)) {
            $options['scope'] = ['project' => ['id' => $config['projectId']]];
        }

        return $options;
    }

    /**
     * Create the Flysystem configuration.
     *
     * @param  array  $config
     *
     * @return Config
     */
    protected function getFlyConfig($config)
    {
        $flyConfig = new Config([
            'disable_asserts' => Arr::get($config, 'disableAsserts', false),
        ]);

        $passThroughConfig = [
            'swiftLargeObjectThreshold',
            'swiftSegmentSize',
            'swiftSegmentContainer',
        ];

        foreach ($passThroughConfig as $key) {
            if (isset($config[$key])) {
                $flyConfig->set($key, $config[$key]);
            }
        }

        return $flyConfig;
    }
}
