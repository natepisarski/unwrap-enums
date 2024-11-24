<?php
declare(strict_types=1);

namespace Natepisarski\UnwrapEnums\Tests;

use Natepisarski\UnwrapEnums\EnumUnwrapException;
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

    public function test_we_cannot_unwrap_enums_without_backing_values(): void
    {
        $enum = TestingUnitEnum::One;
        $this->expectException(EnumUnwrapException::class);
        unwrap_enums($enum);
    }

    public function test_we_cannot_unwrap_enums_without_backing_values_in_arrays(): void
    {
        $this->expectException(EnumUnwrapException::class);
        $enums = [TestingBackedEnum::One, TestingUnitEnum::Two, TestingUnitEnum::Three];
        unwrap_enums($enums);
    }

    public function test_we_can_unwrap_nested_non_backed_enums_if_recursive_is_off(): void
    {
        $enums = [TestingBackedEnum::One, [TestingUnitEnum::One, TestingUnitEnum::Two]];
        $unwrapped = unwrap_enums($enums, false);
        $this->assertEquals(['one', [TestingUnitEnum::One, TestingUnitEnum::Two]], $unwrapped);
    }

    public function test_we_can_unwrap_iterables_of_enums(): void
    {
        $enums = [TestingBackedEnum::One, TestingBackedEnum::Two, TestingBackedEnum::Three];
        $unwrapped = unwrap_enums($enums);
        $this->assertEquals(['one', 'two', 'three'], $unwrapped);
    }

    public function test_we_can_unwrap_raw_values(): void
    {
        $unwrapped = unwrap_enums(1);
        $this->assertEquals(1, $unwrapped);

        $unwrapped = unwrap_enums('string');
        $this->assertEquals('string', $unwrapped);
    }

    public function test_we_can_unwrap_mixed_arrays(): void
    {
        $unwrappedArray = [TestingBackedEnum::One, 1, 'string', TestingBackedEnum::Three];
        $unwrapped = unwrap_enums($unwrappedArray);
        $this->assertEquals(['one', 1, 'string', 'three'], $unwrapped);
    }

    public function test_we_can_recursively_unwrap(): void
    {
        $enums = [TestingBackedEnum::One, [TestingBackedEnum::Two, [TestingBackedEnum::Three]]];
        $unwrapped = unwrap_enums($enums);
        $this->assertEquals(['one', ['two', ['three']]], $unwrapped);
    }

    public function test_unwrapping_is_not_recursive_when_recursive_flag_is_false(): void
    {
        $enums = [TestingBackedEnum::One, [TestingBackedEnum::Two, [TestingBackedEnum::Three]]];
        $unwrapped = unwrap_enums($enums, false);
        $this->assertEquals(['one', [TestingBackedEnum::Two, [TestingBackedEnum::Three]]], $unwrapped);
    }

    public function test_unwrapping_null_is_null_still(): void
    {
        $value = unwrap_enums(null);
        $this->assertNull($value);
    }
}