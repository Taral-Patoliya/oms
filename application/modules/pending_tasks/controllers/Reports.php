<?php defined('BASEPATH') || exit('No direct script access allowed');

/**
 * Reports controller
 */
class Reports extends Admin_Controller
{
    protected $permissionCreate = 'Pending_tasks.Reports.Create';
    protected $permissionDelete = 'Pending_tasks.Reports.Delete';
    protected $permissionEdit   = 'Pending_tasks.Reports.Edit';
    protected $permissionView   = 'Pending_tasks.Reports.View';

    /**
     * Constructor
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
        
        $this->auth->restrict($this->permissionView);
        $this->load->model('pending_tasks/pending_tasks_model');
        $this->lang->load('pending_tasks');
        
            Assets::add_css('flick/jquery-ui-1.8.13.custom.css');
            Assets::add_js('jquery-ui-1.8.13.min.js');
            Assets::add_css('jquery-ui-timepicker.css');
            Assets::add_js('jquery-ui-timepicker-addon.js');
            $this->form_validation->set_error_delimiters("<span class='error'>", "</span>");
        
        Template::set_block('sub_nav', 'reports/_sub_nav');

        Assets::add_module_js('pending_tasks', 'pending_tasks.js');
    }

    /**
     * Display a list of Pending Tasks data.
     *
     * @return void
     */
    public function index($offset = 0)
    {
        // Deleting anything?
        if (isset($_POST['delete'])) {
            $this->auth->restrict($this->permissionDelete);
            $checked = $this->input->post('checked');
            if (is_array($checked) && count($checked)) {

                // If any of the deletions fail, set the result to false, so
                // failure message is set if any of the attempts fail, not just
                // the last attempt

                $result = true;
                foreach ($checked as $pid) {
                    $deleted = $this->pending_tasks_model->delete($pid);
                    if ($deleted == false) {
                        $result = false;
                    }
                }
                if ($result) {
                    Template::set_message(count($checked) . ' ' . lang('pending_tasks_delete_success'), 'success');
                } else {
                    Template::set_message(lang('pending_tasks_delete_failure') . $this->pending_tasks_model->error, 'error');
                }
            }
        }
        $pagerUriSegment = 5;
        $pagerBaseUrl = site_url(SITE_AREA . '/reports/pending_tasks/index') . '/';
        
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
        
    Template::set('toolbar_title', lang('pending_tasks_manage'));

        Template::render();
    }
    
    /**
     * Create a Pending Tasks object.
     *
     * @return void
     */
    public function create()
    {
        $this->auth->restrict($this->permissionCreate);
        
        if (isset($_POST['save'])) {
            if ($insert_id = $this->save_pending_tasks()) {
                log_activity($this->auth->user_id(), lang('pending_tasks_act_create_record') . ': ' . $insert_id . ' : ' . $this->input->ip_address(), 'pending_tasks');
                Template::set_message(lang('pending_tasks_create_success'), 'success');

                redirect(SITE_AREA . '/reports/pending_tasks');
            }

            // Not validation error
            if ( ! empty($this->pending_tasks_model->error)) {
                Template::set_message(lang('pending_tasks_create_failure') . $this->pending_tasks_model->error, 'error');
            }
        }

        Template::set('toolbar_title', lang('pending_tasks_action_create'));

        Template::render();
    }
    /**
     * Allows editing of Pending Tasks data.
     *
     * @return void
     */
    public function edit()
    {
        $id = $this->uri->segment(5);
        if (empty($id)) {
            Template::set_message(lang('pending_tasks_invalid_id'), 'error');

            redirect(SITE_AREA . '/reports/pending_tasks');
        }
        
        if (isset($_POST['save'])) {
            $this->auth->restrict($this->permissionEdit);

            if ($this->save_pending_tasks('update', $id)) {
                log_activity($this->auth->user_id(), lang('pending_tasks_act_edit_record') . ': ' . $id . ' : ' . $this->input->ip_address(), 'pending_tasks');
                Template::set_message(lang('pending_tasks_edit_success'), 'success');
                redirect(SITE_AREA . '/reports/pending_tasks');
            }

            // Not validation error
            if ( ! empty($this->pending_tasks_model->error)) {
                Template::set_message(lang('pending_tasks_edit_failure') . $this->pending_tasks_model->error, 'error');
            }
        }
        
        elseif (isset($_POST['delete'])) {
            $this->auth->restrict($this->permissionDelete);

            if ($this->pending_tasks_model->delete($id)) {
                log_activity($this->auth->user_id(), lang('pending_tasks_act_delete_record') . ': ' . $id . ' : ' . $this->input->ip_address(), 'pending_tasks');
                Template::set_message(lang('pending_tasks_delete_success'), 'success');

                redirect(SITE_AREA . '/reports/pending_tasks');
            }

            Template::set_message(lang('pending_tasks_delete_failure') . $this->pending_tasks_model->error, 'error');
        }
        
        Template::set('pending_tasks', $this->pending_tasks_model->find($id));

        Template::set('toolbar_title', lang('pending_tasks_edit_heading'));
        Template::render();
    }

    //--------------------------------------------------------------------------
    // !PRIVATE METHODS
    //--------------------------------------------------------------------------

    /**
     * Save the data.
     *
     * @param string $type Either 'insert' or 'update'.
     * @param int    $id   The ID of the record to update, ignored on inserts.
     *
     * @return boolean|integer An ID for successful inserts, true for successful
     * updates, else false.
     */
    private function save_pending_tasks($type = 'insert', $id = 0)
    {
        if ($type == 'update') {
            $_POST['id'] = $id;
        }

        // Validate the data
        $this->form_validation->set_rules($this->pending_tasks_model->get_validation_rules());
        if ($this->form_validation->run() === false) {
            return false;
        }

        // Make sure we only pass in the fields we want
        
        $data = $this->pending_tasks_model->prep_data($this->input->post());

        // Additional handling for default values should be added below,
        // or in the model's prep_data() method
        
		$data['created_on']	= $this->input->post('created_on') ? $this->input->post('created_on') : '0000-00-00 00:00:00';

        $return = false;
        if ($type == 'insert') {
            $id = $this->pending_tasks_model->insert($data);

            if (is_numeric($id)) {
                $return = $id;
            }
        } elseif ($type == 'update') {
            $return = $this->pending_tasks_model->update($id, $data);
        }

        return $return;
    }
}