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
 * * Localized language
 * * ABSPATH
 *
 * @link https://wordpress.org/support/article/editing-wp-config-php/
 *
 * @package WordPress
 */

// ** Database settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define( 'DB_NAME', 'local' );

/** Database username */
define( 'DB_USER', 'root' );

/** Database password */
define( 'DB_PASSWORD', 'root' );

/** Database hostname */
define( 'DB_HOST', 'localhost' );

/** Database charset to use in creating database tables. */
define( 'DB_CHARSET', 'utf8' );

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
define( 'AUTH_KEY',          '9*lG~@+P|s}LCa$r,cF,Goh)Coe :+l%:G]1tmNAJt ]qna=v]KC$H/pXj)A89V.' );
define( 'SECURE_AUTH_KEY',   'F.WzG69L@S,vPAWm(1 (;#ckMcH+8=c2&ONZW/Mj][Gd$-SY5p1lk:~t:s{HJ^i8' );
define( 'LOGGED_IN_KEY',     'tFing}KXnG8gUg|3akFKd1^OsSvapu1yS:g>Au`m~~jG+URwOkwI.v?le(ohSDh<' );
define( 'NONCE_KEY',         'yu_n^hu[~CzslH1tCJme$q4i::7UB+;-Qhk!{pmi]N+}N|&OV@ym:K/%`5y^Y37%' );
define( 'AUTH_SALT',         ')S^TL EpQh;I!HU8E7dk&q|`.5<J5A 3J- 0MxoGP+Fx6H{_P<l[}+{wZu>rrmLA' );
define( 'SECURE_AUTH_SALT',  '_gfqbm>_!rYjNO4%CXZ-Dl^oD1Ehh~;uH15#[ V9EgLEy~>B;X4>xbOUq#E_333c' );
define( 'LOGGED_IN_SALT',    '`UctW?fCTYD:/P~XAl~@;JRj=jv&hWa>mV<_<w#fQ+8^%Vmg=yY{qryQz03m%#QG' );
define( 'NONCE_SALT',        'eew%fw*&8d1/!!J=+GDGZCDj<N6^5l;YMg`3N^4$GY.LI`BX>=nAEri4gZOh#q;+' );
define( 'WP_CACHE_KEY_SALT', 'wLayMi[%_:=|;e<<nDeRFBT[gX86[glz|CB>u[`Hg_%R0*|FYT,PE]5]y#Bi]!zI' );


/**#@-*/

/**
 * WordPress database table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix = 'wp_';


/* Add any custom values between this line and the "stop editing" line. */



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
 * @link https://wordpress.org/support/article/debugging-in-wordpress/
 */
if ( ! defined( 'WP_DEBUG' ) ) {
	define( 'WP_DEBUG', false );
}

define( 'WP_ENVIRONMENT_TYPE', 'local' );
/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', __DIR__ . '/' );
}

/** Sets up WordPress vars and included files. */
require_once ABSPATH . 'wp-settings.php';
