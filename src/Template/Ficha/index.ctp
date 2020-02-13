<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Ficha[]|\Cake\Collection\CollectionInterface $ficha
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('New Ficha'), ['action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Enfermedad'), ['controller' => 'Enfermedad', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Enfermedad'), ['controller' => 'Enfermedad', 'action' => 'add']) ?></li>
    </ul>
</nav>
<div class="ficha index large-9 medium-8 columns content">
    <h3><?= __('Ficha') ?></h3>
    <table cellpadding="0" cellspacing="0">
        <thead>
            <tr>
                <th scope="col"><?= $this->Paginator->sort('id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('fechaCreacion') ?></th>
                <th scope="col"><?= $this->Paginator->sort('paciente') ?></th>
                <th scope="col"><?= $this->Paginator->sort('medico') ?></th>
                <th scope="col" class="actions"><?= __('Actions') ?></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($ficha as $ficha): ?>
            <tr>
                <td><?= $this->Number->format($ficha->id) ?></td>
                <td><?= h($ficha->fechaCreacion) ?></td>
                <td><?= $this->Number->format($ficha->paciente) ?></td>
                <td><?= $this->Number->format($ficha->medico) ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['action' => 'view', $ficha->id]) ?>
                    <?= $this->Html->link(__('Edit'), ['action' => 'edit', $ficha->id]) ?>
                    <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $ficha->id], ['confirm' => __('Are you sure you want to delete # {0}?', $ficha->id)]) ?>
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
