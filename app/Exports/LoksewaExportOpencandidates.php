<?php

namespace App\Exports;
use App\Models\ApplicantEduInfo;
use App\Models\ApplicantTrainingInfo;
use App\Models\MstDesignationTraining;
use App\Models\VacancyPost;
use App\Models\VwVacancyPostApplicantProfile;
use Illuminate\Database\Query\Builder;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\Exportable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Worksheet;

class LoksewaExportOpencandidates implements FromQuery, WithHeadings, WithMapping, withTitle, ShouldAutoSize, WithEvents
{
    use Exportable;

    protected $vp_id;
    private $data;

    public function __construct(int $vp_id)
    {
        $this->vp_id = $vp_id;
    }

    public function query()
    {
        return VwVacancyPostApplicantProfile::query()->filter()
            ->leftjoin('vacancy_exam', 'vw_vacancy_post_applicant_profile.vacancy_apply_id', 'vacancy_exam.vacancy_apply_id')
            ->leftjoin('mst_gender', 'vw_vacancy_post_applicant_profile.gender', 'mst_gender.id')
            ->leftjoin('vacancy_post', 'vw_vacancy_post_applicant_profile.vp_id', 'vacancy_post.id')
            ->leftjoin('mst_designation_training', function ($join) {
                $join->on('vw_vacancy_post_applicant_profile.designation_id', 'mst_designation_training.designation_id')->where('mst_designation_training.is_deleted', false);
            })
            ->leftjoin('mst_training', function ($join) {
                $join->on('mst_designation_training.training_id', 'mst_training.id')->where('mst_training.is_deleted', false);
            })
            ->leftjoin('applicant_edu_info', function ($join) {
                $join->on('vw_vacancy_post_applicant_profile.ap_id', 'applicant_edu_info.applicant_id')->where('applicant_edu_info.is_deleted', false);
            })
            ->leftjoin('mst_edu_degree', function ($join) {
                $join->on('applicant_edu_info.edu_degree_id', 'mst_edu_degree.id')->where('mst_edu_degree.is_deleted', false);
            })
            ->leftjoin('applicant_training_info', function ($join) {
                $join->on('vw_vacancy_post_applicant_profile.ap_id', 'applicant_training_info.applicant_id')->where('applicant_training_info.is_deleted', false);
            })
            ->leftjoin('applicant_exp_info', function ($join) {
                $join->on('vw_vacancy_post_applicant_profile.ap_id', 'applicant_exp_info.applicant_id')->where('applicant_exp_info.is_deleted', false);
            })
            ->select('mst_gender.name_np as gender_name', 'vacancy_exam.exam_roll_no as roll', 'vw_vacancy_post_applicant_profile.*', 'vacancy_post.ad_no', DB::raw('GROUP_CONCAT(distinct mst_edu_degree.name_en) as degree'),
                DB::raw('GROUP_CONCAT(distinct applicant_training_info.training_title,"/",applicant_training_info.institute_name) as training'), DB::raw('GROUP_CONCAT(distinct applicant_exp_info.working_office,"(",applicant_exp_info.date_from_bs,"/",applicant_exp_info.date_to_bs,")") as experience'))
            ->where([['vp_id', $this->vp_id]])
            ->groupBy('vw_vacancy_post_applicant_profile.ap_id')
            ->orderBy('applicant_name_en');
    }

