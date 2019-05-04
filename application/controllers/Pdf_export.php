<?php

class Pdf_export extends CI_Controller {

    public function action() {

        $this->load->library('pdf');

        $pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

        $pdf->SetCreator(PDF_CREATOR);
        $pdf->SetAuthor($_SESSION['name']);
        $pdf->SetTitle('List of Users');
        $pdf->SetSubject('SALES');
        $pdf->SetKeywords('SALES');

        $pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, PDF_HEADER_TITLE, PDF_HEADER_STRING);

        $pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
        $pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

        $pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

        $pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
        $pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
        $pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

        $pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

        $pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);


        if (@file_exists(dirname(__FILE__).'/lang/eng.php')) {
            require_once(dirname(__FILE__).'/lang/eng.php');
            $pdf->setLanguageArray($l);
        }


        $pdf->SetFont('dejavusans', '', 10);


        $pdf->AddPage('P');


        $start = date('m/d/Y', strtotime($this->input->get('start')));
        $end = date('m/d/Y', strtotime($this->input->get('end')));

        $sales = $this->sales_model->get_daily($start, $end);
        

        $html = '<h1 style="text-align: center">SALES REPORT</h1>';
        $html .= '<table border="1" cellpadding ="5" cellspacing="0">';
        $html .= '
                <tr>
                    <th style="text-align:center;" colspan="5" >Date</th>
                    <th style="text-align:center;" colspan="2" >Orders Taken</th>
                    <th style="text-align:center;"colspan="3" >Sales</th>
                </tr>
        ';
        
        foreach ($sales as $sale) {
            $html.= '<tr>';
            $html.='<td colspan="5">' . date("F d, Y", strtotime($sale->date)) . '</td>';
            $html.='<td colspan="2">' . $sale->order_number . '</td>';
            $html.='<td colspan="3" >&#x20B1;' . number_format((float)$sale->total_sales, 2) . '</td>';
            $html.= '</tr>';
        }

        $html .= '</table>
                <style>
                    tr th {
                        background-color: #333;
                        color: #fff;
                    }
                </style>
        ';



        $pdf->writeHTML($html, true, false, true, false, '');
            
        $pdf->lastPage();

        $pdf->Output('Sales_Report_' . date('Y/m/d')  . '.pdf', 'I');


    }


}