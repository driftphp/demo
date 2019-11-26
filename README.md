# DriftPHP Demo

This is a simple Demo about how to use properly DriftPHP.

> Remember. This is a demo package. We encourage to make us PRs if you find some
> bugs, but we're not going to add new features unless is necessary. 

## Help US :heart:

Did you enjoy this demo? Do you think that this DriftPHP Framework deserves an
opportunity inside the ecosystem? Then easy. You can help us by making some
small actions

- Make a tweet with hashtag #driftPHP. Tell the world what did you see here
- :star: this demo
- :star: the [DriftPHP Skeleton](https://github.com/driftphp/skeleton) skeleton
- :star: the [DriftPHP HTTP Server](https://github.com/driftphp/server) repository
- :star: the [DriftPHP HTTP Kernel](https://github.com/driftphp/http-kernel) repository
  
## Description

This project is a sample for integrating Symfony and ReactPHP. The base of the
project is a simple and clean DriftPHP installation using `drift/skeleton`, so
that means that, if your code is built on top of that structure, you're a little
bit nearer than turning your project non-blocking.

In this case, we have build an HTTP key/value service, allowing us to store
string values under some keys, get that values and delete them. As simple as it
sounds.

```yml
/values/{key} GET
/values/{key} PUT
/values/{key} DELETE
```

We could have implemented the feature by using a regular DriftPHP installation,
by installing an Nginx and by using one of the existing Redis solutions for PHP.
That would have been the fastest and simplest solution, but we want a little bit
more.

- We want simplicity. No more Nginx for a simple server
- We want performance. Each ms matters. Really.
- We want a non-blocking implementation. If we have one long query, we don't
  want the server to be blocked
  
These are the prerequisites for that project, and by using this new
repositories, we can have everything you need here in one single server.

Let's check how.

## Installation

We can install the server by using composer. In this example, we will install
both the server and the redis implementation to make asynchronous Redis calls.


```yaml
"require": {
    ...
    
    "drift/http-kernel": "^0.1",
    "drift/server": "^0.1",
    "drift/react-functions": "^0.1",
    "clue/redis-react": "^2.3"
},
```

Then, `composer update`.

If you want to install a new skeleton for your new project, you can use
`composer` to download a clean skeleton.

```bash
composer create-project -sdev drift/skeleton 
```

## Configuration

After installing the server, you should be able to find the `server` file under
the bin directory. This file is ready to be used in the command line, in a
DockerFile or in any other environment.

Each DriftPHP application has a kernel. You will find it under `Drift/` folder.
If you check the class, you will find that this kernel extends the Symfony
component one. So we must change that in order to give your application an
asynchronous behavior.

```php
namespace App;

use Drift\HttpKernel\AsyncKernel;
use Symfony\Bundle\FrameworkBundle\Kernel\MicroKernelTrait;

/**
 * My app kernel
 */
class Kernel extends AsyncKernel
{
    use MicroKernelTrait;
    ...
}
```

And that's it. Our application is properly configured.

> Redis connects at localhost in default port. You can change that configuration
> by changing the hardcoded service definition inside `Drift/config/services.yml`
> file

## Creating a new Controller

This is the easiest part of all. You can create controllers the same way you've
done until now, but the **only** difference is that, hereinafter, you won't
return Response instances, but Promises that, once resolved, will return a
Response object.

Let's take a look at `GetValueController` code. This is the response code for
the controller called method. This Redis client is asynchronous, so each time
you call a method, for example `->get($key)` you don't get a value, but a
promise. 

```php
namespace App\Controller;

use App\Redis\RedisWrapper;
use React\Promise\PromiseInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class GetValueController
 */
class GetValueController
{
    /**
     * @var RedisWrapper
     *
     * Redis Wrapper
     */
    private $redisWrapper;

    /**
     * PutValueController constructor.
     *
     * @param RedisWrapper $redisWrapper
     */
    public function __construct(RedisWrapper $redisWrapper)
    {
        $this->redisWrapper = $redisWrapper;
    }

    /**
     * Invoke
     *
     * @param Request $request
     *
     * @return PromiseInterface
     */
    public function __invoke(Request $request)
    {
        $key = $request
            ->attributes
            ->get('key');

        return $this
            ->redisWrapper
            ->getClient()
            ->get($key)
            ->then(function($value) use ($key) {
                return new JsonResponse(
                    [
                        'key' => $key,
                        'value' => is_string($value)
                            ? $value
                            : null,
                    ],
                    200
                );
            });
    }
}
```

When the promise is resolved, the `then` method is called with the given result
as a unique parameter. Once we have this value, we return a `JsonResponse`
instance inside the callback.

And because a `->then()` method returns a new Promise, and we're returning
directly this value, the kernel receives a Promise and not a value. And that's
it. The server should take care of the rest

## Starting the server

Simple. You only need a port, and that should be enough

```bash
vendor/bin/server run 0.0.0.0:8100
```

By default, the server is started with `prod` environment and with the debug
disabled. You can change this behavior with some flags. You can also silence
the output and disable the requests report.

```bash
vendor/bin/server run 0.0.0.0:8100 --dev --debug
```

You can start the server with an already built-in watcher. Simple,

```bash
vendor/bin/server watch 0.0.0.0:8100
```


## Testing the app

Let's test the app. In these lines, we assume that we use the default redis
configuration, in prod mode and with debug disabled. The server is properly
installed in `127.0.0.1:8100`

* Get non existing key (Server response time: **~500μs**)

```bash
curl -i -XGET localhost:8100/values/mykey

HTTP/1.1 200 OK
cache-control: no-cache, private
date: Thu, 09 May 2019 18:39:56 GMT
content-type: application/json
X-Powered-By: React/alpha
Content-Length: 26
Connection: close

{"key":"key","value":null}
```

* Put new value under a new key (Server response time: **~500μs**)

```bash
curl -i -XPUT -H 'Content-Type: application/json' localhost:8100/values/mykey -d'myvalue'

HTTP/1.1 200 OK
cache-control: no-cache, private
date: Thu, 09 May 2019 18:44:03 GMT
content-type: application/json
X-Powered-By: React/alpha
Content-Length: 48
Connection: close

{"key":"mykey","value":"myvalue","message":"OK"}
```

* Get existing key (Server response time: **~500μs**)

```bash
curl -i -XGET localhost:8100/values/mykey

HTTP/1.1 200 OK
cache-control: no-cache, private
date: Thu, 09 May 2019 18:45:17 GMT
content-type: application/json
X-Powered-By: React/alpha
Content-Length: 33
Connection: close

{"key":"mykey","value":"myvalue"}
```

* Delete existing key (Server response time: **~500μs**)

```bash
curl -i -XDELETE localhost:8100/values/mykey

HTTP/1.1 200 OK
cache-control: no-cache, private
date: Thu, 09 May 2019 18:47:03 GMT
content-type: application/json
X-Powered-By: React/alpha
Content-Length: 29
Connection: close

{"key":"mykey","message":"1"}
```
