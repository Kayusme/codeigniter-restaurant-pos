<?php

class Counter extends CI_Controller {

    public function index() {
        if (!isset($_SESSION['id'])) {
            show_404();
        }
        $data['title'] = "Counter";
        $data['categories'] = $this->category_model->get_categories();
        $data['subcategories'] = $this->category_model->get_sub_categories();
        $data['discounts'] = $this->discount_model->get_discounts();
        $data['total'] = $this->cart->total();
        $this->load->view('templates/header');
        $this->load->view('templates/sub-menu');
        $this->load->view('counter/index', $data);
        $this->load->view('templates/footer');
    }

    public function filter_category() {
        $cat_id = $this->input->post('cat_id');
        $subcat_id = $this->input->post('subcat_id');
        $items = $this->item_model->get_items_by_category($cat_id, $subcat_id);
        $html = '';
        foreach ($items as $item) {
            $html .= '<div class="items bg-red" id="'. $item->item_id.'">'.
                        '<h6 class="counter-subcat-name">' . $item->name .'</h6>' .
                        $item->item_name .'<br>
                     </div>';
        }
        echo $html;
    }

    public function filter_items() {
        $item_name = $this->input->post('search_text');  
        $items = $this->item_model->get_items_by_name($item_name);
        $html = '';
        foreach ($items as $item) {
            $html .= '<div class="items bg-red" id="'. $item->item_id.'">'.
                        '<h6 class="counter-subcat-name">' . $item->name .'</h6>' .
                        $item->item_name .'<br>
                     </div>';
        }
        echo $html;
    }

    public function add_item() {
        $item_id = $this->input->post('item_id');
        $item = $this->item_model->get_item_by_id($item_id);
        $id = $item->item_id;
        $name = $item->item_name;
        $price = $item->item_price;
        $subcategory = $item->sub_category_id;
        $qty = 1;
        $data = array(
            'id' => $id,
            'name' => $name,
            'qty' => $qty,
            'price' => $price,
            'options' => 
                array( 'subcategory' => $subcategory )
        );
        if($this->cart->insert($data)){
            echo $this->display_order();
        } else {
            echo 'failed';
        }
    }

    public function display_order() {
        if (count($this->cart->contents()) === 0) {
            echo "<h5 class='text-center' style='height:310px'>No Order Yet!</h5>";
        } else {
        $html = "<table class='table'>";
                $html .= "<tr>";
                    $html .= "<th>Item</th>";
                    $html .= "<th>Price</th>";
                    $html .= "<th>QTY</th>";
                    $html .= "<th>Subtotal</th>";  
                    $html .= "<th><button class='clear-item btn btn-danger my-circle'><i class='glyphicon glyphicon-trash'></i></button></th>";          
                $html .= "</tr>";
            foreach ($this->cart->contents() as $order) {
                $html .= "<tr>";
                    $html .= "<td>" . $order['name'] ."</td>";
                    $html .= "<td> &#x20B1;" . number_format((float)$order['price'], 2) ."</td>";
                    $html .= "<td><input type='text' class='order-input' id='".$order['rowid']."' value='".$order['qty']."'></td>";
                    $html .= "<td> &#x20B1;" . number_format((float)$order['subtotal'], 2) ."</td>";   
                    $html .= "<td><button class='delete-item btn btn-warning my-circle' id='". $order['rowid'] ."'><i class='glyphicon glyphicon-trash'></i></button></td>";          
                $html .= "</tr>";
            }
        $html .= "</table>";
        $html .= "<h1 style='text-align: center' id='total_amount'>Total: &#x20B1;".number_format((float)$this->cart->total(), 2). "</h1>";
        $html .= "<br><button  class='btn btn-success btn-block' id='tender'>Tender</button>";
        echo $html;
        }
    }

    public function delete_item() {
        $rowid = $this->input->post('rowid');
        $data = array(
            'rowid' => $rowid,
            'qty' => 0
        );

        if($this->cart->update($data)) {
            $this->display_order();
        } else {
            echo 'Something Went Wrong! Please reset!';
        }
    }

    public function clear_item() {
       $this->cart->destroy();
       $this->display_order();
    }

    public function update_quantity() {
        $rowid = $this->input->post('rowid');
        $qty = $this->input->post('qty');
        $data = array(
            'rowid' => $rowid,
            'qty' => $qty
        );

        if($this->cart->update($data)) {
            $this->display_order();
        } else {
            echo 'Something Went Wrong! Please reset!';
        }
    }

    public function get_total() {
        echo "&#x20B1;". number_format((float)$this->cart->total(), 2);
    }
    
    public function get_discounted_total() {
        $id = $this->input->post('discount_id');
        $total = $this->generate_discount($id);
        echo "&#x20B1;". number_format((float)$total, 2);
    }   

    public function tender() {
        $num_of_order = count($this->cart->contents());
        $payment = $this->input->post('pay');
        $order_type = $this->input->post('order_type');
        $discount_id = $this->input->post('discount');
        
        $total_price = $this->generate_discount($discount_id);
        $partial_price = $this->cart->total();
        $discounted_price = $partial_price - $total_price;

        $order_id = $this->order_model->insert_order($total_price, $order_type, $discount_id, $partial_price, $discounted_price);
        $this->order_model->insert_order_log($order_id ,$total_price, $order_type, $discount_id, $partial_price, $discounted_price);
        $this->add_to_sales($total_price);
        $this->add_to_monthly_sales($total_price);
        $data = $this->get_item_data($order_id);
        $res = $this->order_model->insert_batch_item($data);

        $change = $payment - $total_price;
        if($res) {
            //destroy cart
            $this->cart->destroy();
            echo "&#x20B1;" . number_format((float)$change, 2);
        }
    }

    public function get_item_data($order_id) {
        $array = array();
        foreach ($this->cart->contents() as $order) {
            $subarray = array(
                'order_id' => $order_id,
                'item_id' => $order['id'],
                'sub_category_id' => $this->cart->product_options($order['rowid'])['subcategory'],
                'qty' => $order['qty']
            );
            $array[] = $subarray; 
        }

        return $array;
    }

    public function add_to_sales($total_price) {

        $date = date('Y/m/d');

        $order_number = $this->sales_model->get_order_number($date) + 1;
        $total_sales  = $this->sales_model->get_total_sales($date) + $total_price;
        $this->sales_model->update_sales($date, $order_number, $total_sales);
        
    }

    public function add_to_monthly_sales($total_price) {

        $year = date('Y');
        $month = date('m');

        $total_sales  = $this->sales_model->get_monthly_sales($year, $month) + $total_price;
        $this->sales_model->update_monthly_sales($year, $month, $total_sales);
    
    }

    public function generate_discount($id) {
        $total_price = $this->cart->total();
        
        $discounted_price = $total_price;
        if ($id != 0) {
            $discount_rate = $this->discount_model->get_discount($id) / 100; 
            $discount = $total_price * $discount_rate;
            $discounted_price = $total_price - $discount; 

        }
        return $discounted_price;
    }


}
