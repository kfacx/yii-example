#
# Copyright (c) 2013 by Alexander Scott
# All rights reserved.
#
class mysql ($db_root_pw) {
  package {
    "mysql-server":
      ensure => installed;
  }
  service {
    "mysql":
      ensure => running,
      require => Package["mysql-server"];
  }
  Exec { path => [ "/usr/bin" ] }
  exec {
    "mysql_password":
      unless => "mysqladmin -uroot -p$db_root_pw status",
      command => "mysqladmin -uroot password $db_root_pw",
      require => Service[mysql];
    "mysql_reload_privs":
      command => "mysqladmin -uroot -p$db_root_pw reload",
      refreshonly => true;
  }
  define create ($db_root_pw, $db_name, $project = "") {
    exec {
      "mysql_create db:$db_name ($project)":
        path => [ "/usr/bin" ],
        unless => "mysql -uroot -p$db_root_pw $db_name",
        command => "mysql -uroot -p$db_root_pw -e \"create database \\`$db_name\\`\"",
        require => Exec["mysql_password"],
        logoutput => "on_failure";
    }
  }
  define grant ($db_root_pw, $db_name, $db_user, $host = "localhost", $project = "") {
    exec {
      "mysql_grant db:$db_name user:$db_user host:$host":
        path => [ "/bin", "/usr/bin" ],
        command => "mysql -uroot -p$db_root_pw -e\"GRANT ALL PRIVILEGES ON \\`$db_name\\`.* TO '$db_user'@'$host' IDENTIFIED BY '$db_user';\"",
        unless => "mysql -uroot -p$db_root_pw -e\"SHOW GRANTS FOR '$db_user'@'$host'\" 2>&1 | grep \"GRANT ALL PRIVILEGES ON \\`$db_name\\`\"",
        logoutput => "on_failure",
        require => Exec["mysql_create db:$db_name ($project)"],
        notify => Exec["mysql_reload_privs"];
    }
  }
}
