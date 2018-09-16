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
            // if ( defined( '' ) && defined( '' ) ) {
            // }else{
            WP_CLI::add_command( 'move-to-s3 show-files-with-no-s3-meta-data', array( $this, 'show_media_with_no_meta_data' ) );
            WP_CLI::add_command( 'move-to-s3 add-meta-data-to-library', array( $this, 'add_meta_data_to_whole_library' ) );

            // }
        }

    }


    public function add_meta_data_to_whole_library( ){

        // Create the logger
        // $logger = new Logger( 'move_wp_media_library_to_s3' );
        //
        // $uploads_directory = wp_upload_dir();
        // $logger->pushHandler(new StreamHandler( $uploads_directory['basedir'] .'/move_wp_media_library_to_s3.log', Logger::DEBUG));
        // $logger->info( '-------- Order placed --------' );
        // $logger->info( 'Order ID: ' . $order_id );
        // // $logger->info( 'Merge fields: ', $merge_fields );
        // $logger->info( 'Timestamp: '. $date->getTimestamp() );

        $files = $this->get_files_with_no_meta_data();

        $options = get_option('tantan_wordpress_s3');

        // if( $options != null && $options['bucket'] != '' && $options['object-prefix'] != '' && $options['region'] != '' ){
        if( $files != false ){

            foreach( $files as $post ){

                $media_url = str_replace( get_bloginfo('url').'/', '', $post->guid );

                $data = array(
                    'region' => $options['region'],
                    'bucket' => $options['bucket'],
                    'key' => $media_url,
                );

                WP_CLI::success( "Added meta to attachment with ID: " . $post->ID  );

                // echo "<pre>";
                // print_r($post);
                // echo "</pre>";

                // update_post_meta( $post->ID, 'amazonS3_info', $data );
            }
        }else{

            WP_CLI::success( "No files found! Everything is up to date 🙂" );

        }

    }

    public function show_media_with_no_meta_data( ){

        WP_CLI::line( "Finding files..."  );

        $files = $this->get_files_with_no_meta_data();

        if( $files != false ){

            WP_CLI::line( "A total of " . count($files) ." files were found without any S3 meta data."  );

            WP_CLI\Utils\format_items( 'table', $files, array( 'ID', 'post_title' ) );

        }else{

            WP_CLI::success( "No files found! Everything is up to date 🙂" );

        }


    }

    private function get_files_with_no_meta_data( ){

        $args = array(
            'post_type' => 'attachment',
            'post_status' => 'inherit',
            'posts_per_page' => -1,
            'meta_query'  => array(
                array(
                    'key' => 'amazonS3_info',
                    // 'compare' => 'EXISTS',
                    'compare' => 'NOT EXISTS',
                    'type' => 'STRING'
               )
            )
        );

        $query = new WP_Query( $args );

        if( $query->post_count > 0 ){
            return $query->posts;
        }else{
            return false;
        }

    }


}

$move_wp_media_library_to_s3 = new MoveMediaLibraryToS3;
