<?php

namespace App\Modules\Informasi\Veteriner\InformasiBerkala\Models;

use Bonfire\Core\Traits\Filterable;
use CodeIgniter\I18n\Time;

class InformasiBerkalaFilter extends InformasiBerkalaModel
{
    use Filterable;

    /**
     * The filters that can be applied to
     * lists of InformasiBerkala
     *
     * @var array
     */
    protected $filters = [];

    function __construct()
    {
        parent::__construct();

        $this->filters = [

            'created_at' => [
                'title'   => lang('InformasiBerkala.headingCreated'),
                'type'    => 'radio', //or 'checkbox'
                'options' => [
                    1   => '1 ' . lang('InformasiBerkala.labelDay'),
                    2   => '2 ' . lang('InformasiBerkala.labelDays'),
                    3   => '3 ' . lang('InformasiBerkala.labelDays'),
                    7   => '1 ' . lang('InformasiBerkala.labelWeek'),
                    14  => '2 ' . lang('InformasiBerkala.labelWeeks'),
                    30  => '1 ' . lang('InformasiBerkala.labelMonth'),
                    90  => '3 ' . lang('InformasiBerkala.labelMonths'),
                    180 => '6 ' . lang('InformasiBerkala.labelMonths'),
                    365 => '1 ' . lang('InformasiBerkala.labelYear'),
                    'all' => lang('InformasiBerkala.labelAnyTime'),
                ],
            ],
        ];
    }

    /**
     * Provides filtering functionality.
     *
     * @param array $params
     *
     * @return InformasiBerkalaFilter
     */
    public function filter(?array $params = null)
    {
        $this->select('informasiberkala.*');



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
