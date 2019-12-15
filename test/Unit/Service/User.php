<?php


use doganoo\PHPUtil\Service\User as UserService;
use PHPUnit\Framework\TestCase;

class User extends TestCase {

    public function testValidMail() {
        $userService = new UserService();
        $this->assertTrue(true === $userService->validEmail("test@test.de"));
        $this->assertTrue(false === $userService->validEmail("test@test"));
        $this->assertTrue(false === $userService->validEmail("phputil"));
    }

    public function testValidPassword() {
        $userService = new UserService();
        $this->assertTrue(true === $userService->validatePassword("doganoophputil", UserService::PASSWORD_VALIDATION_UNSAFE));
        $this->assertTrue(false === $userService->validatePassword("phputil", UserService::PASSWORD_VALIDATION_UNSAFE));
        $this->assertTrue(true === $userService->validatePassword("Doganoophputil", UserService::PASSWORD_VALIDATION_BASIC));
        $this->assertTrue(false === $userService->validatePassword("phputil", UserService::PASSWORD_VALIDATION_BASIC));
        $this->assertTrue(true === $userService->validatePassword("Doganoophputil2", UserService::PASSWORD_VALIDATION_SECURE));
        $this->assertTrue(false === $userService->validatePassword("phputil", UserService::PASSWORD_VALIDATION_SECURE));
    }

}