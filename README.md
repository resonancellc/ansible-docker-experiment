# ansible-docker-experiment

```bash
vagrant up
ansible-playbook ansible/app.yml -i ansible/hosts/app
ansible-playbook ansible/lb.yml -i ansible/hosts/lb

vagrant ssh lb
#test service registry
curl 127.0.0.1:8500/v1/catalog/nodes
curl 127.0.0.1:8500/v1/catalog/services
curl 127.0.0.1:8500/v1/catalog/service/php1
curl 127.0.0.1:8500/v1/catalog/service/php2

#test template generation
consul-template -template "/data/consul-template/nginx_locations_php_api.ctmpl:/tmp/locations_php_api.conf" -once
consul-template -template "/data/consul-template/nginx_upstreams_php_api.ctmpl:/tmp/upstreams_php_api.conf" -once

cp /tmp/locations_php_api.conf /data/nginx/includes/
cp /tmp/upstreams_php_api.conf /data/nginx/upstreams/

sudo docker kill -s HUP nginx
```