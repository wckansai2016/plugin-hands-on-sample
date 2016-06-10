<?php
/**
 * Plugin Name: Plugin-hans-on-sample
 * Version: 0.1-alpha
 * Description: PLUGIN DESCRIPTION HERE
 * Author: YOUR NAME HERE
 * Author URI: YOUR SITE HERE
 * Plugin URI: PLUGIN SITE HERE
 * Text Domain: plugin-hans-on-sample
 * Domain Path: /languages
 * @package Plugin-hans-on-sample
 */


/**
 *
 * 文字列から何分で読めるか計算する
 *
 * @param string $content
 *
 * @return int
 */
function count_reading_minutes( $content ) {
	// 文字列からHTMLタグを除去
	$text   = strip_tags( $content );
	// 文字列の数を計測
	$length = mb_strlen( $text );
	// 日本人の可読文字数は1分間で約400字から600字らしいので、(出展：角川ミニッツブック 400で割って四捨五入)
	return round( $length / 400 );
}