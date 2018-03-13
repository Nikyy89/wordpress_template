<?php
/** 
 * A WordPress fő konfigurációs állománya
 *
 * Ebben a fájlban a következő beállításokat lehet megtenni: MySQL beállítások
 * tábla előtagok, titkos kulcsok, a WordPress nyelve, és ABSPATH.
 * További információ a fájl lehetséges opcióiról angolul itt található:
 * {@link http://codex.wordpress.org/Editing_wp-config.php Editing wp-config.php} 
 *  A MySQL beállításokat a szolgáltatónktól kell kérni.
 *
 * Ebből a fájlból készül el a telepítési folyamat közben a wp-config.php
 * állomány. Nem kötelező a webes telepítés használata, elegendő átnevezni 
 * "wp-config.php" névre, és kitölteni az értékeket.
 *
 * @package WordPress
 */

// ** MySQL beállítások - Ezeket a szolgálatótól lehet beszerezni ** //
/** Adatbázis neve */
define('DB_NAME', 'wordpress');

/** MySQL felhasználónév */
define('DB_USER', 'postgres');

/** MySQL jelszó. */
define('DB_PASSWORD', 'postgres');

/** MySQL  kiszolgáló neve */
define('DB_HOST', 'localhost');

/** Az adatbázis karakter kódolása */
define('DB_CHARSET', 'utf8mb4');

/** Az adatbázis egybevetése */
define('DB_COLLATE', '');

/**#@+
 * Bejelentkezést tikosító kulcsok
 *
 * Változtassuk meg a lenti konstansok értékét egy-egy tetszóleges mondatra.
 * Generálhatunk is ilyen kulcsokat a {@link http://api.wordpress.org/secret-key/1.1/ WordPress.org titkos kulcs szolgáltatásával}
 * Ezeknek a kulcsoknak a módosításával bármikor kiléptethető az összes bejelentkezett felhasználó az oldalról. 
 *
 * @since 2.6.0
 */
define('AUTH_KEY', 'a2D)DWcUgp&7Yp+wEK4)g{C+nD<65ungz#kW)J}m9hZPnjyW[bDRB9SIuiWs^`A=');
define('SECURE_AUTH_KEY', '[zk^enW4jmQPY.e>U_:6L{d~#e?;g$|pFkf@KO -sGqY#eX5wCG{D<)%%{z15:UU');
define('LOGGED_IN_KEY', '}CA1ke4d|N)?{E]IT4o6t,z3$ 8#U1Ev}qycqg1wp).V]vGr%}Ymq>~?K9oIO91^');
define('NONCE_KEY', '[Nx}9;:uStD8F=LETeD6)b1~rUqBk^(q_fB282<l2@II#`KLW[sS{*Nh}C%u[nnn');
define('AUTH_SALT',        'Ix<uK.-JX<4^HEig:{lbZ|uk-B_|`s!c^Lk334)2X RnBf>{Mum~Tm+|c|6L1T3(');
define('SECURE_AUTH_SALT', 'F3+4)|GYuXjZ~]VFB*~%jExU/V2Ob_.^#D=m[fvT7v+!=Qa)0iO8G+?Qh?/aMI%A');
define('LOGGED_IN_SALT',   'V6<3O~N+Xexx8?V`%CF2qGk=%Oe4MA(`BzT4a3YAk&c~CSd+p9(;=B+Kj[$q&X=(');
define('NONCE_SALT',       '0d(XMmP0jzuA6N^Wc|;;aTW=yTv8WqB8N`7[OTmE%`j:%,t{79FfgSgM~f{?s=_N');

/**#@-*/

/**
 * WordPress-adatbázis tábla előtag.
 *
 * Több blogot is telepíthetünk egy adatbázisba, ha valamennyinek egyedi
 * előtagot adunk. Csak számokat, betűket és alulvonásokat adhatunk meg.
 */
$table_prefix  = 'wp_';

/**
 * Fejlesztőknek: WordPress hibakereső mód.
 *
 * Engedélyezzük ezt a megjegyzések megjelenítéséhez a fejlesztés során. 
 * Erősen ajánlott, hogy a bővítmény- és sablonfejlesztők használják a WP_DEBUG
 * konstansot.
 */
define('WP_DEBUG', false);

/* Ennyi volt, kellemes blogolást! */

/** A WordPress könyvtár abszolút elérési útja. */
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(__FILE__) . '/');

/** Betöltjük a WordPress változókat és szükséges fájlokat. */
require_once(ABSPATH . 'wp-settings.php');
