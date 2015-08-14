<?php

namespace Chromabits\Pagination;

use Chromabits\Nucleus\Exceptions\LackOfCoffeeException;
use Chromabits\Nucleus\Foundation\BaseObject;
use Chromabits\Nucleus\Support\Html;
use Chromabits\Nucleus\View\Common\UnorderedList;
use Chromabits\Nucleus\View\Interfaces\RenderableInterface;
use Chromabits\Nucleus\View\Interfaces\SafeHtmlProducerInterface;
use Chromabits\Nucleus\View\SafeHtmlWrapper;
use Illuminate\Contracts\Pagination\Paginator;
use Illuminate\Contracts\Pagination\Presenter;

/**
 * Class SimpleFoundationPresenter
 *
 * @author Eduardo Trujillo <ed@chromabits.com>
 * @package Chromabits\Pagination
 */
class SimpleFoundationPresenter extends BaseObject implements
    Presenter,
    RenderableInterface,
    SafeHtmlProducerInterface
{
    use FoundationNextPreviousRendererTrait;

    /**
     * The paginator implementation.
     *
     * @var Paginator
     */
    protected $paginator;

    /**
     * @var int
     */
    protected $currentPage;

    /**
     * Construct an instance of a SimpleFoundationPresenter.
     *
     * @param Paginator $paginator
     *
     * @throws LackOfCoffeeException
     */
    public function __construct(Paginator $paginator)
    {
        parent::__construct();

        $this->paginator = $paginator;
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
                Html::safe($this->getNextButton()),
            ]))->render();
        }

        return '';
    }

    /**
     * Determine if the underlying paginator being presented has pages to show.
     *
     * @return bool
     */
    public function hasPages()
    {
        return $this->paginator->hasPages()
            && count($this->paginator->items()) > 0;
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
     * Get a safe HTML version of the contents of this object.
     *
     * @return SafeHtmlWrapper
     */
    public function getSafeHtml()
    {
        return Html::safe($this->render());
    }
}
