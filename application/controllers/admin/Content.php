<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Bonfire
 *
 * An open source project to allow developers get a jumpstart their development of CodeIgniter applications
 *
 * @package   Bonfire
 * @author    Bonfire Dev Team
 * @copyright Copyright (c) 2011 - 2013, Bonfire Dev Team
 * @license   http://guides.cibonfire.com/license.html
 * @link      http://cibonfire.com
 * @since     Version 1.0
 * @filesource
 */

// ------------------------------------------------------------------------

/**
 * Content context controller
 *
 * The controller which displays the homepage of the Content context in Bonfire site.
 *
 * @package    Bonfire
 * @subpackage Controllers
 * @category   Controllers
 * @author     Bonfire Dev Team
 * @link       http://guides.cibonfire.com/helpers/file_helpers.html
 *
 */
class Content extends Admin_Controller
{

	protected $permissionCreate = 'Pending_tasks.Content.Create';
    protected $permissionDelete = 'Pending_tasks.Content.Delete';
    protected $permissionEdit   = 'Pending_tasks.Content.Edit';
    protected $permissionView   = 'Pending_tasks.Content.View';


	/**
	 * Controller constructor sets the Title and Permissions
	 *
	 */
	public function __construct()
	{
		parent::__construct();

		Template::set('toolbar_title', 'Content');

		$this->auth->restrict('Site.Content.View');
	}//end __construct()

	//--------------------------------------------------------------------

	/**
	 * Displays the initial page of the Content context
	 *
	 * @return void
	 */
	public function index()
	{
		parent::__construct();
        
        $this->auth->restrict($this->permissionView);
        $this->load->model('pending_tasks/pending_tasks_model');
        //$this->lang->load('pending_tasks');
        
	    Assets::add_css('flick/jquery-ui-1.8.13.custom.css');
	    Assets::add_js('jquery-ui-1.8.13.min.js');
	    Assets::add_css('jquery-ui-timepicker.css');
	    Assets::add_js('jquery-ui-timepicker-addon.js');
	    $this->form_validation->set_error_delimiters("<span class='error'>", "</span>");
        Assets::add_module_js('pending_tasks', 'pending_tasks.js');

        Template::set_view('pending_tasks/content/index');

		Template::set_view('admin/content/index');
		Template::render();
	}//end index()

	//--------------------------------------------------------------------


}//end class