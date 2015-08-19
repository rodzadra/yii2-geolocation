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
    const GEOPLUGIN_URL = 'http://www.geoplugin.net/';
    const FREEGEOIP_URL = 'http://freegeoip.net/';
    const FORMAT_CSV    = 'csv';
    const FORMAT_JSON   = 'json';
    const FORMAT_XML    = 'xml';
    const FORMAT_PHP    = 'php';

    public $config = array();
    
    public static $provider     = self::GEOPLUGIN_URL;
    public static $format       = self::FORMAT_PHP;
    public static $unserialize  = FALSE;

    public static $ipaddress            = null;
    public static $clientInfoLocation   = null;
    
    public function __construct($config = array()) {
        
        //print_r($config); exit;
        
        if(isset($config['config']['provider']) && in_array($config['config']['provider'], ['geoplugin', 'freegeoip'])){
                self::$provider = ($config['config']['provider'] == 'geoplugin')?self::GEOPLUGIN_URL:self::FREEGEOIP_URL;
                
        } else {
                self::$provider = self::GEOPLUGIN_URL;
        }
        
        if(isset($config['config']['format'])){
            
            if(in_array($config['config']['format'], [self::FORMAT_CSV, self::FORMAT_JSON, self::FORMAT_XML, self::FORMAT_PHP])){
                self::$format = $config['config']['format'];                
            } else {
                if(self::$provider == self::GEOPLUGIN_URL){
                    self::$format = self::FORMAT_PHP;
                } else {
                    self::$format = self::FORMAT_JSON;
                }
            }
            
            
        }
        
        if(self::$provider == self::GEOPLUGIN_URL && self::$format == self::FORMAT_CSV){
            self::$format = self::FORMAT_PHP;
            self::$unserialize = TRUE;
        } elseif(self::$provider == self::FREEGEOIP_URL && self::$format == self::FORMAT_PHP){
            self::$format = self::FORMAT_JSON;
        }
        
        if(isset($config['config']['unserialize'])){
            if(self::$format !== self::FORMAT_PHP){
                self::$unserialize = FALSE;
            } else {
                self::$unserialize = $config['config']['unserialize'];
            }
        }
        
        self::createUrl();
        
        return parent::__construct($config);
        
    }

        /**
     * Try to find the real client IP
     * 
     * @param string $ip
     * @return string
     */
    private static function findClientIP($ip=NULL) {
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
            self::$clientInfoLocation = self::getContents($ip); //(self::$unserialize)?unserialize(file_get_contents(self::$provider . self::findClientIP($ip))):file_get_contents(self::$provider . self::findClientIP($ip));
        
            //self::$clientInfoLocation = (unserialize(file_get_contents(self::GEOPLUGIN_URL . self::findClientIP($ip))));
        return self::$clientInfoLocation;
    }
    
    
    private static function createUrl(){
        if(self::$provider == self::GEOPLUGIN_URL){
            self::$provider .= self::$format.".gp?ip=";
        } elseif(self::$provider == self::FREEGEOIP_URL){
          self::$provider .= self::$format."/";
        }
        
        //print_r(self::$provider); exit;
    }
    
    private static function getContents($ip=NULL){
        if(self::$unserialize)
            return unserialize(file_get_contents(self::$provider . self::findClientIP($ip)));
        else
            return file_get_contents(self::$provider . self::findClientIP($ip));
                
    }


 
}

