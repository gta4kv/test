# Requirements

PHP >= 5.6, PHP56-PDO, MySQL

# Setting Up

1) Configure Web-Server, typical framework configuration
- all request should be rewrited to index.php?$args
- document root must be set to ./public directory

Config example for nginx:

    server {
        listen       80;
        server_name  test.local;

        root   /Users/dromazanov/Work/test/public;
        index index.php;

       location / {
                try_files $uri $uri/ /index.php?$args;
        }
        location ~* \.php$ {
                # Server PHP config.
                fastcgi_pass                    127.0.0.1:9000;
                fastcgi_index                   index.php;
                fastcgi_split_path_info         ^(.+\.php)(.*)$;

                # Typical vars in here, nothing interesting.
                include                         fastcgi_params;
                fastcgi_param   SCRIPT_FILENAME $document_root$fastcgi_script_name;
       }
    }


2) Migrate database
- Import database.sql from root of project to MySQL
- Configure database in ./config/database.php

3) All done, you are awesome!

#### Admin credentials

Email: admin@admin.com

Password: admin


# How it works

Well... I didn't have much time to comment this code, but it is very logical and easy to understand.

#### Basic Lifecycle of the Application

1) Registering autoload
2) Creating Application + Container

At this step we initializing the whole system, registering default service providers.
Also it registers App\AppServiceProvider, which is the start point for the user application.

3) Handling Kernel

Even though it sounds a bit tough, at this step we basically looking for suitable route and dispatching it (Which includes creating Controller and getting response content from it)

4) Sending Response

In the past step we've got the response from a controller and now we just seding it to the user.

That's it!