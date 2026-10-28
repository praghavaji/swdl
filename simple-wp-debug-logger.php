<?php
/*
Plugin Name: Simple WP Debug Logger
Description: Simple Plugin to log debug information to the WordPress debug log.
Version: 1.0
Author: Michael Bailey
*/

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class swdl {

	/**
	 * Constructor
	 */
	public function __construct() {
		if ( ! defined( 'WP_DEBUG' ) || ! WP_DEBUG || ! defined( 'WP_DEBUG_LOG' ) || ! WP_DEBUG_LOG ) {
			$log_file = defined( 'WP_CONTENT_DIR' ) ? WP_CONTENT_DIR . '/debug.log' : __DIR__ . '/debug.log';

			if ( ! file_exists( $log_file ) ) {
				@touch( $log_file );
				@chmod( $log_file, 0644 );
			}

			ini_set( 'error_log', $log_file );
		}
	}

	/**
	 * Get formatted date string accounting for WP timezone setting if available.
	 *
	 * @return string
	 */
	public static function get_formatted_date() {
		if ( function_exists( 'wp_date' ) ) {
			return wp_date( 'Y-m-d H:i:s' );
		}
		$date = new DateTime();
		return $date->format( 'Y-m-d H:i:s' );
	}

	/**
	 * Logs a message with optional title and color coding.
	 *
	 * @param mixed  $message The message to log.
	 * @param string $title   Optional. The title/label for the message. Default ''.
	 * @param string $color   Optional. The color code for the message. Default 'default'.
	 */
	public static function log( $message, $title = '', $color = 'default' ) {
		$formattedMessage = self::format( $message, $title, $color );
		error_log( $formattedMessage );
	}

	/**
	 * Formats the log message with date, time, title, and optional color.
	 *
	 * @param mixed  $message The message to format.
	 * @param string $title   The title for the message.
	 * @param string $color   The color code for the message.
	 * @return string The formatted message.
	 */
	public static function format( $message, $title = '', $color = 'default' ) {
		$formattedDate = self::get_formatted_date();
		$colorPart     = ( 'default' !== $color && '' !== $color ) ? " [{$color}]" : '';

		if ( is_array( $message ) || is_object( $message ) ) {
			$messageStr = print_r( $message, true );
			if ( ! empty( $title ) ) {
				return "[{$formattedDate}]{$colorPart}\n{$title} |\n{$messageStr}";
			} else {
				return "[{$formattedDate}]{$colorPart}\n{$messageStr}";
			}
		} else {
			if ( ! empty( $title ) ) {
				return "[{$formattedDate}]{$colorPart} {$title} | {$message}";
			} else {
				return "[{$formattedDate}]{$colorPart} {$message}";
			}
		}
	}

	/**
	 * Logs a delimiter line.
	 *
	 * @param string $char   Optional character for delimiter. Default '-'.
	 * @param int    $length Optional length of delimiter line. Default 50.
	 */
	public static function break( $char = '-', $length = 50 ) {
		$line = str_repeat( $char, $length );
		self::log( $line );
	}
}

// Instantiate the class
new swdl();
