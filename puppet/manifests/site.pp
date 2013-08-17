#
# Copyright (c) 2013 by Alexander Scott
# All rights reserved.
#

$db_root_pw = 'example-db-password'

stage { 'first': before => Stage['main'] }

node default {
  include apt_sources
  include admin
}

node "yii-example" inherits default {
  include apache2
  class {
    'phpmyadmin': db_root_pw => $db_root_pw;
    'yii': db_root_pw => $db_root_pw;
  }
}

Exec["apt-get update"] -> Package <| |>
class {
  'apt_sources': stage => first;
  'admin': stage => first;
}
