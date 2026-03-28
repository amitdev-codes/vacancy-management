<?php

namespace App\Exports;
use \PhpOffice\PhpSpreadsheet\Style\Border;
use App\Models\LoksewaReport;
use App\Models\VacancyAd;
use App\Models\VacancyPost;
use File;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Worksheet\Drawing;

class LokSewaReportExportExcel implements FromQuery, WithHeadings, WithMapping,ShouldAutoSize,WithEvents
{
    use Exportable;
    public $ad_id;
    public $designation;

    public function __construct(int $ad_id,int $designation){
        $this->ad_id=$ad_id;
        $this->designation=$designation;
    }

    public function query()
    {
       return LoksewaReport::query()->filter($this->ad_id)->designation($this->designation)->orderBy('full_name');
    }
    public function headings(): array
    {
        $details=DB::table('vacancy_post as vp')
        ->select('vp.ad_no','vp.designation_id','md.name_np as designation','mwl.name_np as work_level','mws.name_np as service','mwsg.name_np as service_group' )
        ->leftjoin('mst_designation as md','vp.designation_id','md.id')
        ->leftjoin('mst_work_level as mwl','md.work_level_id','mwl.id')
        ->leftjoin('mst_work_service as mws','md.work_service_id','mws.id')
        ->leftjoin('mst_work_service_group as mwsg','md.service_group_id','mwsg.id')
        ->where('vp.vacancy_ad_id',$this->ad_id)
        ->where('vp.designation_id',$this->designation)
        ->where('vp.fiscal_year_id',Session::get('fiscal_year_id'))
        ->first();
        // dd($details);/

        $ad_no = $details->ad_no;
        $opening_type = VacancyAd::where('id', $details->vacancy_ad_id)->pluck('ad_title_en')->first();
        $designation = $details->designation;
        $work_level = $details->work_level;

        $service=$details->service.','.$details->service_group;

        // dd($work_level);

        $open = $details->open_seats;
        $female = $details->mahila_seats;
        $janjati = $details->janjati_seats;
        $madhesi = $details->madhesi_seats;
        $dalit = $details->dalit_seats;
        $apanga = $details->apanga_seats;
        $remote = $details->remote_seats;
        $total = $details->total_req_seats;

        return [
              [' ',' ',' ',' ',' ',' ',' ',''],
                [' ',' ',' ',' ',' ',' ',' ',''],
                [' ',' ',' ',' ',' ',' ',' ',''],
                [],
                [],
                [],
                [],
                [],
                [
                    'क्र.सं', 'रोल नं', 'उम्मेदवारको नामथर', 'लिङ्ग', 'आवेदन समूह','','', '', '', '', '', '', 'फोटो', 'हस्ताक्षर', 'टोकन  नं', 'स्थायी ठेगाना', 'मोबाईल नं', 'बाजेको नाम', 'बाबु/आमाको नाम', 'नागरिकता नं,जारि जिल्ला', 'बुजाएको दस्तुर'
                 ],
                 [
                    '', '', '', '','आ.प्र', 'खुल्ला', 'महिला', 'जनजाती', 'मधेसी', 'दलित', 'अपाङ्ग', 'पिछडिएको क्षेत्र', '', '', '', '', '', '', '', '', ''
                 ],
        ];
    }


