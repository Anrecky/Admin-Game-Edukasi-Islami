<?php
function setUrl($url)
{
    return 'http://' . $_SERVER['HTTP_HOST'] . dirname($_SERVER['PHP_SELF']) . $url;
}
