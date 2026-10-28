# Simple WP Debug Logger (swdl)

A lightweight WordPress plugin to format and log debug messages to the WordPress `debug.log` file.

## Features

- **Custom Formatting**: Automatically includes timestamps, optional color tags, and titles.
- **Array & Object Dump**: Formats arrays and objects nicely for easier debugging.
- **WordPress Timezone Aware**: Respects WordPress configured timezone settings via `wp_date()` when loaded within WP context.
- **Visual Dividers**: Easily output delimiter lines to separate log sections.
- **Direct Access Protection**: Safe against direct file access outside of WordPress.

## Requirements

- WordPress 5.0+
- PHP 7.4+

## Installation

1. Copy or clone `simple-wp-debug-logger.php` into your WordPress plugins folder (`wp-content/plugins/simple-wp-debug-logger/`).
2. Activate the plugin in the WordPress Admin dashboard under **Plugins**.
3. Ensure `WP_DEBUG` and `WP_DEBUG_LOG` are set to `true` in your `wp-config.php`:
   ```php
   define( 'WP_DEBUG', true );
   define( 'WP_DEBUG_LOG', true );
   define( 'WP_DEBUG_DISPLAY', false );
   ```

## Usage

### 1. Simple Log
```php
swdl::log( 'User logged in successfully' );
// Output: [2026-03-31 12:00:00] User logged in successfully
```

### 2. Log with Title and Color
```php
swdl::log( 'Invalid API response code: 500', 'API Error', 'red' );
// Output: [2026-03-31 12:00:00] [red] API Error | Invalid API response code: 500
```

### 3. Log Arrays or Objects
```php
$user_data = [ 'id' => 42, 'role' => 'administrator' ];
swdl::log( $user_data, 'Current User' );
/* Output:
[2026-03-31 12:00:00]
Current User |
Array
(
    [id] => 42
    [role] => administrator
)
*/
```

### 4. Output Delimiter / Break Line
```php
swdl::break(); // Default 50 '-' chars
// Output: [2026-03-31 12:00:00] --------------------------------------------------

swdl::break( '=', 30 );
// Output: [2026-03-31 12:00:00] ==============================
```

## Running Unit Tests

1. Install dependencies:
   ```bash
   composer install
   ```
2. Run test suite:
   ```bash
   ./vendor/bin/phpunit
   ```
