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

use Chromabits\Nucleus\View\Common\ListItem;
use Chromabits\Nucleus\View\Head\Link;

/**
 * Trait FoundationNextPreviousRendererTrait.
 *
 * @author Eduardo Trujillo <ed@chromabits.com>
 * @package Chromabits\Pagination
 */
trait FoundationNextPreviousRendererTrait
{
    /**
     * Get the previous page pagination element.
     *
     * @param  string $text
     *
     * @return string
     */
    public function getPreviousButton($text = '&laquo;')
    {
        // If the current page is less than or equal to one, it means we can't
        // go any further back in the pages, so we will render a disabled
        // previous button when that is the case. Otherwise, we will give it an
        //active "status".
        if ($this->paginator->currentPage() <= 1) {
            return (new ListItem(
                ['class' => 'arrow unavailable'],
                new Link([], $text)
            ))->render();
        } else {
            $url = $this->paginator->previousPageUrl();

            return (new ListItem(['class' => 'arrow'], new Link(
                ['href' => $url],
                $text
            )))->render();
        }
    }

    /**
     * Get the next page pagination element.
     *
     * @param  string $text
     *
     * @return string
     */
    public function getNextButton($text = '&raquo;')
    {
        // If the current page is greater than or equal to the last page, it
        // means we can't go any further into the pages, as we're already on
        // this last page that is available, so we will make it the "next" link
        // style disabled.
        if (!$this->paginator->hasMorePages()) {
            return (new ListItem(
                ['class' => 'arrow unavailable'],
                new Link([], $text)
            ))->render();
        }

        $url = $this->paginator->nextPageUrl();

        return (new ListItem(
                ['class' => 'arrow'],
                new Link(['href' => $url], $text)
            ))->render();
    }
}
