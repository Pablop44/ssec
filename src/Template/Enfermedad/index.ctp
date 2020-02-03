<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Enfermedad[]|\Cake\Collection\CollectionInterface $enfermedad
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('New Enfermedad'), ['action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Ficha'), ['controller' => 'Ficha', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Ficha'), ['controller' => 'Ficha', 'action' => 'add']) ?></li>
    </ul>
</nav>
<div class="enfermedad index large-9 medium-8 columns content">
    <h3><?= __('Enfermedad') ?></h3>
    <table cellpadding="0" cellspacing="0">
        <thead>
            <tr>
                <th scope="col"><?= $this->Paginator->sort('nombre') ?></th>
                <th scope="col" class="actions"><?= __('Actions') ?></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($enfermedad as $enfermedad): ?>
            <tr>
                <td><?= h($enfermedad->nombre) ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['action' => 'view', $enfermedad->nombre]) ?>
                    <?= $this->Html->link(__('Edit'), ['action' => 'edit', $enfermedad->nombre]) ?>
                    <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $enfermedad->nombre], ['confirm' => __('Are you sure you want to delete # {0}?', $enfermedad->nombre)]) ?>
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
