<?php
/**
 * Custom Component class for Header Footer Grid.
 *
 * Name:    Header Footer Grid
 * Author:  Bogdan Preda <bogdan.preda@themeisle.com>
 *
 * @version 1.0.0
 * @package HFG
 */

namespace HFG\Core\Components;

use HFG\Core\Settings\Manager as SettingsManager;
use HFG\Main;
use Neve\Core\Settings\Config;
use Neve\Core\Settings\Mods;
use Neve\Core\Styles\Dynamic_Selector;

/**
 * Class Nav
 *
 * @package HFG\Core\Components
 */
class Nav extends Abstract_Component {
	const COMPONENT_ID             = 'primary-menu';
	const STYLE_ID                 = 'style';
	const COLOR_ID                 = 'color';
	const HOVER_COLOR_ID           = 'hover_color';
	const HOVER_TEXT_COLOR_ID      = 'hover_text_color';
	const ACTIVE_COLOR_ID          = 'active_color';
	const LAST_ITEM_ID             = 'neve_last_menu_item';
	const NAV_MENU_ID              = 'nv-primary-navigation';
	const ITEM_HEIGHT              = 'item_height';
	const SPACING                  = 'spacing';
	const EXPAND_DROPDOWNS         = 'expand_dropdowns';
	const DROPDOWNS_EXPANDED_CLASS = 'dropdowns-expanded';

	/**
	 * Nav constructor.
	 *
	 * @since   1.0.0
	 * @access  public
	 */
	public function init() {
		$this->set_property( 'label', __( 'Primary Menu', 'neve' ) );
		$this->set_property( 'component_slug', 'hfg-primary-menu' );
		$this->set_property( 'id', $this->get_class_const( 'COMPONENT_ID' ) );
		$this->set_property( 'width', 6 );
		$this->set_property( 'icon', 'tagcloud' );
		$this->set_property( 'section', 'header_menu_primary' );
		$this->set_property( 'has_font_family_control', true );
		$this->set_property( 'has_typeface_control', true );
		$this->set_property( 'default_typography_selector', $this->default_typography_selector . '.builder-item--' . $this->get_id() );
		$this->default_align = 'right';
		add_filter(
			'neve_last_menu_setting_slug_' . $this->get_class_const( 'COMPONENT_ID' ),
			array(
				$this,
				'filter_neve_last_menu_setting_slug',
			)
		);

		add_action(
			'neve_before_render_nav',
			function ( $component_id ) {
				if ( $this->get_id() !== $component_id ) {
					return;
				}
				add_filter( 'neve_first_level_expanded', [ $this, 'expanded_dropdown' ] );
				add_filter( 'nav_menu_submenu_css_class', [ $this, 'filter_menu_item_class' ], 10, 3 );
			}
		);

		add_action(
			'neve_after_render_nav',
			function ( $component_id ) {
				if ( $this->get_id() !== $component_id ) {
					return;
				}
				remove_filter( 'neve_first_level_expanded', [ $this, 'expanded_dropdown' ] );
				remove_filter( 'nav_menu_submenu_css_class', [ $this, 'filter_menu_item_class' ] );
			}
		);


		add_action( 'init', [ $this, 'run_nav_init' ] );
	}

	/**
	 * Function for expanded carets.
	 *
	 * @return bool
	 */
	public function expanded_dropdown() {
		if ( ! $this->is_component_active() ) {
			return false;
		}
		return (bool) get_theme_mod( $this->get_id() . '_' . self::EXPAND_DROPDOWNS, false );
	}

	/**
	 * Add open class on submenu if 'Expand the first level of dropdowns...' option is on.
	 *
	 * @param array     $classes Submenu classes.
	 * @param \stdClass $args Submenu args.
	 * @param int       $depth Submenu depth.
	 *
	 * @return array
	 */
	public function filter_menu_item_class( $classes, $args, $depth ) {
		if ( ! $this->is_component_active() ) {
			return $classes;
		}
		$expand_dropdowns = get_theme_mod( $this->get_id() . '_' . self::EXPAND_DROPDOWNS, false );
		if ( (bool) $expand_dropdowns === false ) {
			return $classes;
		}
		if ( property_exists( $args, 'menu_class' ) && strpos( $args->menu_class, 'menu-mobile' ) && $depth === 0 ) {
			$classes[] = 'dropdown-open';
		}
		return $classes;
	}

