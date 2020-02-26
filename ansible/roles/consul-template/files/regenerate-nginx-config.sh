#!/bin/bash

consul-template -template "/data/consul-template/nginx_locations_php_api.ctmpl:/tmp/locations_php_api.conf" -once
consul-template -template "/data/consul-template/nginx_upstreams_php_api.ctmpl:/tmp/upstreams_php_api.conf" -once

cp /tmp/locations_php_api.conf /data/nginx/includes/
cp /tmp/upstreams_php_api.conf /data/nginx/upstreams/
