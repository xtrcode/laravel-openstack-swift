# Laravel OVH Object & Block Storage (OpenStack Swift)

OVH Object & Block Storage driver for Laravel/Lumen.

## Installation

Require the package with Composer:

```
composer require mzur/laravel-openstack-swift
```

### Laravel

For Laravel 5.4 and lower, add the service provider to `config/app.php`:

```php
Mzur\Filesystem\SwiftServiceProvider::class,
```

### Lumen

Add the service provider to `bootstrap/app.php`:
```php
$app->register(Mzur\Filesystem\SwiftServiceProvider::class);
```

## Configuration

Add a new storage disk to `config/filesystems.php` (using v2 of the identity API):

```php
'disks' => [
   'ovh' => [
      'driver' => 'swift',
      'authUrl'    => env('OS_AUTH_URL', ''),
      'region'     => env('OS_REGION_NAME', ''),
      'user'       => env('OS_USERNAME', ''),
      'domain'     => env('OS_USER_DOMAIN_NAME', 'default'),
      'password'   => env('OS_PASSWORD', ''),
      'container'  => env('OS_CONTAINER_NAME', ''),
      'tenantName' => env('OS_TENANT_NAME', ''),
   ],
]
```

Additional configuration options:

- `projectId` (default: `null`) if you want to scope access to a specific project

- `debugLog` (default: `false`), `logger` (default: `null`), `messageFormatter` (default: `null`) [[ref]](https://github.com/php-opencloud/openstack/issues/47#issuecomment-208181121)

- `requestOptions` (default: `[]`) [[ref]](https://github.com/php-opencloud/openstack/pull/63#issue-74731062)

- `disableAsserts` (default: `false`) [[ref]](https://flysystem.thephpleague.com/docs/advanced/performance/)

- `swiftLargeObjectThreshold` [[ref]](https://github.com/mzur/flysystem-openstack-swift#configuration)

- `swiftSegmentSize` [[ref]](https://github.com/mzur/flysystem-openstack-swift#configuration)

- `swiftSegmentContainer` [[ref]](https://github.com/mzur/flysystem-openstack-swift#configuration)

- `prefix` (default: `null`): Prefix to use for the names of the objects in the container.

- `url` (default: `null`): Override URL to use for public URLs to objects. If this is not set, the public URL will point to the public URL of Swift. This configuration is useful if you use a reverse proxy to pass through requests to public Swift containers.

## Credits
* [mzur](https://github.com/mzur) for the original [laravel-openstack-swift](https://github.com/mzur/laravel-openstack-swift) driver.

## (UN)LICENSE
This is free and unencumbered software released into the public domain.

Anyone is free to copy, modify, publish, use, compile, sell, or
distribute this software, either in source code form or as a compiled
binary, for any purpose, commercial or non-commercial, and by any
means.

In jurisdictions that recognize copyright laws, the author or authors
of this software dedicate any and all copyright interest in the
software to the public domain. We make this dedication for the benefit
of the public at large and to the detriment of our heirs and
successors. We intend this dedication to be an overt act of
relinquishment in perpetuity of all present and future rights to this
software under copyright law.

THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND,
EXPRESS OR IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF
MERCHANTABILITY, FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT.
IN NO EVENT SHALL THE AUTHORS BE LIABLE FOR ANY CLAIM, DAMAGES OR
OTHER LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE,
ARISING FROM, OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR
OTHER DEALINGS IN THE SOFTWARE.

For more information, please refer to <http://unlicense.org/>
