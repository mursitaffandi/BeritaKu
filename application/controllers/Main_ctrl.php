
<?php
//Class untuk di panggil user-side
class Main_ctrl extends CI_Controller 
{
	public function __construct() 
	{
		parent::__construct();
		// http://edition.cnn.com/services/rss/
		date_default_timezone_set('Asia/Jakarta');
		$this->load->model('Main_model');
	}
/*
* For request List news item from RSS
*/

/*
* Strart Antara News
*/
	// Antara Update
	public function AdapterAtrUpd($par = 0)
	{
		$docAtrUpd = new DOMDocument();
		$docAtrUpd->load('http://www.antara.co.id/rss/news.xml');	
		
		if($par == 1 ){		
		    $objAtrUpd['berita'] = array();
		} else {			
		    $objAtrUpd = array();
		}	
		
		$itemAtrUpd = $docAtrUpd->getElementsByTagName('item');
		// getlast time from database
		$timingAtrUpd = new DateTime($this->Main_model->latesTime("AdapterAtrUpd"));
		$freshTime = 0;
		foreach ($itemAtrUpd as $itemProses) {
		 	$titlesAtrUpd = $itemProses->getElementsByTagName('title');
		 	$titleAtrUpd = $titlesAtrUpd->item(0)->nodeValue;
		 	
		 	$linksAtrUpd = $itemProses->getElementsByTagName('link');
		 	$linkAtrUpd = $linksAtrUpd->item(0)->nodeValue;
		 	
		 	$datesAtrUpd = $itemProses->getElementsByTagName('pubDate');		 	
		 	$dateAtrUpd = $datesAtrUpd->item(0)->nodeValue;
		 	//description pengambil gambar	
		 	$descriptionsAtrUpd = $itemProses->getElementsByTagName('description');		 	
		 	$descriptionAtrUpd = $descriptionsAtrUpd->item(0)->nodeValue;
		 	
		 	if (substr($descriptionAtrUpd,1,3) == 'img'){
				$s = explode("\"",$descriptionAtrUpd);
				$t = explode("\"",$s[1]);
			} 
			else {
				$t[0] = base_url('/assets/image/images.jpg');
			}

			/*
		 	* String published convert to time
		 	* for comparing 
		 	* for well format
		 	* conditioning fresh item berita
		 	*/
		 	$datetimeAntr = strtotime($dateAtrUpd);
		 	$formatDateTime = date('Y-m-d H:m:s', $datetimeAntr);
		 	// baru
		 	$dRSS = new DateTime($formatDateTime);
			
		 	if ($dRSS > $timingAtrUpd) {
			 	$dataAtrUpd['titleItem'] = $titleAtrUpd;
			 	$dataAtrUpd['linkItem'] = $linkAtrUpd;
			 	$dataAtrUpd['pubDateItem'] = $formatDateTime;
			 	$dataAtrUpd['imageItem'] =$t[0];
				// to database
			 	$this->Main_model->insertItem($dataAtrUpd, "Antara", "Update");
			 	// update freshTime
			 	$freshTime1 = $formatDateTime;
			 	if($freshTime < $freshTime1){
			 		$freshTime = $formatDateTime;
			 	}
		 	}
		 }
		 if ($freshTime != 0) {
		 	$this->Main_model->UpdatelatesTime('AdapterAtrUpd', $freshTime);
		 }

		 /*echo json_encode($this->Main_model->selectTodayItem($_GET['amount'],$_GET['source'],$_GET['category']));*/
        $data = $this->Main_model->selectTodayItem('40','Antara','Update');
		$objAtrUpd['berita'] = $data;
		if (count($data) >= 1) {
			$objAtrUpd['success'] = true;
		} else {
			$objAtrUpd['success'] = false;
		}
        echo json_encode($objAtrUpd);
	}

