<?php

namespace usages;

/**
 * Utility class for sanitizing and validating user inputs.
 * Prevents SQL injection, XSS, and other common vulnerabilities.
 */
class DataFilter
{
    /**
     * Sanitizes a string to prevent SQL injection and XSS.
     * Trims whitespace and escapes special HTML characters.
     *
     * @param string $data The raw string input to sanitize.
     * @return string The sanitized string.
     */
    public static function sanitizeString(string $data): string
    {
        return htmlspecialchars(trim($data), ENT_QUOTES, 'UTF-8');
    }

    /**
     * Validates an email address.
     *
     * @param string $email The raw email input to validate.
     * @return string|null Returns the validated email if valid, otherwise null.
     */
    public static function validateEmail(string $email): ?string
    {
        return filter_var($email, FILTER_VALIDATE_EMAIL) ? $email : null;
    }

    /**
     * Filters an integer value.
     *
     * @param mixed $number The raw input to filter.
     * @return int|null Returns the filtered integer if valid, otherwise null.
     */
    public static function filterInt($number): ?int
    {
        return filter_var($number, FILTER_VALIDATE_INT, FILTER_NULL_ON_FAILURE);
    }

    /**
     * Filters a boolean value.
     *
     * @param mixed $bool The raw input to filter.
     * @return bool|null Returns the filtered boolean if valid, otherwise null.
     */
    public static function filterBool($bool): ?bool
    {
        return filter_var($bool, FILTER_VALIDATE_BOOLEAN, FILTER_NULL_ON_FAILURE);
    }
}
