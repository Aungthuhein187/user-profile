<?php

include "../vendor/autoload.php";

use Libs\Database\UsersTable;
use Libs\Database\MySql;
use Helpers\HTTP;
use Helpers\Auth;

$auth = Auth::check();
$table = new UsersTable(new MySql());

$table->delete($_GET['id']);
HTTP::redirect("/admin.php");