	// Antara Internasional
	public function AdapterAtrInt($par = 0)
	{
		$docAtrUpd = new DOMDocument();
		$docAtrUpd->load('http://www.antaranews.com/rss/internasional');	
		
		if($par == 1 ){		
		    $objAtrUpd['berita'] = array();
		} else {			
		    $objAtrUpd = array();
		}	
		
		$itemAtrUpd = $docAtrUpd->getElementsByTagName('item');
		// getlast time from database
		$timingAtrUpd = new DateTime($this->Main_model->latesTime("AdapterAtrInt"));
		$freshTime = 0;
		foreach ($itemAtrUpd as $itemProses) {
		 	$titlesAtrUpd = $itemProses->getElementsByTagName('title');
		 	$titleAtrUpd = $titlesAtrUpd->item(0)->nodeValue;
		 	
		 	$linksAtrUpd = $itemProses->getElementsByTagName('link');
		 	$linkAtrUpd = $linksAtrUpd->item(0)->nodeValue;
		 	
		 	$datesAtrUpd = $itemProses->getElementsByTagName('pubDate');		 	
		 	$dateAtrUpd = $datesAtrUpd->item(0)->nodeValue;
		 	//description pengambil gambar	
		 	$descriptionsAtrUpd = $itemProses->getElementsByTagName('description');		 	
		 	$descriptionAtrUpd = $descriptionsAtrUpd->item(0)->nodeValue;
		 	
		 	if (substr($descriptionAtrUpd,1,3) == 'img'){
				$s = explode("\"",$descriptionAtrUpd);
				$t = explode("\"",$s[1]);
			} 
			else {
				$t[0] = base_url('/assets/image/images.jpg');
			}

			/*
		 	* String published convert to time
		 	* for comparing 
		 	* for well format
		 	* conditioning fresh item berita
		 	*/
		 	$datetimeAntr = strtotime($dateAtrUpd);
		 	$formatDateTime = date('Y-m-d H:m:s', $datetimeAntr);
		 	// baru
		 	$dRSS = new DateTime($formatDateTime);
			
		 	if ($dRSS > $timingAtrUpd) {
			 	$dataAtrUpd['titleItem'] = $titleAtrUpd;
			 	$dataAtrUpd['linkItem'] = $linkAtrUpd;
			 	$dataAtrUpd['pubDateItem'] = $formatDateTime;
			 	$dataAtrUpd['imageItem'] =$t[0];
				// to database
			 	$this->Main_model->insertItem($dataAtrUpd, "Antara", "Internasional");
			 	// update freshTime
			 	$freshTime1 = $formatDateTime;
			 	if($freshTime < $freshTime1){
			 		$freshTime = $formatDateTime;
			 	}
		 	}
		 }
		 if ($freshTime != 0) {
		 	$this->Main_model->UpdatelatesTime('AdapterAtrInt', $freshTime);
		 }

		 /*echo json_encode($this->Main_model->selectTodayItem($_GET['amount'],$_GET['source'],$_GET['category']));*/
        $data = $this->Main_model->selectTodayItem('40','Antara','Internasional');
		$objAtrUpd['berita'] = $data;
		if (count($data) >= 1) {
			$objAtrUpd['success'] = true;
		} else {
			$objAtrUpd['success'] = false;
		}
        echo json_encode($objAtrUpd);
	}

