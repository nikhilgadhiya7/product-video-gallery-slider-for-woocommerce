<?php
add_action('wp_footer','wp_footer_callback_nickx_loop');
function wp_footer_callback_nickx_loop()
{ ?>
	<style type="text/css">.tc_video_loop embed, iframe, object, video { min-height: 250px; }</style>
	<script type="text/javascript">
		function get_YT_video_Id(url) 
		{
		    var regExp = /^.*(youtu.be\/|v\/|u\/\w\/|embed\/|watch\?v=|\&v=)([^#\&\?]*).*/;
		    var match = url.match(regExp);
		    if (match && match[2].length == 11) {
		        return match[2];
		    } else {
		        return 'error';
		    }
		}
		jQuery(document).ready(function(e){
			jQuery('.tc_video_loop .product_youtube_iframe').each(function(e){
				var iframe_src = get_YT_video_Id(jQuery(this).attr('data_src'));
				jQuery(this).attr('src','https://www.youtube.com/embed/'+iframe_src+'?rel=0&showinfo=0');
			});
		})
        jQuery('.tc_video_loop video.product_video_iframe').mouseenter(function(e)
        {
            jQuery(this).get(0).play();
        }).mouseleave(function () {
            jQuery(this).get(0).pause();
        });
        jQuery('.tc_video_loop iframe.product_youtube_iframe[video-type="youtube"]').mouseenter(function(e)
        {
          nowPlaying = jQuery(this).attr('src');
          jQuery(this).attr('src',nowPlaying+'&autoplay=1');
        }).mouseleave(function (){
          jQuery(this).attr('src',nowPlaying);
        });
	</script><?php
}
function woocommerce_template_loop_product_video(){
	global $product;
	$product_video_url = get_post_meta($product->get_ID(),'_nickx_video_text_url',true);
	if($product_video_url!=''){
		woocommerce_template_loop_product_link_close();
		echo '<div class="tc_video_loop" style="min-height:250px;">';
		if (strpos($product_video_url, 'youtube') > 0 || strpos($product_video_url, 'youtu') > 0) {
   			echo '<iframe data-skip-lazy="" width="100%" height="100%" class="product_youtube_iframe" video-type="youtube" data_src="'.$product_video_url.'" frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>';
	    }
		echo '</div>';
	    woocommerce_template_loop_product_link_open();
	}
	else{
		wc_get_template( 'loop/thumbnail/featured-image.php' );
	}
}
add_filter( 'wc_get_template', 'nickx_get_template_loop_img', 99, 5 );
function nickx_get_template_loop_img( $located, $template_name, $args, $template_path, $default_path )
{
    if ( 'loop/thumbnail/featured-image.php' == $template_name){
        return woocommerce_template_loop_product_video();
    }
    return $located;
}
