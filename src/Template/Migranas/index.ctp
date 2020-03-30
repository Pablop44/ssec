<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Migrana[]|\Cake\Collection\CollectionInterface $migranas
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('New Migrana'), ['action' => 'add']) ?></li>
    </ul>
</nav>
<div class="migranas index large-9 medium-8 columns content">
    <h3><?= __('Migranas') ?></h3>
    <table cellpadding="0" cellspacing="0">
        <thead>
            <tr>
                <th scope="col"><?= $this->Paginator->sort('id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('fecha') ?></th>
                <th scope="col"><?= $this->Paginator->sort('ficha') ?></th>
                <th scope="col"><?= $this->Paginator->sort('frecuencia') ?></th>
                <th scope="col"><?= $this->Paginator->sort('duracion') ?></th>
                <th scope="col"><?= $this->Paginator->sort('horario') ?></th>
                <th scope="col"><?= $this->Paginator->sort('finalizacion') ?></th>
                <th scope="col"><?= $this->Paginator->sort('tipoEpisodio') ?></th>
                <th scope="col"><?= $this->Paginator->sort('intensidad') ?></th>
                <th scope="col"><?= $this->Paginator->sort('limitaciones') ?></th>
                <th scope="col"><?= $this->Paginator->sort('despiertoNoche') ?></th>
                <th scope="col"><?= $this->Paginator->sort('estadoGeneral') ?></th>
                <th scope="col" class="actions"><?= __('Actions') ?></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($migranas as $migrana): ?>
            <tr>
                <td><?= $this->Number->format($migrana->id) ?></td>
                <td><?= h($migrana->fecha) ?></td>
                <td><?= $this->Number->format($migrana->ficha) ?></td>
                <td><?= h($migrana->frecuencia) ?></td>
                <td><?= h($migrana->duracion) ?></td>
                <td><?= h($migrana->horario) ?></td>
                <td><?= h($migrana->finalizacion) ?></td>
                <td><?= h($migrana->tipoEpisodio) ?></td>
                <td><?= h($migrana->intensidad) ?></td>
                <td><?= h($migrana->limitaciones) ?></td>
                <td><?= h($migrana->despiertoNoche) ?></td>
                <td><?= h($migrana->estadoGeneral) ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['action' => 'view', $migrana->id]) ?>
                    <?= $this->Html->link(__('Edit'), ['action' => 'edit', $migrana->id]) ?>
                    <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $migrana->id], ['confirm' => __('Are you sure you want to delete # {0}?', $migrana->id)]) ?>
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
