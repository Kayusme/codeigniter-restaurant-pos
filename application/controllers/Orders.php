<?php

class Orders extends CI_Controller {

    public function index() {
        if (!isset($_SESSION['id'])) {
            show_404();
        }
        $data['title'] = "Orders";
        $data['orders'] = $this->order_model->get_orders();
        $data['items'] = $this->order_model->get_items_order();
        $this->load->view('templates/header');
        $this->load->view('templates/sub-menu');
        $this->load->view('orders/index', $data);
        $this->load->view('templates/footer');
    }

    public function completed() {
        $id = $this->input->post('order_id');

        if($this->order_model->delete_order($id)) {

            $order_items = $this->order_model->get_items_order_by_id($id);
            $data = array();
            foreach($order_items as $items) {
                $subarray = array(
                    'order_id' => $items->order_id,
                    'item_id' => $items->item_id,
                    'sub_category_id' => $items->sub_category_id,
                    'qty' => $items->qty
                );
                $data[] = $subarray;
            }
            if ($this->order_model->insert_batch_item_log($data)) {
                $this->order_model->delete_order_items($id);                
            }
        }
    }

    public function logs() {
        $data['title'] = "Order History";

        $this->load->view('templates/header');
        $this->load->view('templates/sub-menu');
        $this->load->view('orders/logs', $data);
        $this->load->view('templates/footer');
    }

    public function fetch_all() {
        $fetch_data = $this->order_logs_model->make_datatable();
        $order_type = ['dine-in','take-out','deliver'];
        $data = array();
        foreach ($fetch_data as $row) {
            $sub_array = array();
            $sub_array[] = $row->order_id;
            $sub_array[] = $row->user_name;
            $sub_array[] = $order_type[$row->order_type];
            $sub_array[] = '&#x20B1; ' . number_format((float)$row->order_partial_price, 2);
            $sub_array[] = $row->description;
            $sub_array[] = '&#x20B1; ' . number_format((float)$row->order_total_price, 2);
            $sub_array[] = date('m/d/Y H:i A', strtotime($row->order_date));
            $sub_array[] = "<button class='btn btn-info view-items' id='". $row->order_id ."'><span class='glyphicon glyphicon-list-alt'> </span></button>";
            
            $data[] = $sub_array;
        }

        $output = array(
            'draw' => intval($_POST['draw']),
            'recordsTotal' => $this->order_logs_model->get_all_data(),
            'recordsFiltered' => $this->order_logs_model->get_filtered_data(),
            'data' => $data
        );
        echo json_encode($output);
    }

    public function view() {
        $order_id = $this->input->post('order_id'); 
        $items = $this->order_model->get_items_order_log($order_id);
        $order = $this->order_logs_model->get_order_log_id($order_id);
        $order_type = ['Dine-in', 'Take-out', 'Deliver'];
        $html = "";

        $html .= '<div class="box-header">
                     <h3 class="box-title">Order Items</h3>';
        $html .= "<button class='btn btn-info pull-right back'><span class='glyphicon glyphicon-arrow-left'></span> </button>
        </div>  ";
        $html .= "
        <div style='width: 70%; margin: auto'> 
            <table class='table table-striped'>
                <tr>
                    <td><strong>ORDER ID:</strong> ". $order->order_id." </td>
                    <td><strong>CASHIER:</strong> ". strtoupper($order->user_name)." </td>
                </tr>
                <tr>
                    <td><strong>ORDER TYPE:</strong> ". strtoupper($order_type[$order->order_type])." </td>
                    <td><strong>DISCOUNT:</strong> ". strtoupper($order->description)." </td>
                </tr>  
                <tr>
                    <td><strong>DATE:</strong> ". date('m/d/Y', strtotime($order->order_date))." </td>
                    <td><strong>TIME:</strong> ". date('h:i A', strtotime($order->order_date))." </td>
                </tr>  
            </table>   
        </div>
        <table class='table table-bordered' style='width: 70%; margin: auto;'>
            <tr class='bg-primary'>
                <th style='width: 10%'>ITEM</th>
                <th style='width: 10%'>QTY</th>
                <th style='width: 10%'>SUBTOTAL</th>
            </tr>
        ";
        foreach ($items as $item) {
            $html.= "
            <tr>
                <td>". $item->item_name." </td>
                <td>". $item->qty." </td>
                <td>&#x20B1;". number_format((float)$item->qty * (float)$item->item_price,2)." </td>
            </tr>
            ";
        }
        $html .= "
            <tr>
                <td><br>PARTIAL PRICE: &#x20B1;". 
                number_format((float)$order->order_partial_price,2). "</td>
                
                <td><br>DISCOUNT : &#x20B1;". 
                number_format((float)$order->discounted_price,2). "</td>
                
                <td><br><strong>TOTAL PRICE: &#x20B1;". 
                number_format((float)$order->order_total_price,2). "</strong></td>
            </tr>
            ";
        $html .= "</table><br><br><br><br><br><br>";


        echo $html;
    }

}