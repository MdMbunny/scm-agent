<?php
/**
 * Plugin Name:         SCM Agent
 * Plugin URI:          http://studiocreativo-m.it/
 * Description:         SCM Plugin Description
 * Version:             1.0.1
 * Author:              Studio Creativo M
 * Author URI:          http://studiocreativo-m.it/
 * License:             http://www.gnu.org/licenses/gpl-3.0.html
 * GitHub Plugin URI:   MdMbunny/scm-agent
 * GitHub Branch:       master
 */

// *****************************************************
// *      0.0 INIT - [AUTOMATIC - DO NOT TOUCH]
// *****************************************************

    if ( ! function_exists( 'scm_plugin_data' ) ) {
        function scm_plugin_data( $file ) {
            if ( ! function_exists( 'get_plugins' ) )
                require_once( ABSPATH . 'wp-admin/includes/plugin.php' );

            $plugin_folder = get_plugins( '/' . plugin_basename( dirname( $file ) ) );
            $plugin_file = basename( ( $file ) );
            $plugin = $plugin_folder[ $plugin_file ];

            $name = $plugin[ 'Name' ];
            $version = $plugin[ 'Version' ];
            $slug = sanitize_title( $name );
            $const = strtoupper( str_replace( '-', '_', $slug ) );
            $dir = dirname( $file ) . '/';
            $uri = plugin_dir_url( $file );

            // PLUGIN CONSTANTS
            define( $const,                             $slug );
            define( $const . '_VERSION',                $version );
            define( $const . '_DIR',                    $dir );
            define( $const . '_URI',                    $uri );
            define( $const . '_DIR_ASSETS',             $dir . 'assets/' );
            define( $const . '_URI_ASSETS',             $uri . 'assets/' );
            define( $const . '_DIR_LANG',               $dir . 'lang/' );
            define( $const . '_URI_LANG',               $uri . 'lang/' );

            load_plugin_textdomain( $slug, false, $dir . 'lang/' );   
        }
    }

    scm_plugin_data( __FILE__ ); 


// ***************************************************************************************************************************************************************
// ***************************************************************************************************************************************************************
// *** CUSTOM CODE GOES HERE *************************************************************************************************************************************
// ***************************************************************************************************************************************************************
// ***************************************************************************************************************************************************************

$scm_useragent = ( isset( $_SERVER['HTTP_USER_AGENT'] ) ? $_SERVER['HTTP_USER_AGENT'] : '' );

if ( ! class_exists( 'BrowserDetection' ) )
    require_once( 'BrowserDetection.php' );

$scm_agent = new BrowserDetection();

if ( ! class_exists( 'Mobile_Detect' ) )
    require_once( 'Mobile_Detect.php' );

$scm_mobile = new Mobile_Detect();
$scm_mobile->setDetectionType( 'extended' );

/*
*****************************************************
*
*   0.0 Actions and Filters
*   1.0 Assets
*
*****************************************************
*/

// *****************************************************
// *      0.0 ACTIONS AND FILTERS
// *****************************************************

// *****************************************************
// *      1.0 ASSETS
// *****************************************************

function scm_agent( $opt = '' ){

    global $scm_useragent;
    global $scm_mobile;
    global $scm_agent;

    if( $opt && is_string( $opt ) ){
        switch( $opt ) {
            // User Agent
            case 'agent': return $scm_agent->getUserAgent(); break;
            // Browser
            case 'name': return str_replace( 'Internet Explorer', 'IE', $scm_agent->getName() ); break;
            case 'slug': return sanitize_title( $scm_agent->getName() ); break;
            case 'version': return $scm_agent->getVersion(); break;
            case 'ver':
                $r = explode( '.', $scm_agent->getVersion());
                return $r[0];
            break;
            // Platform
            case 'platform': return $scm_agent->getPlatform(); break;
            case 'platform version': return $scm_agent->getPlatformVersion(true);  break;
            case 'platform name': return $scm_agent->getPlatformVersion(); break;
            case 'platform slug': return sanitize_title( $scm_agent->getPlatform() ); break;
            case 'robot': return $scm_agent->isRobot(); break;
            // Mobile
            case 'iphone': return $scm_mobile->isIphone(); break;
            case 'ipad': return $scm_mobile->isIpad(); break;
            case 'ipod': return $scm_mobile->is( 'iPod' ); break;
            case 'android': return $scm_mobile->isAndroidOS(); break;
            case 'blackberry': return $scm_mobile->isBlackBerry(); break;
            case 'opera_mobile': return $scm_mobile->isOpera(); break;
            case 'palm': return $scm_mobile->is( 'webOS' ); break;
            case 'webos': return $scm_mobile->is( 'webOS' ); break;
            case 'symbian': return $scm_mobile->is( 'Symbian' ); break;
            case 'windows_mobile': return $scm_mobile->is( 'WindowsMobileOS' ) || $scm_mobile->is( 'WindowsPhoneOS' ); break;
            case 'lg': return preg_match( '/LG/i', $scm_useragent ); break;
            case 'motorola': return $scm_mobile->is( 'Motorola' ); break;
            case 'nokia': return preg_match( '/Series60/i', $scm_useragent ) || preg_match( '/Symbian/i', $scm_useragent ) || preg_match( '/Nokia/i', $scm_useragent ); break;
            case 'samsung': return $scm_mobile->is( 'Samsung' ); break;
            case 'samsung_galaxy_tab': return $scm_mobile->is( 'SamsungTablet' ); break;
            case 'samsung_tablet': return $scm_mobile->is( 'SamsungTablet' ); break;
            case 'kindle': return $scm_mobile->is( 'Kindle' ); break;
            case 'sony_ericsson': return $scm_mobile->is( 'Sony' ); break;
            case 'nintendo': return preg_match( '/Nintendo DSi/i', $scm_useragent ) || preg_match( '/Nintendo DS/i', $scm_useragent ); break;
            case 'mobile': return scm_agent( 'phone' ) || scm_agent( 'tablet' ) || scm_agent( 'iphone' ) || scm_agent('ipad') || scm_agent('ipod') || scm_agent('android') || scm_agent('blackberry') || scm_agent('opera_mobile') || scm_agent('webos') || scm_agent('symbian') || scm_agent('windows_mobile') || scm_agent('motorola') || scm_agent('samsung') || scm_agent('samsung_tablet') || scm_agent('sony_ericsson') || scm_agent('nintendo'); break;
            case 'desktop': return !scm_agent('mobile'); break;
            case 'ios': return $scm_mobile->isiOS(); break;
            case 'tablet': return $scm_mobile->isTablet(); break;
            case 'phone': return ( $scm_mobile->isTablet() ? false : $scm_agent->isMobile() && $scm_mobile->isMobile() ); break;
            
            default: return NULL; break;
        }
    }

    return $scm_agent;
}


