<?php

namespace App\Modules\Informasi\Aplikasi\Models;

use Bonfire\Core\Traits\Filterable;
use CodeIgniter\I18n\Time;

class AplikasiFilter extends AplikasiModel
{
    use Filterable;

    /**
     * The filters that can be applied to
     * lists of Aplikasi
     *
     * @var array
     */
    protected $filters = [];

    function __construct()
    {
        parent::__construct();

        $this->filters = [

            'created_at' => [
                'title'   => lang('Aplikasi.headingCreated'),
                'type'    => 'radio', //or 'checkbox'
                'options' => [
                    1   => '1 ' . lang('Aplikasi.labelDay'),
                    2   => '2 ' . lang('Aplikasi.labelDays'),
                    3   => '3 ' . lang('Aplikasi.labelDays'),
                    7   => '1 ' . lang('Aplikasi.labelWeek'),
                    14  => '2 ' . lang('Aplikasi.labelWeeks'),
                    30  => '1 ' . lang('Aplikasi.labelMonth'),
                    90  => '3 ' . lang('Aplikasi.labelMonths'),
                    180 => '6 ' . lang('Aplikasi.labelMonths'),
                    365 => '1 ' . lang('Aplikasi.labelYear'),
                    'all' => lang('Aplikasi.labelAnyTime'),
                ],
            ],
        ];
    }

    /**
     * Provides filtering functionality.
     *
     * @param array $params
     *
     * @return AplikasiFilter
     */
    public function filter(?array $params = null)
    {
        $this->select('aplikasi.*');



        if (
            isset($params['created_at'])
            && !empty($params['created_at'])
            && $params['created_at'] != 'all'
        ) {
            $days = $params['created_at'];
            $this->where('created_at >=', Time::now()->subDays($days)->toDateTimeString());
        }

        return $this;
    }
}
