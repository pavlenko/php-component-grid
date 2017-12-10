<?php
/**
 * @var $grid \PE\Component\Grid\View\GridView
 * @var $row  \PE\Component\Grid\View\RowView
 * @var $cell \PE\Component\Grid\View\CellView
 */
?>
<table class="table" data-name="<?php echo $grid->getName() ?>">
    <tbody>
    <?php if (count($rows = $grid->getRows())) { ?>
        <?php foreach ($rows as $row) { ?>
            <tr>
                <?php foreach ($row->getCells() as $cell) { ?>
                    <td><?php echo $cell->getValue() ?></td>
                <?php } ?>
            </tr>
        <?php } ?>
    <?php } else { ?>
        <tr>
            <td colspan="<?php echo count($grid->getHeaders()) ?>">
                There are no records matching criteria
            </td>
        </tr>
    <?php } ?>
    </tbody>
</table>
