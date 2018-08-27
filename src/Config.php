<?php

namespace streltcov\geocoder;

/**
 * Class Config
 * Static singletone class, contains global settings
 *
 * @package streltcov\geocoder
 */
class Config
{

    private static $instance;

    private static $allowed_locales = [
        'RU' => 'ru_RU',
        'US' => 'en_US',
        'EN' => 'en_RU',
        'UA' => 'uk_UA',
        'BY' => 'be_BY',
        'TR' => 'tr_TR'
    ];

    private static $allowed_kinds = [
        'house',
        'street',
        'metro',
        'district',
        'locality',
        'province',
        'country',
        'hydro'
    ];

    private static $parameters = [
        'error' => false,
        'kind' => null,
        'skip' => null,
        'lang' => null
    ];


    /**
     * Config constructor
     */
    private function __construct()
    {

    } // end construct


    private function __clone()
    {

        // empty

    } // end function



    /**
     *
     */
    private function __wakeup()
    {

        //empty

    } // end function



    /**
     * @return mixed
     */
    public static function getConfig()
    {

        if (null === static::$instance) {
            static::$instance = new static();
        }

        return static::$instance;

    } // end function



    /**
     * sets all parameters to null
     *
     * @return boolean
     */
    public static function reset()
    {

        static::$parameters['lang'] = null;
        static::$parameters['skip'] = null;
        static::$parameters['kind'] = null;

        return true;

    } // end function



    /**
     * @param bool $error
     * @return bool
     */
    public static function setError($error)
    {

        if (is_bool($error)) {
            static::$parameters['error'] = $error;
            return true;
        }
        return false;

    } // end function



    /**
     *
     */
    public static function errorMessage()
    {

        switch (static::$parameters['error']) {
            case false:
                return null;
                break;
            case true:
                return "Error, check request";
                break;
        }

    } // end function



    /**
     * sets global locale
     * available languages - russian, english, english(USA), belorussian, turkish, ukrainian
     * (values listed in static::$allowed_locales)
     *
     * @param string $locale
     * @return boolean
     */
    public static function setLocale($locale)
    {

        if (in_array($locale, array_keys(static::$allowed_locales))) {
            static::$parameters['lang'] = static::$allowed_locales[$locale];
            return true;
        } elseif (null == $locale) {
            static::$parameters['lang'] = null;
            return true;
        }

        return false;

    } // end function



    /**
     * sets global kind parameter
     *
     * @param $kind
     */
    public static function setKind($kind)
    {

        if (in_array($kind, static::$allowed_kinds) || $kind == null) {
            static::$parameters['kind'] = $kind;
            return true;
        }

        return false;

    } // end function



    /**
     * sets global skip parameter
     *
     * @param $skip
     */
    public static function setSkip($skip)
    {

        if ((int)$skip > 0) {
            static::$parameters['skip'] = (int)$skip;
            return true;
        } elseif ((int)$skip == null || (int)$skip == 0) {
            static::$parameters['skip'] = null;
        }

        return false;

    } // end function



    /**
     * returns requested parameter value (if exist)
     *
     * @param string $key
     * @return mixed|null
     */
    public static function get($key)
    {

        if (isset(static::$parameters[$key])) {
            return static::$parameters[$key];
        }

        return null;

    } // end function

} // end class
