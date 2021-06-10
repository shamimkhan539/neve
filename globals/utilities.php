<?php
/**
 * Author:          Andrei Baicus <andrei@themeisle.com>
 * Created on:      17/10/2018
 *
 * @package utilities.php
 */

use Neve_Pro\Modules\Header_Footer_Grid\Components\Icons;

/**
 * Check if we're delivering AMP
 *
 * @return bool
 */
function neve_is_amp() {
	return function_exists( 'is_amp_endpoint' ) && is_amp_endpoint();
}

/**
 * Show body attrs.
 */
function neve_body_attrs() {
	$body_attrs = apply_filters( 'neve_body_data_attrs', 'id="neve_body" ' );
	echo( $body_attrs ); //phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
}

/**
 * Get hooks by location
 *
 * @return array $hooks - hooks locations and name
 */
function neve_hooks() {

	$hooks = array(
		'header'     => array(
			'neve_html_start_before',
			'neve_head_start_after',
			'neve_head_end_before',
			'neve_body_start_after',
			'neve_before_header_hook',
			'neve_before_header_wrapper_hook',
			'neve_after_header_hook',
			'neve_after_header_wrapper_hook',
		),
		'footer'     => array(
			'neve_before_footer_hook',
			'neve_after_footer_hook',
			'neve_body_end_before',
		),
		'post'       => array(
			'neve_before_post_content',
			'neve_after_post_content',
		),
		'page'       => array(
			'neve_before_page_header',
			'neve_before_page_comments',
		),
		'single'     => array(
			'neve_before_content',
			'neve_after_content',
		),
		'sidebar'    => array(
			'neve_before_sidebar_content',
			'neve_after_sidebar_content',
		),
		'blog'       => array(
			'neve_before_loop',
			'neve_before_posts_loop',
			'neve_after_posts_loop',
			'neve_loop_entry_before',
			'neve_loop_entry_after',
			'neve_middle_posts_loop',
		),
		'pagination' => array(
			'neve_before_pagination',
		),
	);

	if ( class_exists( 'WooCommerce' ) ) {
		$hooks['shop']     = array(
			'neve_before_cart_popup',
			'neve_after_cart_popup',
			'woocommerce_before_shop_loop',
			'woocommerce_after_shop_loop',
			'woocommerce_before_shop_loop_item',
			'nv_shop_item_content_after',
		);
		$hooks['product']  = array(
			'woocommerce_before_single_product',
			'woocommerce_before_single_product_summary',
			'woocommerce_single_product_summary',
			'woocommerce_simple_add_to_cart',
			'woocommerce_before_add_to_cart_form',
			'woocommerce_before_variations_form',
			'woocommerce_before_add_to_cart_quantity',
			'woocommerce_after_add_to_cart_quantity',
			'woocommerce_before_add_to_cart_button',
			'woocommerce_before_single_variation',
			'woocommerce_single_variation',
			'woocommerce_after_single_variation',
			'woocommerce_after_add_to_cart_button',
			'woocommerce_after_variations_form',
			'woocommerce_after_add_to_cart_form',
			'woocommerce_product_meta_start',
			'woocommerce_product_meta_end',
			'woocommerce_share',
			'woocommerce_after_single_product_summary',
		);
		$hooks['cart']     = array(
			'woocommerce_after_cart_table',
			'woocommerce_before_cart_totals',
			'woocommerce_before_shipping_calculator',
			'woocommerce_after_shipping_calculator',
			'woocommerce_cart_totals_before_order_total',
			'woocommerce_proceed_to_checkout',
			'woocommerce_after_cart_totals',
		);
		$hooks['checkout'] = array(
			'woocommerce_before_checkout_billing_form',
			'woocommerce_after_checkout_billing_form',
			'woocommerce_before_checkout_shipping_form',
			'woocommerce_after_checkout_shipping_form',
			'woocommerce_before_order_notes',
			'woocommerce_after_order_notes',
			'woocommerce_review_order_before_order_total',
			'woocommerce_review_order_before_payment',
			'woocommerce_review_order_before_submit',
			'woocommerce_review_order_after_submit',
			'woocommerce_review_order_after_payment',
		);
	}

	return apply_filters( 'neve_hooks_list', $hooks );
}

/**
 * Cart icon markup.
 *
 * The changes here might not be visible on front end due to woocommerce cart-fragments.js
 * In that case deactivate and reactivate WooCommerce.
 *
 * @param bool   $echo should be echoed.
 * @param int    $size icon size.
 * @param string $cart_icon Cart icon.
 *
 * @return string|null
 */
