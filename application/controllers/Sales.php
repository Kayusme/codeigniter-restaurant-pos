<?php 


class Sales extends CI_Controller {

    public function index() {
        $data['title'] = "Sales";

        $this->load->view('templates/header');
        $this->load->view('templates/sub-menu');
        $this->load->view('sales/index', $data);
        $this->load->view('templates/footer');
    }

    public  function fetch() {
        $start = date('m/d/Y', strtotime($this->input->post('start')));
        $end = date('m/d/Y', strtotime($this->input->post('end')));

        $sales = $this->sales_model->get_daily($start, $end);
        
        $html ="
        <table class='table table-bordered'>
            <tr>
                <th>Date</th>
                <th>Number of Orders Taken</th>
                <th>Subtotal</th>
            </tr>
        ";
        $total = 0;
        foreach ($sales as $s) {
            $html .= "
            <tr>
                <td>".date('F d ,Y', strtotime($s->date))."</td>
                <td>".$s->order_number."</td>
                <td>&#x20B1;" . number_format((float)$s->total_sales, 2 )."</td>
            </tr>
            ";
            $total += $s->total_sales;
        }
        $html .= "
            <tr>
                <td></td>
                <td class='text-right'><strong>Total Sales</strong></td>
                <td><strong>&#x20B1;" . number_format((float)$total, 2 )."</strong></td>
            </tr>";
        $html .= "</table>";

        echo $html;
    }

}