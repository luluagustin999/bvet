<?php

namespace App\Modules\Informasi\Veteriner\InformasiSetiap\Models;

use Bonfire\Core\Traits\Filterable;
use CodeIgniter\I18n\Time;

class InformasiSetiapFilter extends InformasiSetiapModel
{
    use Filterable;

    /**
     * The filters that can be applied to
     * lists of InformasiSetiap
     *
     * @var array
     */
    protected $filters = [];

    function __construct()
    {
        parent::__construct();

        $this->filters = [

            'created_at' => [
                'title'   => lang('InformasiSetiap.headingCreated'),
                'type'    => 'radio', //or 'checkbox'
                'options' => [
                    1   => '1 ' . lang('InformasiSetiap.labelDay'),
                    2   => '2 ' . lang('InformasiSetiap.labelDays'),
                    3   => '3 ' . lang('InformasiSetiap.labelDays'),
                    7   => '1 ' . lang('InformasiSetiap.labelWeek'),
                    14  => '2 ' . lang('InformasiSetiap.labelWeeks'),
                    30  => '1 ' . lang('InformasiSetiap.labelMonth'),
                    90  => '3 ' . lang('InformasiSetiap.labelMonths'),
                    180 => '6 ' . lang('InformasiSetiap.labelMonths'),
                    365 => '1 ' . lang('InformasiSetiap.labelYear'),
                    'all' => lang('InformasiSetiap.labelAnyTime'),
                ],
            ],
        ];
    }

    /**
     * Provides filtering functionality.
     *
     * @param array $params
     *
     * @return InformasiSetiapFilter
     */
    public function filter(?array $params = null)
    {
        $this->select('informasisetiap.*');



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
