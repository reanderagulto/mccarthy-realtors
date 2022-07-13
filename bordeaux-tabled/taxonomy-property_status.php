<?php get_header(); ?>
<?php
	$listing_settings = get_option( 'listing_settings', '' );
	if( !empty( $listing_settings ) ){
		extract( $listing_settings );
	}
	$queried_object = get_queried_object();

	if( isset( $listing_tax_url ) ){
		$default_view = $listing_tax_url['tax_url_'.$queried_object->term_taxonomy_id];
	}else if( !isset( $listing_tax_url ) && strpos( strtolower( single_cat_title( '', false ) ), 'sold' ) !== false ){
		$default_view = 'Table';
	}else{
		$default_view = 'List';
	} 

	$show_sold = false;
	
	if( ( !isset( $listing_settings ) && strpos( strtolower( single_cat_title( '', false ) ), 'sold' ) !== false ) || isset( $listing_show_sold['sold_'.$queried_object->term_taxonomy_id] ) ){
		$show_sold = true;
	}

	$sold_status = false;

	if( strpos( strtolower( single_cat_title( '', false ) ), 'sold' ) !== false ){
		$sold_status = true;
	}

	if( isset( $_GET['view'] ) ){
		$default_view = $_GET['view'];
	}
					

?>
		<div id="content-sidebar">
			<div id="content" class="<?php echo $queried_object->taxonomy; ?>">
				<h1 class="page-title"><?php single_cat_title(); ?></h1>

				<div class="top-sort">
					
					<div class="sort-left">
						<a href="#" class="list-bttn active" data-view="List"><em class="ai-layout-list"></em>
						</a>
						<a href="#" class="grid-bttn " data-view="Grid"><em class="ai-layout-grid"></em>
						</a>
						<a href="#" class="tabled-bttn" data-view="Table"><em class="ai-layout-table"></em>
						</a>
					</div>

					<div class="sort-right">
						<span>Sort by:</span>
						<select class="sort-sel aios-listings-sorter">
							<option value="">&nbsp;&nbsp;&nbsp;&nbsp;-&nbsp;-&nbsp;-&nbsp;-&nbsp;-&nbsp;-&nbsp;-&nbsp;-&nbsp;-&nbsp;-</option>
							<option <?php echo ( $_GET['sort'] == 'price' && $_GET['order'] == 'desc' )?'selected':''; ?> value="?sort=price&order=desc">Price Descending</option>
							<option <?php echo ( $_GET['sort'] == 'price' && $_GET['order'] == 'asc' )?'selected':''; ?> value="?sort=price&order=asc">Price Ascending</option>
							<option <?php echo ( $_GET['sort'] == 'featured' && $_GET['order'] == 'asc' )?'selected':''; ?> value="?sort=featured&order=asc">Featured Top</option>
							<option <?php echo ( $_GET['sort'] == 'featured' && $_GET['order'] == 'desc' )?'selected':''; ?> value="?sort=featured&order=desc">Featured Bottom</option>
							<option <?php echo ( $_GET['sort'] == 'date' && $_GET['order'] == 'desc' )?'selected':''; ?> value="?sort=date&order=desc">Most Recent</option>
							<option <?php echo ( $_GET['sort'] == 'type' && $_GET['order'] == 'asc' )?'selected':''; ?> value="?sort=type&order=asc">Property Type Ascending</option>
							<option <?php echo ( $_GET['sort'] == 'type' && $_GET['order'] == 'desc' )?'selected':''; ?> value="?sort=type&order=desc">Property Type Descending</option>
							<option <?php echo ( $_GET['sort'] == 'status' && $_GET['order'] == 'asc' )?'selected':''; ?> value="?sort=status&order=asc">Property Status Ascending</option>
							<option <?php echo ( $_GET['sort'] == 'status' && $_GET['order'] == 'desc' )?'selected':''; ?> value="?sort=status&order=desc">Property Status Descending</option>
							<option <?php echo ( $_GET['sort'] == 'title' && $_GET['order'] == 'asc' )?'selected':''; ?> value="?sort=title&order=asc">A-Z</option>
							<option <?php echo ( $_GET['sort'] == 'title' && $_GET['order'] == 'desc' )?'selected':''; ?> value="?sort=title&order=desc">Z-A</option>
						</select>
					</div>

				</div>
				<ul class="grid">
					<?php
						
						$current = get_query_var( 'paged' ) ? intval( get_query_var( 'paged' ) ) : 1;
						$current_term = get_term_by( 'name',single_cat_title( '', false ), 'property_status' );
						$args = array( 
									'post_type'					=> 'listing',
									'posts_per_archive_page'	=> ( isset( $listings_per_page ) )?$listings_per_page:10,
									'paged'						=> $current,
									'is_paged'					=> true,
									'tax_query' 				=> array(
																      array(
																        'taxonomy' => 'property_status',
															            'field' => 'term_id',
															            'terms' => $current_term->term_id,
																      )
																  	)
								);	

						$args = array_merge( $args, ListingSearchSort::query_params( $_GET ) );
						$price_currency = ListingConstant::currency();
						$listing_query = new WP_Query( $args );
						if ( $listing_query->have_posts() ) {
							while ( $listing_query->have_posts() ) {
									$listing_query->the_post();
									$listing_info = get_post_meta( get_the_ID( ), 'listing_info', true );

									if( !empty( $listing_info ) ){
										extract( $listing_info );
									}
					?>
					<li>
						<div class="prop-img-wrap">
								<a class="<?php echo ( $sold_property == 'yes' || $sold_status )?'pop-sold':''; ?> listing-item" data-listing-id="<?php echo get_the_ID( ); ?>" href="<?php echo ( $sold_property == 'yes' || $sold_status )?'#pop-light':get_the_permalink( ); ?>">
									<?php 
										if( has_post_thumbnail( ) ){
											the_post_thumbnail( 'listing-grid-thumbnail', array( 'class' => 'main-img' ) ); 
										}else{	
											echo '<img src="'.LISTING_THEME_URL.'/images/no-property-photo.jpg" class="main-img wp-post-image" alt="No Property Photo Available">';
										}	
									?>
									<?php if( $sold_property == 'yes' || $sold_status ){ ?>
										<img src="<?php echo LISTING_THEME_URL; ?>/images/prop-sold-icon.png" alt="Sold" class="sold-icon">
									<?php } ?>	
								</a>
						</div>
						<div class="prop-det">
							<span class="prop-title"><?php echo $full_address; ?></span>
							<p>
								<?php 
									$the_content = get_the_content();
									echo substr( strip_shortcodes( preg_replace("/<img[^>]+\>/i", " ", $the_content ) ), 0, 69 ) . ' ' . (( strlen( $the_content ) > 69 )?'...':'');
								?>
							</p>

							<div class="prop-price">
								<?php 
									if( $sold_property == 'yes' && $display_sold_price == 'yes' ){
										echo ( !empty( $sold_price ) )?$price_currency[$currency].number_format( $sold_price ):''; 
									}else if( $display_list_price == 'yes' ){
								 		echo ( !empty( $list_price ) )?$price_currency[$currency].number_format( $list_price ):''; 
									}
								?>

								<div class="det-smi">
									<?php 
										$show_addtoany = get_post_meta( get_the_ID( ), 'sharing_disabled', true );
										if( $show_addtoany != 1 ){
											echo do_shortcode( '[addtoany url="'.get_the_permalink( ).'" title="'.$full_address.'"]' );
										}
									?>
								</div>
							</div>
							<em class="ai-bed"></em> <?php echo $bedrooms; ?> 
							<span class="det-baths"><em class="ai-showers"></em> <?php echo $bathrooms; ?></span> 
							<?php if( !empty( $lot_size ) ): ?>
								<span class="det-sqft"><?php echo number_format( $lot_size ).' '.$lot_size_unit; ?></span>
							<?php endif; ?>
						</div>							
					</li>
					<?php	
							} //
						} else {
							echo 'No Listing Found.';
						}
						/* Restore original Post Data */
						
					?>

				</ul><!-- end of grid -->
				<div class="list-wrapper">
					<ul class="table-hdr">
						<li class="one">&nbsp;</li>
						<li class="two <?php echo ( !$show_sold )?'sold-hidden':''; ?>">Address</li>
						<li class="three">Price</li>
						<li class="four">Beds</li>
						<li class="five">Baths</li>
						<li class="six">Area</li>
						<?php 
							if( $show_sold ):
						?>
						<li class="seven">Date Sold</li>
						<?php
							endif;
						?>
					</ul>
					<ul class="table-list">
						<?php
							if ( $listing_query->have_posts() ) {
								while ( $listing_query->have_posts() ) {
									$listing_query->the_post();
									$listing_info = get_post_meta( get_the_ID( ), 'listing_info', true );

									if( !empty( $listing_info ) ){
										extract( $listing_info );
									}
						?>
							<li>
								<div class="prop-img">
									<a class="<?php echo ( $sold_property == 'yes' || $sold_status )?'pop-sold':''; ?> listing-item" data-listing-id="<?php echo get_the_ID( ); ?>" 
									href="<?php echo ( $sold_property == 'yes' || $sold_status )?'#pop-light':get_the_permalink( ); ?>" >
									<?php 
										if( has_post_thumbnail( ) ){
											the_post_thumbnail( 'listing-grid-thumbnail', array( 'class' => 'main-img' ) ); 
										}else{	
											echo '<img src="'.LISTING_THEME_URL.'/images/no-property-photo.jpg" class="main-img wp-post-image" alt="No Property Photo Available">';
										}	
									?>
									<?php if( $sold_property == 'yes' || $sold_status ){ ?>
										<img src="<?php echo LISTING_THEME_URL; ?>/images/prop-sold-icon.png" alt="Sold" class="sold-icon">
									<?php } ?>
									</a>
								</div>
								<div class="prop-add <?php echo ( !$show_sold )?'sold-hidden':''; ?>"><label>Address: </label><span><?php echo $full_address; ?></span></div>
								<div class="list-price">
									<?php 
										if( $sold_property == 'yes' && $display_sold_price == 'yes' ){
											echo ( !empty( $sold_price ) )?'<label>List Price: </label><p class="list-price list-price-sec"><span>'.$price_currency[$currency].number_format( $sold_price ).'</span></p>':''; 
										}else if( $display_list_price == 'yes' ){
									 		echo ( !empty( $list_price ) )?'<label>List Price: </label><p class="list-price list-price-sec"><span>'.$price_currency[$currency].number_format( $list_price ).'</span></p>':''; 
										}
									?>
								</div>
								<div class="beds"><label>Beds: </label> <span><?php echo $bedrooms; ?></span></div>
								<div class="baths"><label>Baths: </label><span> <?php echo $bathrooms; ?></span></div>
								<div class="area"><label>Lot Size: </label>
									<?php if( !empty( $lot_size ) ): ?>
										<span class="det-sqft"><?php echo number_format( $lot_size ).' '.$lot_size_unit; ?></span>
									<?php endif; ?>										
								</div>
								<?php 
									if( $show_sold ):
								?>
									<div class="sold-date"><label>Sold Date: </label> <span><?php echo ( $sold_date )?date( 'M d, Y', $sold_date ):'N/A'; ?></span>
									</div>
								<?php 
									endif; 
								?>	
							</li>
							<?php	
								} //
							} else {
								echo 'No Listing Found.';
							}
							/* Restore original Post Data */
							
						?>
					</ul>

				</div><!-- end of table -->
				<ul class="list">
					<?php
						if ( $listing_query->have_posts() ) {
							while ( $listing_query->have_posts() ) {
									$listing_query->the_post();
									$listing_info = get_post_meta( get_the_ID( ), 'listing_info', true );

									if( !empty( $listing_info ) ){
										extract( $listing_info );
									}
					?>
					<li>
						<div class="prop-img-wrap">
							<?php 
										if( has_post_thumbnail( ) ){
											the_post_thumbnail( 'listing-grid-thumbnail', array( 'class' => 'main-img' ) ); 
										}else{	
											echo '<img src="'.LISTING_THEME_URL.'/images/no-property-photo.jpg" class="main-img wp-post-image" alt="No Property Photo Available">';
										}	
									?>
							<?php if( $sold_property == 'yes' || $sold_status ){ ?>
								<img src="<?php echo LISTING_THEME_URL; ?>/images/prop-sold-icon.png" alt="Sold" class="sold-icon">
							<?php } ?>
						</div>
						<div class="prop-det">
							<span class="prop-title"><?php echo $full_address; ?></span>
							<?php 
								if( $sold_property == 'yes' && $display_sold_price == 'yes' ){
									echo ( !empty( $sold_price ) )?'<p class="list-price"><span>'.$price_currency[$currency].number_format( $sold_price ).'</span></p>':''; 
								}else if( $display_list_price == 'yes' ){
							 		echo '<p class="list-price"><span>'.( !empty( $list_price ) )?$price_currency[$currency].number_format( $list_price ).'</span></p>':''; 
								}
							?>
							<div class="prop-beds">
								<em class="ai-bed"></em> <?php echo $bedrooms; ?> <span class="det-baths"><em class="ai-showers"></em> <?php echo $bathrooms; ?></span> 
								<?php if( !empty( $lot_size ) ): ?>
									<span class="det-sqft"><?php echo number_format( $lot_size ).' '.$lot_size_unit; ?></span>
								<?php endif; ?>	
								<div class="det-smi">
									<?php 
										$show_addtoany = get_post_meta( get_the_ID( ), 'sharing_disabled', true );
										if( $show_addtoany != 1 ){
											echo do_shortcode( '[addtoany url="'.get_the_permalink( ).'" title="'.$full_address.'"]' );
										}
									?>
								</div>
							</div>
							<p class="prop-desc">
								<?php 
									$the_content = get_the_content();
									echo substr( strip_shortcodes( preg_replace("/<img[^>]+\>/i", " ", $the_content ) ), 0, 294 ) . ' ' . (( strlen( $the_content ) > 294 )?'[...]':'');
									
								?>
							</p>	
								<a class="view-details <?php echo ( $sold_property == 'yes' || $sold_status )?'pop-sold':''; ?> listing-item" data-listing-id="<?php echo get_the_ID( ); ?>" href="<?php echo ( $sold_property == 'yes' || $sold_status )?'#pop-light':get_the_permalink( ); ?>" >Details</a>
						</div>								
					</li>
					<?php	
							} //
						} else {
							echo 'No Listing Found.';
						}
						/* Restore original Post Data */
						
					?>
					
					
				</ul>


				<div class="page-nation">	
					<?php
						$big = 999999999; // need an unlikely integer
						echo paginate_links( array(
								'base' 			=> str_replace( $big, '%#%', esc_url( get_pagenum_link( $big ) ) ),
								'format' 		=> '?paged=%#%',
								'current' 		=> max( 1, get_query_var('paged') ),
								'prev_text'		=> ( isset( $prev_link_text ) && !empty( $prev_link_text ) )? $prev_link_text : '<span class="p-prev"></span>',
								'next_text'		=> ( isset( $next_link_text ) && !empty( $next_link_text ) )? $next_link_text : '<span class="p-next"></span>',
								'total' 		=> $listing_query->max_num_pages,
							) );
					?>
				</div>

				<div class="clear"></div>
			</div>	

		</div>
<div id="pop-light" class="property-pop">	
	<div class="pop-bg"></div>	
	<div class="popup-wrap">
		<div class="close-pop"></div>
		<div class="popup-holder">	


		</div>

	</div>
</div>
<script type="text/javascript">
	jQuery(document).ready( function($){
		aios_listing_sorting( );
		aios_listing_change_view( );
		aios_listing_scroll_by_height();
		aios_listing_fetch_sold();
		aios_listing_tab_order( '<?php echo $default_view; ?>' );
		jQuery(window).resize(function(){ aios_listing_scroll_by_height(); });
	
	});
</script>

<?php get_footer( ); ?>