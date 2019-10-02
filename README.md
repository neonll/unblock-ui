# unblock-ui
Web interface to manage unblock list

# Installation
- [Install](https://bitbucket.org/padavan/rt-n56u/wiki/EN/HowToConfigureEntware) Entware,
- [Install](https://habr.com/ru/post/428992/) core functionality by [kyrie1965](https://habr.com/ru/users/kyrie1965/),
- Install necesary packages:
```sh
opkg install lighttpd lighttpd-mod-fastcgi php7 php7-cgi php7-mod-json unzip
```
- Configure lighttpd. My config is below (/opt/etc/lighttpd/lighttpd.conf):
```
server.document-root        = "/opt/share/www"
server.upload-dirs          = ( "/tmp" )
server.errorlog             = "/opt/var/log/lighttpd/error.log"
server.pid-file             = "/opt/var/run/lighttpd.pid"
#server.username             = "http"
#server.groupname            = "www-data"

index-file.names            = ( "index.php", "index.html",
                                "index.htm", "default.htm",
                              )

static-file.exclude-extensions = ( ".php", ".pl", ".fcgi" )

### Options that are useful but not always necessary:
#server.chroot               = "/"
server.port                 = 81
#server.bind                 = "localhost"
#server.tag                  = "lighttpd"
#server.errorlog-use-syslog  = "enable"
#server.network-backend      = "writev"

### Use IPv6 if available
#include_shell "/opt/share/lighttpd/use-ipv6.pl"

#dir-listing.encoding        = "utf-8"
#server.dir-listing          = "enable"

include "/opt/etc/lighttpd/mime.conf"
include "/opt/etc/lighttpd/conf.d/*.conf"
```
- Add (or replace) to /opt/etc/lighttpd/conf.d/30-fastcgi.conf the following:
```
fastcgi.server = ( ".php" =>
                   ( "php-local" =>
                     (
                       "socket" => "/opt/tmp/php-fastcgi-1.socket",
                       "bin-path" => "/opt/bin/php-fcgi",
                       "max-procs" => 1,
                       "broken-scriptfilename" => "enable",
                     ),
                     "php-tcp" =>
                     (
                       "host" => "127.0.0.1",
                       "port" => 81,
                       "check-local" => "disable",
                       "broken-scriptfilename" => "enable",
                     ),
                     "php-num-procs" =>
                     (
                       "socket" => "/opt/tmp/php-fastcgi-2.socket",
                       "bin-path" => "/opt/bin/php-fcgi",
                       "bin-environment" => (
                         "PHP_FCGI_CHILDREN" => "3",
                         "PHP_FCGI_MAX_REQUESTS" => "100",
                       ),
                       "max-procs" => 5,
                       "broken-scriptfilename" => "enable",
                     ),
                   ),
                 )
```
- Download and install this repo:
```
wget https://github.com/neonll/unblock-ui/archive/master/master.zip
unzip master.zip -d /opt/share/www
mv /opt/share/www/unblock-ui-master /opt/share/www/unblock
rm master.zip
```
- Restart lighttpd:
```
/opt/etc/init.d/S80lighttpd restart
```

# Usage
Just visit http://192.168.1.1:81/unblock/ using your browser.