	/**
	 * Way for adding other actions in pro.
	 *
	 * @since 3.4
	 * @access public
	 */
	public function run_nav_init() {
		do_action( 'neve_after_nav_init', $this->get_class_const( 'COMPONENT_ID' ) );
	}

	/**
	 * Filter the setting slug for last menu.
	 *
	 * @param string $slug The setting slug.
	 *
	 * @return string
	 * @since   2.3.7
	 * @access  public
	 */
	public function filter_neve_last_menu_setting_slug( $slug ) {
		if ( $slug !== $this->get_class_const( 'LAST_ITEM_ID' ) ) {
			return $this->get_class_const( 'LAST_ITEM_ID' );
		}

		return $slug;
	}

	/**
	 * Called to register component controls.
	 *
	 * @since   1.0.0
	 * @access  public
	 */
	public function add_settings() {
		SettingsManager::get_instance()->add(
			[
				'id'                 => self::STYLE_ID,
				'group'              => $this->get_class_const( 'COMPONENT_ID' ),
				'tab'                => SettingsManager::TAB_STYLE,
				'transport'          => 'refresh',
				'sanitize_callback'  => 'wp_filter_nohtml_kses',
				'default'            => 'style-plain',
				'conditional_header' => true,
				'label'              => __( 'Hover Skin Mode', 'neve' ),
				'type'               => '\Neve\Customizer\Controls\React\Radio_Buttons',
				'section'            => $this->section,
				'options'            => [
					'large_buttons' => true,
					'is_for'        => 'menu',
				],
			]
		);

		$selector = '.builder-item--' . $this->get_id() . ' .nav-menu-primary > .nav-ul ';
		SettingsManager::get_instance()->add(
			[
				'id'                    => self::COLOR_ID,
				'group'                 => $this->get_class_const( 'COMPONENT_ID' ),
				'tab'                   => SettingsManager::TAB_STYLE,
				'transport'             => 'postMessage',
				'sanitize_callback'     => 'neve_sanitize_colors',
				'default'               => neve_is_new_skin() ? '' : 'var(--nv-text-color)',
				'label'                 => __( 'Items Color', 'neve' ),
				'type'                  => 'neve_color_control',
				'section'               => $this->section,
				'conditional_header'    => true,
				'live_refresh_selector' => true,
				'live_refresh_css_prop' => [
					'cssVar'   => [
						'vars'     => '--color',
						'selector' => '.builder-item--' . $this->get_id(),
					],
					'template' =>
						$selector . ' li:not(.current_page_item):not(.current-menu-item):not(.woocommerce-mini-cart-item) > a,' . $selector . ' li.neve-mm-heading span {
						color: {{value}};
					}',
				],
			]
		);
		SettingsManager::get_instance()->add(
			[
				'id'                    => self::ACTIVE_COLOR_ID,
				'group'                 => $this->get_class_const( 'COMPONENT_ID' ),
				'tab'                   => SettingsManager::TAB_STYLE,
				'transport'             => 'postMessage',
				'sanitize_callback'     => 'neve_sanitize_colors',
				'default'               => 'var(--nv-primary-accent)',
				'label'                 => __( 'Active Item Color', 'neve' ),
				'type'                  => 'neve_color_control',
				'section'               => $this->section,
				'conditional_header'    => true,
				'live_refresh_selector' => true,
				'live_refresh_css_prop' => [
					'cssVar'   => [
						'vars'     => '--activecolor',
						'selector' => '.builder-item--' . $this->get_id(),
					],
					'template' =>
						$selector . ' li.current_page_item > .wrap > a,' . $selector . ' li.current-menu-item > .wrap > a {
						color: {{value}} !important;
					}',
				],
			]
		);
		SettingsManager::get_instance()->add(
			[
				'id'                    => self::HOVER_COLOR_ID,
				'group'                 => $this->get_class_const( 'COMPONENT_ID' ),
				'tab'                   => SettingsManager::TAB_STYLE,
				'transport'             => 'postMessage',
				'sanitize_callback'     => 'neve_sanitize_colors',
				'default'               => 'var(--nv-secondary-accent)',
				'label'                 => __( 'Items Hover Color', 'neve' ),
				'type'                  => 'neve_color_control',
				'section'               => $this->section,
				'conditional_header'    => true,
				'live_refresh_selector' => true,
				'live_refresh_css_prop' => [
					'cssVar'   => [
						'vars'     => '--hovercolor',
						'selector' => '.builder-item--' . $this->get_id(),
					],
					'template' =>
						'.builder-item--' . $this->get_id() . ' .nav-menu-primary:not(.style-full-height) > .nav-ul li:not(.woocommerce-mini-cart-item):hover > .wrap > a {
							 color: {{value}} !important;
						}' .
						$selector . ' li:not(.woocommerce-mini-cart-item) > .wrap:after,' . $selector . ' li > .has-caret > a:after {
							background-color: {{value}} !important;
						}',
				],
			]
		);
		SettingsManager::get_instance()->add(
			[
				'id'                    => self::HOVER_TEXT_COLOR_ID,
				'group'                 => $this->get_class_const( 'COMPONENT_ID' ),
				'tab'                   => SettingsManager::TAB_STYLE,
				'transport'             => 'postMessage',
				'sanitize_callback'     => 'neve_sanitize_colors',
				'default'               => 'var(--nv-text-color)',
				'label'                 => __( 'Hover Skin Mode', 'neve' ) . ' ' . __( 'Color', 'neve' ),
				'type'                  => 'neve_color_control',
				'section'               => $this->section,
				'conditional_header'    => true,
				'live_refresh_selector' => true,
				'live_refresh_css_prop' => [
					'cssVar' => [
						'vars'     => '--hovertextcolor',
						'selector' => '.builder-item--' . $this->get_id(),
					],
				],
				'options'               => [
					'active_callback' => function() {
						return Mods::get( $this->get_id() . '_' . self::STYLE_ID, 'style-plain' ) === 'style-full-height';
					},
				],
			]
		);

		$order_default_components = array(
			'search',
		);
		$components               = array(
			'search' => __( 'Search', 'neve' ),
		);

		if ( class_exists( 'WooCommerce', false ) ) {
			array_push( $order_default_components, 'cart' );
			$components['cart'] = __( 'Cart', 'neve' );
		}

		$components = apply_filters( 'neve_last_menu_item_components', $components );

		/**
		 * Last menu item removed for new users and users who didn't have it set.
		 *
		 * @since 2.5.3
		 */
		$old_last_menu_item = json_decode( get_theme_mod( 'neve_last_menu_item' ) );
		if ( $old_last_menu_item !== false && ! empty( $old_last_menu_item ) ) {
			SettingsManager::get_instance()->add(
				[
					'id'                => $this->get_class_const( 'LAST_ITEM_ID' ),
					'group'             => $this->get_class_const( 'COMPONENT_ID' ),
					'tab'               => SettingsManager::TAB_GENERAL,
					'noformat'          => true,
					'transport'         => 'post' . $this->get_class_const( 'COMPONENT_ID' ),
					'sanitize_callback' => array( $this, 'sanitize_last_menu_item' ),
					'default'           => wp_json_encode( $order_default_components ),
					'label'             => __( 'Last Menu Item', 'neve' ),
					'type'              => 'Neve\Customizer\Controls\Ordering',
					'options'           => [
						'components' => $components,
					],
					'section'           => $this->section,
				]
			);
		}
		SettingsManager::get_instance()->add(
			[
				'id'                => 'shortcut',
				'group'             => $this->get_class_const( 'COMPONENT_ID' ),
				'tab'               => SettingsManager::TAB_GENERAL,
				'transport'         => 'postMessage',
				'sanitize_callback' => 'esc_attr',
				'type'              => '\Neve\Customizer\Controls\Button',
				'options'           => [
					'button_text'  => __( 'Primary Menu', 'neve' ),
					'button_class' => 'nv-top-bar-menu-shortcut',
					'icon_class'   => 'menu',
					'shortcut'     => true,
				],
				'section'           => $this->section,
			]
		);

		SettingsManager::get_instance()->add(
			[
				'id'                 => self::SPACING,
				'group'              => $this->get_class_const( 'COMPONENT_ID' ),
				'tab'                => SettingsManager::TAB_LAYOUT,
				'section'            => $this->section,
				'label'              => __( 'Items Spacing (px)', 'neve' ),
				'type'               => 'Neve\Customizer\Controls\React\Responsive_Range',
				'transport'          => 'post' . $this->get_class_const( 'COMPONENT_ID' ),
				'sanitize_callback'  => [ $this, 'sanitize_responsive_int_json' ],
				'default'            => $this->get_default_for_responsive_from_intval( self::SPACING, 20 ),
				'options'            => [
					'input_attrs' => [
						'min'        => 1,
						'max'        => 100,
						'units'      => [ 'px' ],
						'defaultVal' => [
							'mobile'  => 20,
							'tablet'  => 20,
							'desktop' => 20,
							'suffix'  => [
								'mobile'  => 'px',
								'tablet'  => 'px',
								'desktop' => 'px',
							],
						],
					],
				],
				'conditional_header' => true,
			]
		);

		SettingsManager::get_instance()->add(
			[
				'id'                 => self::ITEM_HEIGHT,
				'group'              => $this->get_class_const( 'COMPONENT_ID' ),
				'tab'                => SettingsManager::TAB_LAYOUT,
				'label'              => __( 'Items Min Height (px)', 'neve' ),
				'sanitize_callback'  => [ $this, 'sanitize_responsive_int_json' ],
				'transport'          => 'post' . $this->get_class_const( 'COMPONENT_ID' ),
				'default'            => $this->get_default_for_responsive_from_intval( self::ITEM_HEIGHT, 25 ),
				'type'               => 'Neve\Customizer\Controls\React\Responsive_Range',
				'options'            => [
					'input_attrs' => [
						'min'        => 1,
						'max'        => 100,
						'units'      => [ 'px' ],
						'defaultVal' => [
							'mobile'  => 25,
							'tablet'  => 25,
							'desktop' => 25,
							'suffix'  => [
								'mobile'  => 'px',
								'tablet'  => 'px',
								'desktop' => 'px',
							],
						],
					],
				],
				'section'            => $this->section,
				'conditional_header' => true,
			]
		);

		SettingsManager::get_instance()->add(
			[
				'id'                 => self::EXPAND_DROPDOWNS,
				'group'              => $this->get_class_const( 'COMPONENT_ID' ),
				'tab'                => SettingsManager::TAB_GENERAL,
				'transport'          => 'refresh',
				'sanitize_callback'  => 'absint',
				'default'            => 0,
				'label'              => __( 'Expand first level of dropdowns when menu is in mobile menu content.', 'neve' ),
				'type'               => 'neve_toggle_control',
				'section'            => $this->section,
				'conditional_header' => true,
			]
		);
	}

	/**
	 * Sanitize last menu item.
	 *
	 * @param string $value Json value of the control.
	 *
	 * @return string
	 */
	public function sanitize_last_menu_item( $value ) {
		$allowed = array(
			'cart',
			'search',
			'wish_list',
		);

		if ( empty( $value ) ) {
			return wp_json_encode( $allowed );
		}

		$decoded = json_decode( $value, true );

		foreach ( $decoded as $val ) {
			if ( ! in_array( $val, $allowed, true ) ) {
				return wp_json_encode( $allowed );
			}
		}

		return $value;
	}

	/**
	 * The render method for the component.
	 *
	 * @since   1.0.0
	 * @access  public
	 */
	public function render_component() {
		do_action( 'neve_before_render_nav', $this->get_id() );
		Main::get_instance()->load( 'components/component-nav', '', $this->args );
		do_action( 'neve_after_render_nav', $this->get_id() );
	}

	/**
	 * Add styles to the component.
	 *
	 * @param array $css_array rules array.
	 *
	 * @return array
	 */
	public function add_style( array $css_array = array() ) {
		if ( ! neve_is_new_skin() ) {
			return $this->add_legacy_style( $css_array );
		}

		$selector = '.builder-item--' . $this->get_id();

		$rules = [
			'--color'          => [
				Dynamic_Selector::META_KEY => $this->get_id() . '_' . self::COLOR_ID,
			],
			'--hovercolor'     => [
				Dynamic_Selector::META_KEY     => $this->get_id() . '_' . self::HOVER_COLOR_ID,
				Dynamic_Selector::META_DEFAULT => SettingsManager::get_instance()->get_default( $this->get_id() . '_' . self::HOVER_COLOR_ID ),
			],
			'--hovertextcolor' => [
				Dynamic_Selector::META_KEY     => $this->get_id() . '_' . self::HOVER_TEXT_COLOR_ID,
				Dynamic_Selector::META_DEFAULT => SettingsManager::get_instance()->get_default( $this->get_id() . '_' . self::HOVER_TEXT_COLOR_ID ),
			],
			'--activecolor'    => [
				Dynamic_Selector::META_KEY     => $this->get_id() . '_' . self::ACTIVE_COLOR_ID,
				Dynamic_Selector::META_DEFAULT => SettingsManager::get_instance()->get_default( $this->get_id() . '_' . self::ACTIVE_COLOR_ID ),
			],
			'--spacing'        => [
				Dynamic_Selector::META_KEY           => $this->get_id() . '_' . self::SPACING,
				Dynamic_Selector::META_IS_RESPONSIVE => true,
				Dynamic_Selector::META_SUFFIX        => 'px',
				Dynamic_Selector::META_DEFAULT       => $this->get_default_for_responsive_from_intval( self::SPACING, 20 ),
			],
			'--height'         => [
				Dynamic_Selector::META_KEY           => $this->get_id() . '_' . self::ITEM_HEIGHT,
				Dynamic_Selector::META_IS_RESPONSIVE => true,
				Dynamic_Selector::META_SUFFIX        => 'px',
				Dynamic_Selector::META_DEFAULT       => $this->get_default_for_responsive_from_intval( self::ITEM_HEIGHT, 25 ),
			],
		];

		$css_array[] = [
			Dynamic_Selector::KEY_SELECTOR => $selector,
			Dynamic_Selector::KEY_RULES    => $rules,
		];

		$css_array = apply_filters( 'neve_nav_filter_css', $css_array, $this->get_id() );


		return parent::add_style( $css_array );
	}

	/**
	 * Add legacy style.
	 *
	 * @param array $css_array the styles css array.
	 *
	 * @return array
	 */
	private function add_legacy_style( array $css_array ) {
		$selector = '.builder-item--' . $this->get_id() . ' .nav-menu-primary > .nav-ul ';

		$css_array[] = [
			Dynamic_Selector::KEY_SELECTOR => $selector . 'li:not(.woocommerce-mini-cart-item) > .wrap > a,' . $selector . '.has-caret > a,' . $selector . ' .neve-mm-heading span,' . $selector . ' .has-caret',
			Dynamic_Selector::KEY_RULES    => [
				Config::CSS_PROP_COLOR => [
					Dynamic_Selector::META_KEY     => $this->get_id() . '_' . self::COLOR_ID,
					Dynamic_Selector::META_DEFAULT => SettingsManager::get_instance()->get_default( $this->get_id() . '_' . self::COLOR_ID ),
				],
			],
		];

		$css_array[] = [
			Dynamic_Selector::KEY_SELECTOR => $selector . ' li:not(.woocommerce-mini-cart-item) > wrap:after,' . $selector . ' li > .has-caret > .wrap:after, ' . $selector . ' li:not(.woocommerce-mini-cart-item) > .wrap:after',
			Dynamic_Selector::KEY_RULES    => [
				Config::CSS_PROP_BACKGROUND_COLOR => [
					Dynamic_Selector::META_KEY     => $this->get_id() . '_' . self::HOVER_COLOR_ID,
					Dynamic_Selector::META_DEFAULT => SettingsManager::get_instance()->get_default( $this->get_id() . '_' . self::HOVER_COLOR_ID ),
				],
			],
		];
		if ( SettingsManager::get_instance()->get( $this->get_id() . '_style' ) !== 'style-full-height' ) {
			$css_array[] = [
				Dynamic_Selector::KEY_SELECTOR => $selector . ' li:not(.woocommerce-mini-cart-item):hover > .wrap > a,' . $selector . ' li:hover > .has-caret > .wrap > a,' . $selector . ' li:hover > .has-caret',
				Dynamic_Selector::KEY_RULES    => [
					Config::CSS_PROP_COLOR => [
						Dynamic_Selector::META_KEY     => $this->get_id() . '_' . self::HOVER_COLOR_ID,
						Dynamic_Selector::META_DEFAULT => SettingsManager::get_instance()->get_default( $this->get_id() . '_' . self::HOVER_COLOR_ID ),
					],
				],
			];
			$css_array[] = [
				Dynamic_Selector::KEY_SELECTOR => $selector . 'li:hover > .has-caret svg',
				Dynamic_Selector::KEY_RULES    => [
					Config::CSS_PROP_FILL_COLOR => [
						Dynamic_Selector::META_KEY     => $this->get_id() . '_' . self::HOVER_COLOR_ID,
						Dynamic_Selector::META_DEFAULT => SettingsManager::get_instance()->get_default( $this->get_id() . '_' . self::HOVER_COLOR_ID ),
					],
				],
			];
		}
		$css_array[] = [
			Dynamic_Selector::KEY_SELECTOR => $selector . 'li.current-menu-item > .wrap > a,' . $selector . 'li.current_page_item > .wrap > a,' . $selector . 'li.current_page_item > .has-caret > a',
			Dynamic_Selector::KEY_RULES    => [
				Config::CSS_PROP_COLOR => [
					Dynamic_Selector::META_KEY     => $this->get_id() . '_' . self::ACTIVE_COLOR_ID,
					Dynamic_Selector::META_DEFAULT => SettingsManager::get_instance()->get_default( $this->get_id() . '_' . self::ACTIVE_COLOR_ID ),
				],
			],
		];
		$css_array[] = [
			Dynamic_Selector::KEY_SELECTOR => $selector . 'li.current-menu-item > .has-caret svg',
			Dynamic_Selector::KEY_RULES    => [
				Config::CSS_PROP_FILL_COLOR => [
					Dynamic_Selector::META_KEY     => $this->get_id() . '_' . self::ACTIVE_COLOR_ID,
					Dynamic_Selector::META_DEFAULT => SettingsManager::get_instance()->get_default( $this->get_id() . '_' . self::ACTIVE_COLOR_ID ),
				],
			],
		];

		$is_rtl = is_rtl();
		$last   = $is_rtl ? 'first' : 'last';

		$css_array[] = [
			Dynamic_Selector::KEY_SELECTOR => '.builder-item--' . $this->get_id() . ' .nav-ul > li:not(:' . $last . '-of-type)',
			Dynamic_Selector::KEY_RULES    => [
				Config::CSS_PROP_MARGIN_RIGHT => [
					Dynamic_Selector::META_KEY           => $this->get_id() . '_' . self::SPACING,
					Dynamic_Selector::META_IS_RESPONSIVE => true,
					Dynamic_Selector::META_FILTER        => function ( $css_prop, $value, $meta, $device ) {
						return sprintf( '%s:%s;', $css_prop, absint( $value ) . 'px' );
					},
					Dynamic_Selector::META_DEFAULT       => $this->get_default_for_responsive_from_intval( self::SPACING, 20 ),
				],
			],
		];

		$css_array[] = [
			Dynamic_Selector::KEY_SELECTOR => '.builder-item--' . $this->get_id() . ' .style-full-height .nav-ul li:not(.menu-item-nav-search):not(.menu-item-nav-cart) > a:after',
			Dynamic_Selector::KEY_RULES    => [
				'position' => [
					Dynamic_Selector::META_KEY           => $this->get_id() . '_' . self::SPACING,
					Dynamic_Selector::META_IS_RESPONSIVE => true,
					Dynamic_Selector::META_FILTER        => function ( $css_prop, $value, $meta, $device ) {
						if ( $device !== Dynamic_Selector::DESKTOP ) {
							return '';
						}
						$value = absint( $value );

						return sprintf( 'left:%s;right:%s', - $value / 2 . 'px', - $value / 2 . 'px' );
					},
					Dynamic_Selector::META_DEFAULT       => $this->get_default_for_responsive_from_intval( self::SPACING, 20 ),
				],
			],
		];

		$css_array[] = [
			Dynamic_Selector::KEY_SELECTOR => '.builder-item--' . $this->get_id() . ' .style-full-height .nav-ul li:not(.menu-item-nav-search):not(.menu-item-nav-cart):hover > a:after',
			Dynamic_Selector::KEY_RULES    => [
				Config::CSS_PROP_WIDTH => [
					Dynamic_Selector::META_KEY           => $this->get_id() . '_' . self::SPACING,
					Dynamic_Selector::META_IS_RESPONSIVE => true,
					Dynamic_Selector::META_FILTER        => function ( $css_prop, $value, $meta, $device ) {
						return sprintf( 'width: calc(100%% + %s);', absint( $value ) . 'px' );
					},
					Dynamic_Selector::META_DEFAULT       => $this->get_default_for_responsive_from_intval( self::SPACING, 20 ),
				],
			],
		];

		$css_array[] = [
			Dynamic_Selector::KEY_SELECTOR => '.builder-item--' . $this->get_id() . ' .nav-ul li a, .builder-item--' . $this->get_id() . ' .neve-mm-heading span',
			Dynamic_Selector::KEY_RULES    => [
				'min-height' => [
					Dynamic_Selector::META_KEY           => $this->get_id() . '_' . self::ITEM_HEIGHT,
					Dynamic_Selector::META_IS_RESPONSIVE => true,
					Dynamic_Selector::META_DEFAULT       => $this->get_default_for_responsive_from_intval( self::ITEM_HEIGHT, 25 ),
				],
			],
		];

		return parent::add_style( $css_array );
	}
}
