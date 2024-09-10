<?php

namespace Sergeich5\LaravelTable\Builder;

use Carbon\Carbon;

class Column
{
    const INTEGER_FORMAT = 1;
    const PERCENT_FORMAT = 2;
    const DATE_FORMAT = 3;

    public string $value;
    public string $key;

    public bool $rowSpanable = false;

    public ?string $rowSpanToColumnKey = null;

    private ?string $format = null;
    private ?string $formatAs = null;

    private $class = null;

    function __construct(string $value, string $key)
    {
        $this->value = $value;
        $this->key = $key;
    }

    static function make(string $value, string $key): self
    {
        return new self($value, $key);
    }

    function setRowSpanable(bool $rowSpanable, ?string $rowspanToColumnKey = null): self
    {
        $this->rowSpanable = $rowSpanable;

        $this->rowSpanToColumnKey = ($rowSpanable)
            ? $rowspanToColumnKey
            : null;

        return $this;
    }

    function toDateFormat(string $format = 'Y-m-d'): self
    {
        $this->format = self::DATE_FORMAT;
        $this->formatAs = $format;
        return $this;
    }

    function toIntegerFormat(): self
    {
        $this->format = self::INTEGER_FORMAT;
        $this->formatAs = null;
        return $this;
    }

    function toPercentFormat(): self
    {
        $this->format = self::PERCENT_FORMAT;
        $this->formatAs = null;
        return $this;
    }

    function format($value): string
    {
        switch ($this->format) {
            case self::INTEGER_FORMAT:
                return number_format($value, 0, ',', ' ');
            case self::PERCENT_FORMAT:
                return number_format($value * 100, '2', ',', ' ') . '%';
            case self::DATE_FORMAT:
                return Carbon::parse($value)->format($this->formatAs);
            default:
                return $value;
        }
    }

    /**
     * @param string|array|callable $class
     */
    function setClasses($class): self
    {
        $this->class = $class;
        return $this;
    }

    function classes($value): array
    {
        $result = (is_callable($this->class))
            ? call_user_func($this->class, $value)
            : $this->class;

        if (is_string($result))
            $result = [$result];
        elseif (is_array($result)) {
        } else
            $result = [];

        switch ($this->format) {
            case self::INTEGER_FORMAT:
                $result[] = 'int';
                break;
            case self::PERCENT_FORMAT:
                $result[] = 'percent';
                break;
            case self::DATE_FORMAT:
                $result[] = 'date';
                break;
        }

        return $result;
    }
}