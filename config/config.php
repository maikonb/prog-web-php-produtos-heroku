<?php

$db_url       = parse_url(getenv("CLEARDB_DATABASE_URL"));
$db_user      = $db_url["user"];
$db_password  = $db_url["pass"];
$db_host      = $db_url["host"];
$db_database  = substr($db_url["path"], 1);

