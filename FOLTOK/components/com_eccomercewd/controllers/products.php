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
 *   a hotzá tartozó megrendeléseket, regisztrált userek termékeket vihetnek
 *   fel a front-end oldalon 
 **/
defined('_JEXEC') || die('Access Denied');


class EcommercewdControllerProducts extends EcommercewdController {
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
    public function displayproducts() {
        parent::display();
    }

    public function displayproduct() {
        parent::display();
    }

    public function displayproductreviews() {
        $model_options = WDFHelper::get_model('options');
        $options = $model_options->get_options();

        if ($options->feedback_enable_product_reviews == 0) {
            $product_id = WDFInput::get('product_id', 0, 'int');

            WDFHelper::redirect('products', 'displayproduct&product_id=' . $product_id);
        }

        parent::display();
    }

    public function displaycompareproducts() {
        parent::display();
    }

    public function save_product_review() {
        $app = JFactory::getApplication();

        $model_options = WDFHelper::get_model('options');
        $options = $model_options->get_options();

        // check is guest feedback enabled
        if (($options->feedback_enable_guest_feedback != 0) || (WDFHelper::is_user_logged_in() == true)) {
            $j_user = JFactory::getUser();

            $feedback_published = $options->feedback_publish_review_when_added == 1 ? 1 : 0;

            $product_id = WDFInput::get('product_id', 0, 'int');

            $feedback_user_name =  ($j_user)?  $j_user->name : '';
            $feedback_sender_name = WDFInput::get('user_name');
            $feedback_text = JRequest::getVar( 'review_text', '','post', 'string', JREQUEST_ALLOWRAW );;
		
            if (( $feedback_sender_name == '') || ($feedback_text == '')) {
                $app->enqueueMessage(WDFText::get('MSG_FAILED_TO_SUBMIT_REVIEW'), 'error');
            } else {
                $row_feedback = WDFDb::get_table_instance('feedback');
                $row_feedback->j_user_id = $j_user->id;
                $row_feedback->user_ip_address = WDFUtils::get_client_ip_address();
                $row_feedback->user_name = $feedback_user_name;
                $row_feedback->sender_name = $feedback_sender_name;
                $row_feedback->product_id = $product_id;
                $row_feedback->date = date('Y-m-d H:i:s');
                $row_feedback->text = $feedback_text;
                $row_feedback->published = $feedback_published;
                if ($row_feedback->store() == false) {
                    $app->enqueueMessage(WDFText::get('MSG_FAILED_TO_SUBMIT_REVIEW'), 'error');
                } else {
                    $msg = $feedback_published == true ? WDFText::get('MSG_REVIEW_PUBLISHED') : WDFText::get('MSG_REVIEW_SUBMITTED');
                    $this->sent_review_notification_email($product_id);
					$app->enqueueMessage($msg, 'message');
                }
            }			
        }

        WDFHelper::redirect('products', 'displayproductreviews&product_id=' . $product_id);
    }

    public function ajax_getquickviewproductrow() {
        WDFInput::set('tmpl', 'component');

        $model = WDFHelper::get_model('products');
        $product_row = $model->get_quick_view_product_row();
        if ($product_row === false) {
            $product_row = null;
        }

        echo WDFJson::encode($product_row);
        die();
    }

    public function ajax_rate_product() {
        WDFInput::set('tmpl', 'component');

        $model_options = WDFHelper::get_model('options');
        $options = $model_options->get_options();

        $db = JFactory::getDbo();
        $query = $db->getQuery(true);

        $j_user = JFactory::getUser();
        $product_id = WDFInput::get('product_id', 0, 'int');
		
		$rating_data =WDFJson::decode(stripslashes(WDFInput::get('rating_data_json')));
        $rating = (float)$rating_data->rating;

        // check privileges
        $can_rate = true;
        if (($options->feedback_enable_guest_feedback == 0) && (WDFHelper::is_user_logged_in() == false)) {
            $can_rate = false;
            $msg = WDFText::get('MSG_LOG_IN_TO_RATE');
        } else {
            $query->clear();
            $query->select('id');
            $query->from('#__ecommercewd_ratings');
            if (WDFHelper::is_user_logged_in() == true) {
                $query->where('j_user_id = ' . $j_user->id);
            } else {
				$query->where('user_ip_address = ' . $db->quote(WDFUtils::get_client_ip_address()));
            }
            $query->where('product_id = ' . $product_id);
            $db->setQuery($query);
            $rating_rows = $db->loadObjectList();

            if ($db->getErrorNum()) {
                $can_rate = false;
                $msg = WDFText::get('MSG_FAILED_TO_RATE') ;
            }

            if (($rating_rows != null) && (count($rating_rows) > 0)) {
                $can_rate = false;
                $msg =  WDFText::get('MSG_YOU_HAVE_ALREADY_RATED_THIS_PRODUCT') ;
            }
        }
        if ($can_rate == true) {
            // save rating
            $query->clear();
            $query->insert('#__ecommercewd_ratings (j_user_id, user_ip_address, product_id, rating,`date`)');
            $query_values = array();
            $query_values[] = $db->quote($j_user->id);
            $query_values[] = $db->quote(WDFUtils::get_client_ip_address());
            $query_values[] = $db->quote($product_id);
            $query_values[] = $db->quote($rating);
            $query_values[] = 'NOW()';
            $query->values(implode(',', $query_values));
            $db->setQuery($query);
            $db->query();

            if ($db->getErrorNum()) {
                $msg =  WDFText::get('MSG_FAILED_TO_RATE') ;
            } else {
                $msg = WDFText::get('MSG_SUCCESSFULLY_RATED') ;
            }
        }
        // get average rating
        $query->clear();
        $query->select('FORMAT(AVG(rating), 1)');
        $query->from('#__ecommercewd_ratings');
        $query->where('product_id = ' . $product_id);
        $db->setQuery($query);
        $average_rating = $db->loadResult();
        if ($db->getErrorNum()) {
            $msg = $db->getErrorMsg();
        }

        // return data
        $data = array();
        $data['msg'] = $msg;
        $data['rating'] = $average_rating;
        echo WDFJson::encode($data);
        die();
    }

