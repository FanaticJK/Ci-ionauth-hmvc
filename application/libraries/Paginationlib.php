<?php
/**
 * Created by PhpStorm.
 * User: Ultrabyte
 * Date: 7/25/2017
 * Time: 2:00 PM
 */
if (!defined('BASEPATH')) exit('No direct script access allowed');

class Paginationlib
{
    //put your code here
    function __construct()
    {
        $this->ci =& get_instance();
    }

    public function initPagination($base_url, $total_rows)
    {
        $config['per_page'] = 20;
        $config['uri_segment'] = 4;
        $config['base_url'] = base_url() . $base_url;
        $config['total_rows'] = $total_rows;
        $config['use_page_numbers'] = TRUE;
        $config['first_tag_open'] = $config['last_tag_open'] = $config['next_tag_open'] = $config['prev_tag_open'] = $config['num_tag_open'] = '<li>';
        $config['first_tag_close'] = $config['last_tag_close'] = $config['next_tag_close'] = $config['prev_tag_close'] = $config['num_tag_close'] = '</li>';
        $config['next_link'] = 'Next';
        $config['prev_link'] = 'Previous';
        $config['first_link'] = "";
        $config['last_link'] = "";
        // Open tag for CURRENT link.
        $config['cur_tag_open'] = '<li class="current"><span>';
        // Close tag for CURRENT link.
        $config['cur_tag_close'] = '</span></li>';
        $this->ci->pagination->initialize($config);
        return $config;
    }

    public function initPaginationTroubleshoot($base_url, $total_rows)
    {
        $config['per_page'] = 20;
        $config['uri_segment'] = 6;
        $config['base_url'] = base_url() . $base_url;
        $config['total_rows'] = $total_rows;
        $config['use_page_numbers'] = TRUE;
        $config['first_tag_open'] = $config['last_tag_open'] = $config['next_tag_open'] = $config['prev_tag_open'] = $config['num_tag_open'] = '<li>';
        $config['first_tag_close'] = $config['last_tag_close'] = $config['next_tag_close'] = $config['prev_tag_close'] = $config['num_tag_close'] = '</li>';
        $config['next_link'] = 'Next';
        $config['prev_link'] = 'Previous';
        $config['first_link'] = "";
        $config['last_link'] = "";
        // Open tag for CURRENT link.
        $config['cur_tag_open'] = '<li class="current"><span>';
        // Close tag for CURRENT link.
        $config['cur_tag_close'] = '</span></li>';
        $this->ci->pagination->initialize($config);
        return $config;
    }

}