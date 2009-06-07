<?php
class ApplicationController extends Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->session = new Session();
        $this->menu = array();
    }
}