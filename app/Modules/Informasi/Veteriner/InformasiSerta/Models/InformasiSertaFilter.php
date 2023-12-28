<?php

namespace App\Modules\Informasi\Veteriner\InformasiSerta\Models;

use Bonfire\Core\Traits\Filterable;
use CodeIgniter\I18n\Time;

class InformasiSertaFilter extends InformasiSertaModel
{
    use Filterable;

    /**
     * The filters that can be applied to
     * lists of InformasiSerta
     *
     * @var array
     */
    protected $filters = [];

    function __construct()
    {
        parent::__construct();

        $this->filters = [

            'created_at' => [
                'title'   => lang('InformasiSerta.headingCreated'),
                'type'    => 'radio', //or 'checkbox'
                'options' => [
                    1   => '1 ' . lang('InformasiSerta.labelDay'),
                    2   => '2 ' . lang('InformasiSerta.labelDays'),
                    3   => '3 ' . lang('InformasiSerta.labelDays'),
                    7   => '1 ' . lang('InformasiSerta.labelWeek'),
                    14  => '2 ' . lang('InformasiSerta.labelWeeks'),
                    30  => '1 ' . lang('InformasiSerta.labelMonth'),
                    90  => '3 ' . lang('InformasiSerta.labelMonths'),
                    180 => '6 ' . lang('InformasiSerta.labelMonths'),
                    365 => '1 ' . lang('InformasiSerta.labelYear'),
                    'all' => lang('InformasiSerta.labelAnyTime'),
                ],
            ],
        ];
    }

    /**
     * Provides filtering functionality.
     *
     * @param array $params
     *
     * @return InformasiSertaFilter
     */
    public function filter(?array $params = null)
    {
        $this->select('informasiserta.*');



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
