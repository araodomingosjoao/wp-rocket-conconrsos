<?php
/**
 * The base configuration for WordPress
 *
 * The wp-config.php creation script uses this file during the installation.
 * You don't have to use the web site, you can copy this file to "wp-config.php"
 * and fill in the values.
 *
 * This file contains the following configurations:
 *
 * * Database settings
 * * Secret keys
 * * Database table prefix
 * * ABSPATH
 *
 * @link https://wordpress.org/documentation/article/editing-wp-config-php/
 *
 * @package WordPress
 */

// ** Database settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define( 'DB_NAME', 'questionario' );

/** Database username */
define( 'DB_USER', 'root' );

/** Database password */
define( 'DB_PASSWORD', 'root' );

/** Database hostname */
define( 'DB_HOST', 'localhost' );

/** Database charset to use in creating database tables. */
define( 'DB_CHARSET', 'utf8mb4' );

/** The database collate type. Don't change this if in doubt. */
define( 'DB_COLLATE', '' );

/**#@+
 * Authentication unique keys and salts.
 *
 * Change these to different unique phrases! You can generate these using
 * the {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org secret-key service}.
 *
 * You can change these at any point in time to invalidate all existing cookies.
 * This will force all users to have to log in again.
 *
 * @since 2.6.0
 */
define( 'AUTH_KEY',         '+#B>u~k6z|s&uQ:01.[w3Jwa?%Po[I?ol4Tfjj)whBm5,3+@79VlnwofgrvEf9Gu' );
define( 'SECURE_AUTH_KEY',  'D5_~F`f7o(DP1yI*9Th0(@A83PERNT;X3?1Dq%%ret;Th5J-Z6?i`-2IKoF1BA7j' );
define( 'LOGGED_IN_KEY',    'G)^0BJmgXxR.Qlw>c8xA=i%`mHBxAVsP2cpmbKNWp4zxj]|,lcqxY>cY:N_,,>kL' );
define( 'NONCE_KEY',        'h=PI{Q%CEuR6/@&SKh_nQ* nxWbK=npQ281R u6J;rBZKe.+L8z;D/^(Cu,f0P5*' );
define( 'AUTH_SALT',        ']I*0LY :MMD$m%Z870e!$b!3#R85c1FR}~8@VRgv6)!R?.`:Q2*r/zZrWJ/+<;f]' );
define( 'SECURE_AUTH_SALT', 'I{oUgnkB>/P!,F!&=#x<bf(wH$82i}5%$*P]YZ! HDu}G^Z[AOdFIjr~zxE#faW=' );
define( 'LOGGED_IN_SALT',   'og|Ast.R#hwy~Nab= %7E1eUX>+~um {VGGrC6s<;xs.?!l:!kP<oZwztnDmh-/W' );
define( 'NONCE_SALT',       'n<%@#5jo2;R+x4JW<&T&@CvVfg?w/X?akYX@ZnLhW#d}8umm}pFz0MBa{2q3Akna' );

/**#@-*/

/**
 * WordPress database table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix = 'wp_';

/**
 * For developers: WordPress debugging mode.
 *
 * Change this to true to enable the display of notices during development.
 * It is strongly recommended that plugin and theme developers use WP_DEBUG
 * in their development environments.
 *
 * For information on other constants that can be used for debugging,
 * visit the documentation.
 *
 * @link https://wordpress.org/documentation/article/debugging-in-wordpress/
 */
define( 'WP_DEBUG', false );

/* Add any custom values between this line and the "stop editing" line. */



/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', __DIR__ . '/' );
}

/** Sets up WordPress vars and included files. */
require_once ABSPATH . 'wp-settings.php';
