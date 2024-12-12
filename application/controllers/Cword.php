<?php
defined('BASEPATH') OR exit('No direct script access allowed');

// use PhpOffice\PhpSpreadsheet\Reader\Xml\Style\Fill;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Worksheet\Drawing;
use PhpOffice\PhpSpreadsheet\Style\Fill; 



class Cword extends CI_Controller {
	public function __construct() {
		    parent::__construct();  

	}
	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see https://codeigniter.com/userguide3/general/urls.html
	 */
    public function index() {
        
    }

// Tải dữ liệu và đưa vào file word 
    public function download_word($page = 1) {
        require_once 'vendor/autoload.php';
        //Không muốn require nhiều lần -> Vào config sửa composer_autoload thành True.
        //Tại sao sửa thành true rồi mà ko được.
        $this->load->model('Mperson');
        $datatb = $this->Mperson->get_8_person($page);

        $phpWord = new \PhpOffice\PhpWord\PhpWord();
        $section = $phpWord->addSection();

    //1. Waterwark 
        $header = $section->addHeader();
        if($header){
            $imagePath = 'application/assets/images/HOU.png'; 
            if (file_exists($imagePath)) {
                list($width, $height) = getimagesize($imagePath);
            } else {
                echo "Không tìm thấy ảnh.";
            }
            
            $pageHeight = 19000;
            // Tính toán căn giữa ảnh theo chiều dọc
            $marginTop = ($pageHeight - ($height * 2)) / 2; 

            $header->addWaterMark(base_url('application\assets\images\HOU.png'), 
            array('marginTop' => ($marginTop),
            'width' => $width*2, // Chiều rộng của ảnh
            'height' => $height*2, // Chiều cao của ảnh
            'align' => 'center' // Căn giữa ảnh
            ));
        } else {
            echo "Không tạo được header";
        }
    //1.

    //2. Table
        // Thiết lập style cho bảng
        $tableStyle = [
            'borderSize' => 6,
            'borderColor' => '000000',
            'cellMargin' => 50,
            'alignment' => \PhpOffice\PhpWord\SimpleType\JcTable::CENTER,
            'bgColor' => 'FFFFFF',
            'cellSpacing' => 10,
        ];
        // Thiết lập style cho cell
        $cellStyle = [
            'valign' => 'center',
            'bgColor' => 'FFFFFF',
            'borderTopColor' => 'FF0000',
            'borderTopSize' => 12,
        ];
        $cellStyle2 = [
            'valign' => 'center',
            'bgColor' => 'D3D3D3',
            'borderTopColor' => 'FF0000',
            'borderTopSize' => 12,
        ];
        $firstRow = [
            'valign' => 'center',
            'bgColor' => 'ADD8E6',
            'borderTopColor' => 'FFFFFF',
            'borderTopSize' => 12,
        ];

        // Thêm bảng vào section
        $table = $section->addTable($tableStyle);
        // Thêm các hàng vào bảng
        $table->addRow();
        $table->addCell(800, $firstRow)->addText("ID", ['bold' => true, 'color' => '000000']);
        $table->addCell(2000, $firstRow)->addText("Họ và tên", ['italic' => true, 'color' => '000000']);
        $table->addCell(2000, $firstRow)->addText("Ngày sinh", ['underline' => 'single', 'color' => '000000']);
        $table->addCell(1000, $firstRow)->addText("Giới tính", ['bold' => true, 'color' => '000000']);
        $table->addCell(2000, $firstRow)->addText("Email", ['bold' => true, 'color' => '000000']);
        $count = 0;
        foreach ($datatb as $person) {
            $count++;
            $sex = '';
                switch ($person->Sex) {
                    case 1: $sex = 'Nam'; break;
                    case 2: $sex = 'Nữ' ; break;
                    default: $sex = 'Khác'; break;
                }            
            if($count % 2 != 0) {
                $table->addRow();
                $table->addCell(800, $cellStyle)->addText($person->ID);
                $table->addCell(2000, $cellStyle)->addText($person->Name);
                $table->addCell(2000, $cellStyle)->addText($person->BirthDay);
                $table->addCell(1000, $cellStyle)->addText($sex);
                $table->addCell(2000, $cellStyle)->addText($person->Email);
            }
            else {
                $table->addRow();
                $table->addCell(800, $cellStyle2)->addText($person->ID);
                $table->addCell(2000, $cellStyle2)->addText($person->Name);
                $table->addCell(2000, $cellStyle2)->addText($person->BirthDay);
                $table->addCell(1000, $cellStyle2)->addText($sex);
                $table->addCell(2000, $cellStyle2)->addText($person->Email);
            }
        }
    //2.

        $section->addTextBreak(); // Xuống một dòng
        $section->addText('"Learn from yesterday, live for today, hope for tomorrow. '
        . 'The important thing is not to stop questioning." '
        . '(Albert Einstein)');

        $file = 'TestW.docx';
        $phpWord->save($file, 'Word2007');

        if (file_exists($file)) {
            $this->output
                ->set_content_type('application/vnd.openxmlformats-officedocument.wordprocessingml.document')
                ->set_header('Content-Disposition: attachment; filename="' . $file . '"')
                ->set_output(file_get_contents($file));
            unlink($file); // Xóa tệp sau khi tải xuống
        } else {
            echo "File không tồn tại.";
        }
        
    }

//Có thể sử dụng luôn phpWord để down file pdf 
// Tải dữ liệu và đưa vào file pdf
    public function download_pdf($page = 1) {
        require_once 'vendor/autoload.php';
        $mpdf = new \Mpdf\Mpdf();

        $this->load->model('Mperson');
        $datatb = $this->Mperson->get_8_person($page);

    //1. Watermark
        $imagePath = 'application/assets/images/HOU.png';
        if(file_exists($imagePath)) {
            list($width, $height) = getimagesize($imagePath);
            // Thiết lập watermark hình ảnh với mPDF
            $mpdf->SetWatermarkImage($imagePath, 0.1, [$width/3*2, $height/3*2], 'P'); 
            $mpdf->showWatermarkImage = true; // Hiển thị watermark
        }
        else {
            echo "Không tìm thấy ảnh.";
        }
        $mpdf->WriteHTML('<h1>Hello world!</h1>');

    //2. Table
        $bgcolor = '#ADD8E6';
        $html = '<table border="1" cellpadding="5" cellspacing="0" 
                style="width: 100%; border-collapse: collapse; text-align: center;">
            <thead>
                <tr style="background-color: ' . $bgcolor . ' !important;">
                    <th>ID</th>
                    <th>Họ và tên</th>
                    <th>Ngày sinh</th>
                    <th style="width: 80;">Giới tính</th>
                    <th>Email</th>
                </tr>
            </thead>
            <tbody>';
        $count = 0;
        foreach($datatb as $person) {
            $count++;
            $sex = '';
            switch ($person->Sex) {
                case 1: $sex = 'Nam'; break;
                case 2: $sex = 'Nữ'; break;
                default: $sex = 'Khác'; break;
            }
            $bgcolor = ($count %2 == 0) ?'#D3D3D3':'#FFFFFF';
            $html .= '<tr style="background-color: ' . $bgcolor .';">
                    <td>' . $person->ID . '</td>
                    <td>' . $person->Name . '</td>
                    <td>' . $person->BirthDay . '</td>
                    <td>' . $sex . '</td>
                    <td>' . $person->Email . '</td>
                    </tr>';
        }
        $html .= '</tbody>
                </table>';
        $mpdf->WriteHTML($html);

        $mpdf->WriteHTML('<br> <p style="text-align: center; margin-top: 50px; font-style: italic;">'
                        . '"Learn from yesterday, live for today, hope for tomorrow. '
                        . 'The important thing is not to stop questioning." '
                        . '(Albert Einstein)</p>');

        // Xuất file PDF
        $filename = 'TestPDF.pdf';
        $mpdf->Output($filename, 'F'); // 

        // Gửi phản hồi PDF
        if(file_exists($filename)) {
            $this->output
                ->set_content_type('application/pdf')
                ->set_header('Content-Disposition: attachment; filename="' . $filename . '"')
                ->set_output(file_get_contents($filename));
            unlink($filename); // Xóa file sau khi tải về
        }else{
            echo "File khong ton tai";
        }

    }

// Tải dữ liệu và đưa vào file excel
    public function download_excel($page = 1) {
        require_once 'vendor/autoload.php';
        $this->load->model('Mperson');
        $datatb = $this->Mperson->get_8_person($page);

        // Tạo đối tượng Spreadsheet
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        // 1. Watermark (Hình ảnh logo)
        $imagePath = 'application/assets/images/HOU.png';
        if (file_exists($imagePath)) {
            $drawing = new Drawing();
            $drawing->setName('Watermark');
            $drawing->setDescription('Watermark');
            $drawing->setPath($imagePath); // Đường dẫn tới file ảnh
            $drawing->setHeight(200); // Chiều cao của hình ảnh
            
            $sheet->mergeCells('A1:D11');
            $drawing->setCoordinates('A1');
            $drawing->setOffsetX(0);
            $drawing->setOffsetY(0);

            $drawing->setWorksheet($sheet); // Gán hình ảnh vào worksheet
        } else {
            echo "Không tìm thấy ảnh.";
        }

        // 2. Table (Bảng dữ liệu)
        $sheet->setCellValue('F2', 'ID');
        $sheet->setCellValue('G2', 'Họ và tên');
        $sheet->setCellValue('H2', 'Ngày sinh');
        $sheet->setCellValue('I2', 'Giới tính');
        $sheet->setCellValue('K2', 'Email');
        $sheet->getStyle('F2:K2')->applyFromArray([
            'fill'=> [
                'fillType' => Fill::FILL_SOLID,
                'startColor' => [
                    'argb'=> 'FFCCFFCC'
                ],
            ],
        ]);

        $count = 2;
        foreach ($datatb as $person) {
            $count++;
            $sex = '';
            switch ($person->Sex) {
                case 1: $sex = 'Nam'; break;
                case 2: $sex = 'Nữ'; break;
                default: $sex = 'Khác'; break;
            }
            
            $sheet->setCellValue('F' . $count, $person->ID);
            $sheet->setCellValue('G' . $count, $person->Name);
            $sheet->setCellValue('H' . $count, $person->BirthDay);
            $sheet->setCellValue('I' . $count, $sex);
            $sheet->setCellValue('K' . $count, $person->Email);
        }
        $sheet->getColumnDimension('F')->setWidth(8);
        $sheet->getColumnDimension('G')->setAutosize(true);
        $sheet->getColumnDimension('H')->setAutosize(true);
        $sheet->getColumnDimension('I')->setAutosize(true);
        $sheet->getColumnDimension('K')->setAutosize(true);    

        // 
        $sheet->setCellValue('A' . ($count + 3), '"Learn from yesterday, live for today, hope for tomorrow. '
            . 'The important thing is not to stop questioning." (Albert Einstein)');

        // Xuất file Excel
        $filename = 'TestExcel.xlsx';
        $writer = new Xlsx($spreadsheet);
        $writer->save($filename);

        // Gửi phản hồi file Excel cho người dùng
        if (file_exists($filename)) {
            $this->output
                ->set_content_type('application/vnd.openxmlformats-officedocument.spreadsheetml.sheet')
                ->set_header('Content-Disposition: attachment; filename="' . $filename . '"')
                ->set_output(file_get_contents($filename));
            unlink($filename); // Xóa file sau khi tải về
        } else {
            echo "File không tồn tại";
        }
    }

}