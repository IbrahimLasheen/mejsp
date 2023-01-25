<?php
// Classes
use Carbon\Carbon;

/**
 * Create Text To Slug
 * 1- Remove All (-) IF Isset In The Text
 * 2- String To Lower Case
 * 3- IF Have Space In Text Replace to (-) 
 **/

function slug($text)
{
    $text = str_replace(' ', '-', $text);
    $text = str_replace('/', '-', $text);
    $text = str_replace('\\', '-', $text);
    $text = str_replace('+', '-', $text);
    $text = str_replace('?', '-', $text);
    $text = str_replace('|', '-', $text);

    $text = strtolower($text);
    return $text;
}
function unSlug($text)
{
    $text = str_replace('-', ' ', $text);
    $text = strtolower($text);
    return $text;
}

function test($numbers)
{
    $num = null;
    
    $num += $numbers;

    return $num;
}

/**
 * Create Random Name
 * 1- If Random Name For File,Image..... Set IN Params $file = 'jpg' Or 'pdf' Or .....
 * v2
 */
function randomName($file = null)
{
    if ($file !== null) {
        $file = '.' . str_replace('.', '', $file);
    }
    return time() . '_' . rand(10000, 5000000000) . $file;
}


/**
 * Parse String Time With Carbon Class
 */
function parseTime($time = null)
{
    if ($time == null) {
        $time = date('Y-m-d h:i:s');
    }
    return  Carbon::parse($time)->diffForHumans();
}



/**
 * Format Text
 * 1- Text To Lower Caset
 * 2- First Litter To UpperCase
 */

function formatText($text)
{
    $text = strtolower($text);
    return ucfirst($text);
}



/**
 * Get Auth Info
 * $guard = Auth Guard Name
 * $get   = Get Auth Value
 */
function getAuth($guard, $get)
{
    return auth($guard)->user()->$get;
}



/**
 * Check If File Exist 
 */
function checkFile($file)
{
    if (file_exists(public_path() . '/' . $file)) { // File If Exist
        return true;
    } else {
        return false;
    }
}

/**
 * Check If File Exist And Delete
 */
function deleteFile($path, $fileName)
{
    if (file_exists($path . $fileName)) { // Delete File If Exist

        @unlink($path . $fileName);
    }
}



/**
 * Check Request IN Form Have Old Value Or No
 * IF Have Old Value IN Send Set The Value IN Input
 * Else Set Auth Value Or Any Value
 * $oldName = Name Of The old() Helper Function
 * $antherValue = Onther Value IF old Not Exist
 */

function inputValue($oldName, $antherValue)
{
    if (old($oldName) != null) {
        return old($oldName);
    } else {
        return $antherValue;
    }
}



/**
 * Function For Set Actives Class To Blade Pages
 * $url = Page Uri
 * $setClassName = If Need Set Other Class Name
 */
function activeLink($url, $setClassName = 'active')
{
    if (request()->path() ==  $url) {
        return $setClassName;
    } else {
        return false;
    }
}


function activeSingleLink($key, $setClassName = 'active')
{
    if (in_array($key, explode('/', request()->path()))) {
        return $setClassName;
    } else {
        return false;
    }
}





/**
 * user Prefix URL For Open The user Dashboard
 */
function userPrefix()
{
    return 'u';
}

function userUrl($url)
{
    return url(userPrefix() . "/" . $url);
}


/**
 * Print Not Have Data Message
 */
function notHaveData()
{
    return 'لا توجد بيانات للعرض حتى الان !';
}



/**
 * Tax Price
 */

function tax($price, $tax = 5)
{
    $num = $price / 100;
    $num = $num * $tax;
    return  $price + $num;
}
