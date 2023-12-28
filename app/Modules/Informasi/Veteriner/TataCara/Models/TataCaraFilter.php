<?php

namespace App\Modules\Informasi\Veteriner\TataCara\Models;

use Bonfire\Core\Traits\Filterable;
use CodeIgniter\I18n\Time;

class TataCaraFilter extends TataCaraModel
{
    use Filterable;

    /**
     * The filters that can be applied to
     * lists of TataCara
     *
     * @var array
     */
    protected $filters = [];

    function __construct()
    {
        parent::__construct();

        $this->filters = [

            'created_at' => [
                'title'   => lang('TataCara.headingCreated'),
                'type'    => 'radio', //or 'checkbox'
                'options' => [
                    1   => '1 ' . lang('TataCara.labelDay'),
                    2   => '2 ' . lang('TataCara.labelDays'),
                    3   => '3 ' . lang('TataCara.labelDays'),
                    7   => '1 ' . lang('TataCara.labelWeek'),
                    14  => '2 ' . lang('TataCara.labelWeeks'),
                    30  => '1 ' . lang('TataCara.labelMonth'),
                    90  => '3 ' . lang('TataCara.labelMonths'),
                    180 => '6 ' . lang('TataCara.labelMonths'),
                    365 => '1 ' . lang('TataCara.labelYear'),
                    'all' => lang('TataCara.labelAnyTime'),
                ],
            ],
        ];
    }

    /**
     * Provides filtering functionality.
     *
     * @param array $params
     *
     * @return TataCaraFilter
     */
    public function filter(?array $params = null)
    {
        $this->select('tatacara.*');



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
