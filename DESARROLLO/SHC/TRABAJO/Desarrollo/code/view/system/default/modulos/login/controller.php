<?php
function login()
{
    $oBL_Login=new BL_Login();
    $oBL_Login->login();
}
function logoff()
{
    $oBL_Login=new BL_Login();
    $oBL_Login->logoff();
} 