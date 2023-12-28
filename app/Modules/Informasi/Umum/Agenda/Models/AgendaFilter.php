<?php

namespace App\Modules\Informasi\Umum\Agenda\Models;

use Bonfire\Core\Traits\Filterable;
use CodeIgniter\I18n\Time;

class AgendaFilter extends AgendaModel
{
    use Filterable;

    /**
     * The filters that can be applied to
     * lists of Agenda
     *
     * @var array
     */
    protected $filters = [];

    function __construct()
    {
        parent::__construct();

        $this->filters = [

            'created_at' => [
                'title'   => lang('Agenda.headingCreated'),
                'type'    => 'radio', //or 'checkbox'
                'options' => [
                    1   => '1 ' . lang('Agenda.labelDay'),
                    2   => '2 ' . lang('Agenda.labelDays'),
                    3   => '3 ' . lang('Agenda.labelDays'),
                    7   => '1 ' . lang('Agenda.labelWeek'),
                    14  => '2 ' . lang('Agenda.labelWeeks'),
                    30  => '1 ' . lang('Agenda.labelMonth'),
                    90  => '3 ' . lang('Agenda.labelMonths'),
                    180 => '6 ' . lang('Agenda.labelMonths'),
                    365 => '1 ' . lang('Agenda.labelYear'),
                    'all' => lang('Agenda.labelAnyTime'),
                ],
            ],
        ];
    }

    /**
     * Provides filtering functionality.
     *
     * @param array $params
     *
     * @return AgendaFilter
     */
    public function filter(?array $params = null)
    {
        $this->select('agenda.*');



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
