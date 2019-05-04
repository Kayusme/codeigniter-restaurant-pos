<?php 

require_once 'TCPDF/tcpdf.php';

class Pdf extends TCPDF {
    
    public function __construct() {
        parent::__construct();
    }
}