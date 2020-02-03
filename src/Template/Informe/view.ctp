<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Informe $informe
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('Edit Informe'), ['action' => 'edit', $informe->id]) ?> </li>
        <li><?= $this->Form->postLink(__('Delete Informe'), ['action' => 'delete', $informe->id], ['confirm' => __('Are you sure you want to delete # {0}?', $informe->id)]) ?> </li>
        <li><?= $this->Html->link(__('List Informe'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Informe'), ['action' => 'add']) ?> </li>
    </ul>
</nav>
<div class="informe view large-9 medium-8 columns content">
    <h3><?= h($informe->id) ?></h3>
    <table class="vertical-table">
        <tr>
            <th scope="row"><?= __('Id') ?></th>
            <td><?= $this->Number->format($informe->id) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Plantilla') ?></th>
            <td><?= $this->Number->format($informe->plantilla) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Ficha') ?></th>
            <td><?= $this->Number->format($informe->ficha) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Fecha') ?></th>
            <td><?= h($informe->fecha) ?></td>
        </tr>
    </table>
</div>
