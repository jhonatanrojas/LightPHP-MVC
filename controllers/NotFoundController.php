<?php
namespace controllers;

use core\Controller;


/**
 * It will be responsible for site's page not found behavior.
 */
class NotFoundController extends Controller 
{
    //-----------------------------------------------------------------------
    //        Methods
    //-----------------------------------------------------------------------
    /**
     * @Override
     */
	public function index()
	{
        // Keywords of home page
        $keywords = array('404', 'page-not-found');

        $params = array(
            'title' => '404 - Page not found',
            'description' => "",
            'keywords' => $keywords,
            'robots' => 'noindex'
        );

		$this->loadTemplate('404', $params);
	}
}
