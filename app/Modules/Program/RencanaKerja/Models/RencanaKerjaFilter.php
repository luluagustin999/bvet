<?php

namespace App\Modules\Program\RencanaKerja\Models;

use Bonfire\Core\Traits\Filterable;
use CodeIgniter\I18n\Time;

class RencanaKerjaFilter extends RencanaKerjaModel
{
    use Filterable;

    /**
     * The filters that can be applied to
     * lists of RencanaKerja
     *
     * @var array
     */
    protected $filters = [];

    function __construct()
    {
        parent::__construct();

        $this->filters = [

            'created_at' => [
                'title'   => lang('RencanaKerja.headingCreated'),
                'type'    => 'radio', //or 'checkbox'
                'options' => [
                    1   => '1 ' . lang('RencanaKerja.labelDay'),
                    2   => '2 ' . lang('RencanaKerja.labelDays'),
                    3   => '3 ' . lang('RencanaKerja.labelDays'),
                    7   => '1 ' . lang('RencanaKerja.labelWeek'),
                    14  => '2 ' . lang('RencanaKerja.labelWeeks'),
                    30  => '1 ' . lang('RencanaKerja.labelMonth'),
                    90  => '3 ' . lang('RencanaKerja.labelMonths'),
                    180 => '6 ' . lang('RencanaKerja.labelMonths'),
                    365 => '1 ' . lang('RencanaKerja.labelYear'),
                    'all' => lang('RencanaKerja.labelAnyTime'),
                ],
            ],
        ];
    }

    /**
     * Provides filtering functionality.
     *
     * @param array $params
     *
     * @return RencanaKerjaFilter
     */
    public function filter(?array $params = null)
    {
        $this->select('rencanakerja.*');



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
