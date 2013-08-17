#
# Copyright (c) 2013 by Alexander Scott
# All rights reserved.
#
Vagrant::Config.run do |config|
	use_real_network = false
	config.vm.box = "DebianWheezy64"
	config.vm.box_url = "https://dl.dropboxusercontent.com/s/zsli1e28t1zazy2/DebianWheezy64.box"

	config.vm.define :yii_example do |config|
		# Guest VM name aliases, add more here if extra domains are
		# needed.  These are only applied to the guest VM, you may
		# need to add them to your local hosts file.
		host_aliases=[
			"yii-example.local.domain",
			"yii-example",
			"yii-demo-blog",
			"yii-demo-hangman",
			"yii-demo-helloworld",
			"yii-demo-phonebook"
		]

		# IP address of guest VM
		ip="192.168.42.101"

		# Apply the above so vagant can use them appropriately.
		config.vm.host_name = host_aliases[0]
		config.vm.network :hostonly, ip

		# Update the gues VM's /etc/hosts file.
		config.vm.provision :shell do |shell|
			etc_hosts_line = "#{ip} "+host_aliases.join(" ");
			shell.inline = "grep \"#{ip}\" /etc/hosts || echo \"#{etc_hosts_line}\" >> /etc/hosts"
		end

		# Set the puppet provisioner 
		config.vm.provision :puppet do |puppet|
			puppet.manifests_path = "./puppet/manifests"
			puppet.manifest_file = "site.pp"
			puppet.module_path = "./puppet/modules"
		end
	end
end
