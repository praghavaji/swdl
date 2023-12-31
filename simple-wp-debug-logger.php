<?php
/*
Plugin Name: Simple WP Debug Logger
Description: Simple Plugin to log debug information to the WordPress debug log.
Version: 1.0
Author: Michael Bailey
*/

class swdl {

	/**
	 * Logs a message with optional color coding.
	 *
	 * @param mixed  $message The message to log.
	 * @param string $color   Optional. The color code for the message. Default 'default'.
	 */
	public static function log( $message, $title = '', $color = 'default' ) {
		if ( ! defined( 'WP_DEBUG' ) || true !== WP_DEBUG ) {
			return;
		}

		$formattedMessage = self::format( $message, $title, $color );
		error_log( $formattedMessage );
	}

	/**
	 * Formats the log message with date, time, and optional color.
	 *
	 * @param mixed  $message The message to format.
	 * @param string $color   The color code for the message.
	 * @return string The formatted message.
	 */
	private static function format( $message, $title, $color ) {
	
		$beforeTitle = ' ';
		$is_array_or_object = false;
		if ( is_array( $message ) || is_object( $message ) ) {
			$beforeTitle = "\n";
			$is_array_or_object = true;
			$message = print_r( $message, true );
		}
	
		$date = new DateTime();
		$formattedDate = $date->format( 'Y-m-d H:i:s' );
		$colorPart = ( 'default' !== $color ) ? " [{$color}]" : '';
	    $titlePart = $title ? "{$title}" : '';	

		// Include the message type and the '|' separator after the date and color part
		if ( $is_array_or_object ) {
			return "[{$formattedDate}]{$colorPart}{$beforeTitle}{$titlePart} | {$message}";
		}
		else {
			return "[{$formattedDate}]{$colorPart}{$beforeTitle}{$titlePart} | {$message}\n";
		}
	}
	
	/**
	 * Logs a delimiter line.
	 */
	public static function break() {
		self::log( '' );
	}
}
