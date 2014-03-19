<p>session stress test</p>
<pre>
<?php
error_reporting(E_ALL);

session_start();
if (isset($_GET['v'])) 
{
    echo 'view mode'.PHP_EOL;
}
else if (isset($_GET['d']))
{
    session_destroy();
    $_SESSION = array();
}
else 
{
    echo 'set mode'.PHP_EOL;
    for ($i = 0; $i < (@$_GET['n']?: 100); $i++) {
        $_SESSION['s'.$i] = str_repeat(md5($i.rand().$i), ($i % 4 + 1));
    }
}
var_dump($_SESSION);
session_write_close();
?>
</pre>
