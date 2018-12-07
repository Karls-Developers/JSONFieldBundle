<?php
namespace Karls\JSONFieldBundle\SchemaType\Types\Input;

use GraphQL\Type\Definition\InputObjectType;
use GraphQL\Type\Definition\Type;

class JSONFieldInputType extends InputObjectType
{
    public function __construct()
    {
        parent::__construct(
            [
                'fields' => [
                    'json' => [
                        'type' => Type::string(),
                        'description' => 'The JSON Field for a Content Type',
                    ]
                ],
            ]
        );
    }
}