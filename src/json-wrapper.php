<?php

/**
 * @author Yvan Burrie
 * @package Fornax
 * @version 2020.07.09
 * @license MIT
 */

namespace Fornax;

/**
 * JSON Serialization Wrapper.
 * @package Fornax
 */
abstract class Json
{
    /**
     * @param mixed $decoded
     * @throws JsonException
     * @return string
     */
    public static function encode($decoded)
    {
        $encoded = @json_encode($decoded);

        self::lastException();

        return $encoded;
    }

    /**
     * @param string $encoded
     * @throws JsonException
     * @return mixed
     */
    public static function decode($encoded)
    {
        $decoded = @json_decode($encoded);

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
     */
    protected static function lastException()
    {
        switch (@json_last_error())
        {
            case JSON_ERROR_NONE:
                return;
            case JSON_ERROR_DEPTH:
                throw new DepthJsonException;
            case JSON_ERROR_STATE_MISMATCH:
                throw new UnderflowJsonException;
            case JSON_ERROR_CTRL_CHAR:
                throw new ControlJsonException;
            case JSON_ERROR_SYNTAX:
                throw new SyntaxJsonException;
            case JSON_ERROR_UTF8:
                throw new MalformedJsonException;
            case JSON_ERROR_RECURSION:
                throw new RecursionJsonException;
            case JSON_ERROR_INF_OR_NAN:
                throw new InfOrNanJsonException;
            case JSON_ERROR_UNSUPPORTED_TYPE:
                throw new UnsupportedJsonException;
            default:
                throw new UndefinedJsonException;
        }
    }
}

use Exception;

/**
 * JSON Implementation error.
 */
abstract class JsonException extends Exception
{
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
