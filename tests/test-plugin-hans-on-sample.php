<?php
/**
 * Class TestPluginHansOnSample
 *
 * @package plugin-hans-on-sample
 */

/**
 *  test case.
 */
class TestPluginHansOnSample extends WP_UnitTestCase {

	/** @var string 本文サンプル(空白無しで489文字) */
	private $sample_content = <<<EOM
吾輩わがはいは猫である。名前はまだ無い。

どこで生れたかとんと見当けんとうがつかぬ。何でも薄暗いじめじめした所でニャーニャー泣いていた事だけは記憶している。吾輩はここで始めて人間というものを見た。しかもあとで聞くとそれは書生という人間中で一番獰悪どうあくな種族であったそうだ。この書生というのは時々我々を捕つかまえて煮にて食うという話である。しかしその当時は何という考もなかったから別段恐しいとも思わなかった。ただ彼の掌てのひらに載せられてスーと持ち上げられた時何だかフワフワした感じがあったばかりである。掌の上で少し落ちついて書生の顔を見たのがいわゆる人間というものの見始みはじめであろう。この時妙なものだと思った感じが今でも残っている。第一毛をもって装飾されべきはずの顔がつるつるしてまるで薬缶やかんだ。その後ご猫にもだいぶ逢あったがこんな片輪かたわには一度も出会でくわした事がない。のみならず顔の真中があまりに突起している。そうしてその穴の中から時々ぷうぷうと煙けむりを吹く。どうも咽むせぽくて実に弱った。これが人間の飲む煙草たばこというものである事はようやくこの頃知った。
EOM;

	/**
	 * @test count_reading_minutes
	 *
	 */
	public function test_get_the_reading_minutes() {
		$post = $this->factory->post->create_and_get( array( 'post_content' => $this->sample_content ) );
		$count = count_reading_minutes( $post->post_content );
		$this->assertEquals( 1, $count );
	}

	/**
	 * @test
	 * test shortcode rendering
	 */
	public function test_shortcode() {
		global $post;
		$post = $this->factory->post->create_and_get( array( 'post_content' => $this->sample_content ) );
		$actual = do_shortcode( '[reading-minutes]' );
		$this->assertEquals( '<p class="reading-minutes">この記事は約1分で読めます。</p>', $actual );
	}


	/**
	 * @test
	 */
	public function test_the_content() {
		global $post;
		$post = $this->factory->post->create_and_get( array( 'post_content' => $this->sample_content ) );
		setup_postdata( $post );
		$this->expectOutputString( '<p class="reading-minutes">この記事は約1分で読めます。</p>'.wpautop( $this->sample_content ) );
		the_content();
	}
}

