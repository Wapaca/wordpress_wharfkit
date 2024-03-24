<?php
namespace Cookiz_Elementor\Widgets;
if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}
use Elementor\Widget_Base;
use Elementor\Core\Schemes;
use Elementor\Controls_Manager;
use Elementor\Control_Media;
use Elementor\Utils;
use Elementor\Group_Control_Image_Size;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Css_Filter;

/**
 * Elementor image box widget.
 *
 * Elementor widget that displays an image, a headline and a text.
 *
 * @since 1.0.0
 */
class Widget_Streamer_Box extends Widget_Base
{
    /**
     * Get widget name.
     *
     * Retrieve image box widget name.
     *
     * @since 1.0.0
     * @access public
     *
     * @return string Widget name.
     */
    public function get_name()
    {
        return 'wharfkit-test';
    }

    /**
     * Get widget title.
     *
     * Retrieve image box widget title.
     *
     * @since 1.0.0
     * @access public
     *
     * @return string Widget title.
     */
    public function get_title()
    {
        return __('Cookiz Wharfkit test', 'elementor-test-extension');
    }

    /**
     * Get widget icon.
     *
     * Retrieve image box widget icon.
     *
     * @since 1.0.0
     * @access public
     *
     * @return string Widget icon.
     */
    public function get_icon()
    {
        return 'eicon-image-box';
    }

    /**
     * Get widget keywords.
     *
     * Retrieve the list of keywords the widget belongs to.
     *
     * @since 2.1.0
     * @access public
     *
     * @return array Widget keywords.
     */
    public function get_keywords()
    {
        return ['cookiz', 'streamer'];
    }

    public function get_categories() {
		return [ 'wptips-elementor' ];
	}

    /**
     * Render image box widget output on the frontend.
     *
     * Written in PHP and used to generate the final HTML.
     *
     * @since 1.0.0
     * @access protected
     */
    protected function render()
    {
    ?>
        <div class="cookiz-wharfkit-test">
            <h2>TEST IT WORKS</h2>
            <button onclick="wharfkit_login()">Login button</button>
        </div>
    <?php
    }

    /**
	 * Render image box widget output in the editor.
	 *
	 * Written as a Backbone JavaScript template and used to generate the live preview.
	 *
	 * @since 1.0.0
	 * @access protected
	 */
	protected function _content_template() {
		?>
		<#
		var html = '<div class="elementor-image-box-wrapper">';

		if ( settings.image.url ) {
			var image = {
				id: settings.image.id,
				url: settings.image.url,
				size: settings.thumbnail_size,
				dimension: settings.thumbnail_custom_dimension,
				model: view.getEditModel()
			};

			var image_url = elementor.imagesManager.getImageUrl( image );

			var imageHtml = '<img src="' + image_url + '" class="elementor-animation-' + settings.hover_animation + '" />';

			if ( settings.link.url ) {
				imageHtml = '<a href="' + settings.link.url + '">' + imageHtml + '</a>';
			}

			html += '<figure class="elementor-image-box-img">' + imageHtml + '</figure>';
		}

		var hasContent = !! ( settings.title_text || settings.description_text );

		if ( hasContent ) {
			html += '<div class="elementor-image-box-content">';

			if ( settings.title_text ) {
				var title_html = settings.title_text;

				if ( settings.link.url ) {
					title_html = '<a href="' + settings.link.url + '">' + title_html + '</a>';
				}

				view.addRenderAttribute( 'title_text', 'class', 'elementor-image-box-title' );

				view.addInlineEditingAttributes( 'title_text', 'none' );

				html += '<' + settings.title_size  + ' ' + view.getRenderAttributeString( 'title_text' ) + '>' + title_html + '</' + settings.title_size  + '>';
			}

			if ( settings.description_text ) {
				view.addRenderAttribute( 'description_text', 'class', 'elementor-image-box-description' );

				view.addInlineEditingAttributes( 'description_text' );

				html += '<p ' + view.getRenderAttributeString( 'description_text' ) + '>' + settings.description_text + '</p>';
			}

			html += '</div>';
		}

		html += '</div>';

		print( html );
		#>
		<?php
	}
}
