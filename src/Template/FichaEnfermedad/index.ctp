<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\FichaEnfermedad[]|\Cake\Collection\CollectionInterface $fichaEnfermedad
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('New Ficha Enfermedad'), ['action' => 'add']) ?></li>
    </ul>
</nav>
<div class="fichaEnfermedad index large-9 medium-8 columns content">
    <h3><?= __('Ficha Enfermedad') ?></h3>
    <table cellpadding="0" cellspacing="0">
        <thead>
            <tr>
                <th scope="col"><?= $this->Paginator->sort('ficha') ?></th>
                <th scope="col"><?= $this->Paginator->sort('enfermedad') ?></th>
                <th scope="col" class="actions"><?= __('Actions') ?></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($fichaEnfermedad as $fichaEnfermedad): ?>
            <tr>
                <td><?= $this->Number->format($fichaEnfermedad->ficha) ?></td>
                <td><?= h($fichaEnfermedad->enfermedad) ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['action' => 'view', $fichaEnfermedad->ficha]) ?>
                    <?= $this->Html->link(__('Edit'), ['action' => 'edit', $fichaEnfermedad->ficha]) ?>
                    <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $fichaEnfermedad->ficha], ['confirm' => __('Are you sure you want to delete # {0}?', $fichaEnfermedad->ficha)]) ?>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    <div class="paginator">
        <ul class="pagination">
            <?= $this->Paginator->first('<< ' . __('first')) ?>
            <?= $this->Paginator->prev('< ' . __('previous')) ?>
            <?= $this->Paginator->numbers() ?>
            <?= $this->Paginator->next(__('next') . ' >') ?>
            <?= $this->Paginator->last(__('last') . ' >>') ?>
        </ul>
        <p><?= $this->Paginator->counter(['format' => __('Page {{page}} of {{pages}}, showing {{current}} record(s) out of {{count}} total')]) ?></p>
    </div>
</div>
