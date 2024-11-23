<?php
declare(strict_types=1);

namespace Natepisarski\UnwrapEnums;

use Exception;

/**
 * Exception thrown when a UnitEnum is unwrapped that has no backing value.
 */
class EnumUnwrapException extends Exception
{

}