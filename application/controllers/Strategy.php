<?php
defined('BASEPATH') OR exit('No direct script access allowed');
use CodeIgniter\Database\Query;


class Strategy extends CI_Controller {

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see https://codeigniter.com/user_guide/general/urls.html
	 */


    public function __construct()
    {  
		parent::__construct();
		$this->load->library('session'); 
    }

	public function index()
	{
		$strategy_id = $this->session->strategy_id;

	    $this->load->database();
	    
        $this->db->select('id, country');
		$this->db->where('strategy_id =', $strategy_id);
        $query = $this->db->get("stakeholders"); 
        $data['stakeholders'] = $query->result();
        
        $this->db->select('id, stakeholder_id, comment_citation_type, generic_comment, category');
		$this->db->where('strategy_id =', $strategy_id);
        $query = $this->db->get("stakeholder_comments"); 
        $stakeholder_comments = $query->result();
        
        // Now need to convert this to JSON
        $data['records'] = json_encode($stakeholder_comments);
       	$data['strategy_name'] = $this->session->strategy_name; 
	    $this->load->view('strategy_home',$data);
    
	}

	public function view()
	{
		$strategy_id = $this->session->strategy_id;

	    $this->load->database();

		$this->db->where('id =', $strategy_id);
		$query = $this->db->get("strategies"); 
		$strategies = $query->result();
		$data['strategies'] = $strategies;
	    
        $this->db->select('id, country');
		$this->db->where('strategy_id =', $strategy_id);
        $query = $this->db->get("stakeholders"); 
        $data['stakeholders'] = $query->result();
        
        $this->db->select('id, stakeholder_id, comment_citation_type, generic_comment, category');
		$this->db->where('strategy_id =', $strategy_id);
        $query = $this->db->get("stakeholder_comments"); 
        $stakeholder_comments = $query->result();
        
        // Now need to convert this to JSON
        $data['records'] = json_encode($stakeholder_comments);
       	$data['strategy_name'] = $this->session->strategy_name; 
	    $this->load->view('strategy_view',$data);
    
	}
		
	public function change_strategy()
	{
	    if (count($_GET) > 0) {
	        $new_strategy_id = $_GET['strategy_id'];
			$this->session->set_userdata('strategy_id',$new_strategy_id);

			$this->load->database();
			$this->db->where('id =', $new_strategy_id);
			$query = $this->db->get("strategies"); 
			$strategies = $query->result();
			$this->session->set_userdata('strategy_name',$strategies[0]->name);
		}

		$this->load->helper('url');
		redirect('strategy/view');
	}
	
	public function update()
	{
		$data['previous_update'] = array();
		$strategy_id = $this->session->strategy_id;
	    
	    if (count($_POST) > 0) {
	        
	        $comment = new stdClass();
	        
	        $comment->stakeholder_id = $_POST['stakeholder_id'];
	        $comment->date_of_comment = $_POST['date_of_comment'];
	        $comment->comment_citation_type = $_POST['comment_citation_type'];
	        $comment->comment_citation = $_POST['comment_citation'];
	        $comment->comment_citation_url = $_POST['comment_citation_url'];
	        $comment->raw_comment = $_POST['raw_comment'];
	        
	        $temp = explode("::",$_POST['generic_comment']);
			$comment->strategy_id = $strategy_id;	        
	        $comment->generic_comment = $temp[0];
	        $comment->category = $temp[1];

            $this->load->database();    
            $this->db->insert('ci_stakeholder_comments', $comment);
           	$data['previous_update']['stakeholder_id'] = $comment->stakeholder_id; 
           	$data['previous_update']['date_of_comment'] = $comment->date_of_comment; 
           	$data['previous_update']['comment_citation_type'] = $comment->comment_citation_type; 
           	$data['previous_update']['comment_citation'] = $comment->comment_citation; 
           	$data['previous_update']['comment_citation_url'] = $comment->comment_citation_url; 
	    } 
	    
	    
	    
	    $this->load->database();
	    
		$this->db->where('strategy_id =', $strategy_id);
        $query = $this->db->get("stakeholders"); 
        $data['stakeholders'] = $query->result();
        
        
		$this->db->where('strategy_id =', $strategy_id);
        $query = $this->db->get("stakeholder_comments"); 
        $stakeholder_comments = $query->result();
        
        // Now need to convert this to JSON
        $data['records'] = json_encode($stakeholder_comments);
       	$data['strategy_name'] = $this->session->strategy_name; 
        
	    $this->load->view('update',$data);
    
	}
}
