<?php
namespace Selenia\Exceptions\Fatal;

use Selenia\Exceptions;
use Selenia\Exceptions\FatalException;

class DatabaseException extends FatalException
{

  public function __construct ($message, $code, $query, array $params = null)
  {
    $this->code = $code;
    if (isset($params)) {
      for ($i = 0; $i < count ($params); ++$i)
        if (is_null ($params[$i]))
          $params[$i] = '<i>NULL</i>';
        else if (is_string ($params[$i]))
          $params[$i] = "'" . htmlentities ($params[$i]) . "'";
      $p = '';
      for ($i = 1; $i <= count ($params); ++$i)
        $p .= "<b>$i:</b> " . $params[$i - 1] . "<br>";
    }
    else
      $p = '';
    parent::__construct ("<h3>$message</h3><p><b>Error code</b>: $code</p><b>Query</b>:\n\n<code>$query</code>\n\n<b>Parameters</b>:\n\n$p\n");
  }

}
