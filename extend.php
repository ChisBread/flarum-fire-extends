<?php

use Flarum\Extend;
use Flarum\User\UserValidator;
use Illuminate\Support\Str;

return [
      // Register extenders here
    (new Extend\Validator(UserValidator::class))
        ->configure(function ($flarumValidator, $validator) {
        $rules = $validator->getRules();

        if (!array_key_exists('password', $rules)) {
            return;
        }
        $has_min = false;
        $has_max = false;
        // password限制
        $rules['password'] = array_map(function (string $rule) {
            if (Str::startsWith($rule, 'min:')) {
                $has_min = true;
                return 'min:4';
            }
            if (Str::startsWith($rule, 'max:')) {
                $has_max = true;
                return 'max:12';
            }
            return $rule;
        }, $rules['password']);
        if (!$has_min) {
            $rules['password'][] = 'min:4';
        }
        if (!$has_max) {
            $rules['password'][] = 'max:12';
        }
        $has_min = false;
        $has_max = false;
        // username限制
        $rules['username'] = array_map(function (string $rule) {
            if (Str::startsWith($rule, 'min:')) {
                $has_min = true;
                return 'min:4';
            }
            if (Str::startsWith($rule, 'max:')) {
                $has_max = true;
                return 'max:12';
            }
            return $rule;
        }, $rules['username']);
        if (!$has_min) {
            $rules['username'][] = 'min:4';
        }
        if (!$has_max) {
            $rules['username'][] = 'max:12';
        }
        $validator->setRules($rules);
    }),
];
