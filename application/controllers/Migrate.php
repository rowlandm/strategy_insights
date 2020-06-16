<?php
defined('BASEPATH') OR exit('No direct script access allowed');
use CodeIgniter\Database\Query;
class Migrate extends CI_Controller {


	public function migrate_from_json_to_SQL()
	{
	 
	    if (count($_POST) > 0) {
	        
	        $original_json = json_decode($_POST['original_json']);
	        
	        
	        foreach ($original_json as &$comment) {
                
            
                $this->load->database();    
                $comment->stakeholder_id =  $comment->{'uid'};
                unset($comment->uid);
                $this->db->insert('ci_stakeholder_comments', $comment);
                
            }
	        
	    } 
	    
	    
	    $this->load->database();
	    $query = $this->db->get("ci_json_data"); 
        $data['records'] = $query->result();
        
        $query = $this->db->get("stakeholders"); 
        $data['stakeholders'] = $query->result();
        
        
	    $this->load->view('migrate_from_json_to_SQL',$data);
    
	}
	
	
	
		public function previous_index()
	{
	 
	    $this->load->database();
	    
        $this->db->select('id, country');
        $query = $this->db->get("stakeholders"); 
        $data['stakeholders'] = $query->result();
        
        $this->db->select('id, stakeholder_id, generic_comment, category');
        $query = $this->db->get("stakeholder_comments"); 
        $stakeholder_comments = $query->result();
        
        // Now need to convert this to JSON
        $data['records'] = json_encode($stakeholder_comments);
        
	    $this->load->view('welcome',$data);
    
	}
}
