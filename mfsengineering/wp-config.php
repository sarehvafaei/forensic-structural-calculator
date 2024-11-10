<?php
/**
 * The base configuration for WordPress
 *
 * The wp-config.php creation script uses this file during the installation.
 * You don't have to use the website, you can copy this file to "wp-config.php"
 * and fill in the values.
 *
 * This file contains the following configurations:
 *
 * * Database settings
 * * Secret keys
 * * Database table prefix
 * * ABSPATH
 *
 * @link https://developer.wordpress.org/advanced-administration/wordpress/wp-config/
 *
 * @package WordPress
 */

// ** Database settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define( 'DB_NAME', 'mfsengineering_db' );

/** Database username */
define( 'DB_USER', 'root' );

/** Database password */
define( 'DB_PASSWORD', '' );

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
define( 'AUTH_KEY',         'jZkz-o-UOl?F_l:z,dwx9bq4s8ZV_0>BlwBf5>Mgv,,UgbEBzDD)LN~0:0?0Vit|' );
define( 'SECURE_AUTH_KEY',  ',x+>&IUAY2>QCf8m>Lqh7^XKLDqPa>h=49Y=z;+oE/!N=5:|595Q|vH!@-O=^dpt' );
define( 'LOGGED_IN_KEY',    'UsUl:#?x3$9fa&Yn@miRXAa{]I^|1tM_d,&V/#bd$j,jYyzgPrU~+K{oD<wTWUSh' );
define( 'NONCE_KEY',        '$hHB+VP.xXz|&M yvLltJ 2kiVv#ofQvEviUM>&S!Nb%oLbyQv1rZ Y;E>F|v{Ve' );
define( 'AUTH_SALT',        ',C-h/4~B<0cLzwR&yHSQpRAA*H-)Uf!O8gH0w! VyKg1zhUW`PZRFT?Z {fuKwq*' );
define( 'SECURE_AUTH_SALT', 'iU:U2&5XNHU4x5RGDDOq+lks8;4ojoYL>_/,J:#fp5U=Db]RBGz)qS3O]6Epd`::' );
define( 'LOGGED_IN_SALT',   '~G0v?zZ}[QWaBjm,Ozj##`EolB5{t>?^Ud,9){t4O*b4g[q=$rnB][cFHX_Vf1yJ' );
define( 'NONCE_SALT',       '%>Pe&.N?jZQXOyG_kt_y[fgsk*o2gYe,j7tMFTDm$$|_xR|5bb/Jz/ls<0!M%>;O' );

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
 * @link https://developer.wordpress.org/advanced-administration/debug/debug-wordpress/
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
