<?php
defined('BASEPATH') OR exit('No direct script access allowed');

    $data['url'] = current_url();

    $this->load->view('layout/VHeader', $data);
    $this->load->view('layout/VContent', $data);
    $this->load->view('layout/VFooter');   
