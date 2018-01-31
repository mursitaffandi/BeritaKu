<?php
/**
* 
*/
class Main_model extends CI_Model
{
	
	public function __construct()
	{
		parent::__construct();
		date_default_timezone_set('Asia/Jakarta');
		$this->load->database();
	}
/*
* Model Timing Item Rss
*/

	public function latesTime($fn){
		$this->db->select('value_timing'); 
        $this->db->from('timing');   
        $this->db->where('function_name', $fn);
        $data = $this->db->get()->row_array();
        return $data['value_timing'];
	}

	public function UpdatelatesTime($fn, $freshTime){
        $this->db->where('function_name', $fn);
		$this->db->update('timing', array('value_timing' => $freshTime)); 
	}

/*
* End Model Timing Item Rss
*/

/*
* Model Insert Item Rss
*/

	public function insertItem($dataArray, $sumber, $category)
	{
		$dataItem = array(
				"source_item" => $sumber,
				"category_item" => $category,
				"title_item" => $dataArray['titleItem'],
				"link_item" => $dataArray['linkItem'],
				"pubDate_item" => $dataArray['pubDateItem'],
				"imageUrl_item" => $dataArray['imageItem']
			);

		$this->db->insert("news_item", $dataItem);
	}
/*
* End Model Insert Item Rss
*/

/*
* Model Get Item Rss Today
*/
   public function selectTodayItem($amount, $source, $category)
   {
        $this->db->where('source_item',$source);
        $this->db->where('category_item',$category);        	
   		$this->db->like('pubDate_item', date('Y-m-d'));
   		$this->db->order_by('pubDate_item', 'DESC');
        return $this->db->get('news_item', $amount)->result_array();
   }
/*
* End Model Get Item Rss Today
*/
   public function UpdImgOriBody($id , $oriImg, $bodyUpd)
   {
   	   $this->db->where("id_item", $id);
   	   $this->db->update("news_item", array("urlimage_ori" => $oriImg, "content_ori" => $bodyUpd));
   }

   public function GetOriLateNews($id)
   {
   	   $this->db->select("urlimage_ori , content_ori");
   	   $this->db->from("news_item");
   	   $this->db->where("id_item", $id);
   	   $data = $this->db->get()->result_array();
   	   return $data;
   }
} 
?>