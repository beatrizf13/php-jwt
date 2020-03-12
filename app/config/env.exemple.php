<?php

putenv("NAME_APP=");

$path_app = dirname(__DIR__);

putenv("PATH_APP=$path_app");

putenv("JWT_SECRET=supersecretkeyyoushouldnotcommittogithub");

putenv("DB_HOST=");
putenv("DB_NAME=");
putenv("DB_USERNAME=");
putenv("DB_PASSWORD=");