    public function ajax_getproductreviews() {
        WDFInput::set('tmpl', 'component');

        $model = WDFHelper::get_model('products');
        $reviews_data = $model->get_product_reviews_data();

        echo WDFJson::encode($reviews_data);
        die();
    }

    public function ajax_getcompareproductrow() {
        WDFInput::set('tmpl', 'component');

        $model = WDFHelper::get_model('products');
        $product_row = $model->get_product_view_product_row();

        echo WDFJson::encode($product_row);
        die();
    }


    ////////////////////////////////////////////////////////////////////////////////////////
    // Getters & Setters                                                                  //
    ////////////////////////////////////////////////////////////////////////////////////////
    ////////////////////////////////////////////////////////////////////////////////////////
    // Private Methods                                                                    //
    ////////////////////////////////////////////////////////////////////////////////////////
	private function sent_review_notification_email($product_id){
	
	    $app = JFactory::getApplication();

        $joomla_config = JFactory::getConfig();

        $db = JFactory::getDbo();
        $query = $db->getQuery(true);

        $model_options = WDFHelper::get_model('options');
        $options = $model_options->get_options();

        // get admin email
        $admin_email = $options->registration_administrator_email;
		
		//get product row
		$product_row = WDFHelper::get_model()->get_product_view_product_row($product_id);
		
        // mail data
        $mail_data = array();
        $mail_data['mailfrom'] = JMailHelper::isEmailAddress($admin_email) == true ? $admin_email : $joomla_config->get('mailfrom');
        $mail_data['sitename'] = $joomla_config->get('sitename');
		
        $mail_data['subject'] = WDFText::get('EMAIL_REVIEW_NOTIFICATION_TO_ADMIN');
        $mail_data['body'] = WDFText::get('EMAIL_REVIEW_NOTIFICATION_TO_ADMIN_BODY', $product_row->name, $mail_data['sitename'] );

        //send mail to admins

        $query->clear();
        $query->select('name');
        $query->select('email');
        $query->select('sendEmail');
        $query->from('#__users');
        $query->where('sendEmail = 1');
        $db->setQuery($query);
        $admin_rows = $db->loadObjectList();

        foreach ($admin_rows as $admin_row) {
            WDFMail::send_mail($mail_data['mailfrom'], $admin_row->email, $mail_data['subject'], $mail_data['body'], true);
        }
	}
	
	/**
	  * szellemi termelés változat
	  * front end product felvivő képernyő
	  * JRequest category_id, Itemid
	*/  
	public function add() {
		$user = JFactory::getUser();
		$model = $this->getModel('products');
		// $item = $model->getItem(0);
		$item = new stdClass();
		$item->id = 0;
		$item->images = '[]';
		$item->model = $user->username;
		if (JRequest::getVar('jform') != '')
		   $item = $model->bind(JRequest::getVar('jform'));
		$view = $this->getView('products','html');
		$view->set('Title',JText::_('COM_ECOMMERCEWD_NEW_PRODUCT'));
		$view->set('Item',$item);
		$view->set('saveTask','save');
		$view->set('cancelTask','cancel');
		$view->setLayout('form');
		$view->display();
	}
	
	/**
	  * szellemi termelés változat
	  * front end product módosító képernyő
	  * JRequest category_id, product_id, Itemid
	*/  
	public function edit() {
		$model = $this->getModel('products');
		// $item = $model->getItem(JRequest::getVar('product_id'));
		$item = $model->get_product_view_product_row(JRequest::getVar('product_id'));
		if (JRequest::getVar('jform') != '')
  		   $item = $model->bind(JRequest::getVar('jform'));
		$view = $this->getView('products','html');
		$view->set('Title',JText::_('COM_ECOMMERCEWD_EDIT_PRODUCT'));
		$view->set('Item',$item);
		$view->set('saveTask','save');
		$view->set('cancelTask','cancel');
		$view->setLayout('form');
		$view->display();
	}
	
	/**
	  * szellemi termelés változat
	  * front end product orders képernyő
	  * JRequest category_id
	*/  
	public function orders() {
		echo 'add product orders product_id='.JRequest::getVar('product_id');
	}
	
	/**
	  * szellemi termelés változat
	  * front end product save
	  * JRequest [category_id], jform fields
	*/  
	public function save() {
		$model = $this->getModel('products');
		$item = $model->bind(JRequest::getVar('jform'));
		if ($model->check($item)) {
			if ($model->save($item)) {
				$url = 'index.php?option=com_ecommercewd&controller=products&task=displayproduct'.
					   '&product_id='.$model->getProduct_id().
					   '&Itemid='.JRequest::getVar('Itemid');
				$this->setMessage(JText::_('COM_ECOMMERCEWD_PRODUCT_SAVED'));		
				$this->setRedirect($url);
				$this->redirect();
			} else {
			  echo '<div class="errorMsg">'.$model->getError().'</div>';
			  exit();	
			}
		} else {
			echo '<div class="errorMsg">'.$model->getError().'</div>';
			if (($item->id <= 0) | ($item->id == ''))
			  $this->add();
		    else
			  $this->edit();	
		}
	}
	
    ////////////////////////////////////////////////////////////////////////////////////////
    // Listeners                                                                          //
    ////////////////////////////////////////////////////////////////////////////////////////
}