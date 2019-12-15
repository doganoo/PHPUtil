<?php


namespace doganoo\PHPUtil\Service;


class User {

    public const PASSWORD_VALIDATION_UNSAFE = 1;
    public const PASSWORD_VALIDATION_BASIC  = 2;
    public const PASSWORD_VALIDATION_SECURE = 3;

    public function validEmail(string $email): bool {
        return \filter_var($email, \FILTER_VALIDATE_EMAIL) !== false;
    }

    public function validatePassword(string $password, int $mode = self::PASSWORD_VALIDATION_SECURE): bool {

        if ($mode === User::PASSWORD_VALIDATION_UNSAFE) {
            return $this->validatePasswordUnsafe($password);
        } else if ($mode === User::PASSWORD_VALIDATION_BASIC) {
            return $this->validatePasswordBasic($password);
        } else {
            return $this->validatePasswordSecure($password);
        }
    }

    private function validatePasswordUnsafe(string $password): bool {
        return \strlen($password) >= 8;
    }

    private function validatePasswordBasic(string $password): bool {
        $valid = $this->validatePasswordUnsafe($password);
        $valid = $valid && ((bool) preg_match("(^(?=.*[a-z])(?=.*[A-Z]).+$)", $password));
        return $valid;
    }

    private function validatePasswordSecure(string $password): bool {
        $valid = $this->validatePasswordUnsafe($password);
        return $valid && ((bool) preg_match("(^(?=.*[a-z])(?=.*[A-Z])(?=.*\d).+$)", $password));
    }

}