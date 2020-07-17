<?php

/**
 * @author Yvan Burrie
 * @package Fornax
 * @version 2020.07.17
 * @license MIT
 */

namespace Fornax;

/**
 * JSON Serialization Wrapper.
 * @package Fornax
 */
class Json
{
    protected $options = null;

    protected $depth = null;

    protected $associative = null;

    /**
     * @param mixed $decoded
     * @return string
     * @throws JsonException
     */
    public function encode($decoded)
    {
        $args = array(
            $decoded,
            $this->options,
            $this->depth,
        );
        if ($args[2] === null)
        {
            unset($args[2]);
        }
        if ($args[1] === null)
        {
            if (count($args) === 2)
            {
                unset($args[1]);
            }
            else
            {
                $args[1] = 0;
            }
        }
        $encoded = @call_user_func_array('json_encode', $args);

        self::lastException();

        return $encoded;
    }

    /**
     * @param string $encoded
     * @return mixed
     * @throws JsonException
     */
    public function decode($encoded)
    {
        $args = array(
            $encoded,
            $this->associative,
            $this->depth,
            $this->options,
        );
        if ($args[3] === null)
        {
            unset($args[3]);
        }
        if ($args[2] === null)
        {
            if (count($args) === 3)
            {
                unset($args[2]);
            }
            else
            {
                $args[2] = 512;
            }
        }
        if ($args[1] === null)
        {
            if (count($args) === 2)
            {
                unset($args[1]);
            }
            else
            {
                $args[1] = 512;
            }
        }
        $decoded = @call_user_func_array('json_decode', $args);

        self::lastException();

        return $decoded;
    }

    /**
     * Throws an exceptions if an error occurred.
     * @throws DepthJsonException
     * @throws UnderflowJsonException
     * @throws ControlJsonException
     * @throws SyntaxJsonException
     * @throws MalformedJsonException
     * @throws RecursionJsonException
     * @throws InfOrNanJsonException
     * @throws UnsupportedJsonException
     * @throws UndefinedJsonException
     * @throws InvalidPropertyJsonException
     * @throws Utf16JsonException
     */
    protected function lastException()
    {
        if (PHP_MAJOR_VERSION >= 5 && PHP_MINOR_VERSION >= 5)
        {
            $message = @\json_last_error_msg();
        }
        else
        {
            $message = '';
        }

        $code = @\json_last_error();

        switch ($code)
        {
            case JSON_ERROR_NONE:
                return;
            case JSON_ERROR_DEPTH:
                throw new DepthJsonException($message);
            case JSON_ERROR_STATE_MISMATCH:
                throw new UnderflowJsonException($message);
            case JSON_ERROR_CTRL_CHAR:
                throw new ControlJsonException($message);
            case JSON_ERROR_SYNTAX:
                throw new SyntaxJsonException($message);
            case JSON_ERROR_UTF8:
                throw new MalformedJsonException($message);
        }
        if (PHP_MAJOR_VERSION >= 5 && PHP_MINOR_VERSION >= 5)
        {
            switch ($code)
            {
                case JSON_ERROR_RECURSION:
                    throw new RecursionJsonException($message);
                case JSON_ERROR_INF_OR_NAN:
                    throw new InfOrNanJsonException($message);
                case JSON_ERROR_UNSUPPORTED_TYPE:
                    throw new UnsupportedJsonException($message);
            }
        }
        if (PHP_MAJOR_VERSION >= 7)
        {
            switch ($code)
            {
                case JSON_ERROR_INVALID_PROPERTY_NAME:
                    throw new InvalidPropertyJsonException($message);
                case JSON_ERROR_UTF16:
                    throw new Utf16JsonException($message);
            }
        }
        throw new UndefinedJsonException($message);
    }
}

use Exception;

if (PHP_MAJOR_VERSION >= 7 && PHP_MINOR_VERSION >= 3)
{
    abstract class JsonException extends \JsonException
    {
    }
}
else
{
    abstract class JsonException extends Exception
    {
    }
}

/**
 * JSON Nesting level error.
 */
final class DepthJsonException extends JsonException
{
}

/**
 * JSON State mismatch error.
 */
final class UnderflowJsonException extends JsonException
{
}

/**
 * JSON Control character error.
 */
final class ControlJsonException extends JsonException
{
}

/**
 * JSON Syntax error.
 */
final class SyntaxJsonException extends JsonException
{
}

/**
 * JSON Malformed characters error.
 */
final class MalformedJsonException extends JsonException
{
}

/**
 * JSON Recursive references error.
 */
final class RecursionJsonException extends JsonException
{
}

/**
 * JSON INF or NAN value error.
 */
final class InfOrNanJsonException extends JsonException
{
}

/**
 * JSON Unsupported value error.
 */
final class UnsupportedJsonException extends JsonException
{
}

/**
 * JSON undefined error.
 */
final class UndefinedJsonException extends JsonException
{
}

/**
 *
 */
final class InvalidPropertyJsonException extends JsonException
{
}

/**
 *
 */
final class Utf16JsonException extends JsonException
{
}
