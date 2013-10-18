# Complete Yii Example

The goal of this project is to have a completely installed and running
example site built using [Yii](http://www.yiiframework.com/). This example
aims to cover as many aspects of Yii as possible. Some of the examples will
cover:

- [x] DB Migrations
- [x] Unit Tests
- [ ] Modules
- [ ] Behaviours
- [ ] JavaScript interaction with Yii's JavaScript objects
- [ ] Provide framework for using extention and vendor add-ons development and
testing.
- [ ] Use of PHP's Namespace


## Requirements

* A working install of [Vagrant](http://www.vagrantup.com/)
* [Capistrano](http://www.capistranorb.com/)
* A computer with at least 2GB of RAM


## Recommended

* A fast internet connection to download the Debian Vagrant box. (The file
is 564MB)
* A computer with at least 4GB RAM.


## Install

__These install steps assume the host system is unix based (Linux, Mac OSX,
*BSD, etc.).__

You will need to add the following line to your local **/etc/hosts**

    192.168.42.101 yii-example.local.domain yii-example yii-demo-blog yii-demo-hangman yii-demo-helloworld yii-demo-phonebook

Then run the following commands:

    git clone https://github.com/kfacx/yii-example.git
    cd yii-example
    vagrant up
    chmod 0600 vagrant_insecure_key
    cap deploy

The **vagrant up** can take a long time to finish. If you have a slow
internet connection it can take hours to download the base box.

Once complete, the sites can be tested with the following URLs:

<http://yii-example/>  
<http://yii-demo-blog/>  
<http://yii-demo-hangman/>  
<http://yii-demo-helloworld/>  
<http://yii-demo-phonebook/>  

## Development:

If you intend to use this project for personal development or to contribute
to this project, seeing the results is easy and fast. Simply edit the files
then run:

    cap deploy

If all the unit tests pass then the site is now updated on the VM.

### Enjoy!
