[![Deploy](https://www.herokucdn.com/deploy/button.svg)](https://heroku.com/deploy?template=https://github.com/bogdananton/jwtpoc-server)


## Development

#### Plan / TODOs

- [x] use RAML with mocking and system tests
- [x] create boot-up bin tool (will create default folders / settings)
- [ ] implement routes for introspection
- [ ] generate admin token with long TTL (as a bin helper tool)
- [ ] set maintenance (settings) routes and actions
- [ ] create register client routes
- [ ] when creating a new client, generate a key, assign and deliver the private key without storing it
- [ ] create route to expose own public key (in settings)
- [ ] setup Selenium environment
- [x] include frontend dependencies
- [ ] collect logs
- [ ] build a dashboard for overview / quick access
- [ ] build frontend for client registration

RAML is put in place to ensure the blueprint and system tests golden master / expected actions and content structure.

Run `npm install` to grab frontend dependencies and `./bin/start-server.sh`.

----

#### Starting the mock API

Install:

```
npm install -g osprey-mock-service
```

Start mock API:

```
osprey-mock-service -f res/api.raml -p 19999
```

References:

* http://www.tcias.co.uk/blog/2015/03/11/raml-and-osprey-a-better-way-to-build-mock-apis/

----

#### Starting the server

Start the server by running `./bin/start-server.sh` or setting up a virtual host. Change the "base-url" in settings.json to override the default base URL value.

----

#### Generate keys

Run `php ./bin/generate-keys.php` to generate a pair. The following message will appear:

```
Pair 1458962472-56f6002825648 generated.
```

where "1458962472-56f6002825648" is a random label given to the .prv and .pub files.

----

#### Provision / boot

Run `php bin/boot.php` to set the prepare the client list (empty list), init the settings list and generate the default server public / private key pair.

----

#### Testing

Run `phpunit` to run all tests. The SystemTestListener found in tests/ and loaded via the phpunit.xml setup will raise and halt the mocking process. res/api.raml is used.


**Mock API testing guidelines:**

Validation is enforced at the structure / behavior level, not specific for the mocked input / output current values.
This ensures that switching to the real API will not invalidate these tests.

When no entries are found, mark test as skipped.
