<?php
/**
 * Plugin Name:         SCM Agent
 * Plugin URI:          http://studiocreativo-m.it/
 * Description:         SCM Plugin Description
 * Version:             1.0.0
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

if ( ! class_exists( 'BrowserDetection' ) )
    require_once( 'BrowserDetection.php' );

$scm_agent = new BrowserDetection();


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