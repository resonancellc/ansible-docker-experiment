Vagrant.configure("2") do |config|  
  config.vm.define "dev" do |d|
    #d.vm.box = "debian/buster64"
    d.vm.box = "kaorimatz/ubuntu-16.04-amd64"
    d.vm.hostname = "dev"
    d.vm.network :private_network, ip: "10.100.198.200"
    d.vm.provider "virtualbox" do |v|
      v.memory = 2048
      v.cpus = 2
      v.name = "dev"
    end
  end
  # Setup synced folder
  config.vm.synced_folder "./app", "/vagrant/app", create: true
  config.vm.network :forwarded_port, guest: 8081, host: 8081
end
