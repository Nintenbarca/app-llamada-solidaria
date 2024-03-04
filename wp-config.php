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
define( 'AUTH_KEY',          'w1Y=E?-*qvM*h@}hmwAb=,f3}{$2FP/^B/^eFX,zA _/D.Od5t{Nf4+VL*mf@jOc' );
define( 'SECURE_AUTH_KEY',   'axUK}9 warUyz-=Apyw tg:_mtoR]#J]$UA?iY^WLW#<>^n$0mB4_zW.FdH#J+9d' );
define( 'LOGGED_IN_KEY',     '=`+=FH$K0hnM*LQ=tjwF}pXWyHhu~H`-dsr]H``r98RqT/NxfSQroH8##GQ.v,n<' );
define( 'NONCE_KEY',         '$4?+U32eu=&t4gQC,y_X|ZvwtFQC4mv)&(Ufi^p2*ND;4XARTy!#le}8KAak+7I+' );
define( 'AUTH_SALT',         'kj^B5`5U:!K~7L-_3q6Nrq+=QgmY/fZ1bP6t45ypF7&sn~Sz;(k.q<)Y~,<q2}9w' );
define( 'SECURE_AUTH_SALT',  ':<!)^Bw44<VeQ/mQP`Hs8+Q4,q9r/8w=1A~Ee._7^PfG@`M;PFDs|+s=j7}BkeT?' );
define( 'LOGGED_IN_SALT',    'Fl7=E[y?0.uRNkvK={X^Xe~-elDJ9i?N,h?A0z{1~Jca`?a*6WYQn>;9rtEW[F=]' );
define( 'NONCE_SALT',        'T#3C+QR3`bN,zSfH0Smr^:)z)=zAfL:awV=T1VoLWB~p?b/OC)2ExYkjs9W_ukc@' );
define( 'WP_CACHE_KEY_SALT', 'MjW6O?Z>=H-:*Gl3(=rX:rJ7%h!NA+`jbU  ^15~9H*!N[$IyytK<H2Z|?tqoIp(' );


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
