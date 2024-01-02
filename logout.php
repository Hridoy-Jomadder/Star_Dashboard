<?php

if(isset($_SESSION['das_userid']))
{
    $_SESSION['das_userid'] = NULL;
    unset($_SESSION['das_userid']);
}

header("Location: login.php");
die;
