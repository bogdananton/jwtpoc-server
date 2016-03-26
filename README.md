[![Deploy](https://www.herokucdn.com/deploy/button.svg)](https://heroku.com/deploy?template=https://github.com/bogdananton/jwtpoc-server)


### Development

#### Plan / TODOs

* use RAML with mocking, system tests
* implement routes for introspection
* generate admin token with long TTL (as a bin helper tool)
* create boot-up bin tool (will create default folders / settings)
* set maintenance (settings) routes and actions
* create register client routes
* when creating a new client, generate a key, assign and deliver the private key without storing it
* create route to expose own public key (in settings)


#### Starting the server

Start the server by running `./bin/start-server.sh` or setting up a virtual host.
-Change the "base-url" in settings.json to override the default base URL value.-


#### Generate keys

Run `php ./bin/generate-keys.php` to generate a pair. The following message will appear:

```
Pair 1458962472-56f6002825648 generated.
```

where "1458962472-56f6002825648" is a random label given to the .prv and .pub files.


#### Provision / boot

Run `php bin/boot.php` to set the prepare the client list (empty list), init the settings list and generate the default server public / private key pair.


