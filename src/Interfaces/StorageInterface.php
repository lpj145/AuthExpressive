<?php
namespace AuthExpressive\Interfaces;

interface StorageInterface
{
    public function set($key, $value);
    public function get($key);
    public function has($key):bool;
    public function delete($key);
}
