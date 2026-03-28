<?php

namespace App\Exports;
use \PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Worksheet\MemoryDrawing;
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
use Illuminate\Support\Facades\Log;

class LokSewaNewReportExportExcel implements FromQuery, WithHeadings, WithMapping,ShouldAutoSize,WithEvents
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
       return LoksewaReport::query()->filter($this->ad_id)->designation($this->designation)->orderByRaw('CAST(exam_roll_no AS UNSIGNED) ASC');
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
                    'क्र.सं', 'रोल नं', 'उम्मेदवारको नामथर', 'लिङ्ग', 'आवेदन समूह', 'फोटो', 'हस्ताक्षर', 'टोकन  नं', 'स्थायी ठेगाना', 'मोबाईल नं', 'बाजेको नाम', 'बाबु/आमाको नाम', 'नागरिकता नं,जारी जिल्ला', 'बुझाएको दस्तुर'
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
                $workSheet->getStyle('A4:N8')->applyFromArray($specificRangeStyle);
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
                $workSheet->getStyle('A9:N9')->applyFromArray($headerStyle);
                // Make headers wrap text
                $workSheet->getStyle('A9:N9')->getAlignment()->setWrapText(true);
                // $workSheet->mergeCells('E9:L9');
                $dataStyle = [
                    'borders' => [
                        'allBorders' => [
                            'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                            'color' => ['rgb' => '000000'],
                        ],
                    ],
                ];
    

                 #photo and signature
                $candidate_data = LoksewaReport::query()->filter($this->ad_id)->designation($this->designation)->orderByRaw('CAST(exam_roll_no AS UNSIGNED) ASC')->get();
                // dd($candidate_data)
                foreach ($candidate_data as $index => $data) {
                    $rowIndex = 10 + $index; // Start from row 9
    
                    $workSheet->getRowDimension($rowIndex)->setRowHeight(50);

                    $addImage = function($path,$column) use ($workSheet, $rowIndex) {
                        try{
                            if (File::exists($path) && is_readable($path) && getimagesize($path) !== false) {
                                $imageData = file_get_contents($path);

                                
                                $drawing = new MemoryDrawing();
                                $drawing->setName('Image');
                                $drawing->setDescription('Candidate Image');
                                $drawing->setImageResource(imagecreatefromstring($imageData));
                                $drawing->setRenderingFunction(MemoryDrawing::RENDERING_PNG);
                                $drawing->setMimeType(MemoryDrawing::MIMETYPE_PNG);
                                $drawing->setHeight(50);
                                $drawing->setWidth(50);
                                $drawing->setCoordinates($column . $rowIndex);
                                $drawing->setWorksheet($workSheet);
                            } else {
                                $workSheet->setCellValue($column . $rowIndex, 'Image Not Available');
                            }
                    }catch (\Exception $e) {
                        Log::error('Error adding image: ' . $e->getMessage() . ' Path: ' . $path);
                        $workSheet->setCellValue($column . $rowIndex, 'Error Loading Image');
                       }
                    };
                    
                // Add photo
                    $photoPath = $data->photo ? public_path($data->photo) : public_path('images/avatar.jpg');
                    $addImage($photoPath, 'F');
                    
                   // Add signature
                $signaturePath = $data->signature ? public_path($data->signature) : public_path('images/default_signature.jpg');
                $addImage($signaturePath, 'G');
                    // Add photo
                //     $drawing = new Drawing();
                //     $drawing->setName('Photo');
                //     $drawing->setDescription('Candidate Photo');
                //     $photoPath = public_path($data->photo);
                //     $drawing->setPath(File::exists($photoPath) ? $photoPath : public_path('images/avatar.jpg'));
                //     $drawing->setHeight(50);
                //     $drawing->setWidth(50);
                //     $drawing->setOffsetX(5);
                //     $drawing->setOffsetY(5);
                //     $drawing->setCoordinates('F' . $rowIndex);
                //     $drawing->setWorksheet($workSheet);
    
                //     // Add signature
                //     $drawing1 = new Drawing();
                //     $drawing1->setName('Signature');
                //     $drawing1->setDescription('Candidate Signature');
                //     $signaturePath = public_path($data->signature);
                //     $drawing1->setPath(File::exists($signaturePath) ? $signaturePath : public_path('images/avatar.jpg'));
                //     $drawing1->setHeight(50);
                //     $drawing1->setWidth(50);
                //     $drawing1->setOffsetX(5);
                //     $drawing1->setOffsetY(5);
                //     $drawing1->setCoordinates('G' . $rowIndex);
                //     $drawing1->setWorksheet($workSheet);
                // 
                
            
            }

                foreach (range('A', 'N') as $column) {
                    $workSheet->getColumnDimension($column)->setAutoSize(false);
                }
                $workSheet->getColumnDimension('A')->setWidth(4);  // क्र.सं
                $workSheet->getColumnDimension('B')->setWidth(4); // रोल नं
                $workSheet->getColumnDimension('C')->setWidth(18); // उम्मेदवारको नामथर
                $workSheet->getColumnDimension('D')->setWidth(6);  // लिङ्ग
                $workSheet->getColumnDimension('E')->setWidth(15);
                $workSheet->getColumnDimension('F')->setWidth(12); // फोटो
                $workSheet->getColumnDimension('G')->setWidth(12); // हस्ताक्षर
                $workSheet->getColumnDimension('H')->setWidth(10); // टोक्न  नं
                $workSheet->getColumnDimension('I')->setWidth(30); // स्थायी ठेगाना
                $workSheet->getColumnDimension('J')->setWidth(15); // मोबाईल नं
                $workSheet->getColumnDimension('K')->setWidth(18); // बाजेको नाम
                $workSheet->getColumnDimension('L')->setWidth(30); // बाबु/आमाको नाम
                $workSheet->getColumnDimension('M')->setWidth(25); // नागरिकता नं,जारि जिल्ला
                $workSheet->getColumnDimension('N')->setWidth(10); 

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
                $workSheet->getStyle('A7:N7')->applyFromArray($styleArray);
                $workSheet->mergeCells('B6:N6');

                $workSheet->setCellValue('A1', 'नेपाल दूरसंचार कम्पनी लिमिटेड');
                $workSheet->mergeCells('A1:N1');
                $workSheet->getStyle('A1')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
                $workSheet->getStyle('A1')->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);
                
                $workSheet->setCellValue('A2', '(नेपाल टेलिकम)');
                $workSheet->mergeCells('A2:N2');
                $workSheet->getStyle('A2')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
                $workSheet->getStyle('A2')->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);
                

                $workSheet->setCellValue('A3', 'पदपूर्ति सचिबालय');
                $workSheet->mergeCells('A3:N3');
                $workSheet->getStyle('A3')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
                $workSheet->getStyle('A3')->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);

                
                // dd($ad_no);
                $workSheet->setCellValue('A4', '        विज्ञापन:  '.$ad_no);
                $workSheet->mergeCells('A4:N4');
                $workSheet->getStyle('A4')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT);


                $workSheet->setCellValue('A5', "        पद:   $designation                                 तह:   $work_level");
                $workSheet->mergeCells('A5:N5');
                $workSheet->getStyle('A5')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT);

                $workSheet->setCellValue('A6', "        सेवा, समूह, उपसमूह :  $service");
                $workSheet->mergeCells('A6:N6');
                $workSheet->getStyle('A6')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT);
               
               
               
               
                $workSheet->setCellValue('A7', "        पद संख्या:  $total               खुल्ला: $open             महिला: $female   जनजाति: $janjati                मधेशी: $madhesi    दलित: $dalit    अपाङ्ग: $apanga   पिछडिएको क्षेत्र: $remote");
                $workSheet->mergeCells('A7:N7');
                $workSheet->getStyle('A7')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT);

                $workSheet->setCellValue('A8', 'आ.प्र, खुला तथा समाबेशी तर्फका उम्मेदवारहरुको स्वीकृत नामावली');
                $workSheet->mergeCells('A8:N8');
                $workSheet->getStyle('A8')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
                $workSheet->getStyle('A8')->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);


                      // Add custom row at the end
            $lastDataRow = $workSheet->getHighestDataRow(); // Get the last data row
            $customRow = $lastDataRow + 1;
            $workSheet->setCellValue('A'.$customRow, "                                      तयार गर्ने :                                       रुजु गर्ने:                                                   प्रमाणित गर्ने:");
            $workSheet->mergeCells("A$customRow:N$customRow");
            $workSheet->getStyle('A'.$customRow)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT);
           
            // $workSheet->getStyle('A'.$customRow)->applyFromArray($headerStyle);
            $workSheet->getRowDimension($customRow)->setRowHeight(25);
        },
        ];
    }
    private $index = 0;
    public function map($row): array
    {
        // dd($row);
        $this->index++;
        $combined_values = implode(', ', array_filter([
            $row->is_open == 0 ? 'आ. प्र' : 'खुल्ला', 
            $row->is_female == 1 ? 'महिला' : '',
            $row->is_janajati == 1 ? 'आ. ज' : '',
            $row->is_madhesi == 1 ? 'म' : '',
            $row->is_dalit == 1 ? 'द' : '',
            $row->is_handicapped == 1 ? 'अ' : '',
            $row->is_remote_village == 1 ? 'पि.क्षे' : ''
        ]));
        return [
            $this->index,
            $row->exam_roll_no,
            $row->full_name_np??null,
            $row->gender??null,
            $combined_values,
            '',
            '',
            $row->token_number??null,
            $row->address_np??null,
            $row->mobile_no??null,
            $row->grand_father_np??null,
            $row->father_mother_np,
            $row->citizenship_no.','.$row->citizenship_district,
            $row->total_paid_amount,
 
        ];
    }



}
