<?php

use PHPUnit\Framework\TestCase;

class SwdlTest extends TestCase {

	public function testFormatSimpleMessageWithoutTitle() {
		$message   = "Test message";
		$formatted = swdl::format( $message );

		$this->assertStringContainsString( 'Test message', $formatted );
		$this->assertMatchesRegularExpression( '/^\[\d{4}-\d{2}-\d{2} \d{2}:\d{2}:\d{2}\] Test message$/', $formatted );
	}

	public function testFormatMessageWithTitleAndColor() {
		$message   = "Error occurred";
		$title     = "API Error";
		$color     = "red";
		$formatted = swdl::format( $message, $title, $color );

		$this->assertStringContainsString( '[red]', $formatted );
		$this->assertStringContainsString( 'API Error | Error occurred', $formatted );
	}

	public function testFormatArrayMessage() {
		$data      = [ 'key' => 'value', 'num' => 123 ];
		$formatted = swdl::format( $data, 'Data Object' );

		$this->assertStringContainsString( "Data Object |\n", $formatted );
		$this->assertStringContainsString( '[key] => value', $formatted );
	}

	public function testFormatArrayMessageWithoutTitle() {
		$data      = [ 'foo' => 'bar' ];
		$formatted = swdl::format( $data );

		$this->assertStringContainsString( "[foo] => bar", $formatted );
		$this->assertStringNotContainsString( ' |', $formatted );
	}

	public function testBreak() {
		// Test format output when character is default
		$line = str_repeat( '-', 50 );
		$formatted = swdl::format( $line );
		$this->assertStringContainsString( $line, $formatted );
	}
}
