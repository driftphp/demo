# DriftPHP Demo

This is a simple Demo about how to use properly DriftPHP. Please, read carefully
our [Documentation](https://driftphp.io) in order to understand the rationale
behind each functionality.

<p align="center">
  <img src="public/driftphp.png">
</p>

> Remember. This is a demo package. We encourage to make us PRs if you find some
> bugs, but we're not going to add new features unless is necessary.

This demo uses these DriftPHP packages
- Server
- Http Kernel
- Command Bus + AMQP Adapter
- Event Bus + AMQP Adapter
- Websocket
- Twig Adapter
- DBAL

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
./docker-compose-build.sh
```

Once the whole environment is up and running, you'll be able to request the
server by accessing the port `8000` through your browser.

```bash
http://127.0.0.1:8000/
```

> You can change the forwarded port by changing the values from the .env file  
>
> SERVER_PORT=8000  
> WEBSOCKET_PORT=1234

## The architecture

Please. Keep reading a bit more in order to understand how this application is
designed in terms of architecture. First of all, let's take a look at our
desired achievements.

- We basically want a service that saves key-value pairs in a persistent
database.
- We want to expose a basic API Rest (PUT, DELETE, GET) in order to be able to
interact with this persistence layer.
- We assume that the whole key-value data-set will be small enough to be stored
in memory, so we will design out application on top of events. Read from memory,
write to persistence layer.
- We want to expose a websocket where we will send some events. For now, each
time a key is added/updated or deleted, we will create a new domain event.
- Other websocket connections and disconnections will produce events as well.
- We want a landing page with real-time updated key-value database and domain
events.

Before continuing, take the next 2 minutes thinking how would you implement this
architecture using Laravel or Symfony. First of all, in these frameworks you
simply can't use memory as a local storage, so each read means a persistence
hit (yes, Redis is persistence as well). Working with a distributed set of
services and websockets would need external software pieces in order to work,
basically because Symfony (and all other frameworks) can't do more than one
thing at the same time.

Let's try with DriftPHP. In order to be able to do that, we will work with all
these containers, using the same networks and interacting among each other.

- RabbitMQ as a queues and exchanges system
- PostgreSQL as a persistence layer used as a driver in our DBAL configuration

- Tiny balancer, listening at port 8000 and balancing among next servers
- Server1 - DriftPHP server serving HTTP requests and subscribed to a temporary.
  Configured to Enqueue commands asynchronously
  exchange for domain events
- Server2 - Same than Server1
- Server3 - Same than Server1

- Command consumer - Consumes commands and dispatch domain events through the
  configured EventBus.
- Websocket - Exposes one websocket route in `/events` and dispatches all domain
  events in a documented format
  
So let's take a look at each action

### Put a value

You can put a value using the exposed api REST.

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

As you can see, you're using the port `8000`, what means that the balancer will
forward your request to one of the existing servers. This server will handle the
request and will execute a new Command through the command bus. Because the
command bus is configured to work asynchronously, instead of handling the
command, a middleware will enqueue it in a infrastructure queue (RabbitMQ using
AMQP protocol).

The command consumer will consume the command and will execute again the command
through the command bus, but in this case in the inline command bus (this one
just avoid the async middleware). That means that, in this case, the handler
will handle the command and will update our persistence layer (PostgreSQL) with
the new value.

After that, the handler will create a new domain event and this one will be
dispatched using the event bus. That means that all other network services
subscribed to this queue will receive this domain event.

In fact, our 3 servers and the websocket will receive this domain event,
allowing them all to reload a fresh copy of our data in memory (all key-values).
Each websocket connection will receive as well an update related to this domain
event, updating the local and displayed lists.

### Delete a value

In that case, we want to delete one of our values.

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

The workflow is exactly the same one than the *PUT* action. Both work exactly
the same way.

### Get a value

We can use the api REST to request one key's value. If the key exists then we
will have the value.

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

Otherwise, we will have a 404.

```bash
curl -i -XGET localhost:8000/values/nonexistingkey

HTTP/1.1 404 Not Found
cache-control: no-cache, private
date: Sat, 25 Jan 2020 17:23:33 GMT
content-type: text/html; charset=UTF-8
X-Powered-By: React/alpha
Content-Length: 0
Connection: close
```

Thanks to last workflows, reading a value is as simple as you will see here.
Our request is handled by one of our servers (remember, the balancer forwards
it to one of our defined servers). The server creates a new Query object
requesting a value given a key, and the handler uses the configured repository.

Repositories save an updated list of key-values, keeping it fresh by using the
domain events received through the event subscriber, so we could simply accept
that yes, these values are properly updated!

Just check if the key is in the local array and return the value.
That's it. Without any persistence layer access, without having bottlenecks.

### Visit 127.0.0.1:8000/

You can open your browser to `http://127.0.0.1:8000` and you will be see 2
lists. The first one will be the current state of the website. These values are
not taken from the persistence layer, but from one fresh copy allocated in one
of our servers memory.

The other list is real-time updated list of domain events and websocket events
from our system. These are the current events notified here.

- A new key-value has been put
- A key has been deleted
- A connection has been connected to the route /events
- A connection has been disconnected from the route /events

As soon as our persistence layer changes, both lists will change (the first one
by applying some deltas, the second by appending new domain events).

You can open multiple times this endpoint at the same time and play with the
concurrency. 
>>>>>>> New demo for DriftPHP
