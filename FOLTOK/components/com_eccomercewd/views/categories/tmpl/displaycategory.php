<?php
 /**
 * @package E-Commerce WD
 * @author Web-Dorado
 * @copyright (C) 2014 Web-Dorado. All rights reserved.
 * @license GNU/GPLv3 http://www.gnu.org/licenses/gpl-3.0.html
 *
 * 2015.10.11  szellemi termelés változat.  
 *   A products tábla model adata a felvivő username adatát tartalmazza
 *   Ez a user a frontend -en modosithat a product adatokon és kezelheti 
 *   a hotzá tartozó megrendeléseket. Bejelentkezett userek a frontend -en 
 *   vihetnek fel termékeket 
 **/

defined('_JEXEC') || die('Access Denied');

WDFHelper::add_script('js/framework/items_slider.js');

WDFHelper::add_css('css/' . WDFInput::get_controller() . '/' . $this->_layout . '.css');
WDFHelper::add_script('js/' . WDFInput::get_controller() . '/' . $this->_layout . '.js');


$options = $this->options;
$row = $this->row;

$path_categories = $row->path_categories;
$subcategories = $row->subcategories;
$products = $row->products;


WDFDocument::set_title($row->name);
WDFDocument::set_meta_data('title', $row->meta_title);
WDFDocument::set_meta_data('keywords', $row->meta_keyword);
WDFDocument::set_description($row->meta_description);

?>

<div class="container">
<!-- header -->
<h1 class="wd_shop_category_name wd_shop_header">
    <?php echo $row->name; ?>
</h1>

<!-- button of cassa -->
<div class="wd_shop_btn_Cassa">
  <br />
  <a class="wd_shop_product_btn_add_to_cart btn btn-primary" 
	 href="http://robitc/li-de/index.php?option=com_ecommercewd&view=shoppingcart&layout=displayshoppingcart&Itemid='.JRequest::getVar('Itemid').'">
	 <?php echo JText::_('COM_ECOMMERCEWD_CASSA'); ?>
  </a>
</div>


<?php if ( $row->show_tree == 1 ):?>
	<!-- path -->
	<ul class="breadcrumb">
		<?php
		foreach ($path_categories AS $path_category) {
			?>
			<li>
				<?php
				if ($path_category->is_active == true) {
					?>
					<a href="<?php echo $path_category->url; ?>" class="btn-link">
						<?php echo $path_category->name; ?>
					</a>
				<?php
				} else {
					echo $path_category->name;
				}
				?>
			</li>
		<?php
		}
		?>
	</ul>
<?php endif;?>
<!-- info -->
<?php
if ($row->show_info == 1 && $row->id != 0 ) {
    ?>
    <div class="row ">
        <div class="col-sm-5">
            <div class="wd_shop_category_image_container wd_center_wrapper img-thumbnail">
                <div>
                    <?php
                    if ($row->image != '') {
                        ?>
                        <img class="wd_shop_category_image"
                             src="<?php echo $row->image; ?>"
                             alt="<?php echo $row->name; ?>">
                    <?php
                    } else {
                        ?>
                        <div class="wd_shop_category_no_image">
                            <span class="glyphicon glyphicon-picture"></span>
                            <br>
                            <span><?php echo WDFText::get('NO_IMAGE'); ?></span>
                        </div>
                    <?php } ?>
                </div>
            </div>
        </div>

        <div class="col-sm-7">
            <p class="text-justify">
                <?php echo $row->description; ?>
            </p>
        </div>
    </div>
<?php
}
?>

<!-- divider -->
<?php
if (($row->show_info == 1) && (($row->show_products == 1) || ($row->show_subcategories == 1 || $row->id == 0 ))) {
    ?>
    <div class="wd_divider"></div>
<?php
}
?>

<?php 
//+ 2015.10.11 FT szellemi termelés változat
$user = JFactory::getUser();
if ((JRequest::getVar('category_id') > 0) & ($user->id > 0)) { ?>
<div id="addProductLink">
<a class="btn btn-primary" href="index.php?option=com_ecommercewd&controller=products&task=add&category_id=<?php echo JRequest::getVar('category_id'); ?>">
   <?php echo JText::_('COM_ECOMMERCEWD_ADD_PRODUCT'); ?>
</a>
</div>
<?php
//- 2015.10.11 FT szellemi termelés változat
}
?>

