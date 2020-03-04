#!/bin/bash

cp /tmp/servers.conf /data/nginx/servers/

docker kill -s HUP nginx
