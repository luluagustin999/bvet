<?php

namespace App\Modules\Informasi\Umum\Pengumuman\Models;

use Bonfire\Core\Traits\Filterable;
use CodeIgniter\I18n\Time;

class PengumumanFilter extends PengumumanModel
{
    use Filterable;

    /**
     * The filters that can be applied to
     * lists of Pengumuman
     *
     * @var array
     */
    protected $filters = [];

    function __construct()
    {
        parent::__construct();

        $this->filters = [

            'created_at' => [
                'title'   => lang('Pengumuman.headingCreated'),
                'type'    => 'radio', //or 'checkbox'
                'options' => [
                    1   => '1 ' . lang('Pengumuman.labelDay'),
                    2   => '2 ' . lang('Pengumuman.labelDays'),
                    3   => '3 ' . lang('Pengumuman.labelDays'),
                    7   => '1 ' . lang('Pengumuman.labelWeek'),
                    14  => '2 ' . lang('Pengumuman.labelWeeks'),
                    30  => '1 ' . lang('Pengumuman.labelMonth'),
                    90  => '3 ' . lang('Pengumuman.labelMonths'),
                    180 => '6 ' . lang('Pengumuman.labelMonths'),
                    365 => '1 ' . lang('Pengumuman.labelYear'),
                    'all' => lang('Pengumuman.labelAnyTime'),
                ],
            ],
        ];
    }

    /**
     * Provides filtering functionality.
     *
     * @param array $params
     *
     * @return PengumumanFilter
     */
    public function filter(?array $params = null)
    {
        $this->select('pengumuman.*');



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
