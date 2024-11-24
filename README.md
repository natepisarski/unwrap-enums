# `unwrap_enums`
Provides a function to safely unwrap Enums into their constituent values.

## Installation
```shell
composer require natepisarski/unwrap-enums
```

## Usage
```php
enum Day: string {
    case Monday = 'monday';
    case Tuesday = 'tuesday';
    case Wednesday = 'wednesday';
}

unwrap_enums(Day::Monday); // 'monday'
unwrap_enums([Day::Monday, Day::Tuesday]); // ['monday', 'tuesday']
unwrap_enums([Day::Monday, [Day::Tuesday, Day::Wednesday]], recursive: true); // ['monday', ['tuesday', 'wednesday']]

unwrap_enums('monday'); // 'monday' - already unwrapped
unwrap_enums(null); // null - nothing to unwrap 
```

## Error Handling
* A `EnumUnwrapException` can be thrown if you attempt to unwrap a non-backed Unit enum.