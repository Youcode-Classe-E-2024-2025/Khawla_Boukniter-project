<?php

function url($path = '')
{
    $base_url = '/Khawla_Boukniter-project/public';
    return $base_url . ($path ? '/' . ltrim($path, '/') : '');
}

function redirect($path)
{
    header('Location: ' . url($path));
    exit();
}

function asset($path)
{
    return url($path);
}
