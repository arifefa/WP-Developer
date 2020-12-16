<?php

/** Redirect www to non www - set after define */
if (substr($_SERVER['HTTP_HOST'], 0, 4) === 'www.') {
    header('Location: http' . (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] == 'on' ? 's' : '') . '://' . substr($_SERVER['HTTP_HOST'], 4) . $_SERVER['REQUEST_URI'], true, 301);
    exit;
}
