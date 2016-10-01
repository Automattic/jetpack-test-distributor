[![License](https://poser.pugx.org/automattic/jetpack/license.svg)](http://www.gnu.org/licenses/gpl-2.0.html)
[![Build Status](https://travis-ci.org/jom/jetpack-test-distributor.svg)](https://travis-ci.org/jom/jetpack-test-distributor)

# Test Distributor

Distributes human testable tests to Jetpack sites based on their environment. 

## Trying it Out w/ Docker

Developing in a Docker environment with [jwilder/nginx-proxy](https://github.com/jwilder/nginx-proxy) and DNS masq for `*.docker` to `127.0.0.1`. Can run in another environment, just change the `.env` file with the database connection info.

1. Run `docker-compose up -d`
2. Run `compose install` to get the development requirements (not used in the library itself).
3. Visit http://test-db.docker and load the SQL dump file in `dev/testing.sql`.
4. Visit http://test.docker and try different environments to test the result.
