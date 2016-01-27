<?php
namespace Selenia\Interfaces\Faults\en_US;

use Selenia\Faults\Faults as F;

interface Faults
{
  const MESSAGES = [
    F::ARG_NOT_ITERABLE      => 'The argument must be iterable',
    F::DUPLICATE_LINK_ID     => "Duplicate link ID: '%s'",
    F::LINK_NOT_FOUND        => "Navigation link '%s' was not found",
    F::PROPERTY_IS_READ_ONLY => "Property '%s' is read-only",
    F::REQUEST_NOT_SET       => "No ServerRequest is set for the Navigation",
  ];
}