    public function headings(): array
    {

        $details = VacancyPost::SelectedCandidateFilter($this->vp_id)->with(['designation:id,name_en', 'worklevel:mst_work_level.id,mst_work_level.name_en'])->first();
        $ad_no = $details->ad_no;
        $designation = $details->designation->name_en;
        $work_level = $details->worklevel->name_en;
        $open = $details->open_seats;
        $female = $details->mahila_seats;
        $janjati = $details->janajati_seats;
        $madhesi = $details->madheshi_seats;
        $dalit = $details->dalit_seats;
        $apanga = $details->apanga_seats;
        $remote = $details->remote_seats;
        $total = $details->total_req_seats;

        return [
            [' ', ' ', ' ', ' ', ' ', ' ', ' ', 'नेपाल टेलिकम'],
            [' ', ' ', ' ', ' ', ' ', ' ', ' ', 'पदपूर्ति सचिबालय'],
            ['विज्ञापन:' . $ad_no],
            [
                'पद:' . $designation,
                ' ',
                ' ',
                ' ',
                'तह:' . $work_level,
            ],
            ['पद संख्या:' . $total,
                'खुल्ला:' . $open,
                'महिला:' . $female,
                'आदिवासी/जनजाती:' . $janjati,
                'मधेशी:' . $madhesi,
                'दलित:' . $dalit,
                'अपाङ्ग:' . $apanga,
                'पिछडीएको क्षेत्र:' . $remote,
            ],
            [' ', ' ', ' ', ' ', ' ', ' ', ' ', 'खुला तथा समाबेशी तर्फका उम्मेदवारहरुको स्वीकृत नामावली'],
            [
                'Roll',
                'Applicant ID',
                'Nt Staff Code',
                'नाम',
                'Name',
                'D.O.B.',
                'Gender',
                'Address',
                'बुबा / आमा',
                'बाजे',
                'योग्यता',
                'अनुभब',
                'तालिम',
                'NT Staff',
                'खुल्ला',
                'महिला',
                'आ.ज.',
                'मधेशी',
                'दलित',
                'अपाङ्ग',
                'पि.क्षे.',
                'Token No.',
                'Paid Amount',
                'Receipt no',
                'Paid Date(AD)',
                'Mobile'
            ],
        ];
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {
                $cellRange = 'A7:AC7';
                $event->sheet->getDelegate()->getStyle($cellRange)->getFont()->setSize(14);
                $styleArray = [
                    'font' => [
                        'bold' => true,
                    ],
                    'alignment' => [
                        'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
                    ],
                    'borders' => [
                        'top' => [
                            'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                        ],
                    ],
                    'fill' => [
                        'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_GRADIENT_LINEAR,
                        'rotation' => 90,
                        'startColor' => [
                            'argb' => 'FFA0A0A0',
                        ],
                        'endColor' => [
                            'argb' => 'FFFFFFFF',
                        ],
                    ],
                ];


                $event->sheet->getDelegate()->getStyle('H1')->applyFromArray($styleArray);
                $event->sheet->getDelegate()->getStyle('H2')->applyFromArray($styleArray);
                $event->sheet->getDelegate()->getStyle('H6')->applyFromArray($styleArray);
                $event->sheet->getDelegate()->getColumnDimension('N7')->setAutoSize(false)->setWidth(10);
                $event->sheet->getDelegate()->getStyle('A7:AD7')->applyFromArray($styleArray);
            },
        ];

    }

    public function map($row): array
    {
        return [
            $row->roll,
            $row->ap_id,
            $row->nt_staff_code,
            $row->applicant_name_np,
            $row->applicant_name_en,
            $row->date_of_birth,
            $row->gender_name,
            $row->address,
            $row->father_mother_np,
            $row->grand_father_np,
            $row->degree,
            $row->experience,
            $row->training,
            $row->nt_staff,
            $row->is_open,
            $row->is_female,
            $row->is_janajati,
            $row->is_madhesi,
            $row->is_dalit,
            $row->is_handicapped,
            $row->is_remote_village,
            $row->token_number,
            $row->total_paid_amount,
            $row->paid_receipt_no,
            $row->paid_date_ad,
            $row->mobile,
        ];
    }

    public function fields(): array
    {
        return [
            'roll',
            'ap_id',
            'nt_staff_code',
            'applicant_name_np',
            'applicant_name_en',
            'date_of_birth',
            'gender',
            'address',
            'father_mother',
            'father_mother_np',
            'grand_father',
            'grand_father_np',
            'roll',
            'ap_id',
            'nt_staff_code',
            'nt_staff',
            'is_open',
            'is_female',
            'is_janajati',
            'is_madhesi',
            'is_dalit',
            'is_handicapped',
            'is_remote_village',
            'token_number',
            'total_amount',
            'total_paid_amount',
            'paid_receipt_no',
            'paid_date_ad',
            'email',
            'mobile',
        ];
    }

    public function title(): string
    {
        return 'Applicantsheet1';
    }
}