function neve_cart_icon( $echo = false, $size = 15, $cart_icon = '' ) {
	$icon = '<svg width="' . $size . '" height="' . $size . '" viewBox="0 0 1792 1792" xmlns="http://www.w3.org/2000/svg"><path d="M704 1536q0 52-38 90t-90 38-90-38-38-90 38-90 90-38 90 38 38 90zm896 0q0 52-38 90t-90 38-90-38-38-90 38-90 90-38 90 38 38 90zm128-1088v512q0 24-16.5 42.5t-40.5 21.5l-1044 122q13 60 13 70 0 16-24 64h920q26 0 45 19t19 45-19 45-45 19h-1024q-26 0-45-19t-19-45q0-11 8-31.5t16-36 21.5-40 15.5-29.5l-177-823h-204q-26 0-45-19t-19-45 19-45 45-19h256q16 0 28.5 6.5t19.5 15.5 13 24.5 8 26 5.5 29.5 4.5 26h1201q26 0 45 19t19 45z"/></svg>';
	if ( ! empty( $cart_icon ) && class_exists( '\Neve_Pro\Modules\Header_Footer_Grid\Components\Icons' ) ) {
		$cart_icon_svg = Icons::get_instance()->get_single_icon( $cart_icon );
		$icon          = ! empty( $cart_icon_svg ) ? $cart_icon_svg : $icon;
	}
	$svg = '<span class="nv-icon nv-cart">' . $icon . '</span>';
	if ( $echo === false ) {
		return $svg;
	}
	echo( $svg ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
}

/**
 * Search Icon
 *
 * @param bool $is_link should be wrapped in A tag.
 * @param bool $echo should be echoed.
 * @param int  $size icon size.
 * @param bool $amp_ready Should we add the AMP binding.
 *
 * @return string
 */
function neve_search_icon( $is_link = false, $echo = false, $size = 15, $amp_ready = false ) {

	$amp_state = '';
	if ( $amp_ready ) {
		$amp_state = 'on="tap:AMP.setState({visible: !visible})" role="button" tabindex="0" ';
	}
	$start_tag = $is_link ? 'a aria-label="' . __( 'Search', 'neve' ) . '" href="#"' : 'div';
	$end_tag   = $is_link ? 'a' : 'div';
	$svg       = '<' . $start_tag . ' class="nv-icon nv-search" ' . $amp_state . '>
				<svg width="' . $size . '" height="' . $size . '" viewBox="0 0 1792 1792" xmlns="http://www.w3.org/2000/svg"><path d="M1216 832q0-185-131.5-316.5t-316.5-131.5-316.5 131.5-131.5 316.5 131.5 316.5 316.5 131.5 316.5-131.5 131.5-316.5zm512 832q0 52-38 90t-90 38q-54 0-90-38l-343-342q-179 124-399 124-143 0-273.5-55.5t-225-150-150-225-55.5-273.5 55.5-273.5 150-225 225-150 273.5-55.5 273.5 55.5 225 150 150 225 55.5 273.5q0 220-124 399l343 343q37 37 37 90z"/></svg>
			</' . $end_tag . '>';
	if ( $echo === false ) {
		return $svg;
	}
	echo $svg; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
}

/**
 *  Escape HTML strings containing SVG.
 *
 * @param string $input the input string.
 * @param array  $additional_args additional allowed.
 *
 * @return string
 */
function neve_custom_kses_escape( $input, $additional_args ) {
	$kses_defaults = wp_kses_allowed_html( 'post' );
	$allowed_tags  = array_merge( $kses_defaults, $additional_args );

	return wp_kses( $input, $allowed_tags );
}

/**
 * Get allowed tags for SVG tags.
 *
 * @return array
 */
function neve_get_svg_allowed_tags() {
	return array(
		'svg'      => array(
			'class'           => true,
			'aria-hidden'     => true,
			'aria-labelledby' => true,
			'role'            => true,
			'xmlns'           => true,
			'width'           => true,
			'height'          => true,
			'viewbox'         => true, // <= Must be lower case!
		),
		'g'        => array( 'fill' => true ),
		'title'    => array( 'title' => true ),
		'path'     => array(
			'd'    => true,
			'fill' => true,
		),
		'polyline' => array(
			'fill'         => true,
			'stroke'       => true,
			'stroke-width' => true,
			'points'       => true,
		),
	);
}

/**
 * Escape SVG.
 *
 * @param string $input input string to escape.
 *
 * @return string
 */
function neve_kses_svg( $input ) {
	$svg_args = neve_get_svg_allowed_tags();

	return neve_custom_kses_escape( $input, $svg_args );
}

/**
 * Get standard fonts
 *
 * @return array
 */
function neve_get_standard_fonts() {
	return apply_filters(
		'neve_standard_fonts_array',
		array(
			'Arial, Helvetica, sans-serif',
			'Arial Black, Gadget, sans-serif',
			'Bookman Old Style, serif',
			'Comic Sans MS, cursive',
			'Courier, monospace',
			'Georgia, serif',
			'Garamond, serif',
			'Impact, Charcoal, sans-serif',
			'Lucida Console, Monaco, monospace',
			'Lucida Sans Unicode, Lucida Grande, sans-serif',
			'MS Sans Serif, Geneva, sans-serif',
			'MS Serif, New York, sans-serif',
			'Palatino Linotype, Book Antiqua, Palatino, serif',
			'Tahoma, Geneva, sans-serif',
			'Times New Roman, Times, serif',
			'Trebuchet MS, Helvetica, sans-serif',
			'Verdana, Geneva, sans-serif',
			'Paratina Linotype',
			'Trebuchet MS',
		)
	);
}

/**
 * Get all google fonts.
 *
 * @return array
 */
function neve_get_google_fonts() {
	return apply_filters(
		'neve_google_fonts_array',
		// Updated on 15/09/20
		array(
			'ABeeZee',
			'Abel',
			'Abhaya Libre',
			'Abril Fatface',
			'Aclonica',
			'Acme',
			'Actor',
			'Adamina',
			'Advent Pro',
			'Aguafina Script',
			'Akronim',
			'Aladin',
			'Alata',
			'Alatsi',
			'Aldrich',
			'Alef',
			'Alegreya',
			'Alegreya SC',
			'Alegreya Sans',
			'Alegreya Sans SC',
			'Aleo',
			'Alex Brush',
			'Alfa Slab One',
			'Alice',
			'Alike',
			'Alike Angular',
			'Allan',
			'Allerta',
			'Allerta Stencil',
			'Allura',
			'Almarai',
			'Almendra',
			'Almendra Display',
			'Almendra SC',
			'Amarante',
			'Amaranth',
			'Amatic SC',
			'Amethysta',
			'Amiko',
			'Amiri',
			'Amita',
			'Anaheim',
			'Andada',
			'Andika',
			'Angkor',
			'Annie Use Your Telescope',
			'Anonymous Pro',
			'Antic',
			'Antic Didone',
			'Antic Slab',
			'Anton',
			'Arapey',
			'Arbutus',
			'Arbutus Slab',
			'Architects Daughter',
			'Archivo',
			'Archivo Black',
			'Archivo Narrow',
			'Aref Ruqaa',
			'Arima Madurai',
			'Arimo',
			'Arizonia',
			'Armata',
			'Arsenal',
			'Artifika',
			'Arvo',
			'Arya',
			'Asap',
			'Asap Condensed',
			'Asar',
			'Asset',
			'Assistant',
			'Astloch',
			'Asul',
			'Athiti',
			'Atma',
			'Atomic Age',
			'Aubrey',
			'Audiowide',
			'Autour One',
			'Average',
			'Average Sans',
			'Averia Gruesa Libre',
			'Averia Libre',
			'Averia Sans Libre',
			'Averia Serif Libre',
			'B612',
			'B612 Mono',
			'Bad Script',
			'Bahiana',
			'Bahianita',
			'Bai Jamjuree',
			'Balsamiq Sans',
			'Baloo',
			'Baloo 2',
			'Baloo Bhai',
			'Baloo Bhai 2',
			'Baloo Bhaijaan',
			'Baloo Bhaina',
			'Baloo Bhaina 2',
			'Baloo Chettan',
			'Baloo Chettan 2',
			'Baloo Da',
			'Baloo Da 2',
			'Baloo Paaji',
			'Baloo Paaji 2',
			'Baloo Tamma',
			'Baloo Tamma 2',
			'Baloo Tammudu',
			'Baloo Tammudu 2',
			'Baloo Thambi',
			'Baloo Thambi 2',
			'Balthazar',
			'Bangers',
			'Barlow',
			'Barlow Condensed',
			'Barlow Semi Condensed',
			'Barriecito',
			'Barrio',
			'Basic',
			'Baskervville',
			'Battambang',
			'Baumans',
			'Bayon',
			'Be Vietnam',
			'Bebas Neue',
			'Belgrano',
			'Bellefair',
			'Belleza',
			'Bellota',
			'Bellota Text',
			'BenchNine',
			'Bentham',
			'Berkshire Swash',
			'Beth Ellen',
			'Bevan',
			'Big Shoulders Display',
			'Big Shoulders Text',
			'Bigelow Rules',
			'Bigshot One',
			'Bilbo',
			'Bilbo Swash Caps',
			'BioRhyme',
			'BioRhyme Expanded',
			'Biryani',
			'Bitter',
			'Black And White Picture',
			'Black Han Sans',
			'Black Ops One',
			'Blinker',
			'Bokor',
			'Bonbon',
			'Boogaloo',
			'Bowlby One',
			'Bowlby One SC',
			'Brawler',
			'Bree Serif',
			'Bubblegum Sans',
			'Bubbler One',
			'Buda',
			'Buenard',
			'Bungee',
			'Bungee Hairline',
			'Bungee Inline',
			'Bungee Outline',
			'Bungee Shade',
			'Butcherman',
			'Butterfly Kids',
			'Cabin',
			'Cabin Condensed',
			'Cabin Sketch',
			'Caesar Dressing',
			'Cagliostro',
			'Cairo',
			'Caladea',
			'Calistoga',
			'Calligraffitti',
			'Cambay',
			'Cambo',
			'Candal',
			'Cantarell',
			'Cantata One',
			'Cantora One',
			'Capriola',
			'Cardo',
			'Carme',
			'Carrois Gothic',
			'Carrois Gothic SC',
			'Carter One',
			'Catamaran',
			'Caudex',
			'Caveat',
			'Caveat Brush',
			'Cedarville Cursive',
			'Ceviche One',
			'Chakra Petch',
			'Changa',
			'Changa One',
			'Chango',
			'Charm',
			'Charmonman',
			'Chathura',
			'Chau Philomene One',
			'Chela One',
			'Chelsea Market',
			'Chenla',
			'Cherry Cream Soda',
			'Cherry Swash',
			'Chewy',
			'Chicle',
			'Chilanka',
			'Chivo',
			'Chonburi',
			'Cinzel',
			'Cinzel Decorative',
			'Clicker Script',
			'Coda',
			'Coda Caption',
			'Codystar',
			'Coiny',
			'Combo',
			'Comfortaa',
			'Comic Neue',
			'Coming Soon',
			'Concert One',
			'Condiment',
			'Content',
			'Contrail One',
			'Convergence',
			'Cookie',
			'Copse',
			'Corben',
			'Cormorant',
			'Cormorant Garamond',
			'Cormorant Infant',
			'Cormorant SC',
			'Cormorant Unicase',
			'Cormorant Upright',
			'Courgette',
			'Courier Prime',
			'Cousine',
			'Coustard',
			'Covered By Your Grace',
			'Crafty Girls',
			'Creepster',
			'Crete Round',
			'Crimson Pro',
			'Crimson Text',
			'Croissant One',
			'Crushed',
			'Cuprum',
			'Cute Font',
			'Cutive',
			'Cutive Mono',
			'DM Mono',
			'DM Sans',
			'DM Serif Display',
			'DM Serif Text',
			'Damion',
			'Dancing Script',
			'Dangrek',
			'Darker Grotesque',
			'David Libre',
			'Dawning of a New Day',
			'Days One',
			'Dekko',
			'Delius',
			'Delius Swash Caps',
			'Delius Unicase',
			'Della Respira',
			'Denk One',
			'Devonshire',
			'Dhurjati',
			'Didact Gothic',
			'Diplomata',
			'Diplomata SC',
			'Do Hyeon',
			'Dokdo',
			'Domine',
			'Donegal One',
			'Doppio One',
			'Dorsa',
			'Dosis',
			'Dr Sugiyama',
			'Droid Sans',
			'Droid Sans Mono',
			'Droid Serif',
			'Duru Sans',
			'Dynalight',
			'EB Garamond',
			'Eagle Lake',
			'East Sea Dokdo',
			'Eater',
			'Economica',
			'Eczar',
			'El Messiri',
			'Electrolize',
			'Elsie',
			'Elsie Swash Caps',
			'Emblema One',
			'Emilys Candy',
			'Encode Sans',
			'Encode Sans Condensed',
			'Encode Sans Expanded',
			'Encode Sans Semi Condensed',
			'Encode Sans Semi Expanded',
			'Engagement',
			'Englebert',
			'Enriqueta',
			'Epilogue',
			'Erica One',
			'Esteban',
			'Euphoria Script',
			'Ewert',
			'Exo',
			'Exo 2',
			'Expletus Sans',
			'Fahkwang',
			'Fanwood Text',
			'Farro',
			'Farsan',
			'Fascinate',
			'Fascinate Inline',
			'Faster One',
			'Fasthand',
			'Fauna One',
			'Faustina',
			'Federant',
			'Federo',
			'Felipa',
			'Fenix',
			'Finger Paint',
			'Fira Code',
			'Fira Mono',
			'Fira Sans',
			'Fira Sans Condensed',
			'Fira Sans Extra Condensed',
			'Fjalla One',
			'Fjord One',
			'Flamenco',
			'Flavors',
			'Fondamento',
			'Fontdiner Swanky',
			'Forum',
			'Francois One',
			'Frank Ruhl Libre',
			'Freckle Face',
			'Fredericka the Great',
			'Fredoka One',
			'Freehand',
			'Fresca',
			'Frijole',
			'Fruktur',
			'Fugaz One',
			'GFS Didot',
			'GFS Neohellenic',
			'Gabriela',
			'Gaegu',
			'Gafata',
			'Galada',
			'Galdeano',
			'Galindo',
			'Gamja Flower',
			'Gayathri',
			'Gelasio',
			'Gentium Basic',
			'Gentium Book Basic',
			'Geo',
			'Geostar',
			'Geostar Fill',
			'Germania One',
			'Gidugu',
			'Gilda Display',
			'Girassol',
			'Give You Glory',
			'Glass Antiqua',
			'Glegoo',
			'Gloria Hallelujah',
			'Goblin One',
			'Gochi Hand',
			'Gorditas',
			'Gothic A1',
			'Gotu',
			'Goudy Bookletter 1911',
			'Graduate',
			'Grand Hotel',
			'Grandstander',
			'Gravitas One',
			'Great Vibes',
			'Grenze',
			'Grenze Gotisch',
			'Griffy',
			'Gruppo',
			'Gudea',
			'Gugi',
			'Gupter',
			'Gurajada',
			'Habibi',
			'Halant',
			'Hammersmith One',
			'Hanalei',
			'Hanalei Fill',
			'Handlee',
			'Hanuman',
			'Happy Monkey',
			'Harmattan',
			'Headland One',
			'Heebo',
			'Henny Penny',
			'Hepta Slab',
			'Herr Von Muellerhoff',
			'Hi Melody',
			'Hind',
			'Hind Guntur',
			'Hind Madurai',
			'Hind Siliguri',
			'Hind Vadodara',
			'Holtwood One SC',
			'Homemade Apple',
			'Homenaje',
			'IBM Plex Mono',
			'IBM Plex Sans',
			'IBM Plex Sans Condensed',
			'IBM Plex Serif',
			'IM Fell DW Pica',
			'IM Fell DW Pica SC',
			'IM Fell Double Pica',
			'IM Fell Double Pica SC',
			'IM Fell English',
			'IM Fell English SC',
			'IM Fell French Canon',
			'IM Fell French Canon SC',
			'IM Fell Great Primer',
			'IM Fell Great Primer SC',
			'Ibarra Real Nova',
			'Iceberg',
			'Iceland',
			'Imprima',
			'Inconsolata',
			'Inder',
			'Indie Flower',
			'Inika',
			'Inknut Antiqua',
			'Inria Sans',
			'Inria Serif',
			'Inter',
			'Irish Grover',
			'Istok Web',
			'Italiana',
			'Italianno',
			'Itim',
			'Jacques Francois',
			'Jacques Francois Shadow',
			'Jaldi',
			'Jim Nightshade',
			'Jockey One',
			'Jolly Lodger',
			'Jomhuria',
			'Jomolhari',
			'Josefin Sans',
			'Josefin Slab',
			'Jost',
			'Joti One',
			'Jua',
			'Judson',
			'Julee',
			'Julius Sans One',
			'Junge',
			'Jura',
			'Just Another Hand',
			'Just Me Again Down Here',
			'K2D',
			'Kadwa',
			'Kalam',
			'Kameron',
			'Kanit',
			'Kantumruy',
			'Karla',
			'Karma',
			'Katibeh',
			'Kaushan Script',
			'Kavivanar',
			'Kavoon',
			'Kdam Thmor',
			'Keania One',
			'Kelly Slab',
			'Kenia',
			'Khand',
			'Khmer',
			'Khula',
			'Kirang Haerang',
			'Kite One',
			'Knewave',
			'KoHo',
			'Kodchasan',
			'Kosugi',
			'Kosugi Maru',
			'Kotta One',
			'Koulen',
			'Kranky',
			'Kreon',
			'Kristi',
			'Krona One',
			'Krub',
			'Kufam',
			'Kulim Park',
			'Kumar One',
			'Kumar One Outline',
			'Kumbh Sans',
			'Kurale',
			'La Belle Aurore',
			'Lacquer',
			'Laila',
			'Lakki Reddy',
			'Lalezar',
			'Lancelot',
			'Lateef',
			'Lato',
			'League Script',
			'Leckerli One',
			'Ledger',
			'Lekton',
			'Lemon',
			'Lemonada',
			'Lexend Deca',
			'Lexend Exa',
			'Lexend Giga',
			'Lexend Mega',
			'Lexend Peta',
			'Lexend Tera',
			'Lexend Zetta',
			'Libre Barcode 128',
			'Libre Barcode 128 Text',
			'Libre Barcode 39',
			'Libre Barcode 39 Extended',
			'Libre Barcode 39 Extended Text',
			'Libre Barcode 39 Text',
			'Libre Baskerville',
			'Libre Caslon Display',
			'Libre Caslon Text',
			'Libre Franklin',
			'Life Savers',
			'Lilita One',
			'Lily Script One',
			'Limelight',
			'Linden Hill',
			'Literata',
			'Liu Jian Mao Cao',
			'Livvic',
			'Lobster',
			'Lobster Two',
			'Londrina Outline',
			'Londrina Shadow',
			'Londrina Sketch',
			'Londrina Solid',
			'Long Cang',
			'Lora',
			'Love Ya Like A Sister',
			'Loved by the King',
			'Lovers Quarrel',
			'Luckiest Guy',
			'Lusitana',
			'Lustria',
			'M PLUS 1p',
			'M PLUS Rounded 1c',
			'Ma Shan Zheng',
			'Macondo',
			'Macondo Swash Caps',
			'Mada',
			'Magra',
			'Maiden Orange',
			'Maitree',
			'Major Mono Display',
			'Mako',
			'Mali',
			'Mallanna',
			'Mandali',
			'Manjari',
			'Manrope',
			'Mansalva',
			'Manuale',
			'Marcellus',
			'Marcellus SC',
			'Marck Script',
			'Margarine',
			'Markazi Text',
			'Marko One',
			'Marmelad',
			'Martel',
			'Martel Sans',
			'Marvel',
			'Mate',
			'Mate SC',
			'Maven Pro',
			'McLaren',
			'Meddon',
			'MedievalSharp',
			'Medula One',
			'Meera Inimai',
			'Megrim',
			'Meie Script',
			'Merienda',
			'Merienda One',
			'Merriweather',
			'Merriweather Sans',
			'Metal',
			'Metal Mania',
			'Metamorphous',
			'Metrophobic',
			'Michroma',
			'Milonga',
			'Miltonian',
			'Miltonian Tattoo',
			'Mina',
			'Miniver',
			'Miriam Libre',
			'Mirza',
			'Miss Fajardose',
			'Mitr',
			'Modak',
			'Modern Antiqua',
			'Mogra',
			'Molengo',
			'Molle',
			'Monda',
			'Monofett',
			'Monoton',
			'Monsieur La Doulaise',
			'Montaga',
			'Montez',
			'Montserrat',
			'Montserrat Alternates',
			'Montserrat Subrayada',
			'Moul',
			'Moulpali',
			'Mountains of Christmas',
			'Mouse Memoirs',
			'Mr Bedfort',
			'Mr Dafoe',
			'Mr De Haviland',
			'Mrs Saint Delafield',
			'Mrs Sheppards',
			'Mukta',
			'Mukta Mahee',
			'Mukta Malar',
			'Mukta Vaani',
			'Muli',
			'Mulish',
			'MuseoModerno',
			'Mystery Quest',
			'NTR',
			'Nanum Brush Script',
			'Nanum Gothic',
			'Nanum Gothic Coding',
			'Nanum Myeongjo',
			'Nanum Pen Script',
			'Neucha',
			'Neuton',
			'New Rocker',
			'News Cycle',
			'Niconne',
			'Niramit',
			'Nixie One',
			'Nobile',
			'Nokora',
			'Norican',
			'Nosifer',
			'Notable',
			'Nothing You Could Do',
			'Noticia Text',
			'Noto Sans',
			'Noto Sans HK',
			'Noto Sans JP',
			'Noto Sans KR',
			'Noto Sans SC',
			'Noto Sans TC',
			'Noto Serif',
			'Noto Serif JP',
			'Noto Serif KR',
			'Noto Serif SC',
			'Noto Serif TC',
			'Nova Cut',
			'Nova Flat',
			'Nova Mono',
			'Nova Oval',
			'Nova Round',
			'Nova Script',
			'Nova Slim',
			'Nova Square',
			'Numans',
			'Nunito',
			'Nunito Sans',
			'Odibee Sans',
			'Odor Mean Chey',
			'Offside',
			'Old Standard TT',
			'Oldenburg',
			'Oleo Script',
			'Oleo Script Swash Caps',
			'Open Sans',
			'Open Sans Condensed',
			'Oranienbaum',
			'Orbitron',
			'Oregano',
			'Orienta',
			'Original Surfer',
			'Oswald',
			'Over the Rainbow',
			'Overlock',
			'Overlock SC',
			'Overpass',
			'Overpass Mono',
			'Ovo',
			'Oxanium',
			'Oxygen',
			'Oxygen Mono',
			'PT Mono',
			'PT Sans',
			'PT Sans Caption',
			'PT Sans Narrow',
			'PT Serif',
			'PT Serif Caption',
			'Pacifico',
			'Padauk',
			'Palanquin',
			'Palanquin Dark',
			'Pangolin',
			'Paprika',
			'Parisienne',
			'Passero One',
			'Passion One',
			'Pathway Gothic One',
			'Patrick Hand',
			'Patrick Hand SC',
			'Pattaya',
			'Patua One',
			'Pavanam',
			'Paytone One',
			'Peddana',
			'Peralta',
			'Permanent Marker',
			'Petit Formal Script',
			'Petrona',
			'Philosopher',
			'Piedra',
			'Pinyon Script',
			'Pirata One',
			'Plaster',
			'Play',
			'Playball',
			'Playfair Display',
			'Playfair Display SC',
			'Podkova',
			'Poiret One',
			'Poller One',
			'Poly',
			'Pompiere',
			'Pontano Sans',
			'Poor Story',
			'Poppins',
			'Port Lligat Sans',
			'Port Lligat Slab',
			'Pragati Narrow',
			'Prata',
			'Preahvihear',
			'Press Start 2P',
			'Pridi',
			'Princess Sofia',
			'Prociono',
			'Prompt',
			'Prosto One',
			'Proza Libre',
			'Public Sans',
			'Puritan',
			'Purple Purse',
			'Quando',
			'Quantico',
			'Quattrocento',
			'Quattrocento Sans',
			'Questrial',
			'Quicksand',
			'Quintessential',
			'Qwigley',
			'Racing Sans One',
			'Radley',
			'Rajdhani',
			'Rakkas',
			'Raleway',
			'Raleway Dots',
			'Ramabhadra',
			'Ramaraja',
			'Rambla',
			'Rammetto One',
			'Ranchers',
			'Rancho',
			'Ranga',
			'Rasa',
			'Rationale',
			'Ravi Prakash',
			'Recursive',
			'Red Hat Display',
			'Red Hat Text',
			'Red Rose',
			'Redressed',
			'Reem Kufi',
			'Reenie Beanie',
			'Revalia',
			'Rhodium Libre',
			'Ribeye',
			'Ribeye Marrow',
			'Righteous',
			'Risque',
			'Roboto',
			'Roboto Condensed',
			'Roboto Mono',
			'Roboto Slab',
			'Rochester',
			'Rock Salt',
			'Rokkitt',
			'Romanesco',
			'Ropa Sans',
			'Rosario',
			'Rosarivo',
			'Rouge Script',
			'Rowdies',
			'Rozha One',
			'Rubik',
			'Rubik Mono One',
			'Ruda',
			'Rufina',
			'Ruge Boogie',
			'Ruluko',
			'Rum Raisin',
			'Ruslan Display',
			'Russo One',
			'Ruthie',
			'Rye',
			'Sacramento',
			'Sahitya',
			'Sail',
			'Saira',
			'Saira Condensed',
			'Saira Extra Condensed',
			'Saira Semi Condensed',
			'Saira Stencil One',
			'Salsa',
			'Sanchez',
			'Sancreek',
			'Sansita',
			'Sarabun',
			'Sarala',
			'Sarina',
			'Sarpanch',
			'Satisfy',
			'Sawarabi Gothic',
			'Sawarabi Mincho',
			'Scada',
			'Scheherazade',
			'Schoolbell',
			'Scope One',
			'Seaweed Script',
			'Secular One',
			'Sedgwick Ave',
			'Sedgwick Ave Display',
			'Sen',
			'Sevillana',
			'Seymour One',
			'Shadows Into Light',
			'Shadows Into Light Two',
			'Shanti',
			'Share',
			'Share Tech',
			'Share Tech Mono',
			'Shojumaru',
			'Short Stack',
			'Shrikhand',
			'Siemreap',
			'Sigmar One',
			'Signika',
			'Signika Negative',
			'Simonetta',
			'Single Day',
			'Sintony',
			'Sirin Stencil',
			'Six Caps',
			'Skranji',
			'Slabo 13px',
			'Slabo 27px',
			'Slackey',
			'Smokum',
			'Smythe',
			'Sniglet',
			'Snippet',
			'Snowburst One',
			'Sofadi One',
			'Sofia',
			'Solway',
			'Song Myung',
			'Sonsie One',
			'Sora',
			'Sorts Mill Goudy',
			'Source Code Pro',
			'Source Sans Pro',
			'Source Serif Pro',
			'Space Mono',
			'Spartan',
			'Special Elite',
			'Spectral',
			'Spectral SC',
			'Spicy Rice',
			'Spinnaker',
			'Spirax',
			'Squada One',
			'Sree Krushnadevaraya',
			'Sriracha',
			'Srisakdi',
			'Staatliches',
			'Stalemate',
			'Stalinist One',
			'Stardos Stencil',
			'Stint Ultra Condensed',
			'Stint Ultra Expanded',
			'Stoke',
			'Strait',
			'Stylish',
			'Sue Ellen Francisco',
			'Suez One',
			'Sulphur Point',
			'Sumana',
			'Sunflower',
			'Sunshiney',
			'Supermercado One',
			'Sura',
			'Suranna',
			'Suravaram',
			'Suwannaphum',
			'Swanky and Moo Moo',
			'Syncopate',
			'Syne',
			'Tajawal',
			'Tangerine',
			'Taprom',
			'Tauri',
			'Taviraj',
			'Teko',
			'Telex',
			'Tenali Ramakrishna',
			'Tenor Sans',
			'Text Me One',
			'Thasadith',
			'The Girl Next Door',
			'Tienne',
			'Tillana',
			'Timmana',
			'Tinos',
			'Titan One',
			'Titillium Web',
			'Tomorrow',
			'Trade Winds',
			'Trirong',
			'Trocchi',
			'Trochut',
			'Trykker',
			'Tulpen One',
			'Turret Road',
			'Ubuntu',
			'Ubuntu Condensed',
			'Ubuntu Mono',
			'Ultra',
			'Uncial Antiqua',
			'Underdog',
			'Unica One',
			'UnifrakturCook',
			'UnifrakturMaguntia',
			'Unkempt',
			'Unlock',
			'Unna',
			'VT323',
			'Vampiro One',
			'Varela',
			'Varela Round',
			'Varta',
			'Vast Shadow',
			'Vesper Libre',
			'Viaoda Libre',
			'Vibes',
			'Vibur',
			'Vidaloka',
			'Viga',
			'Voces',
			'Volkhov',
			'Vollkorn',
			'Vollkorn SC',
			'Voltaire',
			'Waiting for the Sunrise',
			'Wallpoet',
			'Walter Turncoat',
			'Warnes',
			'Wellfleet',
			'Wendy One',
			'Wire One',
			'Work Sans',
			'Yanone Kaffeesatz',
			'Yantramanav',
			'Yatra One',
			'Yellowtail',
			'Yeon Sung',
			'Yeseva One',
			'Yesteryear',
			'Yrsa',
			'ZCOOL KuaiLe',
			'ZCOOL QingKe HuangYou',
			'ZCOOL XiaoWei',
			'Zeyada',
			'Zhi Mang Xing',
			'Zilla Slab',
			'Zilla Slab Highlight',
		)
	);
}

/**
 * Get the heading selectors array.
 *
 * @return array
 */
function neve_get_headings_selectors() {
	return apply_filters(
		'neve_headings_typeface_selectors',
		array(
			'h1' => \Neve\Core\Settings\Config::$css_selectors_map[ \Neve\Core\Settings\Config::CSS_SELECTOR_TYPEFACE_H1 ],
			'h2' => \Neve\Core\Settings\Config::$css_selectors_map[ \Neve\Core\Settings\Config::CSS_SELECTOR_TYPEFACE_H2 ],
			'h3' => \Neve\Core\Settings\Config::$css_selectors_map[ \Neve\Core\Settings\Config::CSS_SELECTOR_TYPEFACE_H3 ],
			'h4' => \Neve\Core\Settings\Config::$css_selectors_map[ \Neve\Core\Settings\Config::CSS_SELECTOR_TYPEFACE_H4 ],
			'h5' => \Neve\Core\Settings\Config::$css_selectors_map[ \Neve\Core\Settings\Config::CSS_SELECTOR_TYPEFACE_H5 ],
			'h6' => \Neve\Core\Settings\Config::$css_selectors_map[ \Neve\Core\Settings\Config::CSS_SELECTOR_TYPEFACE_H6 ],
		)
	);
}

/**
 * Get Global Colors Default
 *
 * @param bool $migrated get with migrated colors.
 * @return array
 */
function neve_get_global_colors_default( $migrated = false ) {

	$old_link_color       = get_theme_mod( 'neve_link_color', '#0366d6' );
	$old_link_hover_color = get_theme_mod( 'neve_link_hover_color', '#0e509a' );
	$old_text_color       = get_theme_mod( 'neve_text_color', '#393939' );
	$old_bg_color         = '#' . get_theme_mod( 'background_color', 'ffffff' );

	add_filter( 'theme_mod_background_color', '__return_empty_string' );

	return [
		'activePalette' => 'base',
		'palettes'      => [
			'base'     => [
				'name'          => __( 'Base', 'neve' ),
				'allowDeletion' => false,
				'colors'        => [
					'nv-primary-accent'   => $migrated ? $old_link_color : '#0366d6',
					'nv-secondary-accent' => $migrated ? $old_link_hover_color : '#0e509a',
					'nv-site-bg'          => $migrated ? $old_bg_color : '#ffffff',
					'nv-light-bg'         => '#ededed',
					'nv-dark-bg'          => '#14171c',
					'nv-text-color'       => $migrated ? $old_text_color : '#393939',
					'nv-text-dark-bg'     => '#ffffff',
					'nv-c-1'              => '#77b978',
					'nv-c-2'              => '#f37262',
				],
			],
			'darkMode' => [
				'name'          => __( 'Dark Mode', 'neve' ),
				'allowDeletion' => false,
				'colors'        => [
					'nv-primary-accent'   => '#26bcdb',
					'nv-secondary-accent' => '#1f90a6',
					'nv-site-bg'          => '#121212',
					'nv-light-bg'         => '#1a1a1a',
					'nv-dark-bg'          => '#1a1a1a',
					'nv-text-color'       => '#ffffff',
					'nv-text-dark-bg'     => 'rgba(255, 255, 255, 0.81)',
					'nv-c-1'              => '#77b978',
					'nv-c-2'              => '#f37262',
				],
			],
		],
	];
}
