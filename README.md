# Sys_Start

Sys_Start is a PHP script used for Raspberry PI startup.
Instead of filling the CRON with @reboot I use this script to run all the gagets I want at startup

I have also included logs and log rotate using logrotate.

There is a config file sys_startup.ini
If the PI is using temp probes or relays, you can set configuration in the .ini file

Dillinger is a cloud-enabled, mobile-ready, offline-storage, AngularJS powered HTML5 Markdown editor.

  - Type some Markdown on the left
  - See HTML in the right
  - Magic
### Version
1.0.2

### Tech


### Installation

You need Gulp installed globally:

```sh
$ npm i -g gulp
```


```sh
$ git clone [git-repo-url] dillinger
$ cd dillinger
$ npm i -d
$ mkdir -p downloads/files/{md,html,pdf}
$ gulp build --prod
$ NODE_ENV=production node app
```
