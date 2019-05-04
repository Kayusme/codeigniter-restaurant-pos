<?php 


class Excel_export extends CI_Controller {

    function action() {
        $this->load->library("excel");
        $object = new PHPExcel();

        $object->getProperties()->setCreator("Arjay A. Bernardino")
        ->setLastModifiedBy("Arjay A. Bernardino")
        ->setTitle("Office 2007 XLSX Test Document")
        ->setSubject("Office 2007 XLSX Test Document")
        ->setDescription("Test document for Office 2007 XLSX, generated using PHP classes.")
        ->setKeywords("office 2007 openxml php")
        ->setCategory("Test result file");
       
        $table_columns = array('DATE', 'ORDERS TAKEN', 'SALES');

        $column = 0;

        foreach ($table_columns as $field) {
            $object->getActiveSheet()->setCellValueByColumnAndRow($column, 1, $field);  
            $column++;
        }
        
        $object->setActiveSheetIndex(0);

        $start = date('m/d/Y', strtotime($this->input->get('start')));
        $end = date('m/d/Y', strtotime($this->input->get('end')));

        $sales = $this->sales_model->get_daily($start, $end);
        
        $excel_row = 2;

        foreach ($sales as $sale) {
            $object->getActiveSheet()->setCellValueByColumnAndRow(0, $excel_row, $sale->date);
            $object->getActiveSheet()->setCellValueByColumnAndRow(1, $excel_row, $sale->order_number);
            $object->getActiveSheet()->setCellValueByColumnAndRow(2, $excel_row, $sale->total_sales);
            $excel_row++;
        }
        foreach (range('A','C') as $cols) {
            $object->getActiveSheet()
            ->getColumnDimension($cols)
            ->setAutoSize(true);
        }
        $objWriter = PHPExcel_IOFactory::createWriter($object, 'Excel5');
                
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="Sales_Report'.date("Y/m/d").'.xls"');
        $objWriter->save('php://output');
    }

}