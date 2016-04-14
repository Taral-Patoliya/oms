<?php defined('BASEPATH') || exit('No direct script access allowed');

/**
 * Pending_tasks controller
 */
class Pending_tasks extends Front_Controller
{
    protected $permissionCreate = 'Pending_tasks.Pending_tasks.Create';
    protected $permissionDelete = 'Pending_tasks.Pending_tasks.Delete';
    protected $permissionEdit   = 'Pending_tasks.Pending_tasks.Edit';
    protected $permissionView   = 'Pending_tasks.Pending_tasks.View';

    /**
     * Constructor
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
        
        $this->load->model('pending_tasks/pending_tasks_model');
        $this->lang->load('pending_tasks');
        
            Assets::add_css('flick/jquery-ui-1.8.13.custom.css');
            Assets::add_js('jquery-ui-1.8.13.min.js');
            Assets::add_css('jquery-ui-timepicker.css');
            Assets::add_js('jquery-ui-timepicker-addon.js');
        

        Assets::add_module_js('pending_tasks', 'pending_tasks.js');
    }

    /**
     * Display a list of Pending Tasks data.
     *
     * @return void
     */
    public function index($offset = 0)
    {
        
        $pagerUriSegment = 3;
        $pagerBaseUrl = site_url('pending_tasks/index') . '/';
        
        $limit  = $this->settings_lib->item('site.list_limit') ?: 15;

        $this->load->library('pagination');
        $pager['base_url']    = $pagerBaseUrl;
        $pager['total_rows']  = $this->pending_tasks_model->count_all();
        $pager['per_page']    = $limit;
        $pager['uri_segment'] = $pagerUriSegment;

        $this->pagination->initialize($pager);
        $this->pending_tasks_model->limit($limit, $offset);
        
        $records = $this->pending_tasks_model->find_all();

        Template::set('records', $records);
        

        Template::render();
    }
    
}