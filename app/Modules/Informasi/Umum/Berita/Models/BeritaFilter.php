<?php

namespace App\Modules\Informasi\Umum\Berita\Models;

use Bonfire\Core\Traits\Filterable;
use CodeIgniter\I18n\Time;

class BeritaFilter extends BeritaModel
{
    use Filterable;

    /**
     * The filters that can be applied to
     * lists of Berita
     *
     * @var array
     */
    protected $filters = [];

    function __construct()
    {
        parent::__construct();

        $this->filters = [

            'created_at' => [
                'title'   => lang('Berita.headingCreated'),
                'type'    => 'radio', //or 'checkbox'
                'options' => [
                    1   => '1 ' . lang('Berita.labelDay'),
                    2   => '2 ' . lang('Berita.labelDays'),
                    3   => '3 ' . lang('Berita.labelDays'),
                    7   => '1 ' . lang('Berita.labelWeek'),
                    14  => '2 ' . lang('Berita.labelWeeks'),
                    30  => '1 ' . lang('Berita.labelMonth'),
                    90  => '3 ' . lang('Berita.labelMonths'),
                    180 => '6 ' . lang('Berita.labelMonths'),
                    365 => '1 ' . lang('Berita.labelYear'),
                    'all' => lang('Berita.labelAnyTime'),
                ],
            ],
        ];
    }

    /**
     * Provides filtering functionality.
     *
     * @param array $params
     *
     * @return BeritaFilter
     */
    public function filter(?array $params = null)
    {
        $this->select('berita.*');



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