    public function registerEvents(): array
    {
        $details=DB::table('vacancy_post as vp')
        ->select('vp.ad_no','vp.total_req_seats', 'vp.designation_id','md.name_np as designation','mwl.name_np as work_level','mws.name_np as service','mwsg.name_np as service_group' )
        ->leftjoin('mst_designation as md','vp.designation_id','md.id')
        ->leftjoin('mst_work_level as mwl','md.work_level_id','mwl.id')
        ->leftjoin('mst_work_service as mws','md.work_service_id','mws.id')
        ->leftjoin('mst_work_service_group as mwsg','md.service_group_id','mwsg.id')
        ->where('vp.vacancy_ad_id',$this->ad_id)
        ->where('vp.designation_id',$this->designation)
        ->where('vp.fiscal_year_id',Session::get('fiscal_year_id'))
        ->first();


        return [
            AfterSheet::class => function(AfterSheet $event) use($details) {
                $ad_no = $details->ad_no;
                $designation = $details->designation;
                $work_level = $details->work_level;
                $service=$details->service.','.$details->service_group;
                $open = $details->open_seats;
                $female = $details->mahila_seats;
                $janjati = $details->janjati_seats;
                $madhesi = $details->madhesi_seats;
                $dalit = $details->dalit_seats;
                $apanga = $details->apanga_seats;
                $remote = $details->remote_seats;
                $total = $details->total_req_seats;
               
                $workSheet = $event->sheet->getDelegate();
                // Set Kalimati font for the entire worksheet
                $workSheet->getParent()->getDefaultStyle()->getFont()->setName('Kalimati');
                $workSheet->getParent()->getDefaultStyle()->getFont()->setSize(10);
    
                // Center align all cells
                $workSheet->getParent()->getDefaultStyle()->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
                $workSheet->getParent()->getDefaultStyle()->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER);
    
                // Style for 'आवेदन समूह' header
                $groupHeaderStyle = [
                    'font' => [
                        'bold' => true,
                        'size' => 14,
                        'color' => ['rgb' => 'FFFFFF'],
                    ],
                    'fill' => [
                        'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                        'startColor' => ['rgb' => '4472C4'],
                    ],
                    'borders' => [
                        'allBorders' => [
                            'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                            'color' => ['rgb' => '000000'],
                        ],
                    ],
                    'alignment' => [
                        'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
                        'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER,
                    ],
                ];
    
                $workSheet->getStyle('E10:L10')->applyFromArray($groupHeaderStyle);
    
                $subHeaderStyle = [
                    'font' => [
                        'bold' => true,
                        'size' => 12,
                        'color' => ['rgb' => 'FFFFFF'],
                    ],
                    'fill' => [
                        'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                        'startColor' => ['rgb' => '4472C4'],
                    ],
                    'borders' => [
                        'allBorders' => [
                            'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                            'color' => ['rgb' => '000000'],
                        ],
                    ],
                    'alignment' => [
                        'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
                        'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER,
                    ],
                ];
                $workSheet->getStyle('E10:L10')->applyFromArray($subHeaderStyle);
    

                // Style for title rows
                $titleStyle = [
                    'font' => [
                        'bold' => true,
                        'size' => 12,
                    ],
                    'alignment' => [
                        'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
                    ],
                    'borders' => [
                    'allBorders' => [
                        'borderStyle' => Border::BORDER_NONE,
                    ],
                ],
                ];
    
                // Apply title style to title rows
                $workSheet->getStyle('A1:U8')->applyFromArray($titleStyle);
                $specificRangeStyle = [
                    'font' => [
                        'size' => 10,
                    ],
                ];
                $workSheet->getStyle('A4:U8')->applyFromArray($specificRangeStyle);
                #rows datas
                $workSheet->getRowDimension(1)->setRowHeight(20);
                $workSheet->getRowDimension(2)->setRowHeight(20);
                $workSheet->getRowDimension(3)->setRowHeight(20);
                $workSheet->getRowDimension(4)->setRowHeight(20);
                $workSheet->getRowDimension(5)->setRowHeight(20);
                $workSheet->getRowDimension(6)->setRowHeight(20);
                $workSheet->getRowDimension(7)->setRowHeight(20);
                $workSheet->getRowDimension(8)->setRowHeight(25);
                $workSheet->getRowDimension(9)->setRowHeight(30);
                $workSheet->getRowDimension(10)->setRowHeight(30);

                $headerStyle = [
                    'font' => [
                        'bold' => true,
                        'size' => 10,
                        'color' => ['rgb' => 'FFFFFF'],
                    ],
                    'fill' => [
                        'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                        'startColor' => ['rgb' => '4472C4'],
                    ],
                    'borders' => [
                        'allBorders' => [
                            'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                            'color' => ['rgb' => '000000'],
                        ],
                    ],
                ];
    
                // Apply header style to the header row (assuming it's row 7)
                $workSheet->getStyle('A9:U10')->applyFromArray($headerStyle);
                // Make headers wrap text
                $workSheet->getStyle('A9:U10')->getAlignment()->setWrapText(true);
                $workSheet->mergeCells('E9:L9');
                $dataStyle = [
                    'borders' => [
                        'allBorders' => [
                            'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                            'color' => ['rgb' => '000000'],
                        ],
                    ],
                ];
    

                 #photo and signature
                $candidate_data = LoksewaReport::query()->filter($this->ad_id)->designation($this->designation)->orderBy('full_name')->get();
                foreach ($candidate_data as $index => $data) {
                    $rowIndex = 11 + $index; // Start from row 9
    
                    $workSheet->getRowDimension($rowIndex)->setRowHeight(50);
    
                    // Add photo
                    $drawing = new Drawing();
                    $drawing->setName('Photo');
                    $drawing->setDescription('Candidate Photo');
                    $photoPath = public_path($data->photo);
                    $drawing->setPath(File::exists($photoPath) ? $photoPath : public_path('images/avatar.jpg'));
                    $drawing->setHeight(50);
                    $drawing->setWidth(50);
                    $drawing->setOffsetX(5);
                    $drawing->setOffsetY(5);
                    $drawing->setCoordinates('M' . $rowIndex);
                    $drawing->setWorksheet($workSheet);
    
                    // Add signature
                    $drawing1 = new Drawing();
                    $drawing1->setName('Signature');
                    $drawing1->setDescription('Candidate Signature');
                    $signaturePath = public_path($data->signature);
                    $drawing1->setPath(File::exists($signaturePath) ? $signaturePath : public_path('images/avatar.jpg'));
                    $drawing1->setHeight(50);
                    $drawing1->setWidth(50);
                    $drawing1->setOffsetX(5);
                    $drawing1->setOffsetY(5);
                    $drawing1->setCoordinates('N' . $rowIndex);
                    $drawing1->setWorksheet($workSheet);
                }

                foreach (range('A', 'U') as $column) {
                    $workSheet->getColumnDimension($column)->setAutoSize(false);
                }
                $workSheet->getColumnDimension('A')->setWidth(4);  // क्र.सं
                $workSheet->getColumnDimension('B')->setWidth(4); // रोल नं
                $workSheet->getColumnDimension('C')->setWidth(18); // उम्मेदवारको नामथर
                $workSheet->getColumnDimension('D')->setWidth(6);  // लिङ्ग
                $workSheet->getColumnDimension('E')->setWidth(6);// आ. प्र 
                $workSheet->getColumnDimension('F')->setWidth(6);  // खुल्ला
                $workSheet->getColumnDimension('G')->setWidth(6);  // महिला
                $workSheet->getColumnDimension('H')->setWidth(6); // जनजाती
                $workSheet->getColumnDimension('I')->setWidth(6); // मधेसी
                $workSheet->getColumnDimension('J')->setWidth(5);  // दलित
                $workSheet->getColumnDimension('K')->setWidth(5);  // अपाङ्ग
                $workSheet->getColumnDimension('L')->setWidth(8); // पिछडिएको क्षेत्र
                $workSheet->getColumnDimension('M')->setWidth(12); // फोटो
                $workSheet->getColumnDimension('N')->setWidth(12); // हस्ताक्षर
                $workSheet->getColumnDimension('O')->setWidth(10); // टोक्न  नं
                $workSheet->getColumnDimension('P')->setWidth(30); // स्थायी ठेगाना
                $workSheet->getColumnDimension('Q')->setWidth(15); // मोबाईल नं
                $workSheet->getColumnDimension('R')->setWidth(18); // बाजेको नाम
                $workSheet->getColumnDimension('S')->setWidth(30); // बाबु/आमाको नाम
                $workSheet->getColumnDimension('T')->setWidth(25); // नागरिकता नं,जारि जिल्ला
                $workSheet->getColumnDimension('U')->setWidth(10); 

                $styleArray = [
                    'font' => [
                        'bold' => true,
                    ],
                    'alignment' => [
                        'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
                    ],
                    'borders' => [
                        'top' => [
                            'borderStyle' => Border::BORDER_NONE,
                        ],
                    ],
                ];

                $workSheet->getStyle('H1:H3')->applyFromArray($styleArray);
                $workSheet->getStyle('A7:T7')->applyFromArray($styleArray);
                $workSheet->mergeCells('B6:T6');

                $workSheet->setCellValue('A1', 'नेपाल दूरसंचार कम्पनी लिमिटेड');
                $workSheet->mergeCells('A1:U1');
                $workSheet->getStyle('A1')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
                $workSheet->getStyle('A1')->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);
                
                $workSheet->setCellValue('A2', '(नेपाल टेलिकम)');
                $workSheet->mergeCells('A2:U2');
                $workSheet->getStyle('A2')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
                $workSheet->getStyle('A2')->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);
                

