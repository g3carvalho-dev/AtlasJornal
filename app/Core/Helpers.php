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

function format_date(?DateTime $date, string $format = 'd/m/Y H:i'): string
{
    return $date ? $date->format($format) : '';
}
