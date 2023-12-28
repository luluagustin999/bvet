<?php

namespace App\Modules\Informasi\Umum\StandarPelayanan\Models;

use Bonfire\Core\Traits\Filterable;
use CodeIgniter\I18n\Time;

class StandarPelayananFilter extends StandarPelayananModel
{
    use Filterable;

    /**
     * The filters that can be applied to
     * lists of StandarPelayanan
     *
     * @var array
     */
    protected $filters = [];

    function __construct()
    {
        parent::__construct();

        $this->filters = [

            'created_at' => [
                'title'   => lang('StandarPelayanan.headingCreated'),
                'type'    => 'radio', //or 'checkbox'
                'options' => [
                    1   => '1 ' . lang('StandarPelayanan.labelDay'),
                    2   => '2 ' . lang('StandarPelayanan.labelDays'),
                    3   => '3 ' . lang('StandarPelayanan.labelDays'),
                    7   => '1 ' . lang('StandarPelayanan.labelWeek'),
                    14  => '2 ' . lang('StandarPelayanan.labelWeeks'),
                    30  => '1 ' . lang('StandarPelayanan.labelMonth'),
                    90  => '3 ' . lang('StandarPelayanan.labelMonths'),
                    180 => '6 ' . lang('StandarPelayanan.labelMonths'),
                    365 => '1 ' . lang('StandarPelayanan.labelYear'),
                    'all' => lang('StandarPelayanan.labelAnyTime'),
                ],
            ],
        ];
    }

    /**
     * Provides filtering functionality.
     *
     * @param array $params
     *
     * @return StandarPelayananFilter
     */
    public function filter(?array $params = null)
    {
        $this->select('standarpelayanan.*');



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
