<?php

namespace App\Modules\Blogs\Models;

use Bonfire\Core\Traits\Filterable;
use CodeIgniter\I18n\Time;

class BlogsFilter extends BlogsModel
{
    use Filterable;

    /**
     * The filters that can be applied to
     * lists of Blogs
     *
     * @var array
     */
    protected $filters = [];

    function __construct()
    {
        parent::__construct();

        $this->filters = [

            'created_at' => [
                'title'   => lang('Blogs.headingCreated'),
                'type'    => 'radio', //or 'checkbox'
                'options' => [
                    1   => '1 ' . lang('Blogs.labelDay'),
                    2   => '2 ' . lang('Blogs.labelDays'),
                    3   => '3 ' . lang('Blogs.labelDays'),
                    7   => '1 ' . lang('Blogs.labelWeek'),
                    14  => '2 ' . lang('Blogs.labelWeeks'),
                    30  => '1 ' . lang('Blogs.labelMonth'),
                    90  => '3 ' . lang('Blogs.labelMonths'),
                    180 => '6 ' . lang('Blogs.labelMonths'),
                    365 => '1 ' . lang('Blogs.labelYear'),
                    'all' => lang('Blogs.labelAnyTime'),
                ],
            ],
        ];
    }

    /**
     * Provides filtering functionality.
     *
     * @param array $params
     *
     * @return BlogsFilter
     */
    public function filter(?array $params = null)
    {
        $this->select('blogs.*');



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
