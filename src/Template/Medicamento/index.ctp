<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Medicamento[]|\Cake\Collection\CollectionInterface $medicamento
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('New Medicamento'), ['action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Tratamiento'), ['controller' => 'Tratamiento', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Tratamiento'), ['controller' => 'Tratamiento', 'action' => 'add']) ?></li>
    </ul>
</nav>
<div class="medicamento index large-9 medium-8 columns content">
    <h3><?= __('Medicamento') ?></h3>
    <table cellpadding="0" cellspacing="0">
        <thead>
            <tr>
                <th scope="col"><?= $this->Paginator->sort('nombre') ?></th>
                <th scope="col"><?= $this->Paginator->sort('viaAdministracion') ?></th>
                <th scope="col"><?= $this->Paginator->sort('marca') ?></th>
                <th scope="col" class="actions"><?= __('Actions') ?></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($medicamento as $medicamento): ?>
            <tr>
                <td><?= h($medicamento->nombre) ?></td>
                <td><?= h($medicamento->viaAdministracion) ?></td>
                <td><?= h($medicamento->marca) ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['action' => 'view', $medicamento->nombre]) ?>
                    <?= $this->Html->link(__('Edit'), ['action' => 'edit', $medicamento->nombre]) ?>
                    <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $medicamento->nombre], ['confirm' => __('Are you sure you want to delete # {0}?', $medicamento->nombre)]) ?>
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
