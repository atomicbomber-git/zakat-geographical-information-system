#!/bin/bash

sudo chown -R atomicbomber:www-data bootstrap/cache
sudo chown -R www-data:www-data storage
sudo chmod -R g+rw bootstrap/cache
