<?php
/**
 * Created by PhpStorm.
 * User: meihaibo
 * Date: 2020/12/15
 * Time: 12:21
 */
$options = [
    'expires' => time()+18400,
    'domain' => 'localhost',
    'httponly' => false,
    'samesite' => 'Lax',
    'secure' => false,
    'path' => '/'
];
function samesite_setcookie($name, $value, array $options)
{
    $header = 'Set-Cookie:';
    $header .= rawurlencode($name) . '=' . rawurlencode($value) . ';';
    if (isset($options['expires'])) {
        $header .= 'expires=' . \gmdate('D, d-M-Y H:i:s T', $options['expires']) . ';';
    }
    if (isset($options['expires'])) {
        $header .= 'Max-Age=' . max(0, (int) ($options['expires'] - time())) . ';';
    }
    if (!empty($options['path'])) {
        $header .= 'path=' . $options['path']. ';';
    }
    if (!empty($options['domain'])) {
        $header .= 'domain=' . rawurlencode($options['domain']) . ';';
    }
    if (!empty($options['secure'])) {
        $header .= 'Secure;';
    }
    if (!empty($options['httponly'])) {
        $header .= 'HttpOnly;';
    }
    if (!empty($options['samesite'])) {
        $header .= 'SameSite=' . rawurlencode($options['samesite']);
    }
    header($header, false);
    $_COOKIE[$name] = $value;
}
samesite_setcookie('hahaha', 'tttttt', $options);