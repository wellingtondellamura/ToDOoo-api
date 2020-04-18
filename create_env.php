<?php

function pf($str) { echo "$str\n";}

pf("APP_NAME=\"ToDOoo API\"");
pf("APP_ENV=production");
pf("APP_DEBUG=false");
pf("APP_URL=https://123todoapi.azurewebsites.net");

pf("LOG_CHANNEL=stack");

pf("DB_CONNECTION=mysql");
pf("DB_HOST=".getenv("db_host"));
pf("DB_PORT=".getenv("db_port"));
pf("DB_DATABASE=".getenv("db_database"));
pf("DB_USERNAME=".getenv("db_user"));
pf("DB_PASSWORD=".getenv("db_password"));

pf("BROADCAST_DRIVER=log");
pf("CACHE_DRIVER=file");
pf("QUEUE_CONNECTION=sync");
pf("SESSION_DRIVER=file");
pf("SESSION_LIFETIME=120");


