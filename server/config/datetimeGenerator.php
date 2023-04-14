<?php

class DateTimeGenerator
{

  private $current_datetime;
  private $newDateTime;

  function __construct()
  {
    $this->current_datetime = date("Y-m-d H:i:s");
    $this->newDateTime = new DateTime($this->current_datetime);
  }

  function toUTC(){
    $this->newDateTime->setTimezone(new DateTimeZone("UTC"));
  	$current = $this->newDateTime->format("Y-m-d H:i:s");
    return $current;
  }
}

?>
