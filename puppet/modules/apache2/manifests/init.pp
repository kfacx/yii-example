#
# Copyright (c) 2013 by Alexander Scott
# All rights reserved.
#
class apache2 {
  package {
    "apache2":
      ensure => present,
      before => File["/etc/apache2/ports.conf"];
  }
  service {
    "apache2":
      ensure => true,
      enable => true,
      subscribe => File["/etc/apache2/ports.conf"],
      require => File[
        "/etc/apache2/mods-enabled/ssl.conf",
        "/etc/apache2/ports.conf",
        "/etc/apache2/mods-enabled/rewrite.load",
        "/etc/apache2/mods-enabled/ssl.load"
      ]
  }
  File {
    owner => root,
    group => root,
    ensure => "link",
    require => Package["apache2"]
  }
  file {
    "/etc/apache2/ports.conf":
      source => "puppet:///modules/apache2/ports.conf",
      ensure => "file",
      mode => 644;
    "/etc/apache2/ssl/":
      ensure  => directory,
      mode    => 700;
    "/etc/apache2/mods-enabled/ssl.conf":
      target => "/etc/apache2/mods-available/ssl.conf";
    "/etc/apache2/mods-enabled/ssl.load":
      target => "/etc/apache2/mods-available/ssl.load";
    "/etc/apache2/mods-enabled/rewrite.load":
      target => "/etc/apache2/mods-available/rewrite.load";
    "/var/www/":
      ensure => directory,
      mode => 755;
    "/etc/apache2/sites-enabled/000-default":
      ensure => absent;
  }

  define vhost (
    $email,
    $server_name,
    $server_alias = "",
    $document_root,
    $error_log = "/var/log/apache2/error.log",
    $custom_log = "/var/log/apache2/access.log") {
    file {
      "/etc/apache2/sites-available/$server_name.conf":
        owner => root,
        group => root,
        content => template("apache2/vhost.conf.erb"),
        require => Package["apache2"];
      "/etc/apache2/sites-enabled/$server_name.conf":
        source => "/etc/apache2/sites-available/$server_name.conf",
        ensure => link,
        require => File["/etc/apache2/sites-available/$server_name.conf"],
        notify => Service["apache2"];
    }
  }
}
