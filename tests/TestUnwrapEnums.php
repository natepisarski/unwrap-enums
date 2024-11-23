<?php
declare(strict_types=1);

namespace Natepisarski\UnwrapEnums\Tests;

use PHPUnit\Framework\TestCase;
use function Natepisarski\UnwrapEnums\unwrap_enums;

class TestUnwrapEnums extends TestCase
{
    public function test_we_can_unwrap_simple_enums(): void
    {
        $enum = TestingBackedEnum::One;
        $unwrapped = unwrap_enums($enum);
        $this->assertEquals('one', $unwrapped);
    }
}