# ansible-docker-experiment

There are 3 machines:
* `lb` - load balancer `10.100.193.200`
* `app-01` - app server 1 `10.100.194.201`
* `app-02` - app server 2 `10.100.194.202`

```
        /- app-01 (apache+php/docker)
lb(nginx/docker)
        \_ app-02 (apache+php/docker)
```

`registrator` and `consul` runs on all nodes. registrator "watches" docker system and registers services info in `consul` db.
`consul-template` on `lb` node, generates proxy rules based on `consul` data and templates.

## provision nodes

```bash
vagrant up
ansible-playbook ansible/app.yml -i ansible/hosts/app
ansible-playbook ansible/lb.yml -i ansible/hosts/lb
```

## test service registry

```
vagrant ssh lb
curl 127.0.0.1:8500/v1/catalog/nodes
curl 127.0.0.1:8500/v1/catalog/services
curl 127.0.0.1:8500/v1/catalog/service/php1
curl 127.0.0.1:8500/v1/catalog/service/php2
```

## nginx template generation

`vagrant ssh lb`

```bash
consul-template -template "/data/consul-template/nginx_locations_php_api.ctmpl:/tmp/locations_php_api.conf" -once
consul-template -template "/data/consul-template/nginx_upstreams_php_api.ctmpl:/tmp/upstreams_php_api.conf" -once

cp /tmp/locations_php_api.conf /data/nginx/includes/
cp /tmp/upstreams_php_api.conf /data/nginx/upstreams/

sudo docker kill -s HUP nginx
```

or 

```
bash /data/consul-template/regenerate-nginx-config.sh
sudo docker kill -s HUP nginx
```

## haproxy template generation

provision `haproxy` on `lb` node

```bash
ansible-playbook ansible/lb-haproxy.yml -i ansible/hosts/lb
```

`vagrant ssh lb`

```bash
#stop nginx container if running
sudo docker ps
sudo docker stop nginx

#generate config for running services
bash /data/consul-template/regenerate-haproxy-config.sh

#initial start
sudo docker restart haproxy

#while running
sudo docker kill -s HUP haproxy
```
## test calls

### from host machine:

```bash
curl http://127.0.0.1:8081/php1
curl http://127.0.0.1:8081/php2
```

###  from lb

```bash
curl http://127.0.0.1/php1
curl http://127.0.0.1/php2
```

### from app

to get ports run `curl 127.0.0.1:8500/v1/catalog/service/php1` and `curl 127.0.0.1:8500/v1/catalog/service/php2`

```bash
curl http://127.0.0.1:{port1}/php1
curl http://127.0.0.1:{port2}/php2
```

