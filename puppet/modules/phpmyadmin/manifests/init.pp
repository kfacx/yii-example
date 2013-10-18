#
# Copyright (c) 2013 by Alexander Scott
# All rights reserved.
#
class phpmyadmin ($db_root_pw) {
	class {
		'mysql': db_root_pw => $db_root_pw;
	}
	include apache2
	include php

	file {
		"/root/phpmyadmin.preseed":
			ensure => present,
			mode => 0600,
			content => template("phpmyadmin/preseed.erb");
	}

	exec {
		"preseed_phpmyadmin":
			path => ["/bin", "/usr/bin"],
			command => "debconf-set-selections < /root/phpmyadmin.preseed",
			unless => "debconf-get-selections | grep phpmyadmin",
			require => [ File["/root/phpmyadmin.preseed"], Package["debconf-utils"] ],
			logoutput => "on_failure";
	}

	package {
		"debconf-utils":
			ensure => present;
		"phpmyadmin":
			ensure => present,
			require => [ Package["php5", "debconf-utils"], Service["mysql", "apache2"], Exec["preseed_phpmyadmin"] ];
	}
}
