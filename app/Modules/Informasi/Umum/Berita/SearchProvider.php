<?php

namespace App\Modules\Informasi\Umum\Berita;

use Bonfire\Search\Interfaces\SearchProviderInterface;
use App\Modules\Informasi\Umum\Berita\Models\BeritaModel;

class SearchProvider extends BeritaModel implements SearchProviderInterface
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
            ->select('berita.*')
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
        return lang('Berita.berita');
    }

    /**
     * Returns a URL to the admin area URL main list
     * for this resource.
     *
     * @return string
     */
    public function resourceUrl(): string
    {
        return ADMIN_AREA . '/berita';
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
        return 'App\Modules\Informasi\Umum\Berita\Views\_search_list';
    }
}
