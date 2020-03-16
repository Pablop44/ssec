<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Tratamiento[]|\Cake\Collection\CollectionInterface $tratamiento
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('New Tratamiento'), ['action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Medicamento'), ['controller' => 'Medicamento', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Medicamento'), ['controller' => 'Medicamento', 'action' => 'add']) ?></li>
    </ul>
</nav>
<div class="tratamiento index large-9 medium-8 columns content">
    <h3><?= __('Tratamiento') ?></h3>
    <table cellpadding="0" cellspacing="0">
        <thead>
            <tr>
                <th scope="col"><?= $this->Paginator->sort('id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('posologia') ?></th>
                <th scope="col"><?= $this->Paginator->sort('fechaInicio') ?></th>
                <th scope="col"><?= $this->Paginator->sort('fechaFin') ?></th>
                <th scope="col"><?= $this->Paginator->sort('horario') ?></th>
                <th scope="col"><?= $this->Paginator->sort('enfermedad') ?></th>
                <th scope="col"><?= $this->Paginator->sort('ficha') ?></th>
                <th scope="col" class="actions"><?= __('Actions') ?></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($tratamiento as $tratamiento): ?>
            <tr>
                <td><?= $this->Number->format($tratamiento->id) ?></td>
                <td><?= h($tratamiento->posologia) ?></td>
                <td><?= h($tratamiento->fechaInicio) ?></td>
                <td><?= h($tratamiento->fechaFin) ?></td>
                <td><?= h($tratamiento->horario) ?></td>
                <td><?= h($tratamiento->enfermedad) ?></td>
                <td><?= $this->Number->format($tratamiento->ficha) ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['action' => 'view', $tratamiento->id]) ?>
                    <?= $this->Html->link(__('Edit'), ['action' => 'edit', $tratamiento->id]) ?>
                    <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $tratamiento->id], ['confirm' => __('Are you sure you want to delete # {0}?', $tratamiento->id)]) ?>
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
