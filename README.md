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

```bash
vagrant up
ansible-playbook ansible/app.yml -i ansible/hosts/app
ansible-playbook ansible/lb.yml -i ansible/hosts/lb
```

#test service registry

```
vagrant ssh lb
curl 127.0.0.1:8500/v1/catalog/nodes
curl 127.0.0.1:8500/v1/catalog/services
curl 127.0.0.1:8500/v1/catalog/service/php1
curl 127.0.0.1:8500/v1/catalog/service/php2
```

#test template generation

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