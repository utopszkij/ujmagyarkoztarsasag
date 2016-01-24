<?php
 /**
 * @package E-Commerce WD
 * @author Web-Dorado
 * @copyright (C) 2014 Web-Dorado. All rights reserved.
 * @license GNU/GPLv3 http://www.gnu.org/licenses/gpl-3.0.html
 **/

defined('_JEXEC') || die('Access Denied');

WDFHelper::add_css('css/' . WDFInput::get_controller() . '/' . $this->_layout . '.css');
WDFHelper::add_script('js/' . WDFInput::get_controller() . '/' . $this->_layout . '.js');


$options = $this->options;

$final_checkout_data = $this->final_checkout_data;
$products_data = $final_checkout_data['products_data'];

$total_price_text = $final_checkout_data['total_price_text'];

$payment_buttons_data = $this->payment_buttons_data;
$pager_data = $this->pager_data;

WDFDocument::set_title(WDFText::get('CHECKOUT'));
?>

<form name="wd_shop_main_form" action="" method="POST">
</form>

<div class="container">
<div class="row">
<div class="col-sm-12">
<!-- panel -->
<div class="wd_shop_panel_user_data panel panel-default">
    <div class="panel-body">
        <h2 class="wd_shop_header">
            <?php echo WDFText::get('CONFIRM_ORDER'); ?>
        </h2>

        <?php
        foreach ($products_data as $product_data) {
            if ($product_data->image != '') {
                $el_order_product_image = '<img class="wd_shop_order_product_image" src="' . $product_data->image . '">';
            } else {
                $el_order_product_image = '
                    <div class="wd_shop_order_product_no_image">
                        <span class="glyphicon glyphicon-picture"></span>
                        <br>
                        <span>' . WDFText::get('NO_IMAGE') . '</span>
                    </div>
                    ';
            }
            ?>
            <div class="wd_shop_order_product_container col-sm-12">
                <div class="row">
                    <!-- name -->
                    <div class="col-sm-12">
                        <h4 class="wd_shop_order_product_name wd_shop_product_name wd_shop_header_sm">
                            <?php echo $product_data->name; ?>
                        </h4>
                    </div>

                    <div class="col-sm-9">
                        <div class="row">
                            <!-- image -->
                            <div class="col-sm-4">
                                <div class="row">
                                    <div
                                        class="wd_shop_order_product_image_container wd_center_wrapper col-sm-12">
                                        <div>
                                            <?php echo $el_order_product_image; ?>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- info -->
                            <div class="col-sm-8">
                                <!-- parameters -->
                                <?php
                                if ($product_data->parameters != '') {
                                    ?>
                                    <p>
                                        <strong><?php echo WDFText::get('PARAMETERS') . ': '; ?></strong>
                                        <?php echo $product_data->parameters; ?>
                                    </p>
                                <?php
                                }
                                ?>

                                <!-- shipping -->
                                <?php
                                if (($product_data->enable_shipping == 1 or ($product_data->enable_shipping == 2 && $options->checkout_enable_shipping == 1)) && ($product_data->shipping_method_name != '')) {
                                    ?>
                                    <p>
                                        <strong><?php echo WDFText::get('SHIPPING') . ': '; ?></strong>
                                        <?php echo $product_data->shipping_method_name; ?>
                                    </p>
                                <?php
                                }
                                ?>
                            </div>
                        </div>
                    </div>

                    <div class="col-sm-3 text-right">
                        <!-- price -->
                        <p class="wd_shop_order_product_price_container">
                            <span class="wd_shop_order_product_price wd_shop_product_price">
                                <?php echo $product_data->price_text; ?>
                            </span>
                        </p>

                        <!-- tax -->
                        <p class="wd_shop_order_product_tax_price_container">
                            <span>
                                <?php echo WDFText::get("TAX"); ?>:
                            </span>
                            <span>
                                <?php echo $product_data->tax_price_text; ?>
                            </span>
                        </p>

                        <!-- shipping -->
                        <p class="wd_shop_order_product_shipping_price_container">
                            <span>
                                <?php echo WDFText::get("SHIPPING"); ?>:
                            </span>
                            <span>
                                <?php echo $product_data->shipping_method_price_text; ?>
                            </span>
                        </p>

                        <!-- count -->
                        <p class="wd_shop_order_product_quantity_container">
                            <span>
                                <?php echo WDFText::get("QUANTITY"); ?>:
                            </span>
                            <span>
                                <?php echo $product_data->count; ?>
                            </span>
                        </p>

                        <!-- subtotal -->
                        <p>
                            <span class="wd_shop_order_product_subtotal_title wd_shop_product_price">
                                <?php echo WDFText::get('SUBTOTAL') . ': '; ?>
                            </span>
                            <span class="wd_shop_order_product_subtotal wd_shop_product_price">
                                <?php echo $product_data->subtotal_price_text; ?>
                            </span>
                        </p>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-sm-12">
                    <div class="wd_divider"></div>
                </div>
            </div>
        <?php
        }
        ?>

        <div class="row">
            <!-- total -->
            <div class="col-sm-12 text-right">
                <span class="wd_shop_total_title wd_shop_product_price">
                    <?php echo WDFText::get('TOTAL_PRICE'); ?>:
                </span>
                <span class="wd_shop_total wd_shop_product_price">
                    <?php echo $total_price_text; ?>
                </span>
            </div>
        </div>

        <div class="row">
            <div class="col-sm-12">
                <div class="wd_divider"></div>
            </div>
        </div>

        <div class="row">
            <div class="col-sm-12">
                <?php
                foreach ($payment_buttons_data as $payment_button_data) {
                    ?>
                    <p class="text-right">
                        <a href="<?php echo $payment_button_data->action; ?>"
                           class="btn btn-primary"
                           onclick="wdShop_onBtnCheckoutClick(event, this); return false;">
                            <?php echo JText::_($payment_button_data->text); ?>
                        </a>
                    </p>
                <?php
                }
                ?>
            </div>
        </div>
    </div>
</div>

<!-- pager -->
<div>
    <ul class="pager">
        <?php
        $btn_cancel_checkout_data = $pager_data['btn_cancel_checkout_data'];
        ?>
        <li class="previous">
            <a href="<?php echo $btn_cancel_checkout_data['url']; ?>">
                <span><?php echo WDFText::get('BTN_CANCEL_CHECKOUT'); ?></span>
            </a>
        </li>

        <?php
        if (isset($pager_data['btn_prev_page_data'])) {
            $btn_prev_page_data = $pager_data['btn_prev_page_data'];
            ?>
            <li class="previous">
                <a href="<?php echo $btn_prev_page_data['action']; ?>"
                   onclick="onWDShop_pagerBtnClick(event, this); return false;">
                    <span class="glyphicon glyphicon-arrow-left"></span>&nbsp;
                    <span><?php echo $btn_prev_page_data['text']; ?></span>
                </a>
            </li>
        <?php
        }
        ?>

        <?php
        if (isset($pager_data['btn_next_page_data'])) {
            $btn_next_page_data = $pager_data['btn_next_page_data'];
            ?>
            <li class="next">
                <a href="<?php echo $btn_next_page_data['action']; ?>"
                   onclick="onWDShop_pagerBtnClick(event, this); return false;">
                    <span><?php echo $btn_next_page_data['text']; ?></span>&nbsp;
                    <span class="glyphicon glyphicon-arrow-right"></span>
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