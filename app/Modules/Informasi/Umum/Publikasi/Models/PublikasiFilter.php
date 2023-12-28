<?php

namespace App\Modules\Informasi\Umum\Publikasi\Models;

use Bonfire\Core\Traits\Filterable;
use CodeIgniter\I18n\Time;

class PublikasiFilter extends PublikasiModel
{
    use Filterable;

    /**
     * The filters that can be applied to
     * lists of Publikasi
     *
     * @var array
     */
    protected $filters = [];

    function __construct()
    {
        parent::__construct();

        $this->filters = [

            'created_at' => [
                'title'   => lang('Publikasi.headingCreated'),
                'type'    => 'radio', //or 'checkbox'
                'options' => [
                    1   => '1 ' . lang('Publikasi.labelDay'),
                    2   => '2 ' . lang('Publikasi.labelDays'),
                    3   => '3 ' . lang('Publikasi.labelDays'),
                    7   => '1 ' . lang('Publikasi.labelWeek'),
                    14  => '2 ' . lang('Publikasi.labelWeeks'),
                    30  => '1 ' . lang('Publikasi.labelMonth'),
                    90  => '3 ' . lang('Publikasi.labelMonths'),
                    180 => '6 ' . lang('Publikasi.labelMonths'),
                    365 => '1 ' . lang('Publikasi.labelYear'),
                    'all' => lang('Publikasi.labelAnyTime'),
                ],
            ],
        ];
    }

    /**
     * Provides filtering functionality.
     *
     * @param array $params
     *
     * @return PublikasiFilter
     */
    public function filter(?array $params = null)
    {
        $this->select('publikasi.*');



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
