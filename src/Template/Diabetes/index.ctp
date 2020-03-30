<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Diabetes[]|\Cake\Collection\CollectionInterface $diabetes
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('New Diabetes'), ['action' => 'add']) ?></li>
    </ul>
</nav>
<div class="diabetes index large-9 medium-8 columns content">
    <h3><?= __('Diabetes') ?></h3>
    <table cellpadding="0" cellspacing="0">
        <thead>
            <tr>
                <th scope="col"><?= $this->Paginator->sort('id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('fecha') ?></th>
                <th scope="col"><?= $this->Paginator->sort('ficha') ?></th>
                <th scope="col"><?= $this->Paginator->sort('numeroControles') ?></th>
                <th scope="col"><?= $this->Paginator->sort('nivelBajo') ?></th>
                <th scope="col"><?= $this->Paginator->sort('frecuenciaBajo') ?></th>
                <th scope="col"><?= $this->Paginator->sort('horarioBajo') ?></th>
                <th scope="col"><?= $this->Paginator->sort('perdidaConocimiento') ?></th>
                <th scope="col"><?= $this->Paginator->sort('nivelAlto') ?></th>
                <th scope="col"><?= $this->Paginator->sort('frecuenciaAlto') ?></th>
                <th scope="col"><?= $this->Paginator->sort('horarioAlto') ?></th>
                <th scope="col"><?= $this->Paginator->sort('actividadFisica') ?></th>
                <th scope="col"><?= $this->Paginator->sort('problemaDieta') ?></th>
                <th scope="col"><?= $this->Paginator->sort('estadoGeneral') ?></th>
                <th scope="col" class="actions"><?= __('Actions') ?></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($diabetes as $diabetes): ?>
            <tr>
                <td><?= $this->Number->format($diabetes->id) ?></td>
                <td><?= h($diabetes->fecha) ?></td>
                <td><?= $this->Number->format($diabetes->ficha) ?></td>
                <td><?= $this->Number->format($diabetes->numeroControles) ?></td>
                <td><?= h($diabetes->nivelBajo) ?></td>
                <td><?= h($diabetes->frecuenciaBajo) ?></td>
                <td><?= h($diabetes->horarioBajo) ?></td>
                <td><?= h($diabetes->perdidaConocimiento) ?></td>
                <td><?= h($diabetes->nivelAlto) ?></td>
                <td><?= h($diabetes->frecuenciaAlto) ?></td>
                <td><?= h($diabetes->horarioAlto) ?></td>
                <td><?= h($diabetes->actividadFisica) ?></td>
                <td><?= h($diabetes->problemaDieta) ?></td>
                <td><?= h($diabetes->estadoGeneral) ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['action' => 'view', $diabetes->id]) ?>
                    <?= $this->Html->link(__('Edit'), ['action' => 'edit', $diabetes->id]) ?>
                    <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $diabetes->id], ['confirm' => __('Are you sure you want to delete # {0}?', $diabetes->id)]) ?>
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
