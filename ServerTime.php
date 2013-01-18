<?php

/**
 * ServerTime widget class file.
 * @author urmaul <blacksilver@codesex.org>
 * @link http://www.codesex.org

 * EServerTime extends CWidget and implements a base class for a server time widget.
 * @version: 1.0
 */
class ServerTime extends CWidget
{
	public $id = 'servertime';
	
	public $time;
	
	public $format = 'm-d-Y H:i:s';
	
	public $tag = 'span';
	public $htmlOptions = array();
	
	// function to init the widget
	public function init()
	{
		if (!isset($this->time))
		    $this->time = time();
	    
	    // publish the required assets
		$this->publishAssets();
	}
	
	// function to run the widget
    public function run()
    {
        // Adding updating script
        $format = CJavaScript::encode($this->format);
        $times = CJavaScript::encode(array(
            'd' => (int) date('j', $this->time),
            'm' => (int) date('n', $this->time),
            'Y' => (int) date('Y', $this->time),
            'H' => (int) date('G', $this->time),
            'i' => (int) date('i', $this->time),
            's' => (int) date('s', $this->time),
        ));
        
        $script = sprintf('jQuery("#%s").servertime(%s, %s);', $this->id, $times, $format);
		Yii::app()->clientScript->registerScript($this->id, $script, CClientScript::POS_READY);
		
		// Printing tag
		$htmlOptions = $this->htmlOptions;
		$htmlOptions['id'] = $this->id;
		
		$content = date($this->format, $this->time);
		
		echo CHtml::tag($this->tag, $htmlOptions, $content);
	}
	
	// function to publish and register assets on page 
	public function publishAssets()
	{
		$assets = dirname(__FILE__).'/assets';
		$baseUrl = Yii::app()->assetManager->publish($assets);
		if(is_dir($assets)){
			Yii::app()->clientScript->registerScriptFile($baseUrl . '/servertime.js', CClientScript::POS_HEAD);
		} else {
			throw new Exception('EServerTime - Error: Couldn\'t find assets to publish.');
		}
	}
}