	// Antara Hukum
	public function AdapterAtrHkm($par = 0)
	{
		$docAtrUpd = new DOMDocument();
		$docAtrUpd->load('http://www.antaranews.com/rss/nasional-hukum');	
		
		if($par == 1 ){		
		    $objAtrUpd['berita'] = array();
		} else {			
		    $objAtrUpd = array();
		}	
		
		$itemAtrUpd = $docAtrUpd->getElementsByTagName('item');
		// getlast time from database
		$timingAtrUpd = new DateTime($this->Main_model->latesTime("AdapterAtrHkm"));
		$freshTime = 0;
		foreach ($itemAtrUpd as $itemProses) {
		 	$titlesAtrUpd = $itemProses->getElementsByTagName('title');
		 	$titleAtrUpd = $titlesAtrUpd->item(0)->nodeValue;
		 	
		 	$linksAtrUpd = $itemProses->getElementsByTagName('link');
		 	$linkAtrUpd = $linksAtrUpd->item(0)->nodeValue;
		 	
		 	$datesAtrUpd = $itemProses->getElementsByTagName('pubDate');		 	
		 	$dateAtrUpd = $datesAtrUpd->item(0)->nodeValue;
		 	//description pengambil gambar	
		 	$descriptionsAtrUpd = $itemProses->getElementsByTagName('description');		 	
		 	$descriptionAtrUpd = $descriptionsAtrUpd->item(0)->nodeValue;
		 	
		 	if (substr($descriptionAtrUpd,1,3) == 'img'){
				$s = explode("\"",$descriptionAtrUpd);
				$t = explode("\"",$s[1]);
			} 
			else {
				$t[0] = base_url('/assets/image/images.jpg');
			}

			/*
		 	* String published convert to time
		 	* for comparing 
		 	* for well format
		 	* conditioning fresh item berita
		 	*/
		 	$datetimeAntr = strtotime($dateAtrUpd);
		 	$formatDateTime = date('Y-m-d H:m:s', $datetimeAntr);
		 	// baru
		 	$dRSS = new DateTime($formatDateTime);
			
		 	if ($dRSS > $timingAtrUpd) {
			 	$dataAtrUpd['titleItem'] = $titleAtrUpd;
			 	$dataAtrUpd['linkItem'] = $linkAtrUpd;
			 	$dataAtrUpd['pubDateItem'] = $formatDateTime;
			 	$dataAtrUpd['imageItem'] =$t[0];
				// to database
			 	$this->Main_model->insertItem($dataAtrUpd, "Antara", "Hukum");
			 	// update freshTime
			 	$freshTime1 = $formatDateTime;
			 	if($freshTime < $freshTime1){
			 		$freshTime = $formatDateTime;
			 	}
		 	}
		 }
		 if ($freshTime != 0) {
		 	$this->Main_model->UpdatelatesTime('AdapterAtrHkm', $freshTime);
		 }

		 /*echo json_encode($this->Main_model->selectTodayItem($_GET['amount'],$_GET['source'],$_GET['category']));*/
        $data = $this->Main_model->selectTodayItem('40','Antara','Hukum');
		$objAtrUpd['berita'] = $data;
		if (count($data) >= 1) {
			$objAtrUpd['success'] = true;
		} else {
			$objAtrUpd['success'] = false;
		}
        echo json_encode($objAtrUpd);
	}

/*
* End Antara News
*/
	public function AdapterDetUpd($par = 0)
	{
		$docDetUpd = new DOMDocument();
		$docDetUpd->load('http://rss.detik.com/index.php/detikcom');		
		
		if($par ==1){		
		$objDetUpd['berita'] = array();
		} else {			
		$objDetUpd = array();
		}
		
		$itemDetUpd = $docDetUpd->getElementsByTagName('item');
		
		$i = 0;
		 foreach ($itemDetUpd as $itemProses) {
		 	$titlesDetUpd = $itemProses->getElementsByTagName('title');
		 	$titleDetUpd = $titlesDetUpd->item(0)->nodeValue;
		 	
		 	$linksDetUpd = $itemProses->getElementsByTagName('link');
		 	$linkDetUpd = $linksDetUpd->item(0)->nodeValue;
		 	
		 	$datesDetUpd = $itemProses->getElementsByTagName('pubDate');		 	
		 	$dateDetUpd = $datesDetUpd->item(0)->nodeValue;
		 			 	
		 	//enclosure	pengambil gambar	 	
		 	$descriptionsDetUpd = $itemProses->getElementsByTagName('enclosure');		 	
		 	if ($descriptionsDetUpd) {
		 		$descriptionDetUpd = $descriptionsDetUpd->item(0)->getAttribute('url');
		 	} else {
		 		$descriptionDetUpd = base_url('/index.php');
		 	}
		 	
		 	/*
		 	* String published convert to time
		 	* for comparing 
		 	* for well format
		 	*/
		 	$datetimeDetik = strtotime($dateDetUpd);
		 	// baru
            $formatDateTime = date('Y-M-d H:m:s', $datetimeDetik);
		 			 	
		 	$dataDetUpd['id'] =$i;
		 	$dataDetUpd['source'] ="Detik";
		 	$dataDetUpd['category'] ="Terbaru";
		 	$dataDetUpd['title'] =$titleDetUpd;
		 	$dataDetUpd['link'] =$linkDetUpd;
		 	$dataDetUpd['PubDate'] =$formatDateTime;
		 	$dataDetUpd['img'] =$descriptionDetUpd;

			if($par ==1){		
			array_push($objDetUpd['berita'], $dataDetUpd);
			} else {			
			array_push($objDetUpd, $dataDetUpd);
			} 
			$i++;		 	
		 }		
		 
		if($par == 1){		
			$objDetUpd['success']=true;
		echo json_encode($objDetUpd); 
		} else {			
			return $objDetUpd;
		} 
	}	
	
