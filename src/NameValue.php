<?php

namespace Omnipay\Vindicia;

use InvalidArgumentException;

/**
 * Class to represent Vindicia's NameValue objects, which are used to build
 * many requests.
 */
class NameValue
{
    /**
     * @var string
     */
    public $name;

    /**
     * @var string|int|bool|null
     */
    public $value;

    /**
     * Constructs NameValue. Values can be string, ints, bools, or null and will be converted
     * to strings, as is required for Vindicia's API.
     *
     * @param string $name
     * @param string|int|bool|float|null $value
     * @psalm-suppress FailedTypeResolution Because we're making sure a non-string isn't passed at runtime
     */
    public function __construct($name, $value)
    {
        if (!is_string($name)) {
            throw new InvalidArgumentException('Parameter name must be type string, not ' . gettype($name));
        }
        $this->name = $name;

        if ($value === null) {
            $this->value = 'null';
        } elseif (is_int($value) || is_float($value)) {
            $this->value = strval($value);
        } elseif (is_bool($value)) {
            // this attribute name actually takes a boolean value for some reason
            if ($name == 'vin_PaymentMethod_active') {
                $this->value = $value;
            } else {
                $this->value = $value ? 'true' : 'false';
            }
        } elseif (is_string($value)) {
            $this->value = $value;
        } else {
            throw new InvalidArgumentException('Invalid type ' . gettype($value) . ' for parameter value');
        }
    }
}
