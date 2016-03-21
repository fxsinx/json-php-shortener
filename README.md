# json-php-shortener
A simple PHP url shortener with JSON file.


# Requirements
Apache or Nginx, PHP or HHVM installed.

# Configurations

## Apache Configurations
Modify the `.htaccess file` by appending these lines:

```
DirectoryIndex index.html index.htm index.php
<IfModule mod_rewrite.c>
RewriteRule ^index\.php$ - [L]
RewriteCond %{REQUEST_FILENAME} !-f
RewriteCond %{REQUEST_FILENAME} !-d
RewriteRule . /index.php [L]
</IfModule>
```

## Nginx Configurations
Modify by your `server.conf` in `/etc/nginx/conf.d/` by joining these lines to your `server{ ... }` block:

```
location / {
try_files $uri $uri/ /index.php?$args;
index index.html index.htm index.php;
}
```

# How to use
To get started, move the `some-private-dir/urls.json` to another private place or give it a different name.

Config your `urls.json` file location and your passcode in `config.php`. Passcode is needed to prevent abuse.

# Change file permission
You need to explicitly change the permission of file `urls.json`  to 777.

```
chmod 777 ./some-private-dir/urls.json
```

then, to add a new url shortener rule, you can either visiting `/index.html` which is the default index page for your site, or by query `/add.php?url=http://longurl.com&short=shortname&pass=passcode`.

# The response

You are about to get different response messages in JSON type after the shortener finishes its work.

The `status` indicates whether if it added the rule.

If it fails, you will get detailed `msg`.

If it succeeds, it’s gonna tell you the whether the type is `update` or `insert`. You’ll probably get an `update` type if you shortened an URL that already exists in the JSON file.