<?php
namespace App\Attributes;

use Attribute;

#[Attribute(Attribute::TARGET_METHOD | Attribute::IS_REPEATABLE)]
class AppRoute
{
    public function __construct(
        public string $path,
        public ?string $method = null,
        public ?string $name = null,
        public ?string $action = null
    )
    {}
}