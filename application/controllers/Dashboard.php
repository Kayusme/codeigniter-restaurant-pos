<?php

class Dashboard extends CI_Controller {

    public function index() {

        if (!isset($_SESSION['id'])) {
            $this->load->view('templates/login');
        }
        $today =  date('Y/m/d');
        $year = date('Y');
        $month = date('m');

        if (!$this->sales_model->if_date_exist($today)) {
            $this->sales_model->insert_sales($today, 0, 0);
        }
        if (!$this->sales_model->if_year_month_exist($year, $month)) {
            $this->sales_model->insert_monthly_sales($year, $month, 0);
        }

        //daily sales for chart
        $daily_sales = $this->sales_model->get_sales();
        $dsales = null;
        $days = null;
        
        foreach($daily_sales as $sales) {
            $dsales[] = $sales->total_sales;
            $days[] = date('l', strtotime($sales->date));
        }

        //monthly sales for chart
        $monthName = ['January','February','March','April','May','June','July','August','September','October','November','December'];
        $monthly_sales = $this->sales_model->get_monthly();
        $msales = null;
        $months = null;
        foreach($monthly_sales as $sales) {
            $msales[] = $sales->total_sales;
            $months[] = $monthName[$sales->month - 1];
        }


        $data['days'] = "'" . implode("','", $days) . "'";
        $data['sales_per_day'] = "" . implode(",", $dsales) . "";
        $data['months'] = "'" . implode("','", $months) . "'";
        $data['sales_per_month'] = "" . implode(",", $msales) . "";
        $data['order_number'] = $this->sales_model->get_order_number($today);
        $data['today_sales'] = $this->sales_model->get_total_sales($today);
        $data['month_sales'] = $this->sales_model->get_monthly_sales($year, $month);


        $this->load->view('templates/header');
        $this->load->view('templates/sub-menu');
        $this->load->view('dashboard/index', $data);
        $this->load->view('templates/footer');
    }


}