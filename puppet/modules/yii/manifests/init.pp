#
# Copyright (c) 2013 by Alexander Scott
# All rights reserved.
#
class yii ($db_root_pw) {
	include apache2
	include php
	include git

	user {
		"yii-example":
			shell => "/bin/bash",
			home	=> "/var/www/yii-example",
			groups => "sudo";
		"www-data":
			groups => yii-example,
			require => User["yii-example"],
			notify => Service["apache2"];
	}

	package {
		"phpunit": ensure => installed;
		"php-soap": ensure => installed;
		"php5-sqlite": ensure => installed;
	}

	File {
			owner => yii-example,
			group => yii-example
	}
	file {
		"/var/www/yii-example":
			ensure => directory,
			mode => 0755,
			require => [ User["yii-example"], Package["apache2"], Package["php5"] ];
		"/var/www/yii-example/releases":
			ensure => directory,
			mode => 0775,
			require => File["/var/www/yii-example"];
		"/var/www/yii-example/.ssh":
			ensure => directory,
			mode => 0700,
			require => File["/var/www/yii-example"];
		"/var/www/yii-example/.ssh/authorized_keys":
			source => "puppet:///modules/admin/authorized_keys",
			mode => 0600,
			require => File["/var/www/yii-example/.ssh"];
		"/var/www/yii/1.1.14/demos/blog/protected/runtime":
			owner => www-data,
			group => www-data,
			require => Git::Clone["yii 1.1.14"];
		"/var/www/yii/1.1.14/demos/blog/assets":
			owner => www-data,
			group => www-data,
			require => Git::Clone["yii 1.1.14"];
		"/var/www/yii/1.1.14/demos/blog/protected/data/blog.db":
			owner => www-data,
			group => www-data,
			require => Git::Clone["yii 1.1.14"];
	}

	$example_root="/var/www/yii-example/current/example"
	$demos_root="/var/www/yii/1.1.14/demos"
	Apache2::Vhost {
		email => "yii-example@local.domain",
		error_log => "/var/log/apache2/yii-example-error.log",
		custom_log => "/var/log/apache2/yii-example-access.log"
	}
	apache2::vhost {
		"yii example":
			server_name => "yii-example.local.domain",
			server_alias => "yii-example",
			document_root => "$example_root";
		"yii demo blog":
			server_name => "yii-demo-blog.local.domain",
			server_alias => "yii-demo-blog",
			document_root => "$demos_root/blog";
		"yii demo hangman":
			server_name => "yii-demo-hangman.local.domain",
			server_alias => "yii-demo-hangman",
			document_root => "$demos_root/hangman";
		"yii demo helloworld":
			server_name => "yii-demo-helloworld.local.domain",
			server_alias => "yii-demo-helloworld",
			document_root => "$demos_root/helloworld";
		"yii demo phonebook":
			server_name => "yii-demo-phonebook.local.domain",
			server_alias => "yii-demo-phonebook",
			document_root => "$demos_root/phonebook";
	}

	git::clone {
		"yii 1.1.14":
			url => "https://github.com/yiisoft/yii.git",
			branch => "1.1.14",
			target => "/var/www/yii/1.1.14";
	}

	mysql::create {
		"create yii example db":
			db_root_pw => $db_root_pw,
			db_name => "yii-example",
			project => "yii-example";
		"create yii example test-db":
			db_root_pw => $db_root_pw,
			db_name => "yii-example-test",
			project => "yii-example";
	}
	mysql::grant {
		"grant yii example db user":
			db_root_pw => $db_root_pw,
			db_name => "yii-example",
			project => "yii-example",
			db_user => "yii-example",
			db_pass => "yii-example";
		"grant yii example test-db user":
			db_root_pw => $db_root_pw,
			db_name => "yii-example-test",
			project => "yii-example",
			db_user => "yii-example-test",
			db_pass => "yii-example";
	}
}
