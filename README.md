# Product manager
[![Build Status](https://travis-ci.com/Vasary/product-manager.svg?branch=master)](https://travis-ci.com/Vasary/product-manager)

Service which provides the rest API interfaces to control products of my abstract company.
The manager can create, update, remove products in the warehouse. This is microservice. 
This will be part of the shop service.  

### Environment variables
* ENVIRONMENT
* DATABASE_URL (DSN)
* DEBUG (boolean)

### Extra
[Start guide](extra/TestingScenario.md)

### Commands (For development)
Use `make` for command execution.

* `shell` - open container terminal
* `start` - starts containerized application on host OS 
* `stop` - stops application
* `test` - run test
* `build` - building container
* `create-network` - create local development network
* `start-postgres` - start local postgres
* `stop-postgres` - stops local postgres
