<?php

/**
 * @link https://github.com/rodzadra/yii2-geolocation
 * @copyright Copyright (c) 2015 rodzadra
 * @license http://opensource.org/licenses/GPL-3.0 GPL
 */

namespace rodzadra\geolocation;

use yii;
use yii\base\Component;

class Geolocation extends Component{
 
    /**
     *
     * @author rodzadra
     * @package rodzadra\yii2-geolocation
     */
    const GEOPLUGIN_URL = 'http://www.geoplugin.net/php.gp?ip=';


    public static $ipaddress = null;
    public static $clientInfoLocation = null;
    
    /**
     * Try to find the real client IP
     * 
     * @param string $ip
     * @return string
     */
    public static function findClientIP($ip=NULL) {
        self::$ipaddress = $ip;
        
        if (self::$ipaddress == null) {
            if (isset($_SERVER['HTTP_CLIENT_IP']))
                $ipaddress = $_SERVER['HTTP_CLIENT_IP'];
            else if (isset($_SERVER['HTTP_X_FORWARDED_FOR']))
                $ipaddress = $_SERVER['HTTP_X_FORWARDED_FOR'];
            else if (isset($_SERVER['HTTP_X_FORWARDED']))
                $ipaddress = $_SERVER['HTTP_X_FORWARDED'];
            else if (isset($_SERVER['HTTP_FORWARDED_FOR']))
                $ipaddress = $_SERVER['HTTP_FORWARDED_FOR'];
            else if (isset($_SERVER['HTTP_FORWARDED']))
                $ipaddress = $_SERVER['HTTP_FORWARDED'];
            else if (isset($_SERVER['REMOTE_ADDR']))
                $ipaddress = $_SERVER['REMOTE_ADDR'];
            else
                $ipaddress = NULL;
            
            self::$ipaddress = $ipaddress;
        }
        
        
        return self::$ipaddress;
    }
 
    /**
     * Returns client location info
     * 
     * 
     * @param string $ip
     * @return array
     */
    public static function getClientInfoLocation($ip=NULL) {
        if (self::$clientInfoLocation == null)
            self::$clientInfoLocation = (unserialize(file_get_contents(self::GEOPLUGIN_URL . self::findClientIP($ip))));
        return self::$clientInfoLocation;
    }
 
    /**
     * Return the client country name
     * 
     * @return string
     */
    public static function getClientCountry() {
        $dt = self::getClientInfoLocation();
        return strtolower($dt['geoplugin_countryName']);
    }
 
    /**
     * Returns the client country code
     * 
     * @return string
     */
    public static function getClientLangCode() {
        $dt = self::getClientInfoLocation();
        return strtolower($dt['geoplugin_countryCode']);
    }
 
}

