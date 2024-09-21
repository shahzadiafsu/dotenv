<?php

declare(strict_types=1);

namespace Dotenv\Constant;

final class RegularExpression
{
  public const RNESTVAR = '/\$\{(\w+)\}/m';
  public const RENVLINE = '/^\s*(\w+)[\x20]*=[\x20]*(?:"((?:.|[\r\n])*?)"|\'((?:.|[\r\n])*?)\'|`((?:.|[\r\n])*?)`|([^#\r\n]*))(?!^#)/m';
}
?>
