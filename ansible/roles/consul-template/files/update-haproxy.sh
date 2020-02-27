#!/bin/bash

cat /data/haproxy/config/haproxy.cfg.orig /tmp/haproxy_php_api.conf | tee /data/haproxy/config/haproxy.cfg

docker kill -s HUP haproxy
