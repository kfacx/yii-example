class admin {
	package {
		[ "locales-all", "sudo"]:
			ensure => present;
	}

  File {
		owner => "root",
		group => "root"
  }
	file {
		"/etc/sudoers":
			source => "puppet:///modules/admin/sudoers",
			mode  => "0440",
      require => Package["sudo"];
	}
}
