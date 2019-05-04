<?php

class Sales_model extends CI_Model {

    public function __construct() {
        $this->load->database();
    }


    public function get_daily($start, $end) {
        $this->db->where('date >= ', date('Y-m-d',strtotime($start)));
        $this->db->where('date <= ', date('Y-m-d',strtotime($end)));
        $output = $this->db->get('daily_sales'); 

        return $output->result();
    }

    //get all data from daily_sales table
    public function get_sales() {
        $all = $this->db->count_all('daily_sales');

        $this->db->limit(7, ($all > 7)? $all - 7: 0);
        $output = $this->db->get('daily_sales');

        return $output->result();
    }

    //get all data in montly_sales table
    public function get_monthly() {      
        $all = $this->db->count_all('monthly_sales');

        $this->db->limit(6, ($all > 6)? $all - 6: 0);
        $output = $this->db->get('monthly_sales');

        return $output->result();
    }

    public function insert_sales($date, $order_number, $sales) {
        $data = array(
            'date' => $date,
            'order_number' => $order_number,
            'total_sales' => $sales
        );

        return $this->db->insert('daily_sales', $data);
    }

    public function update_sales($date, $order_number, $sales) {
        $data = array(
            'order_number' => $order_number,
            'total_sales' => $sales
        );
        $this->db->where('date', $date);
        return $this->db->update('daily_sales', $data);
    }

    public function get_order_number($date) {
        $output = $this->db->get_where('daily_sales', array('date' => $date));
        
        $sales = $output->row();

        return $sales->order_number;
    }

    public function get_total_sales($date) {
        $output = $this->db->get_where('daily_sales', array('date' => $date));

        $sales = $output->row();
        return $sales->total_sales;
    }

    public function insert_monthly_sales($year, $month, $sales) {
        $data = array(
            'year' => $year,
            'month' => $month,
            'total_sales' => $sales
        );

        $this->db->insert('monthly_sales', $data);
    }

    public function update_monthly_sales($year, $month, $sales) {
        $data = array(
            'year' => $year,
            'month' => $month,
            'total_sales' => $sales
        );
        
        $this->db->where('year', $year);
        $this->db->where('month', $month);
        $this->db->update('monthly_sales', $data);
    }

    public function get_monthly_sales($year, $month) {
        $this->db->where('year', $year);
        $this->db->where('month', $month);
        $output = $this->db->get('monthly_sales');

        $sales = $output->row();
        return $sales->total_sales;
    }
    
    public function if_year_month_exist($year, $month) {
        $this->db->where('year', $year);
        $this->db->where('month', $month);
        $result = $this->db->count_all_results('monthly_sales');

        if ($result > 0) {
            return true;
        }

        return false;
    }

    public function if_date_exist($date) {
        $this->db->select('date');
        $output = $this->db->where(array('date' => $date));
        $result = $this->db->count_all_results('daily_sales');

        if ($result > 0) {
            return true;
        }

        return false;
    }
}