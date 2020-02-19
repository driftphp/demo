# DriftPHP Demo

This is a simple Demo about how to use properly DriftPHP. Please, read carefully
our [Documentation](https://drift.io) in order to understand the rationale
behind each functionality.

<p align="center">
  <img src="public/driftphp.png">
</p>

> Remember. This is a demo package. We encourage to make us PRs if you find some
> bugs, but we're not going to add new features unless is necessary. 

## Help US :heart:

Did you enjoy this demo? Do you think that this DriftPHP Framework deserves an
opportunity inside the ecosystem? Then easy. You can help us by making some
small actions

- Make a tweet with hashtag #driftPHP. Tell the world what did you see here
- :star: our used components by doing just `composer thanks`

You can join our small community in 
[DriftPHP in Gitter](https://gitter.im/driftphp/community) if you have any
issue or question around this project. We will be very happy to say hello :)
  
## Description

This project is a sample for integrating Symfony and ReactPHP. The base of the
project is a simple and clean DriftPHP installation using `drift/skeleton`, so
that means that, if your code is built on top of that structure, you're a little
bit nearer than turning your project non-blocking.

In this case, we have build an HTTP key/value service, allowing us to store
string values under some keys, get that values and delete them. As simple as it
sounds. We will use Twig as well to render some small templates with some of
this stored information.

```yml
/ GET
/{key} GET
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

## Installation - Docker Compose

You can start using this demo by using `docker-compose`. As easy as it sounds.

```bash
docker-compose up --build
```

Once the whole environment is up and running, you'll be able to request the
server by accessing the port `8000`

```bash
curl http://127.0.0.1:8000/
```

> You can change the exposed port in the `docker-composer.yml` file, changing
> the first part of the line `8000:8000`. For example, if you want to expose 
> this demo to port 9000, change the line to `9000:8000` and run it again

## Testing the app

Let's test the app. In these lines, we assume that we use the default redis
configuration, in prod mode and with debug disabled. The server is properly
installed in `127.0.0.1:8000`

* Get non existing key (Server response time: **~500μs**)

```bash
curl -i -XGET localhost:8000/values/mykey

HTTP/1.1 404 Not Found
cache-control: no-cache, private
date: Sat, 25 Jan 2020 17:23:33 GMT
content-type: text/html; charset=UTF-8
X-Powered-By: React/alpha
Content-Length: 0
Connection: close
```

* Put new value under a new key (Server response time: **~500μs**)

```bash
curl -i -XPUT -H 'Content-Type: application/json' localhost:8000/values/mykey -d'myvalue'

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
curl -i -XGET localhost:8000/values/mykey

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
curl -i -XDELETE localhost:8000/values/mykey

HTTP/1.1 200 OK
cache-control: no-cache, private
date: Thu, 09 May 2019 18:47:03 GMT
content-type: application/json
X-Powered-By: React/alpha
Content-Length: 29
Connection: close

{"key":"mykey","message":"1"}
```

* You can even see two small rendered pages using Twig as the templating engine.
On one hand you can see all keys and values from our system, accessing through
your browser to `http://127.0.0.1:8000/`, and if you click any of these lines,
you will see the unique page of this key value at `http://127.0.0.1:8000/mykey`.
Server response is exactly the same than previous requests, even using Twig. 