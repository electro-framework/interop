<?php
namespace Selenia\Exceptions\Fatal;

use Selenia\DataObject;
use Selenia\Exceptions\FatalException;

class DataModelException extends FatalException
{

  public function __construct (DataObject $obj, $msg)
  {
    $dump = print_r ($obj, true);
    parent::__construct ("$msg<h4>Instance properties:</h4><blockquote><pre>$dump</pre></blockquote>");
  }

}
