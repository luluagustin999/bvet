<?php

namespace App\Modules\Blogs;

use Bonfire\Search\Interfaces\SearchProviderInterface;
use App\Modules\Blogs\Models\BlogsModel;

class SearchProvider extends BlogsModel implements SearchProviderInterface
{
    /**
     * Performs a primary search for just this resource.
     *
     * @param string     $term
     * @param int        $limit
     * @param array|null $post
     *
     * @return array
     */
    public function search(string $term, int $limit = 10, array $post = null): array
    {
        // @phpstan-ignore-next-line
        return $this
            ->select('blogs.*')
            ->like('title', $term, 'right', true, true)
            ->orlike('content', $term, 'right', true, true)
            ->orderBy('title', 'asc')
            ->findAll($limit);
    }

    /**
     * Returns the name of the resource.
     *
     * @return string
     */
    public function resourceName(): string
    {
        return lang('Blogs.blogs');
    }

    /**
     * Returns a URL to the admin area URL main list
     * for this resource.
     *
     * @return string
     */
    public function resourceUrl(): string
    {
        return ADMIN_AREA . '/blogs';
    }

    /**
     * Returns the name of the view to use when
     * displaying the list of results for this
     * resource type.
     *
     * @return string
     */
    public function resultView(): string
    {
        return 'App\Modules\Blogs\Views\_search_list';
    }
}
