<?php

echo "I am a little test file";


class TestClass{

  public static function something(){
    echo self::class;
    echo static::class;
  }


}

TestClass::something();

?>
