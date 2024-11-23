<?php
declare(strict_types=1);

namespace Natepisarski\UnwrapEnums\Tests;

enum TestingBackedEnum : string
{
    case One = 'one';
    case Two = 'two';
    case Three = 'three';
}