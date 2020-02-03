<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Consejo[]|\Cake\Collection\CollectionInterface $consejo
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('New Consejo'), ['action' => 'add']) ?></li>
    </ul>
</nav>
<div class="consejo index large-9 medium-8 columns content">
    <h3><?= __('Consejo') ?></h3>
    <table cellpadding="0" cellspacing="0">
        <thead>
            <tr>
                <th scope="col"><?= $this->Paginator->sort('id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('recomendacion') ?></th>
                <th scope="col"><?= $this->Paginator->sort('paciente') ?></th>
                <th scope="col"><?= $this->Paginator->sort('medico') ?></th>
                <th scope="col" class="actions"><?= __('Actions') ?></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($consejo as $consejo): ?>
            <tr>
                <td><?= $this->Number->format($consejo->id) ?></td>
                <td><?= h($consejo->recomendacion) ?></td>
                <td><?= $this->Number->format($consejo->paciente) ?></td>
                <td><?= $this->Number->format($consejo->medico) ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['action' => 'view', $consejo->id]) ?>
                    <?= $this->Html->link(__('Edit'), ['action' => 'edit', $consejo->id]) ?>
                    <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $consejo->id], ['confirm' => __('Are you sure you want to delete # {0}?', $consejo->id)]) ?>
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
