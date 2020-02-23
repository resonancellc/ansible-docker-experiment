# ansible-docker-experiment

```bash
vagrant up
ansible-playbook ansible/playbook.yml -i ansible/hosts/dev

vagrant ssh
consul-template -template "/data/consul-template/apache_php_api.ctmpl:/tmp/apache.conf" -once
sudo service apache2 reload
```