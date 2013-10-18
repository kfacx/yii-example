#
# Copyright (c) 2013 by Alexander Scott
# All rights reserved.
#
class php {
	package {
		[
			"php5",
			"php5-cli",
			"php5-common"
		]:
			ensure => present;
	}
}
