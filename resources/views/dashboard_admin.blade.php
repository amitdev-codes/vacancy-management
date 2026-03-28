@extends('crudbooster::admin_template')
@section('content')
    <style>
        .bg-white {
            background: #fff;
            box-shadow: 0 0 1px rgb(0 0 0 / 13%), 0 1px 3px rgb(0 0 0 / 20%);
        }
    </style>

    @if(in_array(CRUDBooster::myPrivilegeId(),[1,5]))

   <div class="row col-md-12">
        <div class="col-md-3 col-sm-6 col-xs-12">
            <div class="info-box">
                <span class="info-box-icon bg-green">रू.</span>
                <div class="info-box-content text-success">
                    <span class="info-box-number nepali_td">{{ Helper::money_format_nep($pay_today[0]->total_pay) }}</span>
                    <span class="info-box-text nepali_td"><strong>आज</strong></span>
                    <span
                        class="info-box-text nepali_td"><strong>Esewa:</strong>{{ Helper::money_format_nep($esewa_pay_today[0]->total_pay) }}</span>
                    <span
                        class="info-box-text nepali_td"><strong>IPS:</strong>{{ Helper::money_format_nep($Ips_pay_today[0]->total_pay) }}</span>
                    <span
                        class="info-box-text nepali_td"><strong>Khalti:</strong>{{ Helper::money_format_nep($khalti_pay_today[0]->total_pay) }}</span>
                    <span
                        class="info-box-text nepali_td"><strong>NamastePay:</strong>{{ Helper::money_format_nep($namastepay_pay_today[0]->total_pay) }}</span>
                    <span
                        class="info-box-text nepali_td"><strong>SajiloPay:</strong>{{ Helper::money_format_nep($sajilopay_pay_today[0]->total_pay) }}</span>
                </div>
            </div>
        </div>

        <div class="col-md-3 col-sm-6 col-xs-12">
            <div class="info-box">
                <span class="info-box-icon bg-blue">रू.</span>
                <div class="info-box-content text-primary">
                    <span
                        class="info-box-number nepali_td">{{ Helper::money_format_nep($pay_yesterday[0]->total_pay) }}</span>
                    <span class="info-box-text nepali_td"><strong>हिजो</strong></span>
                    <span
                        class="info-box-text nepali_td"><strong>Esewa:</strong>{{ Helper::money_format_nep($esewa_pay_yesterday[0]->total_pay) }}</span>
                    <span
                        class="info-box-text nepali_td"><strong>IPS:</strong>{{ Helper::money_format_nep($Ips_pay_yesterday[0]->total_pay) }}</span>
                    <span
                        class="info-box-text nepali_td"><strong>Khalti:</strong>{{ Helper::money_format_nep($khalti_pay_yesterday[0]->total_pay) }}</span>
                    <span
                        class="info-box-text nepali_td"><strong>NamastePay:</strong>{{ Helper::money_format_nep($namastepay_pay_yesterday[0]->total_pay) }}</span>
                    <span
                        class="info-box-text nepali_td"><strong>SajiloPay:</strong>{{ Helper::money_format_nep($sajilopay_pay_yesterday[0]->total_pay) }}</span>
                </div>
            </div>
        </div>

        <div class="col-md-3 col-sm-6 col-xs-12">
            <div class="info-box">
                <span class="info-box-icon bg-yellow">रू.</span>
                <div class="info-box-content text-warning">
                    <span
                        class="info-box-number nepali_td">{{ Helper::money_format_nep($pay_weekly[0]->total_pay) }}</span>
                    <span class="info-box-text nepali_td"><strong>साप्ताहिक</strong></span>
                    <span
                        class="info-box-text nepali_td"><strong>Esewa:</strong>{{ Helper::money_format_nep($esewa_pay_weekly[0]->total_pay) }}</span>
                    <span
                        class="info-box-text nepali_td"><strong>IPS:</strong>{{ Helper::money_format_nep($Ips_pay_weekly[0]->total_pay) }}</span>
                    <span
                        class="info-box-text nepali_td"><strong>Khalti:</strong>{{ Helper::money_format_nep($khalti_pay_weekly[0]->total_pay) }}</span>
                    <span
                        class="info-box-text nepali_td"><strong>NamastePay:</strong>{{ Helper::money_format_nep($namastepay_pay_weekly[0]->total_pay) }}</span>
                    <span
                        class="info-box-text nepali_td"><strong>SajiloPay:</strong>{{ Helper::money_format_nep($sajilopay_pay_weekly[0]->total_pay) }}</span>
                </div>
            </div>
        </div>

        <div class="col-md-3 col-sm-6 col-xs-12">
            <div class="info-box">
                <span class="info-box-icon bg-red">रू.</span>
                <div class="info-box-content text-danger">
                    <span class="info-box-number nepali_td">{{ Helper::money_format_nep($pay_total[0]->total_pay) }}</span>
                    <span class="info-box-text nepali_td"><strong>कूल</strong></span>
                    <span
                        class="info-box-text nepali_td"><strong>Esewa:</strong>{{ Helper::money_format_nep($esewa_pay_total[0]->total_pay) }}</span>
                    <span
                        class="info-box-text nepali_td"><strong>IPS:</strong>{{ Helper::money_format_nep($Ips_pay_total[0]->total_pay) }}</span>
                    <span
                        class="info-box-text nepali_td"><strong>Khalti:</strong>{{ Helper::money_format_nep($khalti_pay_total[0]->total_pay) }}</span>
                    <span
                        class="info-box-text nepali_td"><strong>NamastePay:</strong>{{ Helper::money_format_nep($namastepay_pay_total[0]->total_pay) }}</span>
                    <span
                        class="info-box-text nepali_td"><strong>SajiloPay:</strong>{{ Helper::money_format_nep($sajilopay_pay_total[0]->total_pay) }}</span>
                </div>
            </div>
        </div>
    </div>

    <div class="main">
        <div class="main-inner">
            <div class="container">

                <div class="row">
                    <div class="col-md-4 bg-white" style="margin-right: 10px;">
                        <div class="widget-content">
                            <div id="psptotal" style="height: 400px;"></div>
                        </div>
                    </div>

                    <div class="col-md-7 bg-white">
                        <div class="widget-content">
                            <div id="pspchart" style="height: 400px;"></div>
                        </div>
                    </div>
                </div>

                <br />

                <div class="row">
                    <div class="col-md-4 bg-white" style="margin-right: 10px;">
                        <div class="widget-content">
                            <div id="chart1" style="height: 400px;"></div>
                        </div>
                    </div>
                    <div class="col-md-7 bg-white">
                        <div class="widget-content">
                            <div id="chart" style="height: 400px;"></div>
                        </div>
                    </div>
                </div>

                <br />
                <div class="row">
                    <div class="col-md-4 bg-white" style="margin-right: 10px;">
                        <div class="widget-content">
                            <div id="paid_cancelled_applicant_chart" style="height:400px;"></div>
                        </div>
                    </div>
                    <div class="col-md-7 bg-white">
                        <div class="widget-content">
                            <div id="designation_chart" style="height: 400px;"></div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
    @endif

    <script src="https://unpkg.com/chart.js@2.9.3/dist/Chart.min.js"></script>
    <script src="https://unpkg.com/@chartisan/chartjs@^2.1.0/dist/chartisan_chartjs.umd.js"></script>
    <script>
        const chart1 = new Chartisan({
            el: '#chart1',
            url: "/admin/dashboard/chartdata",

            hooks: new ChartisanHooks()
                .beginAtZero()
                .legend({
                    position: 'bottom'
                })
                .title('Privilege Group-Wise Applications')
                .colors()
        });
    </script>

    <script>
        const psptotal = new Chartisan({
            el: '#psptotal',
            url: "/admin/dashboard/psptotal",
            hooks: new ChartisanHooks()
                .beginAtZero()
                .legend({
                    position: 'bottom'
                })
                .title('PSP-Wise Applications')
                .colors()
        });
    </script>

    <script>
        const pspchart = new Chartisan({
            el: '#pspchart',
            url: "/admin/dashboard/pspchart",
            hooks: new ChartisanHooks()
                .datasets('pie')
                .title('PSP-Wise Applications')
                .legend({
                    position: 'bottom'
                })
                .pieColors()
        });
    </script>

    <script>
        const chart = new Chartisan({
            el: '#chart',
            url: "/admin/dashboard/reg_user_chart",
            hooks: new ChartisanHooks()
                .datasets('doughnut')
                .title('Gender-Wise Applications')
                .legend({
                    position: 'bottom'
                })
                .pieColors(),
        });
    </script>

    <script>
        const paid_cancelled_applicant_chart = new Chartisan({
            el: '#paid_cancelled_applicant_chart',
            url: "/admin/dashboard/paid_cancelled_applicant_chart",
            hooks: new ChartisanHooks()
                .beginAtZero()
                .title('Paid Applications')
                .legend({
                    position: 'bottom'
                })
                .colors()
        });
    </script>
    <script>
        const designation_chart = new Chartisan({
            el: '#designation_chart',
            url: "/admin/dashboard/designation_chart",
            hooks: new ChartisanHooks()
                .beginAtZero()
                .title('Designation-wise Applications')
                .legend({
                    position: 'bottom'
                })
                .colors()
        });
    </script>
@endsection
