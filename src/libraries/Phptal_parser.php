<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

require(dirname(__FILE__) .'/../../vendor/autoload.php');

/*
 * PHPTALをテンプレートエンジンとして使用するための機能を提供します
 */
class PhptalParser
{

    private $_PHPTAL = NULL;
    private $_CI     = NULL;

    public function __construct()
    {
        $this->_PHPTAL = new PHPTAL();
        $this->_CI =& get_instance();
		$this->_CI->load->library('parser');

        log_message('debug', "Phptal_parser Class Initialized");
    }

    /*
     * Method: fetch
     *
     * @param  str tmplatename
     * @param  arr data
     *
     */
    public function fetch($tmpl, $data) {

        //$this->_CI->benchmark->mark('phptal_parse_start');

		// instance
		$phptal = $this->_PHPTAL;
		$phptal->setSource($this->_CI->parser->parse($tmpl,$data,true));

        foreach($data as $p => $value) {
            $phptal->$p = $value;
        }
        // execute the template
        try {
            $result = $phptal->execute();
        }
        catch (Exception $e){
            echo $e;
            exit;
        }
        //$this->_CI->benchmark->mark('phptal_parse_end');
        return $result;
    }

    /*
     * Method: view
     *
     * @param  str tmplatename
     * @param  arr data
     *
     */
    public function view($tmpl, $data = array()) {
        echo $this->fetch($tmpl, $data);
    }
}
