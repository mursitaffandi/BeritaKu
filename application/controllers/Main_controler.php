<?php 
/**
* Class untuk dipanggil user-side
*/
class Main_controler extends CI_Controller 
{
	
	public function __construct()
	{
		parent::__construct();
	}

	public function AdapterAtrUpd($par = 0)
	{
		$docAtrUpd = new DOMDocument();
		$docAtrUpd->load('http://www.antara.co.id/rss/news.xml');
		if ($par == 1) {
			$objAtrUpd['berita'] = array();
		} else {
			$objAtrUpd = array();
		}

		$itemAtrUpd = $docAtrUpd->getElementsByTagName('item');

		$i = 0;
		foreach ($itemAtrUpd as $itemProses) {
			$titlesAtrUpd = $itemProses->getElementsByTagName('title');
			$titleAtrUpd = $titlesAtrUpd->item(0)->nodeValue;

			$linksAtrUpd = $itemProses->getElementsByTagName('link');
			$linkAtrUpd = $linksAtrUpd->item(0)->nodeValue;

			$detesAtrUpd = $itemProses->getElementsByTagName('pubDate');
			$dateAtrUpd = $detesAtrUpd->item(0)->nodeValue;

			$descriptionsAtrUpd = $itemProses->getElementsByTagName('description');
			$decsciptionAtrUpd = $descriptionsAtrUpd->item(0)->nodeValue;

			if (substr($decsciptionAtrUpd,1,3) == 'img') {
				$s = explode("\"", $decsciptionAtrUpd);
				$t = explode("\"", $s[1]);
			} else {
				$t[0] = base_url('/asseet/image/imastudio.png');
			}

			$dataAtrUpd['id'] = $i;
			$dataAtrUpd['source'] = "Antara";
			$dataAtrUpd['category'] = "Terbaru";
			$dataAtrUpd['title'] = $titleAtrUpd;
			$dataAtrUpd['link'] = $linkAtrUpd;
			$dataAtrUpd['pubDate'] = $dateAtrUpd;
			$dataAtrUpd['img'] = $t[0];

			if ($par == 1) {
				array_push($objAtrUpd['berita'],$dataAtrUpd);
			} else {
				array_push($objAtrUpd,$dataAtrUpd);
			}
			$i++;
		}
		if ($par == 1) {
			$objAtrUpd['success'] = true;
		    echo json_encode($objAtrUpd);
		} else {
			return $objAtrUpd;
		}
		
	}

	public function AdapterDtkIdx($par = 0)
	{
		$docDtkIdx = new DOMDocument();
		$docDtkIdx->load('http://rss.detik.com/index.php/detikcom');
		if ($par == 1) {
			$objDtkIdx['berita'] = array();
		} else {
			$objDtkIdx = array();
		}

		$itemDtkIdx = $docDtkIdx->getElementsByTagName('item');

		$i = 0;
		foreach ($itemDtkIdx as $itemProses) {
			$titlesDtkIdx = $itemProses->getElementsByTagName('title');
			$titleDtkIdx = $titlesDtkIdx->item(0)->nodeValue;

			$linksDtkIdx = $itemProses->getElementsByTagName('link');
			$linkDtkIdx = $linksDtkIdx->item(0)->nodeValue;

			$detesDtkIdx = $itemProses->getElementsByTagName('pubDate');
			$dateDtkIdx = $detesDtkIdx->item(0)->nodeValue;

			$enclosureDtkIdx = $itemProses->getElementsByTagName('enclosure');
			$imageDtkIdx = $enclosureDtkIdx->item(0)->getAttribute('url');
			$rt = 
			$dataDtkIdx['id'] = $i;
			$dataDtkIdx['source'] = "Detik";
			$dataDtkIdx['category'] = "Terbaru";
			$dataDtkIdx['title'] = $titleDtkIdx;
			$dataDtkIdx['link'] = $linkDtkIdx;
			$dataDtkIdx['pubDate'] = $dateDtkIdx;
			$dataDtkIdx['img'] = $imageDtkIdx;

			if ($par == 1) {
				array_push($objDtkIdx['berita'],$dataDtkIdx);
			} else {
				array_push($objDtkIdx,$dataDtkIdx);
			}
			$i++;
		}
        if ($par == 1) {
        	$objDtkIdx['success'] = true;
        	echo json_encode($objDtkIdx);
        } else {
        	return $objDtkIdx;
        }
		
	}

	public function apiCombine() 
	{
		$data1 = $this->AdapterAtrUpd();
		$data2 = $this->AdapterDtkIdx();
		$ret['berita'] = array();
		$i = 0;
		foreach ($data1 as $data1) {
			$data1['id'] = $i;
			array_push($ret['berita'],$data1);
			$i++;
		}
		$j = $i;
		foreach ($data2 as $data2) {
			$data2['id'] = $j;
			array_push($ret['berita'],$data2);
			$j++; // j plus
		}
	    echo json_encode($ret);
	}
}
?>