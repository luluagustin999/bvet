<?php

namespace App\Modules\Profile\Instansi\StandarMutu\Models;

use Bonfire\Core\Traits\Filterable;
use CodeIgniter\I18n\Time;

class StandarMutuFilter extends StandarMutuModel
{
    use Filterable;

    /**
     * The filters that can be applied to
     * lists of StandarMutu
     *
     * @var array
     */
    protected $filters = [];

    function __construct()
    {
        parent::__construct();

        $this->filters = [

            'created_at' => [
                'title'   => lang('StandarMutu.headingCreated'),
                'type'    => 'radio', //or 'checkbox'
                'options' => [
                    1   => '1 ' . lang('StandarMutu.labelDay'),
                    2   => '2 ' . lang('StandarMutu.labelDays'),
                    3   => '3 ' . lang('StandarMutu.labelDays'),
                    7   => '1 ' . lang('StandarMutu.labelWeek'),
                    14  => '2 ' . lang('StandarMutu.labelWeeks'),
                    30  => '1 ' . lang('StandarMutu.labelMonth'),
                    90  => '3 ' . lang('StandarMutu.labelMonths'),
                    180 => '6 ' . lang('StandarMutu.labelMonths'),
                    365 => '1 ' . lang('StandarMutu.labelYear'),
                    'all' => lang('StandarMutu.labelAnyTime'),
                ],
            ],
        ];
    }

    /**
     * Provides filtering functionality.
     *
     * @param array $params
     *
     * @return StandarMutuFilter
     */
    public function filter(?array $params = null)
    {
        $this->select('standarmutu.*');



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
