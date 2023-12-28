<?php

namespace App\Modules\Informasi\Veteriner\LaporanIkm\Models;

use Bonfire\Core\Traits\Filterable;
use CodeIgniter\I18n\Time;

class LaporanIkmFilter extends LaporanIkmModel
{
    use Filterable;

    /**
     * The filters that can be applied to
     * lists of LaporanIkm
     *
     * @var array
     */
    protected $filters = [];

    function __construct()
    {
        parent::__construct();

        $this->filters = [

            'created_at' => [
                'title'   => lang('LaporanIkm.headingCreated'),
                'type'    => 'radio', //or 'checkbox'
                'options' => [
                    1   => '1 ' . lang('LaporanIkm.labelDay'),
                    2   => '2 ' . lang('LaporanIkm.labelDays'),
                    3   => '3 ' . lang('LaporanIkm.labelDays'),
                    7   => '1 ' . lang('LaporanIkm.labelWeek'),
                    14  => '2 ' . lang('LaporanIkm.labelWeeks'),
                    30  => '1 ' . lang('LaporanIkm.labelMonth'),
                    90  => '3 ' . lang('LaporanIkm.labelMonths'),
                    180 => '6 ' . lang('LaporanIkm.labelMonths'),
                    365 => '1 ' . lang('LaporanIkm.labelYear'),
                    'all' => lang('LaporanIkm.labelAnyTime'),
                ],
            ],
        ];
    }

    /**
     * Provides filtering functionality.
     *
     * @param array $params
     *
     * @return LaporanIkmFilter
     */
    public function filter(?array $params = null)
    {
        $this->select('laporanikm.*');



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