	public function AdapterBBCUpd($par = 0)
	{
		$docBBCUpd = new DOMDocument();
		$docBBCUpd->load('http://www.bbc.com/indonesia/index.xml');		
		
		if($par ==1){		
			$objBBCUpd['berita'] = array();
		} else {			
			$objBBCUpd = array();
		}
		$itemBBCUpd = $docBBCUpd->getElementsByTagName('entry');
		
		$i = 0;
		 foreach ($itemBBCUpd as $itemProses) {
		 	$titlesBBCUpd = $itemProses->getElementsByTagName('title');
		 	$titleBBCUpd = $titlesBBCUpd->item(0)->nodeValue;
		 	
		 	$linksBBCUpd = $itemProses->getElementsByTagName('link');
		 	$linkBBCUpd = $linksBBCUpd->item(0)->getAttribute('href');
		 	
		 	$datesBBCUpd = $itemProses->getElementsByTagName('published');	 	
		 	$dateBBCUpd = $datesBBCUpd->item(0)->nodeValue;
		 			 	
		 	$dataBBCUpd['id'] =$i;
		 	$dataBBCUpd['source'] ="BBC";
		 	$dataBBCUpd['category'] ="Terbaru";
		 	$dataBBCUpd['title'] =$titleBBCUpd;
		 	$dataBBCUpd['link'] =$linkBBCUpd;
		 	/*
		 	* String published convert to time
		 	* for comparing 
		 	* for well format
		 	*/
		 	$datetimeBBC = strtotime($dateBBCUpd);
		 	// baru
            $formatDateTime = date('Y-M-d H:m:s', $datetimeBBC);

		 	$dataBBCUpd['PubDate'] =$formatDateTime;
		 	$dataBBCUpd['img'] =base_url('/assets/image/images.jpg');

			if($par ==1){		
			    array_push($objBBCUpd['berita'], $dataBBCUpd);
			} else {			
			    array_push($objBBCUpd, $dataBBCUpd);
			} 
			$i++;		 	
		 }		
		 
		if($par == 1){		
		    $objBBCUpd['success']=true;
		    echo json_encode($objBBCUpd); 
		} else {			
		    return $objBBCUpd;
		}	
	}
/*
* End request List news item from RSS
*/

/*
* For request detail news
*/

	// Antara Update
	public function DetailAtrUpd()
	{
		if (isset($_GET['url']) && isset($_GET['id'])) {
			$link = $_GET['url'];
			$id = $_GET['id'];
		    $imageOri = $this->UrlOriAtrUpd($link);
		    $bodyAtr = $this->bodyAtrUpd($link);

		   // $this->Main_model->UpdImgOriBody($id, $imageOri, $bodyAtr);
		   // $latesAtrUpd = $this->Main_model->GetOriLateNews($id);
		    $data = array();
		    $data["success"] = true;
		    $data["detail_ori"] = $latesAtrUpd;
		    echo json_encode($data);
		}
	}
    
    public function UrlOriAtrUpd($url)
    {
		$html = file_get_html($url);  
		// $html->find('div[id=Content_news]');
		preg_match_all('~<img.*?src=["\']+(.*?)["\']+~', $html, $urls);
		$urls=$urls[1];
		return $urls[1];
    }

    public function bodyAtrUpd($url)
    {
    	$html = file_get_html($_GET['url']);
		$contn = $html->find('div#content_news');
		foreach ($contn as $e) {
			$del = $e->innertext;
		}
		return $del;
	}
}
?>