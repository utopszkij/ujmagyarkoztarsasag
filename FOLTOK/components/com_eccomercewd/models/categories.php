<?php
 /**
 * @package E-Commerce WD
 * @author Web-Dorado
 * @copyright (C) 2014 Web-Dorado. All rights reserved.
 * @license GNU/GPLv3 http://www.gnu.org/licenses/gpl-3.0.html
 **/


defined('_JEXEC') || die('Access Denied');


class EcommercewdModelCategories extends EcommercewdModel {
    ////////////////////////////////////////////////////////////////////////////////////////
    // Events                                                                             //
    ////////////////////////////////////////////////////////////////////////////////////////
    ////////////////////////////////////////////////////////////////////////////////////////
    // Constants                                                                          //
    ////////////////////////////////////////////////////////////////////////////////////////
    ////////////////////////////////////////////////////////////////////////////////////////
    // Variables                                                                          //
    ////////////////////////////////////////////////////////////////////////////////////////
    ////////////////////////////////////////////////////////////////////////////////////////
    // Constructor & Destructor                                                           //
    ////////////////////////////////////////////////////////////////////////////////////////
    ////////////////////////////////////////////////////////////////////////////////////////
    // Public Methods                                                                     //
    ////////////////////////////////////////////////////////////////////////////////////////
    public function get_row() {
        $db = JFactory::getDbo();
        if(WDFInput::get('type'))
            {
                $id = WDFInput::get('id');
            }
        else
        $id = WDFInput::get('category_id', WDFParams::get('category_id', 0, 'int'));
        $row = WDFDb::get_row('categories', array($db->quoteName('id') . ' = ' . $id, $db->quoteName('published') . ' = 1'));
        if ($row->id == 0) {
            $row->id = 0;
            $row->name = JText::_('root');
        }

        // additional data
        // path categories
        $row->path_categories = $this->get_category_path_categories($row->id);

        // info
        if(WDFInput::get('type'))
        {
            $row->show_info = WDFInput::get('show_info');
        }
        else
        $row->show_info = WDFParams::get('show_info', 1);

        // image
        if ($row->images != null) {
            $images = WDFJson::decode($row->images);
            $row->image = empty($images) == false ? $images[0] : '';
        } else {
            $row->image = '';
        }

        // subcategories
        if(WDFInput::get('type'))
        {
            $row->show_subcategories = WDFInput::get('show_subcategories');
        }
        else
        $row->show_subcategories = WDFParams::get('show_subcategories', 1);
        if(WDFInput::get('type'))
        {
            $row->subcategories_cols = WDFInput::get('number_columns');
        }
        else
        $row->subcategories_cols = WDFParams::get('subcategories_cols', 1);
        $subcategories = $this->get_category_subcategories($row->id);
        if ($subcategories === false) {
            WDFHelper::redirect('systempages', 'displayerror', '', 'code=2');
        }
        $row->subcategories = $subcategories;
        if (empty($row->subcategories) == true) {
            $row->show_subcategories = 0;
        }
		
        // category tree
        if(WDFInput::get('type'))
        {
            $row->show_tree = WDFInput::get('show_path');
        }
        else
        $row->show_tree = WDFParams::get('show_tree', 1);
		
        // products and count
        if(WDFInput::get('type'))
        {
            $row->show_products = WDFInput::get('show_products');
        }
        else
			$row->show_products = WDFParams::get('show_products', 1);
        if(WDFInput::get('type'))
        {
            $row->products_count = WDFInput::get('products_count');
        }
        else
			$row->products_count = WDFParams::get('products_count');
        $row->products = array();
        if ($row->show_products == 1) {
            $products = $this->get_category_products($row->id, $row->products_count);
            if ($products === false) {
                WDFHelper::redirect('systempages', 'displayerror', '', 'code=2');
            }
            $row->products = $products;
        }
        if (empty($row->products) == true) {
            $row->show_products = 0;
        }

        // url view products
        $row->url_view_products = JRoute::_('index.php?option=com_'.WDFHelper::get_com_name().'&controller=products&task=displayproducts&search_category_id=' . $row->id);

        return $row;
    }