<!-- products -->
<?php
if ($row->show_products == 1) {
    ?>
    <div class="row">
        <div class="col-sm-12">
            <h4 class="wd_shop_header_sm">
                <?php echo WDFText::get('PRODUCTS'); ?>
            </h4>

            <div class="wd_shop_products_slider">
                <a class="wd_items_slider_btn_prev btn btn-link pull-left">
                    <span class="glyphicon glyphicon-chevron-left"></span>
                </a>

                <a class="wd_items_slider_btn_next btn btn-link pull-right">
                    <span class="glyphicon glyphicon-chevron-right"></span>
                </a>

                <div class="wd_items_slider_mask">
                    <ul class="wd_items_slider_items_list">
                        <?php
                        for ($i = 0; $i < count($products); $i++) {
                            $product = $products[$i];
                            if ($product->image != '') {
                                $el_category_product_image = '<img src="' . $product->image . '">';
                            } else {
                                $el_category_product_image = '
                                    <div class="wd_shop_product_no_image">
                                        <span class="glyphicon glyphicon-picture"></span>
                                        <br>
                                        <span>' . WDFText::get('NO_IMAGE') . '</span>
                                    </div>
                                    ';
                            }
                            ?>
                            <li>
                                <a class="wd_shop_product_container btn btn-link"
                                   href="<?php echo $product->url; ?>"
                                   title="<?php echo $product->name; ?>">
                                    <!-- image -->
                                    <div class="wd_shop_product_image_container wd_center_wrapper">
                                        <div>
                                            <?php echo $el_category_product_image; ?>
                                        </div>
                                    </div>

                                    <!-- name -->
                                    <div class="wd_shop_product_link_name text-center">
                                        <?php echo $product->name; ?>
                                    </div>
                                </a>
                            </li>
                        <?php
                        }
                        ?>
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <!-- button show all products -->
    <?php
    if ($options->search_by_category == 1) {
        ?>
        <div class="row">
            <div class="col-sm-12 text-center">
                <a class="btn btn-primary"
                   href="<?php echo $row->url_view_products; ?>">
                    <?php echo WDFText::get('BTN_VIEW_ALL_PRODUCTS'); ?>
                </a>
            </div>
        </div>
    <?php
    }
    ?>
<?php
}
?>

<!-- divider -->
<?php
if (($row->show_products == 1) && ($row->show_subcategories == 1 || $row->id == 0)) {
    ?>
    <div class="wd_divider"></div>
<?php
}
?>

<!-- subcategories -->
<?php
if ($row->show_subcategories || $row->id == 0) {
    switch ($row->subcategories_cols) {
        case 1:
            $category_subcategory_col_class = 'col-md-3 col-sm-4 col-xs-12';
            break;
        case 2:
            $category_subcategory_col_class = 'col-md-4 col-sm-6 col-xs-12';
            break;
        case 3:
            $category_subcategory_col_class = 'col-md-6 col-sm-12 col-xs-12';
            break;
    }
    ?>
    <h4 class="wd_shop_header_sm">
        <?php echo WDFText::get('SUBCATEGORIES'); ?>
    </h4>

    <div class="row">
        <?php
        foreach ($subcategories as $subcategory) {
            ?>
            <div class="<?php echo $category_subcategory_col_class; ?>">
                <!-- subcategory panel -->
                <div class="wd_shop_panel_product wd_shop_subcategory_container panel panel-default">
                    <div class="panel-body">
                        <a class="btn btn-link"
                           href="<?php echo $subcategory->url; ?>"
                           title="<?php echo $subcategory->name; ?>">
                            <!-- image -->
                            <div class="wd_shop_subcategory_image_container wd_center_wrapper">
                                <?php
                                $images = WDFJson::decode($subcategory->images);
                                if (empty($images) == false) {
                                    ?>
                                    <div>
                                        <img src="<?php echo $images[0]; ?>"
                                             class="wd_align_center_block img-responsive"
                                             alt="<?php echo $subcategory->name; ?>">
                                    </div>
                                <?php
                                } else {
                                    ?>
                                    <div class="wd_shop_subcategory_no_image ">
                                        <span class="glyphicon glyphicon-picture"></span>
                                        <br>
                                        <span><?php echo WDFText::get('NO_IMAGE'); ?></span>
                                    </div>
                                <?php } ?>
                            </div>

                            <!-- name -->
                            <div class="wd_shop_subcategory_name">
                                <?php echo $subcategory->name; ?>
                            </div>
                        </a>
                    </div>
                </div>
            </div>
        <?php
        }
        ?>
    </div>
<?php
}
?>
</div>