Vagrant.configure("2") do |config|  
  #config.vm.define "dev" do |d|
  #  d.vm.box = "ubuntu/bionic64"
  #  d.vm.hostname = "dev"
  #  d.vm.network :private_network, ip: "10.100.198.200"
  #  d.vm.provider "virtualbox" do |v|
  #    v.memory = 2048
  #    v.cpus = 2
  #    v.name = "dev"
  #  end
  #end
  (1..2).each do |i|
    config.vm.define "app-0#{i}" do |d|
      d.vm.box = "ubuntu/bionic64"
      d.vm.hostname = "app-0#{i}"
      d.vm.network "private_network", ip: "10.100.194.20#{i}"
      d.vm.provider "virtualbox" do |v|
        v.customize ["modifyvm", :id, "--natdnshostresolver1", "on"]     
        v.memory = 1024
        v.name = "app-0#{i}"
      end
    end
  end
  config.vm.define "lb" do |d|
    d.vm.box = "ubuntu/bionic64"
    d.vm.hostname = "lb"
    d.vm.network "private_network", ip: "10.100.193.200"
    d.vm.provider "virtualbox" do |v|
      v.customize ["modifyvm", :id, "--natdnshostresolver1", "on"]
      v.memory = 1024
      v.name = "lb"
    end
    d.vm.network :forwarded_port, guest: 80, host: 8081
  end
  # Setup synced folder
  config.vm.synced_folder ".", "/vagrant", create: true  
end
