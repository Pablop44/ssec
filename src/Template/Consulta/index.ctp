<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Consultum[]|\Cake\Collection\CollectionInterface $consulta
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('New Consultum'), ['action' => 'add']) ?></li>
    </ul>
</nav>
<div class="consulta index large-9 medium-8 columns content">
    <h3><?= __('Consulta') ?></h3>
    <table cellpadding="0" cellspacing="0">
        <thead>
            <tr>
                <th scope="col"><?= $this->Paginator->sort('id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('lugar') ?></th>
                <th scope="col"><?= $this->Paginator->sort('motivo') ?></th>
                <th scope="col"><?= $this->Paginator->sort('fecha') ?></th>
                <th scope="col"><?= $this->Paginator->sort('diagnostico') ?></th>
                <th scope="col"><?= $this->Paginator->sort('observaciones') ?></th>
                <th scope="col"><?= $this->Paginator->sort('medico') ?></th>
                <th scope="col"><?= $this->Paginator->sort('paciente') ?></th>
                <th scope="col"><?= $this->Paginator->sort('ficha') ?></th>
                <th scope="col" class="actions"><?= __('Actions') ?></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($consulta as $consultum): ?>
            <tr>
                <td><?= $this->Number->format($consultum->id) ?></td>
                <td><?= h($consultum->lugar) ?></td>
                <td><?= h($consultum->motivo) ?></td>
                <td><?= h($consultum->fecha) ?></td>
                <td><?= h($consultum->diagnostico) ?></td>
                <td><?= h($consultum->observaciones) ?></td>
                <td><?= $this->Number->format($consultum->medico) ?></td>
                <td><?= $this->Number->format($consultum->paciente) ?></td>
                <td><?= $this->Number->format($consultum->ficha) ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['action' => 'view', $consultum->id]) ?>
                    <?= $this->Html->link(__('Edit'), ['action' => 'edit', $consultum->id]) ?>
                    <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $consultum->id], ['confirm' => __('Are you sure you want to delete # {0}?', $consultum->id)]) ?>
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
