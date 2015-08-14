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

use Chromabits\Nucleus\Support\Html;
use Chromabits\Nucleus\Support\Std;
use Chromabits\Nucleus\View\Common\Anchor;
use Chromabits\Nucleus\View\Common\ListItem;
use Chromabits\Nucleus\View\Common\UnorderedList;
use Chromabits\Nucleus\View\SafeHtmlWrapper;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Pagination\UrlWindow;
use Illuminate\Pagination\UrlWindowPresenterTrait;

/**
 * Class FoundationPresenter.
 *
 * @author Eduardo Trujillo <ed@chromabits.com>
 * @package Chromabits\Pagination
 */
class FoundationPresenter extends SimpleFoundationPresenter
{
    use FoundationNextPreviousRendererTrait, UrlWindowPresenterTrait;

    /**
     * The paginator implementation.
     *
     * @var LengthAwarePaginator
     */
    protected $paginator;

    /**
     * The URL window data structure.
     *
     * @var array
     */
    protected $window;

    /**
     * Construct an instance of a FoundationPresenter.
     *
     * @param LengthAwarePaginator $paginator
     * @param UrlWindow|null $window
     */
    public function __construct(
        LengthAwarePaginator $paginator,
        UrlWindow $window = null
    ) {
        parent::__construct($paginator);

        $this->window = Std::firstBias(
            is_null($window),
            function () use ($paginator) {
                return UrlWindow::make($paginator);
            },
            function () use ($window) {
                return $window->get();
            }
        );
    }

    /**
     * Render the given paginator.
     *
     * @return string
     */
    public function render()
    {
        if ($this->hasPages()) {
            return (new UnorderedList(['class' => 'pagination'], [
                Html::safe($this->getPreviousButton()),
                Html::safe($this->getLinks()),
                Html::safe($this->getNextButton()),
            ]))->render();
        }

        return '';
    }

    /**
     * Get HTML wrapper for an available page link.
     *
     * @param string $url
     * @param int $page
     * @param string|null $rel
     *
     * @return string
     */
    protected function getAvailablePageWrapper($url, $page, $rel = null)
    {
        return (new ListItem([], new Anchor([
            'href' => $url,
            'rel' => $rel,
        ], (string) $page)))->render();
    }

    /**
     * Get HTML wrapper for disabled text.
     *
     * @param string $text
     *
     * @return string
     */
    protected function getDisabledTextWrapper($text)
    {
        return (new ListItem(
            ['class' => 'unavailable'],
            new Anchor([], (string) $text))
        )->render();
    }

    /**
     * Get HTML wrapper for active text.
     *
     * @param string $text
     *
     * @return string
     */
    protected function getActivePageWrapper($text)
    {
        return (new ListItem(
            ['class' => 'current'],
            new Anchor([], (string) $text))
        )->render();
    }

    /**
     * Get a pagination "dot" element.
     *
     * @return string|SafeHtmlWrapper
     */
    public function getDots()
    {
        return $this->getDisabledTextWrapper(Html::safe('&hellip;'));
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

    /**
     * Determine if the underlying paginator being presented has pages to show.
     *
     * @return bool
     */
    public function hasPages()
    {
        return $this->paginator->hasPages();
    }
}
