<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Snappy PDF / Image Configuration
    |--------------------------------------------------------------------------
    |
    | This option contains settings for PDF generation.
    |
    | Enabled:
    |
    |    Whether to load PDF / Image generation.
    |
    | Binary:
    |
    |    The file path of the wkhtmltopdf / wkhtmltoimage executable.
    |
    | Timout:
    |
    |    The amount of time to wait (in seconds) before PDF / Image generation is stopped.
    |    Setting this to false disables the timeout (unlimited processing time).
    |
    | Options:
    |
    |    The wkhtmltopdf command options. These are passed directly to wkhtmltopdf.
    |    See https://wkhtmltopdf.org/usage/wkhtmltopdf.txt for all options.
    |
    | Env:
    |
    |    The environment variables to set while running the wkhtmltopdf process.
    |
     */

    'pdf' => [
        'enabled' => true,
        'binary' => base_path('vendor/h4cc/wkhtmlpdf/bin/wkhtmlpdf'),
        'timeout' => false,
         'options' => array(
            'page-size' => 'A4',
            'margin-top' => 10,
            'margin-right' => 10,
            'margin-left' => 10,
            'margin-bottom' => 10,
            'orientation' => 'Portrait',
            'footer-right' => 'Page [page] of [toPage]',
            'footer-left'      => '[date]',
            'footer-font-size' => 8,
            'encoding' => 'UTF-8',
        ),
        'env' => [],
    ],

    'image' => [
        'enabled' => true,
       'binary' => base_path('vendor/h4cc/wkhtmlimage/bin/wkhtmlimage'),
        'timeout' => false,
        'options' => [],
        'env' => [],
    ],



];