                $workSheet->setCellValue('A3', 'पदपूर्ति सचिबालय');
                $workSheet->mergeCells('A3:U3');
                $workSheet->getStyle('A3')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
                $workSheet->getStyle('A3')->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);

                
                // dd($ad_no);
                $workSheet->setCellValue('A4', '        विज्ञापन:  '.$ad_no);
                $workSheet->mergeCells('A4:U4');
                $workSheet->getStyle('A4')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT);


                $workSheet->setCellValue('A5', "        पद:   $designation                                 तह:   $work_level");
                $workSheet->mergeCells('A5:U5');
                $workSheet->getStyle('A5')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT);

                $workSheet->setCellValue('A6', "        सेवा, समूह, उपसमूह :  $service");
                $workSheet->mergeCells('A6:U6');
                $workSheet->getStyle('A6')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT);
               
               
               
               
                $workSheet->setCellValue('A7', "        पद संख्या:  $total               खुल्ला: $open                महिला: $female   जनजाती: $janjati                मधेशी: $madhesi    दलित: $dalit    अपाङ्ग: $apanga   पिछडीएको क्षेत्र: $remote");
                $workSheet->mergeCells('A7:U7');
                $workSheet->getStyle('A7')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT);

                $workSheet->setCellValue('A8', 'आ.प्र,खुला तथा समाबेशी तर्फका उम्मेदवारहरुको स्वीकृत नामावली');
                $workSheet->mergeCells('A8:U8');
                $workSheet->getStyle('A8')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
                $workSheet->getStyle('A8')->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);


                      // Add custom row at the end
            $lastDataRow = $workSheet->getHighestDataRow(); // Get the last data row
            $customRow = $lastDataRow + 1;
            $workSheet->setCellValue('A'.$customRow, "                                      तयार गर्ने :                                       रुजु गर्ने:                                                   प्रमाणित गर्ने:");
            $workSheet->mergeCells("A$customRow:T$customRow");
            $workSheet->getStyle('A'.$customRow)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT);
           
            // $workSheet->getStyle('A'.$customRow)->applyFromArray($headerStyle);
            $workSheet->getRowDimension($customRow)->setRowHeight(25);
        },
        ];
    }
    private $index = 0;
    public function map($row): array
    {
        $this->index++;
        return [
            $this->index,
            $row->exam_roll_no,
            $row->full_name_np,
            $row->gender,
            $row->is_open == 0 ? '✓' : '', 
            $row->is_open,
            $row->is_female,
            $row->is_janajati,
            $row->is_madhesi,
            $row->is_dalit,
            $row->is_handicapped,
            $row->is_remote_village,
            '',
            '',
            $row->token_number,
            $row->address_np,
            $row->mobile_no,
            $row->grand_father_np,
            $row->father_mother_np,
            $row->citizenship_no.','.$row->citizenship_district,
            $row->total_paid_amount,
 
        ];
    }



}
