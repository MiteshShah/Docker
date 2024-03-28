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
 * * MySQL settings
 * * Secret keys
 * * Database table prefix
 * * ABSPATH
 *
 * @link https://wordpress.org/support/article/editing-wp-config-php/
 */

if (!function_exists('getenv_docker')) {
	// https://github.com/docker-library/wordpress/issues/588 (WP-CLI will load this file 2x)
	function getenv_docker($env, $default) {
		if ($fileEnv = getenv($env . '_FILE')) {
			return rtrim(file_get_contents($fileEnv), "\r\n");
		}
		else if (($val = getenv($env)) !== false) {
			return $val;
		}
		else {
			return $default;
		}
	}
}

define( 'DB_NAME', getenv_docker('WORDPRESS_DB_NAME', 'wordpress') );

define( 'DB_USER', getenv_docker('WORDPRESS_DB_USER', 'rtcamp') );

define( 'DB_PASSWORD', getenv_docker('WORDPRESS_DB_PASSWORD', 'dipankar') );

define( 'DB_HOST', getenv_docker('WORDPRESS_DB_HOST', '127.0.0.1:3306') );

define( 'DB_CHARSET', getenv_docker('WORDPRESS_DB_CHARSET', 'utf8') );

define( 'DB_COLLATE', getenv_docker('WORDPRESS_DB_COLLATE', '') );

/**#@+
 * Authentication Unique Keys and Salts.
 *
 * Change these to different unique phrases!
 * You can generate these using the {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org secret-key service}
 * You can change these at any point in time to invalidate all existing cookies. This will force all users to have to log in again.
 */
define('AUTH_KEY',         '55vdI&y!z~e<4#fB!?0!Hmro(r-*fB-1UGn#?.kC0?fP7g|sU9wUdHo6l8|pixmI');
define('SECURE_AUTH_KEY',  '8bJV1T4?F{#mY_T{N-|+)2$m6tOswz!AkB&NCBu|8vG)-vVGKI.{c(kTr> 71&KG');
define('LOGGED_IN_KEY',    '3%-f:G8S.s+p?]Qtu(.84OGmt^6eC^E)GCf@!)BSn=-_,dmay+pcotJtR+AQ/gTI');
define('NONCE_KEY',        'p0;#1~/c5$g@x<G|*+l$#ee:-zC#>N+?&&&P*l*6Gx(eA^7c]hZ7cwet(Y/:_`*T');
define('AUTH_SALT',        'cLk?*8LUqKd[XtgT>Ry`,Zk]v,Vx@m:/X0MqVnu$JHWkNC|]P]}Bmh.kRr*%ipLD');
define('SECURE_AUTH_SALT', 'pYOi)~N]uD{>6/jiyB/c,rV=8O7Jurwv+8`4k5;3lxyDFX/O)I{($T^&$@]p!cH)');
define('LOGGED_IN_SALT',   'c:@z +0OH=q#ty$aH,dUTJpvT!S<kD^6Wm=OFp|m-m@)rJ*n/.0YE]TVr< i=IYh');
define('NONCE_SALT',       '6zhgmIwy/3{dseF{l!KO5W?uWTn@mXt}vx5n|IqeJT`:OS-Z+Nq=h??ZaY8kU76Y');

/**#@-*/

/**
 * WordPress Database Table prefix.
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
 * @link https://wordpress.org/support/article/debugging-in-wordpress/
 */
define( 'WP_DEBUG', false );

define( 'S3_UPLOADS_AUTOENABLE', true );

define( 'S3_UPLOADS_BUCKET', getenv_docker('WORDPRESS_S3_UPLOADS_BUCKET', 'my-bucket') );

define( 'S3_UPLOADS_REGION', getenv_docker('WORDPRESS_S3_UPLOADS_REGION', '') );

define( 'S3_UPLOADS_KEY', getenv_docker('WORDPRESS_S3_UPLOADS_KEY', '') );

define( 'S3_UPLOADS_SECRET', getenv_docker('WORDPRESS_S3_UPLOADS_SECRET', '') );

define( 'S3_UPLOADS_USE_INSTANCE_PROFILE', getenv_docker('WORDPRESS_S3_UPLOADS_USE_INSTANCE_PROFILE', false) );

define('S3_UPLOADS_OBJECT_ACL', 'private');

// If we're behind a proxy server and using HTTPS, we need to alert WordPress of that fact
// see also https://wordpress.org/support/article/administration-over-ssl/#using-a-reverse-proxy
if (isset($_SERVER['HTTP_X_FORWARDED_PROTO']) && strpos($_SERVER['HTTP_X_FORWARDED_PROTO'], 'https') !== false) {
	$_SERVER['HTTPS'] = 'on';
}
// (we include this by default because reverse proxying is extremely common in container environments)

if ($configExtra = getenv_docker('WORDPRESS_CONFIG_EXTRA', '')) {
	eval($configExtra);
}
/* That's all, stop editing! Happy publishing. */


/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', __DIR__ . '/' );
}

/** Sets up WordPress vars and included files. */
require_once ABSPATH . 'wp-settings.php';
