<?php

namespace Core;

use Core\Exceptions\RuleNotFoundException;

class Validator
{
    public static function check(array $constraints): array
    {
        $_SESSION['errors'] = [];
        $_SESSION['old'] = [];

        $request_data = array_filter(
            $_POST,
            fn(string $k) => $k !== '_method' && $k !== '_csrf',
            ARRAY_FILTER_USE_KEY
        );

        try {
            self::parse_constraints($constraints);
        } catch (RuleNotFoundException $e) {
            //die($e->getMessage());
            Response::abort(Response::SERVER_ERROR);
        }

        if (count($_SESSION['errors']) > 0) {
            $_SESSION['old'] = $request_data;
            Response::redirect($_SERVER['HTTP_REFERER']);
        }

        return $request_data;
    }

    private static function parse_constraints(array $constraints): void
    {
        $value = null;
        $method = $rule = '';
        $sub_value = null;

        foreach ($constraints as $key => $rules) {
            $rules = explode('|', $rules);
            foreach ($rules as $rule) {
                if (str_contains($rule, ':')) {
                    $rule_arr = explode(':', $rule);
                    [$method, $value] = $rule_arr;
                    if (str_contains($value, ',')){
                       [$value, $sub_value] = explode(',', $value);
                    }
                } else {
                    $method = $rule;
                }
                if (!method_exists(self::class, $method)) {
                    throw new RuleNotFoundException($rule);
                }
                self::$method($key, $value, $sub_value);
            }
        }
    }

    private static function datetime(string $key): bool
    {
        if (!date_create_from_format('Y-m-d H:i', $_POST[$key])) {
            $_SESSION['errors'][$key] = 'La date doit est une date au format AAAA-MM-JJ HH:MM';
            return false;
        }
        return true;
    }

    private static function max(string $key, int $value): bool
    {
        if (mb_strlen($_POST[$key]) > $value) {
            $_SESSION['errors'][$key] = "{$key} doit avoir une taille maximum de {$value} caractères";
            return false;
        }
        return true;
    }

    private static function min(string $key, int $value): bool
    {
        if (mb_strlen($_POST[$key]) < $value) {
            $_SESSION['errors'][$key] = "{$key} doit avoir une taille minimum de {$value} caractères";
            return false;
        }
        return true;
    }

    private static function email(string $key): bool
    {
        $email = $_REQUEST[$key];
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $_SESSION['errors'][$key] = "{$key} doit être un email valide";
            return false;
        }
        return true;
    }
    private static function exists(string $key, string $model_name, string $column): bool
    {
        $email = $_REQUEST[$key];
        $model_name = 'App\\Models\\'.ucfirst($model_name);
        $model = new $model_name(base_path('.env.local.ini'));
        $method = 'findBy' . ucfirst($column);

        if (!$model->$method($email)) {
            $_SESSION['errors'][$key] = "{$key} n'existe pas dans la base de données";
            return false;
        }
        return true;
    }
    private static function digits(string $key): bool
    {
        $string = $_REQUEST[$key];
        $pattern = '/\d/';
        if (!preg_match($pattern, $string)) {
            $_SESSION['errors'][$key] = "{$key} doit contenir au moins un chiffre";
            return false;
        }
        return true;
    }
    private static function specials(string $key): bool
    {
        $string = $_REQUEST[$key];
        $pattern = '/[+\-*\/?!_]/';
        if (!preg_match($pattern, $string)) {
            $_SESSION['errors'][$key] = "{$key} doit contenir au moins un caractére spécial parmis '+-*?!_";
            return false;
        }
        return true;
    }

    private static function required(string $key): bool
    {
        if (empty($_POST[$key])) {
            $_SESSION['errors'][$key] = "{$key} doit obligatoirement être fourni";
            return false;
        }
        return true;
    }
}