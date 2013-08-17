#
# Copyright (c) 2013 by Alexander Scott
# All rights reserved.
#
class apt_sources {
  File {
    owner => "root",
    group => "root",
  }
  file {
    "/etc/apt/sources.list":
      source => "puppet:///modules/apt_sources/sources.list";
    "/etc/apt/sources.list.d/testing.list":
      source => "puppet:///modules/apt_sources/testing.list";
    "/etc/apt/preferences":
      source => "puppet:///modules/apt_sources/preferences";
  }
  Exec { path => [ "/bin", "/usr/bin" ] }
  exec {
    "apt-get update":
      command => "apt-get update",
      unless => "sh -c '
        exit $((
          $((
            $(( $(date +%s) - $(stat -c %Y /var/cache/apt/pkgcache.bin) ))
              >=
            $(( 24 * 60 * 60 ))
          ))
            |
          $( [ -z \"$(find /etc/apt -cnewer /var/cache/apt)\" ] ; echo $?)
        ))'",
      require => File["/etc/apt/sources.list", "/etc/apt/sources.list.d/testing.list", "/etc/apt/preferences"],
      logoutput => "on_failure";
  }
}
