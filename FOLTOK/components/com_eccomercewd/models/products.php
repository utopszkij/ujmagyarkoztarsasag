<?php
 /**
 * @package E-Commerce WD
 * @author Web-Dorado
 * @copyright (C) 2014 Web-Dorado. All rights reserved.
 * @license GNU/GPLv3 http://www.gnu.org/licenses/gpl-3.0.html
 **/

defined('_JEXEC') || die('Access Denied');

JTable::addIncludePath(JPATH_ADMINISTRATOR.'/components/com_ecommercewd/tables');

class EcommercewdModelProducts extends EcommercewdModel {
    ////////////////////////////////////////////////////////////////////////////////////////
    // Events                                                                             //
    ////////////////////////////////////////////////////////////////////////////////////////
    ////////////////////////////////////////////////////////////////////////////////////////
    // Constants                                                                          //
    ////////////////////////////////////////////////////////////////////////////////////////
    const PRODUCTS_ARRANGEMENT_THUMBS = 'thumbs';
    const PRODUCTS_ARRANGEMENT_LIST = 'list';

    const MAX_LENGTH_NAME_THUMBS_VIEW = 35;
    const MAX_LENGTH_DESCRIPTION_THUMBS_VIEW = 100;
    const MAX_LENGTH_NAME_LIST_VIEW = 30;
    const MAX_LENGTH_DESCRIPTION_LIST_VIEW = 30;

    const MAX_REVIEWS_PRODUCT_VIEW = 5;

    const REVIEWS_COUNT_TO_LOAD = 5;
    const MAX_LENGTH_DESCRIPTION_WRITE_REVIEW = 240;


    ////////////////////////////////////////////////////////////////////////////////////////
    // Variables                                                                          //
    ////////////////////////////////////////////////////////////////////////////////////////
    private $search_data;
    private $filters_data;


    ////////////////////////////////////////////////////////////////////////////////////////
    // Constructor & Destructor                                                           //
    ////////////////////////////////////////////////////////////////////////////////////////
    ////////////////////////////////////////////////////////////////////////////////////////
    // Public Methods                                                                     //
    ////////////////////////////////////////////////////////////////////////////////////////
    /* product */
    public function get_product_view_product_row($id = 0) {
       
        if ($id == 0) {
            if(WDFInput::get('type'))
            {
                $id = WDFInput::get('id');
            }
            else
            $id = WDFInput::get('product_id', WDFParams::get('product_id', 0), 'int');
            
        }

        $product_rows = $this->get_product_rows($id, false);
        if (($product_rows === false) || (empty($product_rows) == true)) {
            WDFHelper::redirect('systempages', 'displayerror', '', 'code=2');
        }
        if (($this->add_product_parameters($product_rows) === false) || ($this->add_product_selectable_parameters($product_rows) === false) || ($this->add_product_tags($product_rows) === false) || ($this->add_product_reviews($product_rows) === false) || ($this->add_product_shipping_methods($product_rows) === false) || ($this->add_product_related_products($product_rows) === false)
        ) {
            WDFHelper::redirect('systempages', 'displayerror', '', 'code=2');
        }
        $product_row = empty($product_rows) == false ? $product_rows[0] : null;

		foreach($product_row->reviews as $review )
			$review->text = str_replace('111','&lt;',$review->text);
			
		
        return $product_row;
    }

    public function get_product_selectable_parameters($product_id) {
        $db = JFactory::getDbo();
        $query = $db->getQuery(true);
        $model_options = WDFHelper::get_model('options');
        $options = $model_options->get_options();
		$decimals = $options->option_show_decimals == 1 ? 2 : 0;
        // get ids and names
        $query->clear();
        $query->select('T_PARAMETERS.id');
        $query->select('T_PARAMETERS.name');
		$query->select('T_PARAMETERS.type_id AS type_id');
        $query->select('T_PARAMETER_TYPES.name AS type_name');
        $query->from('#__ecommercewd_parameters AS T_PARAMETERS');
        $query->leftJoin('#__ecommercewd_productparameters AS T_PRODUCT_PARAMETERS ON T_PRODUCT_PARAMETERS.parameter_id = T_PARAMETERS.id');
        $query->leftJoin('#__ecommercewd_parametertypes AS T_PARAMETER_TYPES ON T_PARAMETERS.type_id = T_PARAMETER_TYPES.id');
		$query->where('T_PRODUCT_PARAMETERS.product_id = ' . $product_id);
        $query->order('T_PRODUCT_PARAMETERS.productparameters_id ASC');
        $query->group('T_PRODUCT_PARAMETERS.parameter_id');
        $query->having('COUNT(T_PRODUCT_PARAMETERS.parameter_value) > 1 OR T_PARAMETERS.type_id = 1 OR T_PARAMETERS.type_id = 3 OR T_PARAMETERS.type_id = 5');
        $db->setQuery($query);
        $product_selectable_parameters_data = $db->loadObjectList();

        if ($db->getErrorNum()) {
            echo $db->getErrorMsg();
        }

        // get values
        foreach ($product_selectable_parameters_data as $product_selectable_parameter_data) {
            $query->clear();
            $query->select('T_PRODUCT_PARAMETERS.parameter_value AS value');
            $query->select('T_PRODUCT_PARAMETERS.parameter_value AS text');
            $query->select('T_PRODUCT_PARAMETERS.productparameters_id ');
			$query->select('T_PRODUCT_PARAMETERS.parameter_value_price AS parameter_price');
            $query->from('#__ecommercewd_productparameters AS T_PRODUCT_PARAMETERS');
            $query->leftJoin('#__ecommercewd_parameters AS T_PARAMETERS ON T_PRODUCT_PARAMETERS.parameter_id = T_PARAMETERS.id');
            $query->where('T_PRODUCT_PARAMETERS.product_id = ' . $product_id);
            $query->where('T_PRODUCT_PARAMETERS.parameter_id = ' . $product_selectable_parameter_data->id);
			$query->order('T_PRODUCT_PARAMETERS.productparameters_id ASC');
            $db->setQuery($query);
            $product_selectable_parameter_data_values_list = $db->loadAssocList();

            if ($db->getErrorNum()) {
                return false;
            }
			$values_list = array();
			foreach($product_selectable_parameter_data_values_list as $value){		
				$price_sign = substr($value['parameter_price'],0,1);	
				$value['parameter_price'] = $price_sign.number_format(substr($value['parameter_price'],1), $decimals);		
				$values_list[] = $value;
			}
			$product_selectable_parameter_data->values_list = $values_list;
        }
        return $product_selectable_parameters_data;
    }

