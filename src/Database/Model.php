<?php

namespace Eraasoft311\Mvc\Database;

use Eraasoft311\Mvc\Contracts\Database\DatabaseInterface;
use Eraasoft311\Mvc\Env\EnvDash;


class Model implements DatabaseInterface{

    var object $connection;
    var string $sql;
    protected string $table;
    
    function __construct()
    {
        $this->connection = mysqli_connect(EnvDash::env("DB_CONNECTION"), EnvDash::env("DB_USER"), EnvDash::env("DB_PASSWORD"), EnvDash::env("DB_NAME"));
    } 

    function select(string $columns = "*"): object
    {
        $table = self::$table;
        $this->sql = "SELECT $columns FROM `$table` ";
        return $this;
    }

    function delete():object
    {
        $table = self::$table;

        $this->sql = "DELETE FROM `$table` ";
        return $this;
    }

    function insert(array $data):object
    {
        $table = self::$table;

        $columns = "";
        $values = "";
        foreach($data as $key => $value){
            $columns .= "`$key` ,";
            $values .=  "'$value' ,";
        }
        $columns = rtrim($columns,",");
        $values = rtrim($values,",");

        $this->sql = "INSERT INTO `$table` ($columns) VALUES ($values)";
        return $this;
    }

    function update(array $data):object
    {
        $table = self::$table;

        $row = "";
        foreach($data as $key => $value){
            $row .= "`$key` = '$value' ,";
        }
        $row = rtrim($row,",");

        $this->sql = "UPDATE TABLE `$table` SET $row";
        return $this;
    }

    function where(string $column,string $value,string $operator = "="):object
    {
        $this->sql .= "WHERE `$column` $operator '$value'";
        return $this;
    }

    function excute():int
    {
         mysqli_query($this->connection,$this->sql); 
         return mysqli_affected_rows($this->connection);
    } 
    function all():array
    {
        $query = mysqli_query($this->connection,$this->sql);
       return mysqli_fetch_all($query,MYSQLI_ASSOC);
    }

    function first():array
    {
        $query = mysqli_query($this->connection,$this->sql);
        return mysqli_fetch_assoc($query);
    }

}