<?php

namespace PE\Component\Grid\DataMapper;

use PE\Component\Grid\Exception\InvalidArgumentException;
use PE\Component\Grid\Exception\RuntimeException;
use PE\Component\Grid\Exception\UnexpectedValueException;

class ReflectionDataMapper implements DataMapperInterface
{
    protected static $reflections = [];

    /**
     * @inheritDoc
     */
    public function getValue($data, $field)
    {
        if (!is_array($data) && !is_object($data)) {
            throw new UnexpectedValueException($data, 'array or object');
        }

        if (is_array($data)) {
            if (!array_key_exists($field, $data)) {
                throw new InvalidArgumentException(sprintf('Array key "%s" does not exists', $field));
            }

            return $data[$field];
        }

        $class      = get_class($data);
        $reflection = array_key_exists($class, static::$reflections)
            ? static::$reflections[$class]
            : static::$reflections[$class] = new \ReflectionClass($class);

        $camelized = $this->camelize($field);
        $getter    = 'get' . $camelized;
        $isser     = 'is' . $camelized;
        $hasser    = 'has' . $camelized;

        if ($reflection->hasMethod($getter) && $reflection->getMethod($getter)->isPublic()) {
            return $data->{$getter}();
        } else if ($reflection->hasMethod($isser) && $reflection->getMethod($isser)->isPublic()) {
            return $data->{$isser}();
        } else if ($reflection->hasMethod($hasser) && $reflection->getMethod($hasser)->isPublic()) {
            return $data->{$hasser}();
        } else if ($reflection->hasProperty($field) && $reflection->getProperty($field)->isPublic()) {
            return $data->{$field};
        } else {
            throw new RuntimeException(sprintf(
                'Neither the property "%s" nor one of the methods "%s()" '.
                'exist and have public access in class "%s".',
                $field,
                implode('()", "', [$getter, $isser, $hasser]),
                $reflection->name
            ));
        }
    }

    /**
     * @inheritDoc
     */
    public function setValue(&$data, $field, $value)
    {
        if (!is_array($data) && !is_object($data)) {
            throw new UnexpectedValueException($data, 'array or object');
        }

        if (is_array($data)) {
            $data[$field] = $value;
            return;
        }

        $class      = get_class($data);
        $reflection = array_key_exists($class, static::$reflections)
            ? static::$reflections[$class]
            : static::$reflections[$class] = new \ReflectionClass($class);

        $camelized = $this->camelize($field);
        $setter    = 'set' . $camelized;

        if ($reflection->hasMethod($setter) && $reflection->getMethod($setter)->isPublic()) {
            $data->{$setter}($value);
        } else if ($reflection->hasProperty($field) && $reflection->getProperty($field)->isPublic()) {
            $data->{$field} = $value;
        } else {
            throw new RuntimeException(sprintf(
                'Neither the property "%s" nor one of the methods "%s()" '.
                'exist and have public access in class "%s".',
                $field,
                implode('()", "', [$setter]),
                $reflection->name
            ));
        }
    }

    /**
     * @param string $string
     *
     * @return string
     */
    protected function camelize($string)
    {
        return preg_replace_callback('/(^|_|\.)+(.)/', function ($match) {
            return ('.' === $match[1] ? '_' : '') . strtoupper($match[2]);
        }, $string);
    }
}