    /* products */
    public function get_products_view_data() {
        jimport('joomla.html.pagination');

        $pagination = $this->get_pagination(null, true, true);
        if ($pagination === false) {
            WDFHelper::redirect('systempages', 'displayerror', '', 'code=2');
        }
        $product_rows = $this->get_product_rows(null, true, $pagination,true);
        if ($product_rows === false) {
            WDFHelper::redirect('systempages', 'displayerror', '', 'code=2');
        }

        // prepare data
    if(WDFInput::get('type'))
    {
        $arrangement_data = WDFInput::get('arrangement');
        $arrangement['arrangement'] = $arrangement_data;
        switch ($arrangement) {
            case self::PRODUCTS_ARRANGEMENT_THUMBS:
                $name_max_length = self::MAX_LENGTH_NAME_THUMBS_VIEW;
                $description_max_length = self::MAX_LENGTH_DESCRIPTION_THUMBS_VIEW;
                break;
            case self::PRODUCTS_ARRANGEMENT_LIST:
                $name_max_length = self::MAX_LENGTH_NAME_LIST_VIEW;
                $description_max_length = self::MAX_LENGTH_DESCRIPTION_LIST_VIEW;
                break;
            default:
                $name_max_length = self::MAX_LENGTH_NAME_THUMBS_VIEW;
                $description_max_length = self::MAX_LENGTH_DESCRIPTION_THUMBS_VIEW;
                break;
        }
    }
    else 
    {
        $arrangement_data = $this->get_arrangement_data();
        $arrangement['arrangement'] = $arrangement_data;
        switch ($arrangement) {
            case self::PRODUCTS_ARRANGEMENT_THUMBS:
                $name_max_length = self::MAX_LENGTH_NAME_THUMBS_VIEW;
                $description_max_length = self::MAX_LENGTH_DESCRIPTION_THUMBS_VIEW;
                break;
            case self::PRODUCTS_ARRANGEMENT_LIST:
                $name_max_length = self::MAX_LENGTH_NAME_LIST_VIEW;
                $description_max_length = self::MAX_LENGTH_DESCRIPTION_LIST_VIEW;
                break;
            default:
                $name_max_length = self::MAX_LENGTH_NAME_THUMBS_VIEW;
                $description_max_length = self::MAX_LENGTH_DESCRIPTION_THUMBS_VIEW;
                break;
        }
    }
        for ($i = 0; $i < count($product_rows); $i++) {
            $product_row = $product_rows[$i];

            // shorten name
            if (strlen($product_row->name) > $name_max_length) {
               // $product_row->name = substr($product_row->name, 0, $name_max_length - 3) . '...';
				$product_row->name = join("", array_slice( preg_split("//u", $product_row->name, -1, PREG_SPLIT_NO_EMPTY), 0, $name_max_length - 3)). '...';		
            }

            // shorten description
            if (strlen(strip_tags($product_row->description)) > $description_max_length) {      
                $product_row->description = WDFText::truncate_html($product_row->description,$description_max_length - 3);
            }

            //empty parameters
            $product_row->parameters = $this->get_selectable_params_empty_row($product_row->id);
        }

        // get products min and max price
        $products_min_and_max_price_data = $this->get_products_min_and_max_price_data();
        if ($products_min_and_max_price_data === false) {
            WDFHelper::redirect('systempages', 'displayerror', '', 'code=2');
        }

        $search_categories_list = $this->get_search_categories_list();
        if ($search_categories_list === false) {
            WDFHelper::redirect('systempages', 'displayerror', '', 'code=2');
        }

        $data = array();
        $data['search_categories_list'] = $search_categories_list;
        $data['search_data'] = $this->get_search_data();
        $data['filter_manufacturer_rows'] = $this->get_filter_manufacturer_rows();
        $data['filter_products_min_price'] = $products_min_and_max_price_data['min_price'];
        $data['filter_products_max_price'] = $products_min_and_max_price_data['max_price'];
        $data['filter_date_added_ranges'] = $this->get_filter_date_added_ranges();
        $data['filters_data'] = $this->get_filters_data();
        $data['arrangement_data'] = $this->get_arrangement_data();
        $data['sortables_list'] = $this->get_sortables_list();
        $data['sort_data'] = $this->get_sort_data();
        $data['pagination'] = $pagination;
        $data['product_rows'] = $product_rows;

        return $data;
    }

    public function get_quick_view_product_row($id = 0) {
        if ($id == 0) {
            $id = WDFInput::get('product_id', 0, 'int');
        }

        $product_rows = $this->get_product_rows($id);
        if (($product_rows === false) || (empty($product_rows) == true)
        ) {
            return false;
        }
        $this->add_product_selectable_parameters($product_rows);
        $product_row = $product_rows[0];
//        var_dump($product_row);
		$product_row->image = WDFHelper::get_image_original_url($product_row->image);
        return $product_row;
    }

    /* compare products */
    public function get_compare_products_view_product_row($id = 0) {
        if ($id == 0) {
            $id = WDFInput::get('product_id', 0, 'int');
        }

        $product_rows = $this->get_product_rows($id);
        if (($product_rows === false) || (empty($product_rows) == true) || ($this->add_product_parameters($product_rows) === false)
        ) {
            WDFHelper::redirect('systempages', 'displayerror', '', 'code=2');
        }
        $product_row = $product_rows[0];

        return $product_row;
    }

    public function get_compare_products_lists($product_row) {
        $lists = array();
        $lists['products'] = WDFDb::get_list('products', 'id', 'name', array('category_id = ' . $product_row->category_id, 'id != ' . $product_row->id), '', array(array('id' => '', 'name' => WDFText::get('SELECT_PRODUCT'))));;

        return $lists;
    }

    /* product reviews */
    public function get_product_reviews_data($product_id = 0, $start = 0, $limit = 0) {
        $failed = false;

        if ($product_id == 0) {
            $product_id = WDFInput::get('product_id', 0, 'int');
        }

        if ($start == 0) {
            $start = WDFInput::get('reviews_start', 0, 'int');
        }

        if ($limit == 0) {
            $limit = WDFInput::get('reviews_limit', self::REVIEWS_COUNT_TO_LOAD, 'int');
        }

        $db = JFactory::getDbo();
        $query = $db->getQuery(true);

        $model_options = WDFHelper::get_model('options');
        $options = $model_options->get_options();

        // count
        $query->clear();
        $query->select('COUNT(*)');
        $query->from('#__ecommercewd_feedback');
        $query->where('product_id = ' . $product_id);
        $query->where('published = 1');
        $db->setQuery($query);
        $count = $db->loadResult();

        if ($db->getErrorNum()) {
            $failed = true;
        }

        // rows
        if ($failed == false) {
            $query->clear();
            $query->select('user_name');
            $query->select('sender_name');
            $query->select('date');
            $query->select('text');
            $query->from('#__ecommercewd_feedback');
            $query->where('product_id = ' . $product_id);
            $query->where('published = 1');
            $query->order('date DESC');
            $db->setQuery($query, $start, $limit);
            $rows = $db->loadObjectList();

            if ($db->getErrorNum()) {
                $failed = true;
            }
        }

        // additional data
        if ($failed == false) {
            foreach ($rows as $row) {
                // date
                $row->date = date($options->option_date_format, strtotime($row->date));
            }
        }

        $data = array();
        $data['rows'] = $failed == false ? $rows : array();
        $data['can_load_more'] = ($failed == false) && ($start + $limit < $count) ? 1 : 0;

        return $data;
    }


    ////////////////////////////////////////////////////////////////////////////////////////
    // Getters & Setters                                                                  //
    ////////////////////////////////////////////////////////////////////////////////////////
    ////////////////////////////////////////////////////////////////////////////////////////
    // Private Methods                                                                    //
    ////////////////////////////////////////////////////////////////////////////////////////
    private function get_search_categories_list($category_id = 0, $categories_list = array(), $indent = 0) {
        if (empty($categories_list) == true) {
            $categories_list[] = array('id' => '', 'name' => WDFText::get('ANY_CATEGORY'));
        }

        $indent++;

        $db = JFactory::getDbo();
        $query = $db->getQuery(true);

        // get child categories
        $query->clear();
        $query->select('T_CATEGORIES.id');
        $query->select('T_CATEGORIES.name');
        $query->from('#__ecommercewd_categories AS T_CATEGORIES');
        $query->where('T_CATEGORIES.parent_id = ' . $category_id);
        $query->where('published = 1');
        $query->order($db->quoteName('ordering') . ' ASC');

        $db->setQuery($query);
        $subcategories = $db->loadAssocList();

        if ($db->getErrorNum()) {
            return false;
        }

        for ($i = 0; $i < count($subcategories); $i++) {
            $subcategory = $subcategories[$i];
            $subcategory['name'] = WDFTextUtils::indent_string($subcategory['name'], $indent * 2, '&nbsp;');
            $categories_list[$subcategory['id']] = $subcategory;
            $categories_list = $this->get_search_categories_list($subcategory['id'], $categories_list, $indent);
            if ($categories_list === false) {
                return false;
            }
        }

        return $categories_list;
    }

    private function get_search_data() {
        if ($this->search_data == null) {
            $search_data = array();

            $search_data['category_id'] = (int) WDFInput::get('search_category_id', WDFParams::get('category_id'));
            $search_data['name'] = WDFInput::get('search_name', '');
            $this->search_data = $search_data;
        }

        return $this->search_data;
    }

    private function get_filter_manufacturer_rows() {
        $db = JFactory::getDbo();
        $query = $db->getQuery(true);

        // manufacturer rows
        $query->clear();
        $query->select('id');
        $query->select('name');
        $query->from('#__ecommercewd_manufacturers');
        $query->where('published = 1');

        $db->setQuery($query);
        $manufacturer_rows = $db->loadObjectList();

        return $manufacturer_rows;
    }

