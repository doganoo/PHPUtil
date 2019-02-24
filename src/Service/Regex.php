<?php


namespace doganoo\PHPUtil\Service;

/**
 * Class Regex
 * @package doganoo\PHPUtil\Service
 */
class Regex {
    public const PHONE_NUMBERS_REGEX = "<^((\\+|00)[1-9]\\d{0,3}|0 ?[1-9]|\\(00? ?[1-9][\\d ]*\\))[\\d\\-/ ]*$>";
    public const UNWANTED_CHARS_IN_PHONE_STRING = "/[^0-9\\+\\(\\)\\-\\/]/";

    /**
     * strips all email adresses out of an string. More information at:
     * https://stackoverflow.com/questions/1028553/how-to-get-email-address-from-a-long-string
     *
     * @param string $dump
     * @param bool $unique
     * @return array
     */
    public function stripAddresses(string $dump, bool $unique = true): array {
        $emails = [];
        foreach (preg_split('/\s/', $dump) as $token) {
            $email = filter_var(filter_var($token, FILTER_SANITIZE_EMAIL), FILTER_VALIDATE_EMAIL);
            if ($email !== false) {
                $emails[] = $email;
            }
        }
        if ($unique) {
            $emails = \array_unique($emails);
        }
        return $emails;
    }

    /**
     * @param string $dump
     * @param bool $unique
     * @return array
     */
    public function stripPhoneNumbers(string $dump, bool $unique): array {

        $numbers = [];

        $delimiter = ";";
        $dump = \str_replace(" ", "", $dump);
        $res = preg_replace(Regex::UNWANTED_CHARS_IN_PHONE_STRING, $delimiter, $dump);
        $array = \explode($delimiter, $res);

        foreach ($array as $value) {
            if (\preg_match(Regex::PHONE_NUMBERS_REGEX, $value)) {
                $value = preg_replace("<^\\+>", "00", $value);
                $value = preg_replace("<\\D+>", "", $value);
                $numbers[] = $value;
            }
        }

        if ($unique) {
            $numbers = \array_unique($numbers);
        }
        return $numbers;
    }
}