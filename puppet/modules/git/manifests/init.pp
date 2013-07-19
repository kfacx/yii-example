class git {
  package {
    "git":
      ensure => present;
  }

  Exec {
    path => [ "/bin", "/usr/bin" ]
  }
  define clone ($url, $branch = "HEAD", $target) {
    exec {
      "git $repo $tag $target":
        path => [ "/bin", "/usr/bin" ],
        unless => "stat $target",
        command => "git clone -b $branch $url $target",
        require => Package["git"],
        logoutput => "on_failure";
    }
  }
}
