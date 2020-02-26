#!/bin/bash

consul-template -template "/data/consul-template/haproxy_php_api.ctmpl:/tmp/haproxy_php_api.conf" -once

cat /data/haproxy/config/haproxy.cfg.orig /tmp/haproxy_php_api.conf | tee /data/haproxy/config/haproxy.cfg
