<?php
namespace Electro\Interfaces\Caching;

interface CachePoolInterface
{
  function setNamespace ($name);

  function withTTL ($seconds);

  function withExpiration ($dateTime);

  function withTags (array $tags);


}
