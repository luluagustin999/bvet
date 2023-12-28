<?php

namespace App\Modules\Informasi\Veteriner\TarifPengujian\Models;

use Bonfire\Core\Traits\Filterable;
use CodeIgniter\I18n\Time;

class TarifPengujianFilter extends TarifPengujianModel
{
    use Filterable;

    /**
     * The filters that can be applied to
     * lists of TarifPengujian
     *
     * @var array
     */
    protected $filters = [];

    function __construct()
    {
        parent::__construct();

        $this->filters = [

            'created_at' => [
                'title'   => lang('TarifPengujian.headingCreated'),
                'type'    => 'radio', //or 'checkbox'
                'options' => [
                    1   => '1 ' . lang('TarifPengujian.labelDay'),
                    2   => '2 ' . lang('TarifPengujian.labelDays'),
                    3   => '3 ' . lang('TarifPengujian.labelDays'),
                    7   => '1 ' . lang('TarifPengujian.labelWeek'),
                    14  => '2 ' . lang('TarifPengujian.labelWeeks'),
                    30  => '1 ' . lang('TarifPengujian.labelMonth'),
                    90  => '3 ' . lang('TarifPengujian.labelMonths'),
                    180 => '6 ' . lang('TarifPengujian.labelMonths'),
                    365 => '1 ' . lang('TarifPengujian.labelYear'),
                    'all' => lang('TarifPengujian.labelAnyTime'),
                ],
            ],
        ];
    }

    /**
     * Provides filtering functionality.
     *
     * @param array $params
     *
     * @return TarifPengujianFilter
     */
    public function filter(?array $params = null)
    {
        $this->select('tarifpengujian.*');



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
