<?php

use Illuminate\Support\Facades\DB;

function all($table,$select = [],$where = null,$value = null)
{
    return DB::table($table)->select($select)->where($where,$value)->get();
}



function row($table,$select = [],$where = null,$value = null)
{
    return DB::table($table)->select($select)->where($where,$value)->first();
}


function countColumns($table,$select = [],$where = null,$value = null)
{
    return DB::table($table)->select($select)->where($where,$value)->count();

}


