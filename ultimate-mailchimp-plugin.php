<?php
/**
 * Plugin Name:     Move media library to S3
 * Plugin URI:      atomicsmash.co.uk
 * Description:     Move media library to S3
 * Author:          atomicsmash.co.uk
 * Author URI:      atomicsmash.co.uk
 * Version:         0.0.1
 */

if (!defined('ABSPATH')) exit; //Exit if accessed directly

// If autoload exists... autoload it baby... (this is for plugin developemnt and sites not using composer to pull plugins)
if ( file_exists( __DIR__ . '/vendor/autoload.php' ) ) {
    require __DIR__ . '/vendor/autoload.php';
}

use \Monolog\Logger;
use \Monolog\Handler\StreamHandler;

class MoveMediaLibraryToS3 {

    function __construct() {

        // Setup CLI commands
        if ( defined( 'WP_CLI' ) && WP_CLI ) {
            if ( defined( '' ) && defined( '' ) ) {
            }else{
                WP_CLI::add_command( '', array( $this, '' ) );
            }
        }

    }


    private function update_single_user( $order_id = 0, $user_status = 'subscribed', $marketing_preferences = array() ){


        // Create the logger
        $logger = new Logger( 'move_media_library_to_s3' );

        $uploads_directory = wp_upload_dir();
        $logger->pushHandler(new StreamHandler( $uploads_directory['basedir'] .'/move_media_library_to_s3.log', Logger::DEBUG));
        $logger->info( '-------- Order placed --------' );
        $logger->info( 'Order ID: ' . $order_id );
        // $logger->info( 'Merge fields: ', $merge_fields );
        $logger->info( 'Timestamp: '. $date->getTimestamp() );


    }


}

$move_media_library_to_s3 = new MoveMediaLibraryToS3;
