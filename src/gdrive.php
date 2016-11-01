<?php
namespace Marxvn;
/**
 * Google Drive library
 *
 * @author Marxvn
 * @copyright (c) 2016, Marxvn
 * @license https://spdx.org/licenses/BSD-3-Clause.html BSD-3-Clause
 */

class gdrive
{
	/**
     *
     * @var url
     */
	protected $url;

	/**
     *
     * @var title
     */
	protected $title = '';

	/**
     *
     * @var sources
     */
	public $sources;

	/**
	 * 
     * @var itag
     */
	protected $itag = [
		37,
		22,
		59,
		18
	];


	/**
     *
     * @var vidcode
     */
	protected $vidcode = [
	 	//2D Non-DASH
        '18'	=> '360',
        '59'	=> '480',
        '22'	=> '720',
        '37'	=> '1080',
        //3D Non-DASH
        '82'	=> '360',
        '83'	=> '240',
        '84'	=> '720',
        '85'	=> '1080'
    ];

    /**
     *
     * @param  array    $itags
     * @return void
     */

	public function setItag(array $itag)
	{
		$this->itag = $itag;
	}

	/**
     *
     * @param  array    $vidcode
     * @return void
     */
    
	public function setVidcode(array $vidcode)
	{
		$this->vidcode = $vidcode + $this->vidcode;
	}

	/**
     *
     * @param  array    $title
     * @return void
     */
    
	public function setTitle($title)
	{
		$this->title = $title;
	}

	/**
     *
     * @param  string   $gurl
     * @return array
     */
    
	public function getLink($gurl)
	{
		$source = [];

		if( $this->getDriveId($gurl) ) {
			$body = $this->getByfopen();

			if($body && $this->getStr($body,'status=', '&') === 'ok') {

				$fmt = $this->getStr($body, 'fmt_stream_map=','&');

				$urls = explode(',', urldecode($fmt));
				
				foreach ($urls as $url) {
					list($itag,$link) = explode('|', $url);
					if(in_array($itag, $this->itag)){
						$source[$this->vidcode[$itag]] = preg_replace("/[^\/]+\.googlevideo\.com/", "redirector.googlevideo.com",$link);
					}
				}
			}
		}
		$this->sources = $source;

	}

	/**
     *
     * @param  string   $type
     * @return json
     */
    
	public function getSources($type = 'videojs')
	{
		$s = [];

		$url_tag = ($type == 'videojs') ? 'src' : 'file';

		foreach ($this->sources as $itag => $link) {
			$s[] = [
				'type' 	=> 'video/mp4',
				'label'	=> $itag,
				'file'	=> $link.'&tile='.$itag,
				$url_tag => $link.'&tile='.$this->title.'-'.$itag
			];
		}
		return json_encode($s);
	}

	/**
     *
     * @param  string   $url
     * @return string
     */
	public function getByfopen()
	{
		try	{
	    	$handle = fopen($this->url, "r");

	    	if ( !$handle ) {
	        	throw new \Exception('Url open failed.');
	      	}  

			$contents = stream_get_contents($handle);
			fclose($handle);

			return $contents ? $contents : '';

		} catch( \Exception $e) {
			echo 'Message: ' .$e->getMessage();
		}
	}

	/**
     *
     * @param  string   $url
     * @return mixed
     */
    
	private function getDriveId($url)
	{
		preg_match('/(?:https?:\/\/)?(?:[\w\-]+\.)*(?:drive|docs)\.google\.com\/(?:(?:folderview|open|uc)\?(?:[\w\-\%]+=[\w\-\%]*&)*id=|(?:folder|file|document|presentation)\/d\/|spreadsheet\/ccc\?(?:[\w\-\%]+=[\w\-\%]*&)*key=)([\w\-]{28,})/i', $url , $match);

		if(isset($match[1])) {
			$this->url = 'https://docs.google.com/get_video_info?docid='.$match[1];
			return true;
		}

		return false;
	}

	/**
     *
     * @param  string   $string
     * @param  string   $find_start
     * @param  string   $find_end
     * @return mixed
     */
	private function getStr($string, $find_start, $find_end)
	{
		$start = stripos($string, $find_start);

		if($start === false) return false;

		$length = strlen($find_start);

		$end = stripos(substr($string, $start+$length), $find_end);

		if($end !== false) {
			$rs = substr($string, $start+$length, $end);
		} else {
			$rs = substr($string, $start+$length);
		}

		return $rs ? $rs : false;
	}
}