<?php

namespace PETest\Component\Grid\View;

use PE\Component\Grid\View\CellView;
use PE\Component\Grid\View\RowView;

class RowViewTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var CellView
     */
    private $cell1;

    /**
     * @var CellView
     */
    private $cell2;

    /**
     * @var RowView
     */
    private $view;

    protected function setUp()
    {
        $this->cell1 = $this->createMock(CellView::class);
        $this->cell2 = $this->createMock(CellView::class);

        $this->view = new RowView([$this->cell1, $this->cell2]);
    }

    public function testGetCells()
    {
        static::assertSame([$this->cell1, $this->cell2], $this->view->getCells());
    }
}
