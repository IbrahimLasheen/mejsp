<?php

/**
 * Admin Prefix URL For Open The Admin Dashboard
 */
function adminPrefix()
{
   return 'admin';
}




/**
 * ( NEW ) Admin URL To Get Admin Route Name And Prefix
 */
function adminUrl($url)
{
   return url(adminPrefix() . "/" . $url);
}
/**
 * old version
 */
function admin_url($url)
{
   return url(adminPrefix() . "/" . $url);
}






/**
 * Function For Set Actives Class To Blade Pages
 * $url = Page Uri
 * $setClassName = If Need Set Other Class Name
 */
function adminActiveLink($url, $setClassName = 'active')
{

   if (request()->path() == adminPrefix() . '/' . $url) {
      return $setClassName;
   } else {
      return false;
   }
}
