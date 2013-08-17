#
# Copyright (c) 2013 by Alexander Scott
# All rights reserved.
#
set :application, "yii-example"
set :scm, :none
set :repository, "."
set :deploy_via, :copy 
set :copy_local_tar, "/usr/bin/gnutar" if `uname` =~ /Darwin/
set :copy_exclude, [".git", "example/assets", "example/protected/runtime"]
set :deploy_to, "/var/www/#{application}/"
set :use_sudo, false
set :normalize_asset_timestamps, false
set :user, "yii-example"

ssh_options[:keys] = ['./vagrant_insecure_key']

role :web, "yii-example"
role :app, "yii-example"
role :db,  "yii-example", :primary => true