    private function get_filter_date_added_ranges() {
        $date_added_ranges = array();

        $date_added_ranges[1] = WDFText::get('TODAY');
        $date_added_ranges[2] = WDFText::get('LAST_WEEK');
        $date_added_ranges[3] = WDFText::get('LAST_TWO_WEEKS');
        $date_added_ranges[4] = WDFText::get('LAST_MONTH');
        $date_added_ranges[0] = WDFText::get('ANY_DATE');

        return $date_added_ranges;
    }

    private function get_filters_data() {
        if ($this->filters_data == null) {
            $filters_data = array();

            $filters_data['filters_opened'] = WDFInput::get('filter_filters_opened', 0, 'int');
			if(WDFInput::get('filter_manufacturer_ids') !== NULL ){
				$manufacturer_ids = WDFInput::get_array('filter_manufacturer_ids',',',array());
			}	
			else{				
				$manufacturer_ids = WDFParams::get('manufacturer_id') ? explode(',',WDFParams::get('manufacturer_id')): array();
			}
			array_walk($manufacturer_ids, create_function('&$value', '$value = (int)$value;'));		
            $filters_data['manufacturer_ids'] = $manufacturer_ids;
			
            $filters_data['price_from'] = max(0, WDFInput::get('filter_price_from', WDFParams::get('min_price'), 'double'));
            $filters_data['price_from'] = $filters_data['price_from'] == 0 ? '' : $filters_data['price_from'];
            $filters_data['price_to'] = max(0, WDFInput::get('filter_price_to', WDFParams::get('max_price'), 'double'));
            $filters_data['price_to'] = $filters_data['price_to'] == 0 ? '' : $filters_data['price_to'];
            $filters_data['date_added_range'] = (int) WDFInput::get('filter_date_added_range', WDFParams::get('date_added'));
            $filters_data['minimum_rating'] = (int) WDFInput::get('filter_minimum_rating', WDFParams::get('min_rating'));
			
			$selected_tags = array();
			if(WDFInput::get('filter_tags')!== NULL)
				$selected_tags = WDFInput::get_array('filter_tags', ',', array(), true, true);
			elseif(WDFParams::get('tags')){
				$tag_ids = WDFJson::decode(WDFParams::get('tags'));
				
				$selected_tags = array();
				foreach($tag_ids as $tag_id){
					$row_tag = WDFDb::get_row('tags', array('id = ' . $tag_id, 'published = 1'));              
					if($row_tag->id != 0){
						$selected_tags[]= $row_tag->name;
					}				
				}						
			}
		
            $filters_data['tags'] = $selected_tags;

            $this->filters_data = $filters_data;
        }

        return $this->filters_data;
    }

    private function get_products_min_and_max_price_data() {
        $db = JFactory::getDbo();
        $query = $db->getQuery(true);

        $model_options = WDFHelper::get_model('options');
        $options = $model_options->get_options();

        $decimals = $options->option_show_decimals == 1 ? 2 : 0;

        //get products data
        $query->clear();
        $select_price = 'T_PRODUCTS.price';
        if ($options->option_include_discount_in_price) {
            $select_price .= ' * (1 - IFNULL(T_DISCOUNTS.rate, 0) / 100)';
        }
        if ($options->option_include_tax_in_price) {
            $select_price .= ' * (1 + IFNULL(T_TAXES.rate, 0) / 100)';
        }
        $query->select('MIN(' . $select_price . ') AS min_price');
        $query->select('MAX(' . $select_price . ') AS max_price');
        $query = $this->add_product_rows_query_from($query);
        $query = $this->add_product_rows_query_where_filter_name($query);
        $query = $this->add_product_rows_query_where_filter_category($query);
        if ($query === false) {
            WDFHelper::redirect('systempages', 'displayerror', '', 'code=2');
        }
        $query = $this->add_product_rows_query_where_filter_manufacturer($query);
        $query = $this->add_product_rows_query_where_filter_date_added($query);
        $query = $this->add_product_rows_query_where_filter_minimum_rating($query);
        $query = $this->add_product_rows_query_where_filter_tags($query);
        $query->where('T_PRODUCTS.published = 1');
        $db->setQuery($query);
        $min_and_max_price = $db->loadObject();

        if ($db->getErrorNum()) {
            return false;
        }

        $min_and_max_price_data = array();
        $min_and_max_price_data['min_price'] = number_format($min_and_max_price->min_price, $decimals);
        $min_and_max_price_data['max_price'] = number_format($min_and_max_price->max_price, $decimals);

        return $min_and_max_price_data;
    }

    private function get_arrangement_data() {
        $arrangement_data = array();

        $arrangement_data['arrangement'] = WDFSession::get('arrangement', WDFInput::get('arrangement', WDFParams::get('arrangement', 'thumbs')));

        return $arrangement_data;
    }

    private function get_sortables_list() {
        $model_options = WDFHelper::get_model('options');
        $options = $model_options->get_options();

        $sortables_list = array();
		$sortables_list['ordering'] = array('value' => 'ordering', 'text' => WDFText::get('RELEVANCE'));
        if ($options->sort_by_name == 1) {
            $sortables_list['name'] = array('value' => 'name', 'text' => WDFText::get('NAME'));
        }

        if ($options->sort_by_manufacturer == 1) {
            $sortables_list['manufacturer'] = array('value' => 'manufacturer', 'text' => WDFText::get('MANUFACTURER'));
        }

        if ($options->sort_by_price == 1) {
            $sortables_list['price'] = array('value' => 'price', 'text' => WDFText::get('PRICE'));
        }

        if (($options->feedback_enable_product_reviews) && ($options->sort_by_count_of_reviews == 1)) {
            $sortables_list['reviews_count'] = array('value' => 'reviews_count', 'text' => WDFText::get('NUMBER_OF_REVIEWS'));
        }

        if (($options->feedback_enable_product_rating == 1) && ($options->sort_by_rating)) {
            $sortables_list['rating'] = array('value' => 'rating', 'text' => WDFText::get('RATING'));
        }

        return $sortables_list;
    }

    private function get_sort_data() {
        
        $sort_data = array();
        if(WDFInput::get('type'))
        {
            $sort_data['sort_by'] = WDFInput::get('order');
            $sort_data['sort_order'] = WDFInput::get('direction');
        }
        else 
        {
            $sort_data['sort_by'] = WDFSession::get('sort_by', WDFInput::get('sort_by', WDFParams::get('ordering')));
            $sort_data['sort_order'] = WDFSession::get('sort_order', WDFInput::get('sort_order', WDFParams::get('order_dir')));
        }
        return $sort_data;
    }

    private function get_pagination($ids, $use_search_and_filters = false, $use_menu_params = false) {
        $db = JFactory::getDbo();
        $query = $db->getQuery(true);

        $theme = WDFHelper::get_model('theme')->get_theme_row();

        // get products count
        if ($use_search_and_filters == true) {
            $query->clear();
            $query->select('COUNT(*)');
            $query = $this->add_product_rows_query_from($query);
            if ($ids != null) {
                $query = $this->add_product_rows_query_where_ids($query, $ids);
            }
            if ($use_search_and_filters == true) {
                $query = $this->add_product_rows_query_where_filter_name($query);
                $query = $this->add_product_rows_query_where_filter_category($query);
                if ($query === false) {
                    WDFHelper::redirect('systempages', 'displayerror', '', 'code=2');
                }
                $query = $this->add_product_rows_query_where_filter_manufacturer($query);
                $query = $this->add_product_rows_query_where_filter_price($query);
                $query = $this->add_product_rows_query_where_filter_date_added($query);
                $query = $this->add_product_rows_query_where_filter_minimum_rating($query);
                $query = $this->add_product_rows_query_where_filter_tags($query);
            }
			else if($use_menu_params == true){			
				$query = $this->add_product_rows_query_where_filter_menu_params($query);
			}
            $query->where('T_PRODUCTS.published = 1');
            $db->setQuery($query);
            $products_count = $db->loadResult();

            if ($db->getErrorNum()) {
                return false;
            }
        } else {
            $products_count = count($ids);
        }

        $limit_start = WDFInput::get('pagination_limit_start', 0, 'int');
        $limit = WDFInput::get('pagination_limit', $theme->products_count_in_page, 'int');

        $pagination = new JPagination($products_count, $limit_start, $limit);
        return $pagination;
    }

