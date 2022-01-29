<?php
namespace App\Services\Storage\Contracts;

interface storageInterface {

    public function get($index);

    public function set($index,$value);

    public function all();

    public function exists($index);

    public function unset($index);

    public function clear();

    public function increment($index,$value);
  

  
  
}
