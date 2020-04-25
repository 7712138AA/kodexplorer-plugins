<?php

class PhotopeaPlugin extends PluginBase {
    function __construct() {
        parent::__construct();
    }
    public function regiest() {
        $this->hookRegiest(array(
            'user.commonJs.insert' => 'PhotopeaPlugin.echoJs'
        ));
    }
    public function echoJs($st,$act) {
        if ($this->isFileExtence($st,$act)) {
            $this->echoFile('static/main.js');
        }
    }
    public function index() {
        if (substr($this->in['path'],0,4) == 'http') {
            $path = $this->in['path'];
        } else {
            $path = _DIR($this->in['path']);
            if (!file_exists($path)) {
                show_tips(LNG('not_exists'));
            }
        }
	$fileName = get_path_this(rawurldecode($this->in['path']));
        $fileExt = get_path_ext($path);
        $fileUrl = $this->pluginHost.'php/handler.php?act=sent&path='.rawurlencode($path);
        $saveUrl = $this->pluginHost.'php/handler.php?act=save&path='.rawurlencode($path);
        $fullUri = '{"files":["'.$fileUrl.'"],"resources":[],"server":{"version":1,"url":"'.$saveUrl.'","formats":["'.$fileExt.'"]},"environment":{},"script":""}';

		$config = $this->getConfig();

        //header('Location:https://www.photopea.com/#'.urlencode($fullUri));
        //国内访问速度问题，故本地化
        header('Location:'.$this->pluginHost.'/static/photopea/#'.($fullUri));
    }
}
