<?php

namespace App\Exports;
use App\Models\LoksewaReport;
use App\Models\VacancyAd;
use App\Models\VacancyPost;
use File;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Worksheet\Drawing;

class LokSewaReportExport implements FromQuery, WithHeadings, WithMapping,ShouldAutoSize,WithEvents
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
    $details = VacancyPost::search($this->ad_id, $this->designation)->with(['designation:id,name_en','worklevel:mst_work_level.id,mst_work_level.name_en'])->first();
    $ad_no = $details->ad_no;
    $opening_type = VacancyAd::where('id', $details->vacancy_ad_id)->pluck('ad_title_en')->first();
    $designation = $details->designation->name_np;
    $work_level = $details->worklevel->name_en;
    $open = $details->open_seats;
    $female = $details->mahila_seats;
    $janjati = $details->janjati_seats;
    $madhesi = $details->madhesi_seats;
    $dalit = $details->dalit_seats;
    $apanga = $details->apanga_seats;
    $remote = $details->remote_seats;
    $total = $details->total_req_seats;

    return [
            [' ',' ',' ',' ',' ',' ',' ','नेपाल टेलिकम'],
            [' ',' ',' ',' ',' ',' ',' ','पदपूर्ति सचिबालय'],
            ['विज्ञापन:'.$ad_no],
            [
                'पद:'.$designation,
                ' ',
                ' ',
                ' ',
                'तह:'.$work_level,
            ],
            ['पद संख्या:'.$total,
                'खुल्ला:'.$open,
                'महिला:'.$female,
                'जनजाती:'.$janjati,
                'मधेशी:'.$madhesi,
                'दलित:'.$dalit,
                'अपाङ्ग:'.$apanga,
                'पिछडीएको क्षेत्र:'.$remote,
            ],
            [' ',' ',' ',' ',' ',' ',' ','खुला तथा समाबेशी तर्फका उम्मेदवारहरुको स्वीकृत नामावली'],
        [
            'रोल नं', 'पुरा नाम', 'लिङ्ग', 'फोटो', 'हस्ताक्षर', 'टोक्न  नं', 'नागरिकता नं,जारि जिल्ला',
            'खुल्ला', 'महिला', 'जनजाती', 'मधेसी', 'दलित', 'अपाङ्ग', 'पिछडिएको क्षेत्र'
        ],
    ];
}
    // public function headings(): array
    // {
    //     $details=VacancyPost::search($this->ad_id,$this->designation)->with(['designation:id,name_en','worklevel:mst_work_level.id,mst_work_level.name_en'])->first();
    //     $ad_no=$details->ad_no;
    //     $opening_type=VacancyAd::where('id',$details->vacancy_ad_id)->pluck('ad_title_en');

    //     // dd($opening_type);
    //     $ot=$opening_type[0];
    //     // dd($ot);

    //     $designation=$details->designation->name_np;
    //     $work_level=$details->worklevel->name_en;
    //     $open=$details->open_seats;
    //     $female=$details->mahila_seats;
    //     $janjati=$details->janjati_seats;
    //     $madhesi=$details->madhesi_seats;
    //     $dalit=$details->dalit_seats;
    //     $apanga=$details->apanga_seats;
    //     $remote=$details->remote_seats;
    //     $total=$details->total_req_seats;
    //     return[
    //         [' ',' ',' ',' ',' ',' ',' ','नेपाल टेलिकम'],
    //         [' ',' ',' ',' ',' ',' ',' ','पदपूर्ति सचिबालय'],
    //         ['विज्ञापन:'.$ad_no],
    //         [
    //             'पद:'.$designation,
    //             ' ',
    //             ' ',
    //             ' ',
    //             'तह:'.$work_level,
    //         ],
    //         ['पद संख्या:'.$total,
    //             'खुल्ला:'.$open,
    //             'महिला:'.$female,
    //             'जनजाती:'.$janjati,
    //             'मधेशी:'.$madhesi,
    //             'दलित:'.$dalit,
    //             'अपाङ्ग:'.$apanga,
    //             'पिछडीएको क्षेत्र:'.$remote,
    //         ],
    //         [' ',' ',' ',' ',' ',' ',' ','खुला तथा समाबेशी तर्फका उम्मेदवारहरुको स्वीकृत नामावली'],
    //         [
    //             'रोल नं',
    //             'पुरा नाम',
    //             'लिङ्ग',
    //             'फोटो',
    //             'हस्ताक्षर',
    //             'टोक्न  नं',
    //             // 'applicant_id',
    //             'नागरिकता नं,जारि जिल्ला ',
    //             'खुल्ला',
    //             'महिला',
    //             'जनजाती',
    //             'मधेसी',
    //             'दलित',
    //             'अपाङ्ग',
    //             'पिछडिएको क्षेत्र ',
    //         ],
    //         // [
    //         //     'exam_roll_no',
    //         //     'full_name',
    //         //     'gender',
    //         //     'photo',
    //         //     'signature',
    //         //     'token_number',
    //         //     'applicant_id',
    //         //     'citizenship_no,citizenship_district',
    //         //     'is_open',
    //         //     'is_female',
    //         //     'is_janajati',
    //         //     'is_madhesi',
    //         //     'is_dalit',
    //         //     'is_handicapped',
    //         //     'is_remote_village',
    //         // ],
    //     ];
    // }

    // public function registerEvents(): array
    // {
    //     return [
    //         AfterSheet::class=> function(AfterSheet $event) {
    //             $event->sheet->getParent()->getDefaultStyle()->getFont()->setName('Kalimati');
    //             $event->sheet->getParent()->getDefaultStyle()->getFont()->setSize(11);

    //             $cellRange = 'A7:O7';
    //             $event->sheet->getDelegate()->getStyle($cellRange)->getFont()->setSize(14);

    //             $styleArray = [
    //                 'font' => [
    //                     'bold' => true,
    //                 ],
    //                 'alignment' => [
    //                     'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
    //                 ],
    //                 'borders' => [
    //                     'top' => [
    //                         'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
    //                     ],
    //                 ],
    //                 'fill' => [
    //                     'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_GRADIENT_LINEAR,
    //                     'rotation' => 90,
    //                     'startColor' => [
    //                         'argb' => 'FFA0A0A0',
    //                     ],
    //                     'endColor' => [
    //                         'argb' => 'FFFFFFFF',
    //                     ],
    //                 ],
    //             ];

    //             $candidate_data=LoksewaReport::query()->filter($this->ad_id)->designation($this->designation)->orderBy('full_name')->get();
    //             for ($i = 0; $i < count($candidate_data); $i++) //iterate based on row count
    //             {
    //                 $event->sheet->getRowDimension((8+$i))->setRowHeight(50);
    //             }
    //             $loop = 1;


    //             foreach ($candidate_data as $data) {
    //                 $drawing = new Drawing();
    //                 $drawing->setName('image');
    //                 $drawing->setDescription('image');

    //                 $path = public_path($data->photo);
    //                 $isExists = File::exists($path);


    //                 if($isExists ){
    //                     $drawing->setPath(public_path($data->photo));
    //                 }else{
    //                     $drawing->setPath(public_path('images/avatar.jpg'));
    //                 }

    //                 $drawing->setHeight(50);
    //                 $drawing->setOffsetX(5);
    //                 $drawing->setOffsetY(5);
    //                 $drawing->setCoordinates('D' . (7+$loop));
    //                 $drawing->setWorksheet($event->sheet->getDelegate());

    //                 $drawing1 = new Drawing();
    //                 $drawing1->setName('image');
    //                 $drawing1->setDescription('image');

    //                 $signaturepath = public_path($data->signature);
    //                 $signatureExists = File::exists($signaturepath);

    //                 if($signatureExists ){
    //                     $drawing1->setPath(public_path($data->signature));
    //                 }else{
    //                     $drawing1->setPath(public_path('images/avatar.jpg'));
    //                 }

    //                 $drawing1->setHeight(50);
    //                 $drawing1->setOffsetX(5);
    //                 $drawing1->setOffsetY(5);
    //                 $drawing1->setCoordinates('E' . (7+$loop));
    //                 $drawing1->setWorksheet($event->sheet->getDelegate());

    //                 $loop++;
    //             }

    //             $event->sheet->getDelegate()->getStyle('H1')->applyFromArray($styleArray);
    //             $event->sheet->getDelegate()->getStyle('H2')->applyFromArray($styleArray);
    //             $event->sheet->getDelegate()->getStyle('H6')->applyFromArray($styleArray);
    //             $event->sheet->getDelegate()->getColumnDimension('N7')->setAutoSize(false)->setWidth(10);
    //             $event->sheet->getDelegate()->getStyle('A7:O7')->applyFromArray($styleArray);
    //         },
    //     ];

    // }


    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function(AfterSheet $event) {
                $workSheet = $event->sheet->getDelegate();
                
                // Set Kalimati font for the entire worksheet
                $workSheet->getParent()->getDefaultStyle()->getFont()->setName('Kalimati');
                $workSheet->getParent()->getDefaultStyle()->getFont()->setSize(11);

                // Center align all cells
                $workSheet->getParent()->getDefaultStyle()->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
                $workSheet->getParent()->getDefaultStyle()->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER);

                // Style for headers
                $headerStyle = [
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
                ];

                // Apply header style to the header row (assuming it's row 7)
                $workSheet->getStyle('A7:O7')->applyFromArray($headerStyle);

                // Make headers wrap text
                $workSheet->getStyle('A7:O7')->getAlignment()->setWrapText(true);

                // Set row height for header
                $workSheet->getRowDimension(7)->setRowHeight(30);

                // Style for data rows
                $dataStyle = [
                    'borders' => [
                        'allBorders' => [
                            'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                            'color' => ['rgb' => '000000'],
                        ],
                    ],
                ];

                // Apply data style to all data rows
                $lastRow = $workSheet->getHighestDataRow();
                $workSheet->getStyle('A8:O' . $lastRow)->applyFromArray($dataStyle);

                // Set column widths
                foreach(range('A','O') as $col) {
                    $workSheet->getColumnDimension($col)->setAutoSize(true);
                }

                // Your existing code for adding images, etc.
                // ...

                // Style for title rows
                $titleStyle = [
                    'font' => [
                        'bold' => true,
                        'size' => 16,
                    ],
                    'alignment' => [
                        'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
                    ],
                ];

                // Apply title style to title rows
                $workSheet->getStyle('A1:O6')->applyFromArray($titleStyle);

                // Merge cells for titles
                $workSheet->mergeCells('A1:O1');
                $workSheet->mergeCells('A2:O2');
                $workSheet->mergeCells('A3:O3');
                $workSheet->mergeCells('A4:O4');
                $workSheet->mergeCells('A5:O5');
                $workSheet->mergeCells('A6:O6');
            },
        ];
    }

    public function map($row): array
    {
        return [
            $row->exam_roll_no,
            $row->full_name_np,
            $row->gender,
           '',
            '',
            $row->token_number,
            // $row->applicant_id,
            $row->citizenship_no.','.$row->citizenship_district,
            $row->is_open,
            $row->is_female,
            $row->is_janajati,
            $row->is_madhesi,
            $row->is_dalit,
            $row->is_handicapped,
            $row->is_remote_village,
        ];
    }
    public function fields(): array
    {
        return [
            'exam_roll_no',
            'full_name',
            'gender',
            'photo',
            'signature',
            'token_number',
            'applicant_id',
            ['citizenship_no','citizenship_district'],
            'is_open',
            'is_female',
            'is_janajati',
            'is_madhesi',
            'is_dalit',
            'is_handicapped',
            'is_remote_village',
        ];
    }

}
