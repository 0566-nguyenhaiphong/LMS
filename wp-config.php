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
 * @link https://wordpress.org/documentation/article/editing-wp-config-php/
 *
 * @package WordPress
 */

// ** Database settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define( 'DB_NAME', 'lms' );

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
define( 'AUTH_KEY',         'y^E/$R/#bkNZ@#nfP^QH@q<9PRD;H.%Tu,!. $rI5q%J<,5;hG[xki~j!M^t.B8R' );
define( 'SECURE_AUTH_KEY',  'jxh1Lon5pwF*}}I_gqH|bRnkJCmmn{z&v2XjNiI.~-WO``_fM<eb}ysK_!+k;l)3' );
define( 'LOGGED_IN_KEY',    'agqB,+VExVB[A}D M,Cp#vbxKLaFQ&_UYh`$lUg.m-Y|/(x%:|-N,RR9Q#5g^kE1' );
define( 'NONCE_KEY',        'x!_p~v/U%.rDKB{f13V-tQc$KAvf:!b^U3G9!b<mE?;B-:Z$zO|^ ~evj}[>?]h@' );
define( 'AUTH_SALT',        '`gc^+*|f%)]#{LRbmPW67-Oe1pdBi.(4WOtyr,?y/(W?nyznV7Ut6]1hHKF53>:k' );
define( 'SECURE_AUTH_SALT', '!$]`}czU8.=S/+yos9&) Z*xyGYy6iluJ!P[!/TllG~#0BYa54X)$j@j5t5qAMsG' );
define( 'LOGGED_IN_SALT',   'fJ_yjNjiOD3;{T1QX:oRAW10Qr M7Rd,(U,a~gkFor ZbHQ0c{tSF-fy?}-`HRfu' );
define( 'NONCE_SALT',       'aBi/270TF#kQa`Sp@ fAj})okkt^6J9caNl]Cx@0O}]l{cO6~zNJGlCp,k(H<lM*' );

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