    private function get_product_rows($ids, $use_search_and_filters = false, $pagination = null, $use_menu_params = false) {
        if (($ids != null) && (is_array($ids) == false)) {
            $ids = array($ids);
        }

        $db = JFactory::getDbo();
        $query = $db->getQuery(true);

        $model_options = WDFHelper::get_model('options');
        $options = $model_options->get_options();
        $module_filters = WDFInput::get('module_filters');

        $decimals = $options->option_show_decimals == 1 ? 2 : 0;

        $row_default_currency = WDFDb::get_row('currencies', $db->quoteName('default') . ' = 1');

        //get products data
        $query->clear();
        $query = $this->add_product_rows_query_select($query);
        $query = $this->add_product_rows_query_from($query);
        if ($ids != null) {
            $query = $this->add_product_rows_query_where_ids($query, $ids);
        }

        if ($use_search_and_filters == true) {
            $query = $this->add_product_rows_query_where_filter_name($query);
            $query = $this->add_product_rows_query_where_filter_category($query);
            if ($query === false) {
                WDFHelper::redirect('systempages', 'displayerror', '', 'code=2');
            }
            $query = $this->add_product_rows_query_where_filter_manufacturer($query);
            $query = $this->add_product_rows_query_where_filter_price($query);
            $query = $this->add_product_rows_query_where_filter_date_added($query);
            $query = $this->add_product_rows_query_where_filter_minimum_rating($query);
            $query = $this->add_product_rows_query_where_filter_tags($query);
            $query = $this->add_product_rows_query_order($query);
        }
        else if($use_menu_params == true){			
            $query = $this->add_product_rows_query_where_filter_menu_params($query);
        }		
        $query->where('T_PRODUCTS.published = 1');
 
        if ($pagination != null) {
            $db->setQuery($query, $pagination->limitstart, $pagination->limit);
        } else {
            $db->setQuery($query);
        }

        $product_rows = $db->loadObjectList();

        if ($db->getErrorNum()) {
            return false;
        }

        // additional data
        foreach ($product_rows as $product_row) {
            // url
            $product_row->url = JRoute::_('index.php?option=com_'.WDFHelper::get_com_name().'&controller=products&task=displayproduct&product_id=' . $product_row->id);
            $product_row->url_absolute = WDFUrl::get_site_url() . 'index.php?option=com_'.WDFHelper::get_com_name().'&controller=products&task=displayproduct&product_id=' . $product_row->id;

            // image
            $images = WDFJson::decode($product_row->images);
            $product_row->image = empty($images) == false ? $images[0] : '';
			
			//videos
			$product_row->videos = WDFJson::decode($product_row->videos);
			
            // label
            $label_thumbs = WDFJson::decode($product_row->label_thumb);
            $product_row->label_thumb = empty($label_thumbs) == false ? $label_thumbs[0] : '';

            // rating
            $product_row->rating_url = '';
            $product_row->rating_msg = '';

            if (($options->feedback_enable_guest_feedback == 0) && (WDFHelper::is_user_logged_in() == false)) {
                $product_row->can_rate = 0;
                $product_row->rating_msg = WDFText::get('MSG_LOG_IN_TO_RATE');
            } elseif ($product_row->can_rate == 0) {
                $product_row->rating_msg = WDFText::get('MSG_YOU_HAVE_ALREADY_RATED_THIS_PRODUCT');
            } else {
                $product_row->rating_url = WDFUrl::get_site_url() . 'index.php?option=com_'.WDFHelper::get_com_name().'&controller=products&task=ajax_rate_product&product_id=' . $product_row->id;
            }

            // category
            $product_row->category_url = $product_row->category_id == 0 ? '' : JRoute::_('index.php?option=com_'.WDFHelper::get_com_name().'&controller=categories&task=displaycategory&category_id=' . $product_row->category_id);

            // manufacturer
            $product_row->manufacturer_url = $product_row->manufacturer_id == 0 ? '' : JRoute::_('index.php?option=com_'.WDFHelper::get_com_name().'&controller=manufacturers&task=displaymanufacturer&manufacturer_id=' . $product_row->manufacturer_id);
            $manufacturer_logos = WDFJson::decode($product_row->manufacturer_logo);
            $product_row->manufacturer_logo = empty($manufacturer_logos) == true ? '' : $manufacturer_logos[0];

            // prices
			
            $product_row->price_text = number_format($product_row->price, $decimals);
            $product_row->market_price_text = ($product_row->market_price != '0.00') ? number_format($product_row->market_price, $decimals) : '';

            // currency symbols
            if ($row_default_currency->sign_position == 0) {
                $product_row->price_text = $row_default_currency->sign . $product_row->price_text;
                $product_row->market_price_text = ($product_row->market_price != '0.00') ? $row_default_currency->sign . $product_row->market_price_text : '';
            } else {
                $product_row->price_text = $product_row->price_text . $row_default_currency->sign;
                $product_row->market_price_text = ($product_row->market_price != '0.00') ? $product_row->market_price_text . $row_default_currency->sign : '';
            }
			$product_row->currency_sign = $row_default_currency->sign;
            // availability
            if ($product_row->unlimited == 1) {
                $product_row->is_available = true;
                $product_row->available_msg = WDFText::get('IN_STOCK');
				$product_row->stock_class = 'class="wd_in_stock"';
            } elseif ($product_row->amount_in_stock > 0) {
                $product_row->is_available = true;
                $product_row->available_msg = WDFText::get('IN_STOCK') . ': ' . $product_row->amount_in_stock;
				$product_row->stock_class = 'class="wd_in_stock"';
            } else {
                $product_row->is_available = false;
                $product_row->available_msg = WDFText::get('OUT_OF_STOCK');
				$product_row->stock_class = 'class="wd_out_of_stock"';
            }

            // checkout privileges
            $products_in_stock = ($product_row->amount_in_stock > 0) || ($product_row->unlimited == 1) ? true : false;
            $product_row->can_checkout = $products_in_stock == true ? true : false;


            // compare url
            $product_row->compare_url = JRoute::_('index.php?option=com_'.WDFHelper::get_com_name().'&controller=products&task=displaycompareproducts&product_id=' . $product_row->id);

            // review urls
            $product_row->reviews_url = JRoute::_('index.php?option=com_'.WDFHelper::get_com_name().'&controller=products&task=displayproductreviews&product_id=' . $product_row->id);
            $product_row->write_review_url = JRoute::_('index.php?option=com_'.WDFHelper::get_com_name().'&controller=products&task=displayproductreviews&product_id=' . $product_row->id . '&write_review=1');
		}

        return $product_rows;
    }
	

