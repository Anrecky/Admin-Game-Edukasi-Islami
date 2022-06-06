<?php
function setUrl($url)
{
    return 'http://' . $_SERVER['HTTP_HOST'] . dirname($_SERVER['PHP_SELF']) . $url;
}

function getParamFromUrl($url, $paramName)
{
    parse_str(parse_url($url, PHP_URL_QUERY), $op);
    return array_key_exists($paramName, $op) ? $op[$paramName] : "Not Found"; 
}
