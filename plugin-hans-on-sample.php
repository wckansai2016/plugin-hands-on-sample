<?php
/**
 * Plugin Name: Plugin-hans-on-sample
 * Version: 0.1-alpha
 * Description: WCK2016 Plguin Hans-on Sample.
 * Author: WCK2016 Plguin Hans-on Team
 * Author URI: https://2016.kansai.wordcamp.org/
 * Plugin URI: https://github.com/wckansai2016/plugin-hands-on-sample
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
	$length_per_minute = 400; //ここら辺でフィルターフックの話する方が良いかもね。
	return round( $length / $length_per_minute );
}


/**
 *
 * ショートコードの実装。
 *
 * @param string $attr
 * @param string $content
 */
function reading_minutes_shortcode( $attr , $content = '' ) {
	//TODO 引数の説明どうする？ 英語表記とか?

	$post = get_post(); // global $post とほぼ同じ動作。
	$content = $post->post_content;
	$minutes = count_reading_minutes( $content );

	$template = 'この記事は約%d分で読めます。';
	$text = sprintf( $template, $minutes );

	//エスケープ大切！
	return '<span class="reading-minutes">'.esc_html( $text ). '</span>';
}

/**
 * ショートコードの登録
 */
add_shortcode('reading-minutes', 'reading_minutes_shortcode');


/**
 * 本文の前にテキスト表示。
 * @param string $content
 *
 * @return string
 */
function add_reading_minutes_to_the_content( $content ) {
	$minutes = count_reading_minutes( $content );
	$template = 'この記事は約%d分で読めます。';
	$text = sprintf( $template, $minutes );
	$reading_minutes_html = '<span class="reading-minutes">'.esc_html( $text ). '</span>';

	return $reading_minutes_html.$content;
}

/**
 * フィルターフックを登録
 */
add_filter( 'the_content', 'add_reading_minutes_to_the_content' );