    private function add_product_rows_query_select(JDatabaseQuery $query) {
        $model_options = WDFHelper::get_model('options');
        $options = $model_options->get_options();

        $query->select('T_PRODUCTS.date_added');
        $query->select('T_PRODUCTS.id');
        $query->select('T_PRODUCTS.name');
        $query->select('IFNULL(T_PRODUCTS.category_id, 0) AS category_id');
        $query->select('T_CATEGORIES.name AS category_name');
        $query->select('FORMAT(T_RATINGS.rating, 1) AS rating');
        $query->select('CASE
                WHEN T_USER_RATINGS.ratings_count > 0 THEN 0
                WHEN T_USER_RATINGS.ratings_count = 0 THEN 1
                WHEN T_USER_RATINGS.ratings_count IS NULL THEN 1
            END AS can_rate');
        $query->select('IFNULL(T_PRODUCTS.manufacturer_id, 0) AS manufacturer_id');
        $query->select('T_MANUFACTURERS.name AS manufacturer_name');
        $query->select('T_MANUFACTURERS.logo AS manufacturer_logo');
        $query->select('T_MANUFACTURERS.site AS manufacturer_site');
        $query->select('T_PRODUCTS.description');
        $query->select('T_PRODUCTS.images');
        $select_price = 'T_PRODUCTS.price';
        if ($options->option_include_discount_in_price) {
            $select_price .= ' * (1 - IFNULL(T_DISCOUNTS.rate, 0) / 100)';
        }
        if ($options->option_include_tax_in_price) {
            $select_price .= ' * (1 + IFNULL(T_TAXES.rate, 0) / 100)';
        }
        $select_price .= ' AS price';
        $query->select($select_price);
        $query->select('T_PRODUCTS.market_price');
		$query->select('T_PRODUCTS.price AS price_without_t_d');
        $query->select('T_PRODUCTS.amount_in_stock');
        $query->select('T_PRODUCTS.unlimited');
        $query->select('CASE
                WHEN T_ORDERPRODUCTS.products_in_cart > 0 THEN 1
                WHEN T_ORDERPRODUCTS.products_in_cart = 0 THEN 0
            END AS added_to_cart');
        $query->select('T_LABELS.name AS label_name');
        $query->select('T_LABELS.thumb AS label_thumb');
        $query->select('T_LABELS.thumb_position AS label_thumb_position');
        $query->select('T_TAXES.name AS tax_name');
		$query->select('T_TAXES.rate AS tax_rate');
        $query->select('T_DISCOUNTS.name AS discount_name');
		$query->select('T_DISCOUNTS.rate AS discount_rate');
        $query->select('T_PRODUCTS.meta_title');
        $query->select('T_PRODUCTS.meta_description');
        $query->select('T_PRODUCTS.meta_keyword');
        $query->select('T_PRODUCTS.model');
        $query->select('T_PRODUCTS.sku');
        $query->select('T_PRODUCTS.upc');
        $query->select('T_PRODUCTS.ean');
        $query->select('T_PRODUCTS.jan');
        $query->select('T_PRODUCTS.isbn');
        $query->select('T_PRODUCTS.mpn');
        $query->select('T_PRODUCTS.weight');
        $query->select('T_PRODUCTS.dimensions');
        $query->select('T_PRODUCTS.videos');
        $query->select('T_FEEDBACK.reviews_count');

        return $query;
    }

    private function add_product_rows_query_from(JDatabaseQuery $query) {
        $db = JFactory::getDbo();

        $j_user = JFactory::getUser();

        $query->from('#__ecommercewd_products AS T_PRODUCTS');
        $query->leftJoin('(SELECT * FROM #__ecommercewd_categories WHERE published = 1) AS T_CATEGORIES ON T_CATEGORIES.id = T_PRODUCTS.category_id');
        $query->leftJoin('(SELECT * FROM #__ecommercewd_manufacturers WHERE published = 1) AS T_MANUFACTURERS ON T_MANUFACTURERS.id = T_PRODUCTS.manufacturer_id');
        $query->leftJoin('(SELECT * FROM #__ecommercewd_labels WHERE published = 1) AS T_LABELS ON T_LABELS.id = T_PRODUCTS.label_id');
        $query->leftJoin('(SELECT * FROM #__ecommercewd_taxes WHERE published = 1) AS T_TAXES ON T_TAXES.id = T_PRODUCTS.tax_id');
        $query->leftJoin('(SELECT * FROM #__ecommercewd_discounts WHERE published = 1) AS T_DISCOUNTS ON T_PRODUCTS.discount_id = T_DISCOUNTS.id');
        $query->leftJoin('(SELECT product_id, COUNT(id) AS reviews_count FROM #__ecommercewd_feedback WHERE published = 1 GROUP BY product_id) AS T_FEEDBACK ON T_FEEDBACK.product_id = T_PRODUCTS.id');
        $query->leftJoin('(SELECT product_id, AVG(rating) AS rating FROM #__ecommercewd_ratings GROUP BY product_id) AS T_RATINGS ON T_RATINGS.product_id = T_PRODUCTS.id');
        // tags
        $query->leftJoin('
            (
                SELECT
                    T_PRODUCT_TAGS.product_id,
                    CONCAT(",", GROUP_CONCAT(T_TAGS.name SEPARATOR ","), ",") as tag_names
                FROM
                    #__ecommercewd_tags AS T_TAGS
                    LEFT JOIN #__ecommercewd_producttags AS T_PRODUCT_TAGS ON T_PRODUCT_TAGS.tag_id = T_TAGS.id
                    GROUP BY product_id)
            AS T_PRODUCT_TAGS ON T_PRODUCT_TAGS.product_id = T_PRODUCTS.id');
        // rating
        if (WDFHelper::is_user_logged_in() == true) {
            $user_identification = 'j_user_id = ' . $j_user->id;
        } else {
            $user_ip_address = WDFUtils::get_client_ip_address();
            $user_identification = 'user_ip_address = ' . $db->quote($user_ip_address);
        }
        $query->leftJoin('(
                SELECT
                    product_id,
                    COUNT(rating) AS ratings_count
                FROM
                    #__ecommercewd_ratings
                WHERE ' . $user_identification . '
                GROUP BY product_id
            ) AS T_USER_RATINGS ON T_USER_RATINGS.product_id = T_PRODUCTS.id');

        if (WDFHelper::is_user_logged_in()) {
            $j_user = JFactory::getUser();
            $user_identification = 'j_user_id = ' . $j_user->id;
        } else {
            $order_product_rand_ids = WDFInput::cookie_get_array('order_product_rand_ids');
            if (empty($order_product_rand_ids) == false) {
                $user_identification = 'j_user_id = 0 AND rand_id IN (' . implode(',', $order_product_rand_ids) . ')';
            } else {
                $user_identification = '0';
            }
        }
        $query->leftJoin('(SELECT product_id, COUNT(id) AS products_in_cart FROM #__ecommercewd_orderproducts WHERE ' . $user_identification . ' AND order_id = 0 GROUP BY product_id) AS T_ORDERPRODUCTS ON T_ORDERPRODUCTS.product_id = T_PRODUCTS.id');

        return $query;
    }

    private function add_product_rows_query_where_ids(JDatabaseQuery $query, $ids) {
        if ($ids != null) {
            $query->where('T_PRODUCTS.id IN (' . implode(',', $ids) . ')');
        }

        return $query;
    }
	
	// menu param filters
	private function add_product_rows_query_where_filter_menu_params(JDatabaseQuery $query){
		$db = JFactory::getDbo();
		$model_options = WDFHelper::get_model('options');
                $options = $model_options->get_options();
		
		//category
                if(WDFInput::get('type') && WDFInput::get('id')!=='')
                {
                    $query->where('T_PRODUCTS.category_id = ' . WDFInput::get('id') );
                }
                else
		if(WDFParams::get('category_id'))
			$query->where('T_PRODUCTS.category_id = ' . WDFParams::get('category_id') );
		 
		//manufacturer
		if(WDFInput::get('type') && WDFInput::get('manufacturers_id')!=='')
                {
                    $product_manufacturers = WDFInput::get('manufacturers_id');
                    $man_ids = str_replace("_",',',$product_manufacturers);
                    
                    $query->where('T_PRODUCTS.manufacturer_id IN (' . $man_ids.')' );
                    
                }
                else
                {
		if(WDFParams::get('manufacturer_id'))
			$query->where('T_PRODUCTS.manufacturer_id IN (' . WDFParams::get('manufacturer_id').')' );
                }
                
		//prices
		$select_price = 'T_PRODUCTS.price';
        if ($options->option_include_discount_in_price) {
            $select_price .= ' * (1 - IFNULL(T_DISCOUNTS.rate, 0) / 100)';
        }
        if ($options->option_include_tax_in_price) {
            $select_price .= ' * (1 + IFNULL(T_TAXES.rate, 0) / 100)';
        }
                if(WDFInput::get('type') && WDFInput::get('min_price')!=='')
                {
                    $query->where($select_price . ' >= ' . WDFInput::get('min_price'));
                }
                else
                {
                if(WDFParams::get('min_price'))
                    $query->where($select_price . ' >= ' . WDFParams::get('min_price'));
                }
                
		if(WDFInput::get('type') && WDFInput::get('max_price')!=='')
                {
                    $query->where($select_price . ' <= ' . WDFInput::get('max_price'));
                }
                else
                {
                if(WDFParams::get('max_price'))
                    $query->where($select_price . ' <= ' . WDFParams::get('max_price'));
                }

        //date added
        if (WDFInput::get('type')) {
            switch (WDFInput::get('date')) {
                case 1:
                    $query->where('DATE_FORMAT(T_PRODUCTS.date_added,"%Y-%m-%d" ) BETWEEN SUBDATE(CURDATE(), INTERVAL 1 DAY) AND CURDATE()');
                    break;
                case 2:
                    $query->where('DATE_FORMAT(T_PRODUCTS.date_added,"%Y-%m-%d" ) BETWEEN SUBDATE(CURDATE(), INTERVAL 1 WEEK) AND CURDATE()');
                    break;
                case 3:
                    $query->where('DATE_FORMAT(T_PRODUCTS.date_added,"%Y-%m-%d" ) BETWEEN SUBDATE(CURDATE(), INTERVAL 2 WEEK) AND CURDATE()');
                    break;
                case 4:
                    $query->where('DATE_FORMAT(T_PRODUCTS.date_added,"%Y-%m-%d" ) BETWEEN SUBDATE(CURDATE(), INTERVAL 1 MONTH) AND CURDATE()');
                    break;
            }
        } else {
            if (WDFParams::get('date_added')) {
                switch (WDFParams::get('date_added')) {
                    case 1:
                        $query->where('DATE_FORMAT(T_PRODUCTS.date_added,"%Y-%m-%d" ) BETWEEN SUBDATE(CURDATE(), INTERVAL 1 DAY) AND CURDATE()');
                        break;
                    case 2:
                        $query->where('DATE_FORMAT(T_PRODUCTS.date_added,"%Y-%m-%d" ) BETWEEN SUBDATE(CURDATE(), INTERVAL 1 WEEK) AND CURDATE()');
                        break;
                    case 3:
                        $query->where('DATE_FORMAT(T_PRODUCTS.date_added,"%Y-%m-%d" ) BETWEEN SUBDATE(CURDATE(), INTERVAL 2 WEEK) AND CURDATE()');
                        break;
                    case 4:
                        $query->where('DATE_FORMAT(T_PRODUCTS.date_added,"%Y-%m-%d" ) BETWEEN SUBDATE(CURDATE(), INTERVAL 1 MONTH) AND CURDATE()');
                        break;
                }
            }
        }
		//rating
             
                if(WDFInput::get('type') && WDFInput::get('rating') )
                {
                    
                    $query->where('T_RATINGS.rating >= ' . WDFInput::get('rating'));
                }
                else
                {
		if(WDFParams::get('min_rating'))		
			$query->where('T_RATINGS.rating >= ' . WDFParams::get('min_rating'));
               }	
			
		// tags	
                if(WDFInput::get('type') && WDFInput::get('tags')!=='')
                {
                    $product_tags = WDFInput::get('tags');
                    $tag_ids = explode("_",$product_tags);
                    
                    foreach ( $tag_ids as $tag_id) {
                        $row_tag = WDFDb::get_row('tags', array($db->quoteName('id') . ' = ' . $tag_id, $db->quoteName('published') . ' = 1'));              
                        if( $row_tag->id != 0 ){
                                $query->where('T_PRODUCT_TAGS.tag_names LIKE ' . $db->quote('%' . $row_tag->name . '%'));
                        }
                    }
                }
                else
                {
                    if(WDFParams::get('tags')){
                            $tag_ids = WDFJson::decode(WDFParams::get('tags'));

                            foreach ( $tag_ids as $tag_id) {
                                    $row_tag = WDFDb::get_row('tags', array($db->quoteName('id') . ' = ' . $tag_id, $db->quoteName('published') . ' = 1'));              
                                    if( $row_tag->id != 0 ){
                                            $query->where('T_PRODUCT_TAGS.tag_names LIKE ' . $db->quote('%' . $row_tag->name . '%'));
                                    }
                            }
                    }
                }
		return $query;
	}

    // filters
    private function add_product_rows_query_where_filter_name(JDatabaseQuery $query) {
        $db = JFactory::getDbo();

        $model_options = WDFHelper::get_model('options');
        $options = $model_options->get_options();

        $search_data = $this->get_search_data();
        $module_filters = WDFInput::get('module_filters');

        if ((($options->search_enable_search == 1) && ($search_data['name'] != '')) || $module_filters == 1
        )  {
            $query->where('LOWER(T_PRODUCTS.name) LIKE ' . $db->quote('%' . $search_data['name'] . '%'));
        }

        return $query;
    }

    private function add_product_rows_query_where_filter_category(JDatabaseQuery $query) {
        $model_options = WDFHelper::get_model('options');
        $options = $model_options->get_options();

        $search_data = $this->get_search_data();

        $module_filters = WDFInput::get('module_filters');
        $include_subcategories = WDFInput::get('include_subcategories');


        if ((($options->search_enable_search == 1) && ($options->search_by_category) && ($search_data['category_id'] != '')) || (($module_filters == 1) && ($search_data['category_id'] != '') && ($search_data['category_id'] != 0))
        ) {
            $category_ids = array($search_data['category_id']);
            if (($options->search_enable_search == 1 && $options->search_include_subcategories == true) || $search_data['category_id'] == 0 || ($include_subcategories == 1 && $options->search_enable_search == 0)) {
                $category_ids = $this->get_category_and_all_subcategories_ids($category_ids);
                if ($category_ids === false) {
                    return false;
                }
            }
            $query->where('T_PRODUCTS.category_id IN (' . implode(',', $category_ids) . ')');
        }


        return $query;
    }

    private function get_category_and_all_subcategories_ids($category_ids) {
        $db = JFactory::getDbo();
        $query = $db->getQuery(true);

        $query->clear();
        $query->select('id');
        $query->from('#__ecommercewd_categories');
        $query->where('parent_id IN (' . implode(',', $category_ids) . ')');
        $db->setQuery($query);
        $subcategories_ids = $db->loadColumn();

        if ($db->getErrorNum()) {
            return false;
        }

        if (empty($subcategories_ids) == false) {
            $category_ids = array_merge($category_ids, $this->get_category_and_all_subcategories_ids($subcategories_ids));
        }

        return $category_ids;
    }

    private function add_product_rows_query_where_filter_manufacturer(JDatabaseQuery $query) {
        $model_options = WDFHelper::get_model('options');
        $options = $model_options->get_options();

        $filters_data = $this->get_filters_data();

        $module_filters = WDFInput::get('module_filters');

        if ((($options->search_enable_search == 1) && ($options->filter_manufacturers) && (count($filters_data['manufacturer_ids']) > 0)) || (($module_filters == 1) && (count($filters_data['manufacturer_ids']) > 0))
        ) {
            $query->where('T_PRODUCTS.manufacturer_id IN (' . implode(',', $filters_data['manufacturer_ids']) . ')');
        }

        return $query;
    }

    private function add_product_rows_query_where_filter_price(JDatabaseQuery $query) {
        $model_options = WDFHelper::get_model('options');
        $options = $model_options->get_options();

        $select_price = 'T_PRODUCTS.price';
        if ($options->option_include_discount_in_price) {
            $select_price .= ' * (1 - IFNULL(T_DISCOUNTS.rate, 0) / 100)';
        }
        if ($options->option_include_tax_in_price) {
            $select_price .= ' * (1 + IFNULL(T_TAXES.rate, 0) / 100)';
        }

        $module_filters = WDFInput::get('module_filters');

        $filters_data = $this->get_filters_data();
        if ((($options->search_enable_search == 1) && ($options->filter_price)) || $module_filters == 1
        )  {
            if ($filters_data['price_from'] != '') {
                $query->where($select_price . ' >= ' . $filters_data['price_from']);
            }
            if ($filters_data['price_to'] != '') {
                $query->where($select_price . ' <= ' . $filters_data['price_to']);
            }
        }

        return $query;
    }
	

    private function add_product_rows_query_where_filter_date_added(JDatabaseQuery $query) {
        $model_options = WDFHelper::get_model('options');
        $options = $model_options->get_options();

        $filters_data = $this->get_filters_data();

        $module_filters = WDFInput::get('module_filters');

        if ((($options->search_enable_search == 1) && ($options->filter_date_added == 1)) || $module_filters == 1
        ) {
            switch ($filters_data['date_added_range']) {
                case 1:
                    $query->where('DATE_FORMAT(T_PRODUCTS.date_added,"%Y-%m-%d" ) BETWEEN SUBDATE(CURDATE(), INTERVAL 1 DAY) AND CURDATE()');
                    break;
                case 2:
                    $query->where('DATE_FORMAT(T_PRODUCTS.date_added,"%Y-%m-%d" ) BETWEEN SUBDATE(CURDATE(), INTERVAL 1 WEEK) AND CURDATE()');
                    break;
                case 3:
                    $query->where('DATE_FORMAT(T_PRODUCTS.date_added,"%Y-%m-%d" ) BETWEEN SUBDATE(CURDATE(), INTERVAL 2 WEEK) AND CURDATE()');
                    break;
                case 4:
                    $query->where('DATE_FORMAT(T_PRODUCTS.date_added,"%Y-%m-%d" ) BETWEEN SUBDATE(CURDATE(), INTERVAL 1 MONTH) AND CURDATE()');
                    break;
            }
        }

        return $query;
    }
	
	private function add_product_rows_query_where_filter_price_without_td(JDatabaseQuery $query){
        $model_options = WDFHelper::get_model('options');
        $options = $model_options->get_options();

        $select_price = 'T_PRODUCTS.price AS price_without_td';


        return $query;
    }

    private function add_product_rows_query_where_filter_minimum_rating(JDatabaseQuery $query) {
        $model_options = WDFHelper::get_model('options');
        $options = $model_options->get_options();

        $filters_data = $this->get_filters_data();

        $module_filters = WDFInput::get('module_filters');

        if ((($options->search_enable_search == 1) && ($options->filter_minimum_rating) && ($options->feedback_enable_product_rating) && ($filters_data['minimum_rating'] != 0)) || (($module_filters == 1) && ($filters_data['minimum_rating'] != 0))
        ) {
            $query->where('T_RATINGS.rating >= ' . $filters_data['minimum_rating']);
        }

        return $query;
    }

    private function add_product_rows_query_where_filter_tags(JDatabaseQuery $query) {
        $db = JFactory::getDbo();

        $model_options = WDFHelper::get_model('options');
        $options = $model_options->get_options();

        $filters_data = $this->get_filters_data();

        $module_filters = WDFInput::get('module_filters');

        if ((($options->search_enable_search == 1) && ($options->filter_tags == 1)) || $module_filters == 1
        ) {
            foreach ($filters_data['tags'] as $tag_name) {
                $query->where('T_PRODUCT_TAGS.tag_names LIKE ' . $db->quote('%,' . $tag_name . ',%'));
            }
        }

        return $query;
    }


    private function add_product_rows_query_order(JDatabaseQuery $query) {
        $sort_data = $this->get_sort_data();
        $sort_by = '';
        $sort_order = ($sort_data['sort_order'] == "asc" || $sort_data['sort_order'] == "desc" || $sort_data['sort_order'] == "") ? strtoupper($sort_data['sort_order']) : "ASC";

        switch ($sort_data['sort_by']) {
		    case 'ordering':
                $sort_by = 'T_PRODUCTS.ordering';
                break;
            case 'name':
                $sort_by = 'T_PRODUCTS.name';
                break;
            case 'manufacturer':
                $sort_by = 'T_MANUFACTURERS.name';
                break;
            case 'price':
                $sort_by = 'T_PRODUCTS.price';
                break;
            case 'reviews_count':
                $sort_by = 'T_FEEDBACK.reviews_count';
                break;
            case 'rating':
                $sort_by = 'T_RATINGS.rating';
                break;
        }
        if ($sort_by != '') {
            $query->order($sort_by . ' ' . $sort_order);
        }
        $query->order('T_PRODUCTS.ordering ' . $sort_order);

        return $query;
    }

    private function add_product_parameters($product_rows) {
        $db = JFactory::getDbo();
        $query = $db->getQuery(true);

        for ($i = 0; $i < count($product_rows); $i++) {
            $product_row = $product_rows[$i];

            $query->clear();
            $query->select('T_PRODUCT_PARAMETERS.parameter_id AS id');
            $query->select('T_PARAMETERS.name');
            $query->select('T_PRODUCT_PARAMETERS.parameter_value AS value');
            $query->select('T_PRODUCT_PARAMETERS.productparameters_id');
            $query->from('#__ecommercewd_productparameters AS T_PRODUCT_PARAMETERS');
            $query->leftJoin('#__ecommercewd_parameters AS T_PARAMETERS ON T_PRODUCT_PARAMETERS.parameter_id = T_PARAMETERS.id');
            $query->where('T_PRODUCT_PARAMETERS.product_id = ' . $product_row->id);
            $query->order('T_PRODUCT_PARAMETERS.productparameters_id ASC');
            $db->setQuery($query);
            $parameter_rows = $db->loadObjectList();

            if ($db->getErrorNum()) {
                return false;
            }

            $parameters = array();
            foreach ($parameter_rows as $parameter_row) {
                if (isset($parameters[$parameter_row->id]) == false) {
                    $parameter = new stdClass();
                    $parameter->name = $parameter_row->name;
                    $parameter->values = array();
                } else {
                    $parameter = $parameters[$parameter_row->id];
                }
                $parameter->values[] = $parameter_row->value;

                $parameters[$parameter_row->id] = $parameter;
            }

            $product_row->parameters = $parameters;
        }
    }

    private function add_product_selectable_parameters($product_rows) {
        for ($i = 0; $i < count($product_rows); $i++) {
            $product_row = $product_rows[$i];

            $selectable_parameters = $this->get_product_selectable_parameters($product_row->id);
            if ($selectable_parameters === false) {
                return false;
            }
            $product_row->selectable_parameters = $selectable_parameters;
        }
    }

    private function add_product_tags($product_rows) {
        $db = JFactory::getDbo();
        $query = $db->getQuery(true);

        for ($i = 0; $i < count($product_rows); $i++) {
            $product_row = $product_rows[$i];

            $query->clear();
            $query->select('T_PRODUCT_TAGS.tag_id AS id');
            $query->select('T_TAGS.name');
            $query->from('#__ecommercewd_producttags AS T_PRODUCT_TAGS');
            $query->leftJoin('#__ecommercewd_tags AS T_TAGS ON T_PRODUCT_TAGS.tag_id = T_TAGS.id');
            $query->where('T_PRODUCT_TAGS.product_id = ' . $product_row->id);
            $query->order('T_TAGS.ordering ASC');
            $db->setQuery($query);
            $tag_rows = $db->loadObjectList();

            if ($db->getErrorNum()) {
                return false;
            }

            $product_row->tags = $tag_rows;
        }
    }

    private function add_product_reviews($product_rows) {
        $db = JFactory::getDbo();
        $query = $db->getQuery(true);

        $model_options = WDFHelper::get_model('options');
        $options = $model_options->get_options();

        for ($i = 0; $i < count($product_rows); $i++) {
            $product_row = $product_rows[$i];

            $query->clear();
            $query->select('T_FEEDBACK.user_name');
            $query->select('T_FEEDBACK.sender_name');
            $query->select('T_FEEDBACK.date');
            $query->select('T_FEEDBACK.text');
            $query->from('#__ecommercewd_feedback AS T_FEEDBACK');
            $query->where('T_FEEDBACK.product_id = ' . $product_row->id);
            $query->where('T_FEEDBACK.published = 1');
            $query->order('T_FEEDBACK.date DESC');
            $db->setQuery($query, 0, self::MAX_REVIEWS_PRODUCT_VIEW);
            $review_rows = $db->loadObjectList();

            if ($db->getErrorNum()) {
                return false;
            }

            // additional data
            foreach ($review_rows as $review_row) {
                $review_row->date = date($options->option_date_format, strtotime($review_row->date));
            }

            $product_row->reviews = $review_rows;
        }
    }

    private function add_product_shipping_methods($product_rows) {
        $db = JFactory::getDbo();
        $query = $db->getQuery(true);

        $model_options = WDFHelper::get_model('options');
        $options = $model_options->get_options();

        $decimals = $options->option_show_decimals == 1 ? 2 : 0;

        $row_default_currency = WDFDb::get_row('currencies', $db->quoteName('default') . ' = 1');

        for ($i = 0; $i < count($product_rows); $i++) {
            $product_row = $product_rows[$i];

            $query->clear();
            $query->select('T_SHIPPING_METHODS.name');
            $query->select('T_SHIPPING_METHODS.description');
            $query->select('T_SHIPPING_METHODS.price');
            $query->select('T_SHIPPING_METHODS.free_shipping');
            $query->select('T_SHIPPING_METHODS.free_shipping_start_price');
            $query->from('#__ecommercewd_productshippingmethods AS T_PRODUCT_SHIPPING_METHODS');
            $query->leftJoin('#__ecommercewd_shippingmethods  AS T_SHIPPING_METHODS ON T_PRODUCT_SHIPPING_METHODS.shipping_method_id = T_SHIPPING_METHODS.id');
            $query->where('T_PRODUCT_SHIPPING_METHODS.product_id = ' . $product_row->id);
            $query->where('T_SHIPPING_METHODS.published = 1');
            $query->order('T_SHIPPING_METHODS.ordering ASC');
            $db->setQuery($query);
            $shipping_method_rows = $db->loadObjectList();

            if ($db->getErrorNum()) {
                return false;
            }

            // additional data
            foreach ($shipping_method_rows as $shipping_method_row) {
                // prices
                $shipping_method_row->price = $shipping_method_row->free_shipping == 1 ? 0 : $shipping_method_row->price;

                // number format and currency signs
                if ($shipping_method_row->price != 0) {
                    $shipping_method_row->price_text = number_format($shipping_method_row->price, $decimals);
                    if ($row_default_currency->sign_position == 0) {
                        $shipping_method_row->price_text = $row_default_currency->sign . $shipping_method_row->price_text;
                    } else {
                        $shipping_method_row->price_text = $shipping_method_row->price_text . $row_default_currency->sign;
                    }
                } else {
                    $shipping_method_row->price_text = WDFText::get('FREE_SHIPPING');
                }
            }

            $product_row->shipping_methods = $shipping_method_rows;
        }
    }

    private function add_product_related_products($product_rows) {
        $db = JFactory::getDbo();
        $query = $db->getQuery(true);

        for ($i = 0; $i < count($product_rows); $i++) {
            $product_row = $product_rows[$i];

            $query->clear();
            $query->select('T_PRODUCTS.id');
            $query->select('T_PRODUCTS.name');
            $query->select('T_PRODUCTS.images');
            $query->from('#__ecommercewd_products AS T_PRODUCTS');
            $query->where('T_PRODUCTS.category_id = ' . $product_row->category_id);
            $query->where('T_PRODUCTS.id <> ' . $product_row->id);
            $query->where('T_PRODUCTS.published = 1');
            $query->order('RAND() LIMIT 0, 15');
            $db->setQuery($query);
            $related_product_rows = $db->loadObjectList();

            if ($db->getErrorNum()) {
                return false;
            }

            // add data
            foreach ($related_product_rows as $related_product_row) {
                // link
                $related_product_row->link = JRoute::_('index.php?option=com_'.WDFHelper::get_com_name().'&controller=products&task=displayproduct&product_id=' . $related_product_row->id);

                // image
                $related_product_row->images = WDFJson::decode($related_product_row->images);
                $related_product_row->image = count($related_product_row->images) > 0 ? $related_product_row->images[0] : '';
            }

            $product_row->related_products = $related_product_rows;
        }
    }

    private function get_selectable_params_empty_row($product_id){
        $product_selectable_params = $this->get_product_selectable_parameters($product_id);
        return $product_selectable_params;
    }
	
	/**
	  * szellemi termelés változat   beolvasás képernyő mezőkből
	  * @param object
	  * @return object
	*/  
	public function bind($source) {
	  $item = new stdClass();
	  foreach ($source as $fn => $fv)
	    $item->$fn = $fv;
	  return $item;
	}
	
	/**
	  * szellemi termelés változat   beirt adatok ellenörzése
	  * @param object
	  * @return boolean
	*/  
	public function check($item) {
	  // $this->setError(...);	
	  $msg = '';
	  if ($item->name == '')
		  $msg .= JText::_('COM_ECCOMERCEWD_NAME_REQUED').'<br />';
	  if ($item->price < 0)
		  $msg .= JText::_('COM_ECCOMERCEWD_PRICE_REQUED').'<br />';
	  
	  if ($dmg != '') {
		  $result = false;
		  $this->setError($msg);
	  } else {
		  $result = true;
	  }
      return $result;		
	}
	
	/**
	  * szellemi termelés változat   adat térolás adatbázisba
	  * @param object
	  * @JRequest imgdel0,imgdel1,imgdel2,imgdel3
	  * @JRequest img0, img1, img2, img3
	  * @return boolean
	*/  
	public function save($item) {
		$user = JFactory::getUser();
		// eredeti rekord elérése
		$orig = $this->get_product_view_product_row($item->id);
		// eredeti images elérése
		if ($orig->images != '')
		  $origImages = JSON_decode($orig->images);
	    else
		  $origImages = array();	 
	    while (count($origImages) < 4) $origImages[] = '';
		// images_delete kérések teljesitése
		for ($i=0; $i<5; $i++) {
			$fn = 'imgdel'.$i;
			if (JRequest::getVar($fn) == 1) {
			  unlink($origImages[$i]);
			  $origImages[$i] = '';
			}
		}
		// alapértelmezett értékek beirása
		$item->published = 1;
		if ($item->model == '') $item->model = $user->username;
		$item->alias = strtolower(preg_replace("/[^A-Za-z0-9]/", '', $item->name));
		$item->date_added = date('Y-m-d H:i:s');
		$item->category_id = JRequest::getVar('category_id',$orig->category_id);
		if ($item->category_id == '') $item->category_id = $orig->category_id;
		// tárolás adatbázisba
        $table = JTable::getInstance('products', 'EcommercewdTable');
		foreach ($item as $fn => $fv) {
		  $table->$fn = $fv;
		} 
		$result = $table->store();
		// új product_id lekérdezése
		$product_id = $table->id;
		$this->product_id = $product_id;
		// image uploadok végrehajtása, új images kialakitása
		if ($result) {
			for ($i=0; $i<5; $i++) {
              if (file_exists($_FILES['img'.$i]['tmp_name']) & is_uploaded_file($_FILES['img'.$i]['tmp_name'])) {
				 $targetFile = 'media/com_ecommercewd/uploads/images/products/'.substr($product_id,0,2);
				 if (!is_dir($targetFile)) 
					 mkdir($targetFile,0777);
                 $fileExt = strtolower(pathinfo($_FILES['img'.$i]['name'], PATHINFO_EXTENSION));				 
				 if (($fileExt == 'jpg') | ($fileExt == 'png')) {
					 $targetFile .= '/'.$product_id.'_'.$_FILES['img'.$i]['name'];
					 if (file_exists($targetFile)) unlink($targetFile);
					 if (move_uploaded_file($_FILES['img'.$i]["tmp_name"], $targetFile))
						$origImages[$i] = $targetFile;
					 else {
						$this->setError(JTEXT::_('COM_ECOMMERCEWD_SAVE_ERROR_1'));
						$result = false;		
					 }	
				 } else {
		           $this->setError(JTEXT::_('COM_ECOMMERCEWD_ILLEGAL_FILE_EXTENSION').' fileExt='.$fileExt);
				   $result = false;
				 }
			  }
			}
			
				
			// rekord update, új images adat kitárolása az adatbázisba
			$images = array();
			foreach ($origImages as $image) {
				if ($image != '')
					$images[] = $image;
			}
			$table->images = JSON_encode($images);
			if ($table->store() == false) {
		        $this->setError(JTEXT::_('COM_ECOMMERCEWD_SAVE_ERROR_2'));
				$result = false;
			}
		} else {
			$this->setError(JTEXT::_('COM_ECOMMERCEWD_SAVE_ERROR_0'));
		}
		return $result;
	}
	
	/**
	  * szellemi termelés változat   utoljára tárolt rekord id elérése
	  * @param object
	  * @return boolean
	*/  
	public function getProduct_id() {
	  return $this->product_id;
	}
    ////////////////////////////////////////////////////////////////////////////////////////
    // Listeners                                                                          //
    ////////////////////////////////////////////////////////////////////////////////////////
}