<?php

function get_route($route, $path_to_include): void
{
    if ($_SERVER['REQUEST_METHOD'] == 'GET') {
        custom_route(HOST . $route, $path_to_include);
    }
}

function post_route($route, $path_to_include): void
{
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        custom_route(HOST . $route, $path_to_include);
    }
}

function put_route($route, $path_to_include): void
{
    if ($_SERVER['REQUEST_METHOD'] == 'PUT') {
        custom_route($route, $path_to_include);
    }
}

function patch_route($route, $path_to_include): void
{
    if ($_SERVER['REQUEST_METHOD'] == 'PATCH') {
        custom_route($route, $path_to_include);
    }
}

function delete_route($route, $path_to_include): void
{
    if ($_SERVER['REQUEST_METHOD'] == 'DELETE') {
        custom_route($route, $path_to_include);
    }
}

function any_route($route, $path_to_include): void
{
    custom_route($route, $path_to_include);
}

function sanitize_url(string $url): string
{
    return preg_replace('/[^a-zA-Z0-9\-_\.\~\!\*\'\(\);\/\?\:\@\&\=\+\$\,\#\%\_]/', '', $url);
}

function custom_route($route, $path_to_include): void
{
    $callback = $path_to_include;
    if (!is_callable($callback)) {
        if (!strpos($path_to_include, '.php')) {
            $path_to_include .= '.php';
        }
    }
    if ($route == "/404") {
        include_once __DIR__ . "/$path_to_include";
        exit();
    }
    $request_url = sanitize_url($_SERVER['REQUEST_URI']);
    $request_url = rtrim($_SERVER['REQUEST_URI'], '/');
    $request_url = strtok($request_url, '?');
    $route_parts = explode('/', $route);
    $request_url_parts = explode('/', $request_url);
    array_shift($route_parts);
    array_shift($request_url_parts);
    if ($route_parts[0] == '' && count($request_url_parts) == 0) {
        // Callback function
        if (is_callable($callback)) {
            call_user_func_array($callback, []);
            exit();
        }
        include_once __DIR__ . "/$path_to_include";
        exit();
    }
    if (count($route_parts) != count($request_url_parts)) {
        return;
    }
    $parameters = [];
    for ($__i__ = 0; $__i__ < count($route_parts); $__i__++) {
        $route_part = $route_parts[$__i__];
        if (preg_match("/^[$]/", $route_part)) {
            $route_part = ltrim($route_part, '$');
            array_push($parameters, $request_url_parts[$__i__]);
            $$route_part = $request_url_parts[$__i__];
        } else if ($route_parts[$__i__] != $request_url_parts[$__i__]) {
            return;
        }
    }
    // Callback function
    if (is_callable($callback)) {
        call_user_func_array($callback, $parameters);
        exit();
    }
    include_once __DIR__ . "/$path_to_include";
    exit();
}
