# JSON PHP URL Shortener
A simple PHP url shortener using JSON file.


## Requirements
Apache or Nginx, PHP or HHVM installed.

## Configurations

### Apache Configurations
Modify the `.htaccess` file at the root directory `/` by appending these lines to the end of the file:

```
DirectoryIndex index.html index.htm index.php
<IfModule mod_rewrite.c>
RewriteRule ^index\.php$ - [L]
RewriteCond %{REQUEST_FILENAME} !-f
RewriteCond %{REQUEST_FILENAME} !-d
RewriteRule . /index.php [L]
</IfModule>
```

### Nginx Configurations
Modify your specific `server.conf` in `/etc/nginx/conf.d/` or somewhere else by joining these lines into your `server{ ... }` block:

```
location / {
try_files $uri $uri/ /index.php?$args;
index index.html index.htm index.php;
}
```

## How to use
To get started, move the `some-private-dir/urls.json` to another private place or give it a different name. You don't want it to be public on the Internet.

Config your `urls.json` file location and your own passcode in `config.php`. Passcode is needed to prevent abuse.

### Change file permission
You need to explicitly change the permission of file `urls.json`  to 777.

```
chmod 777 ./some-private-dir/urls.json
```

Then, to add a new url shortener rule, you can either visiting `/index.html` which is the default index page for your site, or by query `/add.php?url=http://longurl.com&short=shortname&pass=passcode`.

Note that your server may refuse requests that contains slashes `/` in URL query. It depends your server side settings.

## The response text

You are about to get different response messages in JSON type after the shortener finishes its work.

The `status` indicates whether if it added the rule.

If it fails, you will get detailed `msg`.

If it succeeds, it’s gonna tell you the whether the type is `update` or `insert`. You’ll probably get an `update` type if you shortened an URL that already exists in the JSON file.