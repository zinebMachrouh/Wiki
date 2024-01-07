<?php

require 'config/config.php';
require_once 'helpers/url_helper.php';

spl_autoload_register(function ($className) {
    require 'libraries/' . $className . '.php';
});
