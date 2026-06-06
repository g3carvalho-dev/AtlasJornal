<?php

function url(string $path = '')
{
    $baseUrl = rtrim(BASE_URL, '/');
    $path = '/' . ltrim($path, '/');
    return $baseUrl . $path;
}

function asset(string $path): string
{
    return url('assets/' . ltrim($path, '/'));
}

function e(?string $string)
{
    return htmlspecialchars($string ?? '', ENT_QUOTES, 'UTF-8');
}