    public function get_required_parameters($id) {
        $db = JFactory::getDbo();
        $query = $db->getQuery(true);

        $query->clear();
        $query->select('T_PARAMETERS.id');
        $query->select('T_PARAMETERS.name');
        $query->from('#__ecommercewd_parameters AS T_PARAMETERS');
        $query->leftJoin('#__ecommercewd_categoryparameters AS T_CATEGORY_PARAMETERS ON T_CATEGORY_PARAMETERS.parameter_id = T_PARAMETERS.id AND T_PARAMETERS.type_id != 1');
        $query->where('T_CATEGORY_PARAMETERS.category_id = ' . $id);
        $query->order('T_CATEGORY_PARAMETERS.categoryparameters_id ASC');
        $db->setQuery($query);
        $required_parameters = $db->loadObjectList('id');

        if ($db->getErrorNum()) {
            return false;
        }

        return $required_parameters;
    }


    ////////////////////////////////////////////////////////////////////////////////////////
    // Getters & Setters                                                                  //
    ////////////////////////////////////////////////////////////////////////////////////////
    ////////////////////////////////////////////////////////////////////////////////////////
    // Private Methods                                                                    //
    ////////////////////////////////////////////////////////////////////////////////////////
    private function get_category_path_categories($category_id) {
        $path_categories = array();

        while ($category_id != 0) {
            $category_row = WDFDb::get_row_by_id('categories', $category_id);

            // additional data
            // is actiive
            $category_row->is_active = $category_row->published == 1 ? true : false;

            // url
            $category_row->url = JRoute::_('index.php?option=com_'.WDFHelper::get_com_name().'&controller=categories&task=displaycategory&category_id=' . $category_row->id);

            array_unshift($path_categories, $category_row);

            $category_id = $category_row->parent_id;
        }

        $category_row = WDFDb::get_table_instance('categories');
        $category_row->id = 0;
        $category_row->is_active = true;
        $category_row->url = JRoute::_('index.php?option=com_'.WDFHelper::get_com_name().'&controller=categories&task=displaycategory&category_id=0');
        $category_row->name = WDFText::get('ROOT_CATEGORY');
        $category_row->image = '';
        array_unshift($path_categories, $category_row);

        return $path_categories;
    }

    private function get_category_subcategories($category_id) {
        $db = JFactory::getDbo();
        $query = $db->getQuery(true);

        $query->clear();
        $query->select('id');
        $query->select('name');
        $query->select('images');
        $query->from('#__ecommercewd_categories');
        $query->where('parent_id = ' . $category_id);
        $query->where('published = 1');
        $query->order($db->quoteName('ordering') . ' ASC');
        $db->setQuery($query);
        $rows = $db->loadObjectList();

        if ($db->getErrorNum()) {
            return false;
        }

        // additional data
        foreach ($rows as $row) {
            // url
            $row->url = JRoute::_('index.php?option=com_'.WDFHelper::get_com_name().'&controller=categories&task=displaycategory&category_id=' . $row->id);
        }

        return $rows;
    }

    private function get_category_products($category_id, $count) {
        $db = JFactory::getDbo();
        $query = $db->getQuery(true);

        $query->select('id');
        $query->select('name');
        $query->select('images');
        $query->from('#__ecommercewd_products');
        $query->where('category_id = ' . $category_id);
        $query->where('published = 1');
        $query->order('ordering ASC');
		if($count){
			$db->setQuery($query, 0, $count);
		}
		else{
			$db->setQuery($query);
		}
        $rows = $db->loadObjectList();

        if ($db->getErrorNum()) {
            return false;
        }

        // additional data
        foreach ($rows as $row) {
            // url
            $row->url = JRoute::_('index.php?option=com_'.WDFHelper::get_com_name().'&controller=products&task=displayproduct&product_id=' . $row->id);

            // image
            $row->images = WDFJson::decode($row->images);
            $row->image = empty($row->images) == false ? $row->images[0] : '';
        }

        return $rows;
    }


    ////////////////////////////////////////////////////////////////////////////////////////
    // Listeners                                                                          //
    ////////////////////////////////////////////////////////////////////////////////////////
}