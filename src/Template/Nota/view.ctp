<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Notum $notum
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('Edit Notum'), ['action' => 'edit', $notum->id]) ?> </li>
        <li><?= $this->Form->postLink(__('Delete Notum'), ['action' => 'delete', $notum->id], ['confirm' => __('Are you sure you want to delete # {0}?', $notum->id)]) ?> </li>
        <li><?= $this->Html->link(__('List Nota'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Notum'), ['action' => 'add']) ?> </li>
    </ul>
</nav>
<div class="nota view large-9 medium-8 columns content">
    <h3><?= h($notum->id) ?></h3>
    <table class="vertical-table">
        <tr>
            <th scope="row"><?= __('Datos') ?></th>
            <td><?= h($notum->datos) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Id') ?></th>
            <td><?= $this->Number->format($notum->id) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Ficha') ?></th>
            <td><?= $this->Number->format($notum->ficha) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Fecha') ?></th>
            <td><?= h($notum->fecha) ?></td>
        </tr>
    </table>
</div>
