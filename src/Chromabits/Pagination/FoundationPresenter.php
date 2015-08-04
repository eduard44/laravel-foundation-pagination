<?php

/**
 * Copyright 2015, Eduardo Trujillo <ed@chromabits.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * This file is part of the Laravel Foundation Pagination package
 */

namespace Chromabits\Pagination;

use Chromabits\Nucleus\Foundation\BaseObject;
use Chromabits\Nucleus\Support\Std;
use Chromabits\Nucleus\View\Common\ListItem;
use Chromabits\Nucleus\View\Head\Link;
use Illuminate\Contracts\Pagination\Paginator;
use Illuminate\Contracts\Pagination\Paginator as PaginatorContract;
use Illuminate\Contracts\Pagination\Presenter;
use Illuminate\Pagination\UrlWindow;
use Illuminate\Pagination\UrlWindowPresenterTrait;

/**
 * Class FoundationPresenter.
 *
 * @author Eduardo Trujillo <ed@chromabits.com>
 * @package Chromabits\Pagination
 */
class FoundationPresenter extends BaseObject implements Presenter
{
    use FoundationNextPreviousRendererTrait, UrlWindowPresenterTrait;

    /**
     * The paginator implementation.
     *
     * @var \Illuminate\Contracts\Pagination\Paginator
     */
    protected $paginator;

    /**
     * The URL window data structure.
     *
     * @var array
     */
    protected $window;

    protected $currentPage;

    /**
     * Construct an instance of a FoundationPresenter.
     *
     * @param Paginator $paginator
     * @param UrlWindow|null $window
     */
    public function __construct(
        PaginatorContract $paginator,
        UrlWindow $window = null
    ) {
        parent::__construct();

        $this->paginator = $paginator;
        $this->window = Std::firstBias(
                is_null($window),
            function () use ($paginator) {
                UrlWindow::make($paginator);
            },
            function () use ($window) {
                $window->get();
            }
        );
    }

    /**
     * Determine if the underlying paginator being presented has pages to show.
     *
     * @return bool
     */
    public function hasPages()
    {
        return $this->paginator->hasPages();
    }

    /**
     * Render the given paginator.
     *
     * @return string
     */
    public function render()
    {
        if ($this->hasPages()) {
            return sprintf(
                '<ul class="pagination">%s %s %s</ul>',
                $this->getPreviousButton(),
                $this->getLinks(),
                $this->getNextButton()
            );
        }

        return '';
    }

    /**
     * Create a range of pagination links.
     *
     * @param  int $start
     * @param  int $end
     *
     * @return string
     */
    public function getPageRange($start, $end)
    {
        $pages = [];

        for ($page = $start; $page <= $end; $page++) {
            // If the current page is equal to the page we're iterating on, we
            // will create a disabled link for that page. Otherwise, we can
            // create a typical active one for the link.
            if ($this->currentPage == $page) {
                $pages[] = (new ListItem(['class' => 'current'], new Link(
                    ['href' => '#'],
                    $page
                )))->render();
            } else {
                $pages[] = $this->getLink($page);
            }
        }

        return implode('', $pages);
    }

    /**
     * Get HTML wrapper for an available page link.
     *
     * @param  string $url
     * @param  int $page
     * @param  string|null $rel
     *
     * @return string
     */
    protected function getAvailablePageWrapper($url, $page, $rel = null)
    {
        return (new ListItem([], new Link([
            'href' => $url,
            'rel' => $rel,
        ], $page)))->render();
    }

    /**
     * Get HTML wrapper for disabled text.
     *
     * @param  string $text
     *
     * @return string
     */
    protected function getDisabledTextWrapper($text)
    {
        return (new ListItem(['class' => 'unavailable'], new Link([], $text)))
            ->render();
    }

    /**
     * Get HTML wrapper for active text.
     *
     * @param  string $text
     *
     * @return string
     */
    protected function getActivePageWrapper($text)
    {
        return (new ListItem(['class' => 'current'], new Link([], $text)))
            ->render();
    }

    /**
     * Get a pagination "dot" element.
     *
     * @return string
     */
    public function getDots()
    {
        return $this->getDisabledTextWrapper('&hellip;');
    }

    /**
     * Get the current page from the paginator.
     *
     * @return int
     */
    protected function currentPage()
    {
        return $this->paginator->currentPage();
    }

    /**
     * Get the last page from the paginator.
     *
     * @return int
     */
    protected function lastPage()
    {
        return $this->paginator->lastPage();
    }
}
