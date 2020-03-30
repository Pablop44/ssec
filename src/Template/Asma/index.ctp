<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Asma[]|\Cake\Collection\CollectionInterface $asma
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('New Asma'), ['action' => 'add']) ?></li>
    </ul>
</nav>
<div class="asma index large-9 medium-8 columns content">
    <h3><?= __('Asma') ?></h3>
    <table cellpadding="0" cellspacing="0">
        <thead>
            <tr>
                <th scope="col"><?= $this->Paginator->sort('id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('fecha') ?></th>
                <th scope="col"><?= $this->Paginator->sort('ficha') ?></th>
                <th scope="col"><?= $this->Paginator->sort('calidadSueno') ?></th>
                <th scope="col"><?= $this->Paginator->sort('dificultadRespirar') ?></th>
                <th scope="col"><?= $this->Paginator->sort('tos') ?></th>
                <th scope="col"><?= $this->Paginator->sort('gravedadTos') ?></th>
                <th scope="col"><?= $this->Paginator->sort('limitaciones') ?></th>
                <th scope="col"><?= $this->Paginator->sort('silbidos') ?></th>
                <th scope="col"><?= $this->Paginator->sort('usoMedicacion') ?></th>
                <th scope="col"><?= $this->Paginator->sort('espirometria') ?></th>
                <th scope="col"><?= $this->Paginator->sort('factoresCrisis') ?></th>
                <th scope="col"><?= $this->Paginator->sort('estadoGeneral') ?></th>
                <th scope="col" class="actions"><?= __('Actions') ?></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($asma as $asma): ?>
            <tr>
                <td><?= $this->Number->format($asma->id) ?></td>
                <td><?= h($asma->fecha) ?></td>
                <td><?= $this->Number->format($asma->ficha) ?></td>
                <td><?= h($asma->calidadSueno) ?></td>
                <td><?= h($asma->dificultadRespirar) ?></td>
                <td><?= h($asma->tos) ?></td>
                <td><?= h($asma->gravedadTos) ?></td>
                <td><?= h($asma->limitaciones) ?></td>
                <td><?= h($asma->silbidos) ?></td>
                <td><?= h($asma->usoMedicacion) ?></td>
                <td><?= h($asma->espirometria) ?></td>
                <td><?= h($asma->factoresCrisis) ?></td>
                <td><?= h($asma->estadoGeneral) ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['action' => 'view', $asma->id]) ?>
                    <?= $this->Html->link(__('Edit'), ['action' => 'edit', $asma->id]) ?>
                    <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $asma->id], ['confirm' => __('Are you sure you want to delete # {0}?', $asma->id)]) ?>
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
