<?php


/**
 * @link https://github.com/rodzadra/yii2-geolocation
 * @version 0.0.2
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
    
    public $config = ['provider'=>NULL,'return_format'=>NULL, 'api_key'=>NULL];
        
    private static $plugins         = array();      
    private static $provider        = NULL;       
    private static $return_format   = NULL;
    private static $api_key         = NULL;


    public function __construct($config = array()) {
                
        self::$plugins = array_diff(scandir((__DIR__).'/plugins/'), array('..', '.'));
        
        if (isset($config['config']['provider'])) {

            $provider = $config['config']['provider'];

            if (in_array($provider . ".php", self::$plugins)) {

                require (__DIR__) . '/plugins/' . $provider . '.php';

                if (isset($config['config']['return_format'])) {
                    $format = $config['config']['return_format'];
                    
                    if(in_array($format, $plugin['accepted_formats'])){
                        self::$return_format = $format;
                    } else {
                        self::$return_format = $plugin['default_accepted_format'];
                    }
                }

                self::$provider = $plugin;
                
                self::$api_key = (isset($config['config']['api_key']))?$config['config']['api_key']:NULL;

            } else {
                throw new \yii\web\HttpException(404, 'The requested Item could not be found.');
            }
        } else {
            require (__DIR__) . '/plugins/geoplugin.php';
            self::$provider = $plugin;
            self::$return_format = $plugin['default_accepted_format'];
        }

        return parent::__construct($config);
    }
   
    /**
     * Creates the plugin URL
     * 
     * @param strint $ip
     * @return string
     */
    private static function createUrl($ip){
        $urlTmp = preg_replace('!\{\{(accepted_formats)\}\}!', self::$return_format, self::$provider['plugin_url']);
        $urlTmp = preg_replace('!\{\{(ip)\}\}!', $ip, $urlTmp);
        
        if(isset(self::$api_key))
            $urlTmp = preg_replace('!\{\{(api_key)\}\}!', self::$api_key, $urlTmp);
        
        return $urlTmp;
    }
    
    /**
     * Returns client info
     * 
     * @param string $ip You can supply an IP address or none to use the current client IP address
     * @return mixed
     */
    public static function getInfo($ip=NULL){
        
        $url = self::createUrl($ip);
        
        //print_r($url); exit;
        
        if(self::$return_format == 'php')
            return unserialize(file_get_contents($url));
        else
            return file_get_contents($url);
    }    
    
    
    /**
     * 
     * Changes the used plugin
     * 
     * @param string $provider The provider plugin name
     * @param string $format The data return format
     */
    public static function getPlugin($provider=NULL, $format=NULL, $api_key=NULL){
        
        self::$plugins = array_diff(scandir((__DIR__).'/plugins/'), array('..', '.'));
        
        if(isset($api_key)){
            self::$api_key = $api_key;
        }
        
        
        if (in_array($provider . ".php", self::$plugins)) {

            require (__DIR__) . '/plugins/' . $provider . '.php';

            if(in_array($format, $plugin['accepted_formats'])){
                self::$return_format = $format;
            } else {
                self::$return_format = $plugin['default_accepted_format'];
            }

            self::$provider = $plugin;
        }

    }

 
}

